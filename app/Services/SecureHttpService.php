<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

/**
 * SECURE HTTP SERVICE
 * 
 * Serviço centralizado para todas as chamadas HTTP externas
 * Implementa timeouts, retry logic, circuit breaker e logging de segurança
 */
class SecureHttpService
{
    private const DEFAULT_TIMEOUT = 10;
    private const DEFAULT_CONNECT_TIMEOUT = 5;
    private const DEFAULT_MAX_RETRIES = 3;
    private const CIRCUIT_BREAKER_THRESHOLD = 5;
    private const CIRCUIT_BREAKER_TIMEOUT = 300; // 5 minutos
    
    private static $circuitBreakerState = [];
    
    /**
     * Realizar chamada HTTP GET segura
     */
    public static function get(string $url, array $headers = [], array $options = []): array
    {
        return self::makeRequest('GET', $url, null, $headers, $options);
    }
    
    /**
     * Realizar chamada HTTP POST segura
     */
    public static function post(string $url, array $data = [], array $headers = [], array $options = []): array
    {
        return self::makeRequest('POST', $url, $data, $headers, $options);
    }
    
    /**
     * Realizar chamada HTTP PUT segura
     */
    public static function put(string $url, array $data = [], array $headers = [], array $options = []): array
    {
        return self::makeRequest('PUT', $url, $data, $headers, $options);
    }
    
    /**
     * Realizar chamada HTTP DELETE segura
     */
    public static function delete(string $url, array $headers = [], array $options = []): array
    {
        return self::makeRequest('DELETE', $url, null, $headers, $options);
    }
    
    /**
     * Método principal para realizar requisições HTTP seguras
     */
    private static function makeRequest(
        string $method, 
        string $url, 
        ?array $data = null, 
        array $headers = [], 
        array $options = []
    ): array {
        $startTime = microtime(true);
        $requestId = uniqid('req_');
        
        // Verificar circuit breaker
        if (self::isCircuitBreakerOpen($url)) {
            Log::warning('Circuit breaker aberto para URL', [
                'url' => $url,
                'request_id' => $requestId
            ]);
            
            return [
                'success' => false,
                'error' => 'Circuit breaker ativo - serviço temporariamente indisponível',
                'circuit_breaker' => true,
                'request_id' => $requestId
            ];
        }
        
        // Configurações padrão
        $timeout = $options['timeout'] ?? self::DEFAULT_TIMEOUT;
        $connectTimeout = $options['connect_timeout'] ?? self::DEFAULT_CONNECT_TIMEOUT;
        $maxRetries = $options['max_retries'] ?? self::DEFAULT_MAX_RETRIES;
        
        // Headers de segurança padrão
        $defaultHeaders = [
            'User-Agent' => 'DentalGo-Scholar/1.0',
            'Accept' => 'application/json',
            'X-Request-ID' => $requestId,
        ];
        
        $headers = array_merge($defaultHeaders, $headers);
        
        // Log da requisição (sem dados sensíveis)
        Log::info('Iniciando requisição HTTP', [
            'method' => $method,
            'url' => self::sanitizeUrlForLog($url),
            'request_id' => $requestId,
            'timeout' => $timeout,
            'headers' => array_keys($headers)
        ]);
        
        $attempt = 0;
        $lastError = null;
        
        while ($attempt < $maxRetries) {
            $attempt++;
            
            try {
                $client = Http::timeout($timeout)
                    ->connectTimeout($connectTimeout)
                    ->withHeaders($headers)
                    ->withOptions([
                        'verify' => true, // Verificar SSL
                        'allow_redirects' => false, // Não seguir redirects automaticamente
                    ]);
                
                // Executar requisição baseada no método
                $response = match($method) {
                    'GET' => $client->get($url),
                    'POST' => $client->post($url, $data),
                    'PUT' => $client->put($url, $data),
                    'DELETE' => $client->delete($url),
                    default => throw new \InvalidArgumentException("Método HTTP não suportado: {$method}")
                };
                
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                // Log de sucesso
                Log::info('Requisição HTTP concluída', [
                    'method' => $method,
                    'url' => self::sanitizeUrlForLog($url),
                    'status' => $response->status(),
                    'duration_ms' => $duration,
                    'attempt' => $attempt,
                    'request_id' => $requestId
                ]);
                
                // Reset circuit breaker em caso de sucesso
                self::resetCircuitBreaker($url);
                
                return [
                    'success' => true,
                    'response' => $response->body(),
                    'status' => $response->status(),
                    'headers' => $response->headers(),
                    'duration_ms' => $duration,
                    'attempt' => $attempt,
                    'request_id' => $requestId
                ];
                
            } catch (RequestException $e) {
                $lastError = $e;
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                Log::warning("Tentativa HTTP falhou (tentativa {$attempt}/{$maxRetries})", [
                    'method' => $method,
                    'url' => self::sanitizeUrlForLog($url),
                    'error' => $e->getMessage(),
                    'duration_ms' => $duration,
                    'attempt' => $attempt,
                    'request_id' => $requestId
                ]);
                
                // Incrementar contador do circuit breaker
                self::incrementCircuitBreakerFailure($url);
                
                if ($attempt < $maxRetries) {
                    // Backoff exponencial
                    $delay = min(pow(2, $attempt - 1), 5); // Máximo 5 segundos
                    sleep($delay);
                }
            }
        }
        
        // Todas as tentativas falharam
        $totalDuration = round((microtime(true) - $startTime) * 1000, 2);
        
        Log::error('Todas as tentativas HTTP falharam', [
            'method' => $method,
            'url' => self::sanitizeUrlForLog($url),
            'total_attempts' => $maxRetries,
            'total_duration_ms' => $totalDuration,
            'last_error' => $lastError?->getMessage(),
            'request_id' => $requestId
        ]);
        
        return [
            'success' => false,
            'error' => $lastError?->getMessage() ?? 'Erro desconhecido',
            'total_attempts' => $maxRetries,
            'total_duration_ms' => $totalDuration,
            'request_id' => $requestId
        ];
    }
    
    /**
     * Verificar se o circuit breaker está aberto para uma URL
     */
    private static function isCircuitBreakerOpen(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);
        
        if (!isset(self::$circuitBreakerState[$host])) {
            return false;
        }
        
        $state = self::$circuitBreakerState[$host];
        
        // Verificar se o timeout expirou
        if (time() - $state['last_failure'] > self::CIRCUIT_BREAKER_TIMEOUT) {
            unset(self::$circuitBreakerState[$host]);
            return false;
        }
        
        return $state['failure_count'] >= self::CIRCUIT_BREAKER_THRESHOLD;
    }
    
    /**
     * Incrementar contador de falhas do circuit breaker
     */
    private static function incrementCircuitBreakerFailure(string $url): void
    {
        $host = parse_url($url, PHP_URL_HOST);
        
        if (!isset(self::$circuitBreakerState[$host])) {
            self::$circuitBreakerState[$host] = [
                'failure_count' => 0,
                'last_failure' => time()
            ];
        }
        
        self::$circuitBreakerState[$host]['failure_count']++;
        self::$circuitBreakerState[$host]['last_failure'] = time();
        
        if (self::$circuitBreakerState[$host]['failure_count'] >= self::CIRCUIT_BREAKER_THRESHOLD) {
            Log::critical('Circuit breaker ativado', [
                'host' => $host,
                'failure_count' => self::$circuitBreakerState[$host]['failure_count']
            ]);
        }
    }
    
    /**
     * Reset do circuit breaker em caso de sucesso
     */
    private static function resetCircuitBreaker(string $url): void
    {
        $host = parse_url($url, PHP_URL_HOST);
        
        if (isset(self::$circuitBreakerState[$host])) {
            unset(self::$circuitBreakerState[$host]);
        }
    }
    
    /**
     * Sanitizar URL para logs (remover dados sensíveis)
     */
    private static function sanitizeUrlForLog(string $url): string
    {
        $parsed = parse_url($url);
        
        // Remover query parameters que podem conter dados sensíveis
        return $parsed['scheme'] . '://' . $parsed['host'] . ($parsed['path'] ?? '');
    }
    
    /**
     * Obter estatísticas do circuit breaker
     */
    public static function getCircuitBreakerStats(): array
    {
        return self::$circuitBreakerState;
    }
    
    /**
     * Reset manual do circuit breaker (para uso administrativo)
     */
    public static function resetAllCircuitBreakers(): void
    {
        self::$circuitBreakerState = [];
        Log::info('Todos os circuit breakers foram resetados manualmente');
    }
}
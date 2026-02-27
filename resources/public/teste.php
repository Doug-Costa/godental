<?php
// Início da medição do tempo
$start_time = microtime(true);
$email = 'ti3@dentalpress.com.br';
$password = 'dental2024@';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.dentalgo.com.br/sessions/sign-in");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$info_plano = curl_exec ($ch);
curl_close ($ch);

$retorno_plano = json_decode($info_plano);

$info_plano = curl_exec($ch);

// Captura informações da transferência
$curl_info = curl_getinfo($ch);

// Verifica se ocorreu algum erro
if (curl_errno($ch)) {
    $curl_error = curl_error($ch);
} else {
    $curl_error = 'Nenhum erro.';
}

curl_close($ch);

// Fim da medição do tempo
$end_time = microtime(true);
$execution_time = $end_time - $start_time;

// Decodifica a resposta JSON
$retorno_plano = json_decode($info_plano, true);

// Exibe as informações coletadas
echo '<pre>';
echo "Informações da transferência cURL:\n";
print_r($curl_info);

echo "\nErro cURL (se houver):\n";
echo $curl_error . "\n";

echo "\nTempo de execução:\n";
echo $execution_time . " segundos\n";

echo "\nResposta da API:\n";
print_r($retorno_plano);
echo '</pre>';
?>
# Script de Sincronização DentalPress2026 (Simplificado)
$ServerIP = "187.77.48.78"
$User = "root"
$RemotePath = "/var/www/dentalpress"

Write-Host "1. Criando diretório remoto..." -ForegroundColor Cyan
ssh "$User@$ServerIP" "mkdir -p $RemotePath"

Write-Host "2. Enviando arquivos (isso pode levar alguns minutos)..." -ForegroundColor Cyan
# Envia arquivos visíveis e o .env explicitamente
scp -r * "$User@$($ServerIP):$RemotePath"
## scp .env "$User@$($ServerIP):$RemotePath"

Write-Host "3. Ajustando permissões do deploy.sh..." -ForegroundColor Cyan
ssh "$User@$ServerIP" "chmod +x $RemotePath/deploy.sh"

Write-Host "Concluído!" -ForegroundColor Green

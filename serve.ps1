# Laravel Development Server Launcher (PowerShell)
# Bypasses Laravel's serve command which has issues on Windows

param(
    [string]$Host = "127.0.0.1",
    [int]$Port = 8000
)

Write-Host "═══════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  Starting Laravel Development Server" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  Server: http://$Host`:$Port" -ForegroundColor Green
Write-Host "  Press Ctrl+C to stop the server" -ForegroundColor Yellow
Write-Host "═══════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

php serve.php $Host $Port


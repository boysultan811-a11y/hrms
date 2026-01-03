# PowerShell script to start Laravel development server
# Uses custom serve.php to bypass Laravel's serve command issues on Windows

param(
    [string]$Host = "127.0.0.1",
    [int]$Port = 8000
)

Write-Host "Starting Laravel development server..." -ForegroundColor Cyan

# Check if port is available
$portInUse = Get-NetTCPConnection -LocalPort $Port -ErrorAction SilentlyContinue

if ($portInUse) {
    Write-Host "Port $Port is already in use. Trying alternative ports..." -ForegroundColor Yellow
    
    # Try alternative ports
    $alternativePorts = @(8080, 3000, 9000, 7000, 5000, 4000)
    foreach ($altPort in $alternativePorts) {
        $altPortInUse = Get-NetTCPConnection -LocalPort $altPort -ErrorAction SilentlyContinue
        if (-not $altPortInUse) {
            $Port = $altPort
            Write-Host "Using port $Port instead" -ForegroundColor Green
            break
        }
    }
}

# Use the custom serve.php script
if (Test-Path "serve.php") {
    Write-Host "Using custom server script (bypasses Laravel serve command)" -ForegroundColor Green
    php serve.php $Host $Port
} else {
    Write-Host "Error: serve.php not found!" -ForegroundColor Red
    Write-Host "Please ensure serve.php exists in the project root." -ForegroundColor Yellow
    exit 1
}


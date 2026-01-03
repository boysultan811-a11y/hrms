@echo off
REM Laravel Development Server Launcher
REM Bypasses Laravel's serve command which has issues on Windows

if "%1"=="" (
    set HOST=127.0.0.1
) else (
    set HOST=%1
)

if "%2"=="" (
    set PORT=8000
) else (
    set PORT=%2
)

echo Starting Laravel development server on http://%HOST%:%PORT%
echo.

php serve.php %HOST% %PORT%


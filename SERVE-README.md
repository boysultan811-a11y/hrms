# Laravel Server Fix - Windows Port Binding Issue

## Problem Fixed ✅

Laravel's `php artisan serve` command fails on Windows with:
```
Failed to listen on 127.0.0.1:8000 (reason: ?)
```

## Solution

A custom server script has been created that bypasses Laravel's serve command and uses PHP's built-in server directly.

## How to Use

### Option 1: Use the Batch File (Easiest)
```cmd
serve.bat
```

Or with custom host/port:
```cmd
serve.bat 127.0.0.1 8080
```

### Option 2: Use PowerShell Script
```powershell
.\serve.ps1
```

Or with custom host/port:
```powershell
.\serve.ps1 -Host 127.0.0.1 -Port 8080
```

### Option 3: Use PHP Directly
```cmd
php serve.php
```

Or with custom host/port:
```cmd
php serve.php 127.0.0.1 8000
```

## Default Settings

- **Host:** 127.0.0.1
- **Port:** 8000
- **URL:** http://127.0.0.1:8000

## What Was Fixed

The issue was in Laravel's `serve` command implementation on Windows. The custom `serve.php` script:
1. Uses PHP's built-in server (`php -S`) directly
2. Points to the correct public directory
3. Uses the Laravel router (index.php)
4. Bypasses the problematic Laravel serve command

## Verification

The server is now running successfully on port 8000! ✅

You can verify by:
1. Opening http://127.0.0.1:8000 in your browser
2. Running: `netstat -ano | findstr :8000` (should show LISTENING)

## Alternative: Use XAMPP Apache

If you prefer using XAMPP's Apache:
- Access: http://localhost/project/HRMS/public


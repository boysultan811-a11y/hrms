# Fix Laravel Server Port Binding Issue on Windows

## Problem
`php artisan serve` fails to bind to ports 8000-8010 with error: "Failed to listen on 127.0.0.1:XXXX (reason: ?)"

## Solutions

### Solution 1: Run PowerShell as Administrator (Recommended)

1. Close your current PowerShell window
2. Right-click on PowerShell and select "Run as Administrator"
3. Navigate to your project: `cd C:\xampp\htdocs\project\HRMS`
4. Run: `php artisan serve`

### Solution 2: Use XAMPP Apache (Best for XAMPP Users)

Since you're using XAMPP, you can use Apache instead of PHP's built-in server:

1. **Quick Access:**
   - Open browser and go to: `http://localhost/project/HRMS/public`

2. **Configure Virtual Host (Better):**
   - Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
   - Add this configuration:
   ```apache
   <VirtualHost *:80>
       ServerName hrms.test
       DocumentRoot "C:/xampp/htdocs/project/HRMS/public"
       <Directory "C:/xampp/htdocs/project/HRMS/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
   - Open `C:\Windows\System32\drivers\etc\hosts` (as Administrator)
   - Add: `127.0.0.1 hrms.test`
   - Restart Apache in XAMPP Control Panel
   - Access: `http://hrms.test`

### Solution 3: Check Windows Firewall

1. Open Windows Defender Firewall
2. Click "Allow an app or feature through Windows Firewall"
3. Find "PHP" or add it manually
4. Ensure both Private and Public networks are checked

### Solution 4: Use Different Port Range

Try ports outside the common range:
```powershell
php artisan serve --port=50000 --host=127.0.0.1
```

### Solution 5: Use 0.0.0.0 Instead of 127.0.0.1

```powershell
php artisan serve --port=8000 --host=0.0.0.0
```

### Solution 6: Use the PowerShell Script

Run the provided script:
```powershell
.\start-server.ps1
```

## Quick Test

To test if it's a permission issue, try:
```powershell
# Run as Administrator
php artisan serve --port=8000 --host=127.0.0.1
```

## Why This Happens

On Windows, PHP's built-in server sometimes has issues binding to ports due to:
- Windows Firewall blocking PHP
- Permission restrictions
- Port reservation conflicts
- Antivirus software interference

## Recommended Approach

For XAMPP users, **Solution 2 (Use XAMPP Apache)** is the best option as:
- Apache is already configured and running
- Better performance
- More production-like environment
- No port binding issues


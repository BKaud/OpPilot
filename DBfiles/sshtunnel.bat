@echo off
REM SSH Tunnel for Database Access
REM This creates a tunnel from localhost:3307 -> remote server -> database:3306
 
echo Starting SSH tunnel to database server...
echo Local port: 3307 will forward to remote MySQL port 3306
echo.
echo Press Ctrl+C to stop the tunnel when done
echo.
 
REM SSH Configuration - Update the key path if needed
set SSH_KEY=%USERPROFILE%\LightsailDefaultKey-us-east-2.pem
set SSH_USER=bitnami
set SSH_HOST=3.142.11.187
set LOCAL_PORT=3307
set REMOTE_DB_HOST=localhost
set REMOTE_DB_PORT=3306
 
REM Check if key exists
if not exist "%SSH_KEY%" (
    echo ERROR: SSH key not found at: %SSH_KEY%
    echo Please update the SSH_KEY variable in this script.
    pause
    exit /b 1
)
 
REM Start SSH tunnel with key
REM -i = identity file (SSH key)
REM -L = Port forwarding (local_port:remote_host:remote_port)
REM -N = Don't execute remote commands, just tunnel
 
ssh -i "%SSH_KEY%" -L %LOCAL_PORT%:%REMOTE_DB_HOST%:%REMOTE_DB_PORT% %SSH_USER%@%SSH_HOST% -N
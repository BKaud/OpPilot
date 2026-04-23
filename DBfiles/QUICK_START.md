# OpPilot Database Connection - Quick Start

## ✅ Setup Complete!

Your database connection is configured to use SSH tunneling to access the remote database securely.

---

## Daily Workflow

### 1. Start the SSH Tunnel

Before working on OpPilot, run ONE of these:

**PowerShell (Recommended):**
```powershell
.\DBfiles\ssh_tunnel.ps1
```

**OR Command Prompt:**
```cmd
DBfiles\ssh_tunnel.bat
```

**Keep this window open** while you work. You'll see no output - that's normal!

### 2. Work Normally

- Your PHP app will automatically connect through the tunnel
- All database queries go through `localhost:3307` → SSH tunnel → remote database

### 3. Stop the Tunnel

When done working:
- Press `Ctrl+C` in the tunnel window
- Or just close the tunnel window

---

## Testing Your Connection

**Browser Test:**
Visit: `http://localhost/OpPilot/DBfiles/db_config_debug.php`

Expected output:
```json
{
    "success": true,
    "environment": "local_override",
    "db_host": "localhost",
    "db_port": 3307,
    "connection_test": {
        "connected": true
    }
}
```

**PowerShell Test:**
```powershell
Test-NetConnection -ComputerName 127.0.0.1 -Port 3307
# Should show: TcpTestSucceeded : True
```

---

## Configuration Files

- **`DBfiles/db_local_config.php`** - Your local config (gitignored, contains your password)
- **`DBfiles/ssh_tunnel.ps1`** - SSH tunnel script (gitignored)
- **`C:\Users\brade\LightsailDefaultKey-us-east-2.pem`** - Your SSH key

---

## Troubleshooting

**"Connection failed" in PHP:**
- Check if tunnel is running (`Test-NetConnection 127.0.0.1 -Port 3307`)
- Restart the tunnel script
- Check MySQL credentials in `db_local_config.php`

**"Permission denied" when starting tunnel:**
- SSH key location: `C:\Users\brade\LightsailDefaultKey-us-east-2.pem`
- Check if key file exists
- Update path in `ssh_tunnel.ps1` if key moved

**Port 3307 already in use:**
- Another tunnel is running - close it first
- Or change port in both `ssh_tunnel.ps1` AND `db_local_config.php`

---

## What's Happening?

```
Your PHP App → localhost:3307 → SSH Tunnel → 3.142.11.187 → MySQL:3306
```

This setup:
✅ Secures your database (port 3306 not exposed to internet)
✅ Keeps passwords out of Git (db_local_config.php is gitignored)
✅ Works the same for all team members (they use their own keys)

---

## Production vs Development

**Production (on server):**
- No tunnel needed
- `app_config.php` exists → uses `localhost:3306` directly

**Your Development (local):**
- Tunnel required
- `db_local_config.php` exists → uses `localhost:3307` (tunnel)

The code automatically detects which mode to use!

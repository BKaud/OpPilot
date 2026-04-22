# SSH Setup Guide for Database Tunnel

## Quick Start - Generate and Add SSH Key

### Step 1: Generate SSH Key (if you don't have one)

```powershell
# Check if you already have an SSH key
Test-Path ~\.ssh\id_rsa.pub

# If False, generate a new key:
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
# Press Enter to accept default location
# Enter a passphrase or press Enter for no passphrase
```

### Step 2: Copy Your Public Key to the Server

**Option A - Using ssh-copy-id (if available):**
```powershell
ssh-copy-id bitnami@3.142.11.187
```

**Option B - Manual Copy (Windows):**
```powershell
# Display your public key
Get-Content ~\.ssh\id_rsa.pub

# Copy the output, then SSH to server with password:
ssh bitnami@3.142.11.187

# On the server, run:
mkdir -p ~/.ssh
chmod 700 ~/.ssh
echo "PASTE_YOUR_PUBLIC_KEY_HERE" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
exit
```

**Option C - One-liner (if you have password access):**
```powershell
type $env:USERPROFILE\.ssh\id_rsa.pub | ssh bitnami@3.142.11.187 "mkdir -p ~/.ssh && chmod 700 ~/.ssh && cat >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys"
```

### Step 3: Test SSH Connection

```powershell
# This should connect without asking for a password
ssh bitnami@3.142.11.187 "echo 'SSH key authentication works!'"
```

### Step 4: Start the Tunnel

```powershell
.\DBfiles\ssh_tunnel.ps1
```

---

## Alternative: Password Authentication

If you prefer to use password authentication (less secure, but works), you can modify the SSH command.

SSH with password will prompt you each time, but it will work without setting up keys.

---

## Troubleshooting

**"Permission denied (publickey)"**
- Your public key isn't on the server
- Follow Step 2 again

**"ssh-keygen not found"**
- Install OpenSSH: Settings → Apps → Optional Features → Add OpenSSH Client

**"Connection refused"**
- Check the server allows SSH connections
- Verify you're using the correct SSH port (default: 22)

**Tunnel connects but no port 3307**
- Check if MySQL on the server allows localhost connections
- Verify MySQL is running on the server

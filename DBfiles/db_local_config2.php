<?php
// DBfiles/db_local_config.php
// This file is gitignored - your passwords stay private!
// Edit these with your actual database credentials
 
// OPTION 1: Using SSH Tunnel (Recommended for remote databases)
// Run ssh_tunnel.bat first, then use:
define('DB_HOST', 'localhost');
define('DB_PORT', 3307);  // Local tunnel port
 
// OPTION 2: Direct Connection (if port 3306 is publicly accessible)
// define('DB_HOST', '3.142.11.187');
// define('DB_PORT', 3306);
 
define('DB_USER', 'root');
define('DB_PASS', 'A6^^tcB3H4lT7e');
define('DB_NAME', 'oppilot');
#!/bin/bash

# Check if the user has root privileges
if [[ ! $(id -u) -eq 0 ]]; then
    echo "This script requires root privileges. Please run it with sudo."
    exit 1
fi

# Execute the commands
sudo git pull
sudo php artisan route:cache
sudo php artisan config:cache
sudo php artisan view:cache
sudo php artisan optimize:clear
sudo php artisan queue:clear
sudo php artisan cache:clear
sudo php artisan config:clear
sudo php artisan route:clear
sudo php artisan view:clear
sudo php artisan queue:restart

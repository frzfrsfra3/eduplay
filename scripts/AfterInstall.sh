#!/bin/bash

#

cd /var/www/html
#sudo mount -t nfs4 -o nfsvers=4.1,rsize=1048576,wsize=1048576,hard,timeo=600,retrans=2,noresvport fs-839e9603.efs.us-east-1.amazonaws.com:/ public/

cp /var/www/html/public/.env .env 2>&1 | tee /home/ubuntu/out.log

sudo chmod -R 777 /var/www/html/public/assets/
#
# Run composer
#sudo composer install 2>&1 | tee /home/ubuntu/out.log

sudo chmod -R 777 /var/www/html/public/assets/eduplaycloud 2>&1 | tee /home/ubuntu/out.log



sudo chmod -R 0777 /var/www/html/storage 2>&1 | tee /home/ubuntu/out.log
sudo chmod -R 0777 /var/www/html/bootstrap 2>&1 | tee /home/ubuntu/out.log

#!/bin/bash
rm -rf /opt/codedeploy-agent/deployment-root/deployment-instructions/*-cleanup
shopt -s extglob
cd /var/www/html
rm -rf !(public)
rm -rf .git*
rm -rf .en*
rm -rf .id*
rm -rf '.env2(client)'
rm -rf '.env1(client)'
rm -rf .ht*

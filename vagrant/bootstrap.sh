#!/usr/bin/env bash

apt-get update
#Git
apt-get install -y git
apt-get install -y dos2unix
apt-get install -y vera++
apt-get install -y apache2



if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant /var/www
fi
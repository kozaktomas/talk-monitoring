#!/usr/bin/bash

# DO NOT USE FOR PRODUCTION ENVIRONMENT (OR YOUR OWN MACHINE)
# script prepare environment for docker-compose
# tested on Ubuntu 20.04

# replace debian mirror - DO seems to be useless
cp sources.list /etc/apt/sources.list

# install dependencies
apt-get update
apt-get upgrade -y
apt-get install -y \
  curl \
  git \
  zsh \
  build-essential \
  htop \
  apache2-utils \
  iputils-ping \
  netcat \
  libfcgi0ldbl \
  whois

# install docker engine and docker-compose
curl -fsSL https://get.docker.com -o get-docker.sh
chmod +x get-docker.sh
./get-docker.sh
apt install -y docker-compose

# make vim beautiful
git clone --depth=1 https://github.com/amix/vimrc.git ~/.vim_runtime
sh ~/.vim_runtime/install_awesome_vimrc.sh

# install ohmyzsh and do NOT run it immediately
RUNZSH=no sh -c "$(curl -fsSL https://raw.github.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"

# aliases
echo -e "\nPROMPT='%(?.%F{green}√.%F{red}?%?)%f %B%F{240}%1~%f%b %# '" >> /root/.zshrc
echo -e "\nalias d=\"docker\"" >> /root/.zshrc
echo -e "\nalias dc=\"docker-compose\"" >> /root/.zshrc

# hostname
hostname demo
echo "demo" > /etc/hostname

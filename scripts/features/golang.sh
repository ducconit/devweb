#!/usr/bin/env bash

if [ -f ~/.features/wsl_user_name ]; then
  WSL_USER_NAME="$(cat ~/.features/wsl_user_name)"
  WSL_USER_GROUP="$(cat ~/.features/wsl_user_group)"
else
  WSL_USER_NAME=vagrant
  WSL_USER_GROUP=vagrant
fi

export DEBIAN_FRONTEND=noninteractive

if [ -f /home/$WSL_USER_NAME/.features/golang ]; then
  echo "Golang already installed."
  exit 0
fi

touch /home/$WSL_USER_NAME/.features/golang
chown -Rf $WSL_USER_NAME:$WSL_USER_GROUP /home/$WSL_USER_NAME/.features

ARCH=$(arch)

# Install Golang
golangVersion="1.21.2"
if [[ "$ARCH" == "aarch64" ]]; then
  wget https://dl.google.com/go/go${golangVersion}.linux-arm64.tar.gz -O golang.tar.gz
else
  wget https://dl.google.com/go/go${golangVersion}.linux-amd64.tar.gz -O golang.tar.gz
fi

tar -C /usr/local -xzf golang.tar.gz go
printf "\nPATH=\"/usr/local/go/bin:\$PATH\"\n" | tee -a /home/vagrant/.profile
rm -rf golang.tar.gz

# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  config.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
  config.vm.network "public_network"
  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 19132, host: 19132, protocol: 'tcp'
  config.vm.network "forwarded_port", guest: 19132, host: 19132, protocol: 'udp'

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.provider "vmware_fusion" do |vb|
    # Customize the amount of memory on the VM:
    vb.memory = "1024"
  end
  config.vm.provision "shell", inline: $script
end

$script = <<SCRIPT
apt-get update
apt-get -y install perl gcc g++ make automake libtool autoconf m4 gcc-multilib
sudo -u vagrant 'cd && wget -q -O - http://get.pocketmine.net/ | bash -s - -v beta'
SCRIPT
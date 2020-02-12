sudo apt-get -y update && sudo apt-get -y upgrade && sudo apt-get -y install git unzip;
git clone https://github.com/veldera/customer_portal.git;
cd customer_portal;
sudo ./install.sh | tee customerportal-install.log;
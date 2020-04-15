#!/bin/bash
history >> ~/gity/webdev1/historiaubuszyny2.txt
#sudo apt-get update
sudo aureport -x --summary
sudo aureport --failed #failed logins: 4171
sudo aureport -f -i # dostepy do plikow systemowych
rsync -aHAXvh --update --stats /var/www ~/gity/kopianextgen/ #katalog www jest kopiowany do kopianextgen

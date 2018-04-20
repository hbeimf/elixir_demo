#! /usr/bin

# server="47.106.78.218"
server="192.168.1.49"

# sshpass -f /etc/test_password.txt scp -r -v /mnt/web/m.demo.com/application/controllers root@${server}:/mnt/web/m.demo.com/application
# sshpass -f /etc/test_password.txt scp -r -v /mnt/web/m.demo.com/application/views root@${server}:/mnt/web/m.demo.com/application
# sshpass -f /etc/test_password.txt scp -r -v /mnt/web/m.demo.com/public/js_src root@${server}:/mnt/web/m.demo.com/public
# sshpass -f /etc/test_password.txt scp -r -v /mnt/web/m.demo.com/public/js root@${server}:/mnt/web/m.demo.com/public

sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/application/* root@${server}:/mnt/web/m.demo.com/application/
# sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/application/views/* root@${server}:/mnt/web/m.demo.com/application/views/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/css/* root@${server}:/mnt/web/m.demo.com/public/css/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/image/* root@${server}:/mnt/web/m.demo.com/public/image/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/js_src/* root@${server}:/mnt/web/m.demo.com/public/js_src/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/js/* root@${server}:/mnt/web/m.demo.com/public/js/

sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/bin/* root@${server}:/mnt/web/m.demo.com/bin/

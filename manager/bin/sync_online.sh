#! /usr/bin

server="192.168.1.50"

# scp -r /mnt/web/m.demo.com/application/controllers root@${server}:/mnt/web/m.demo.com/application
# scp -r /mnt/web/m.demo.com/application/views root@${server}:/mnt/web/m.demo.com/application
# scp -r /mnt/web/m.demo.com/public/js_src root@${server}:/mnt/web/m.demo.com/public
# scp -r /mnt/web/m.demo.com/public/js root@${server}:/mnt/web/m.demo.com/public

# sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/application/controllers/* root@${server}:/mnt/web/m.demo.com/application/controllers/
# sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/application/views/* root@${server}:/mnt/web/m.demo.com/application/views/
# sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/js_src/* root@${server}:/mnt/web/m.demo.com/public/js_src/
# sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/js/* root@${server}:/mnt/web/m.demo.com/public/js/


sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/application/* root@${server}:/mnt/web/m.demo.com/application/
# sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/application/views/* root@${server}:/mnt/web/m.demo.com/application/views/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/css/* root@${server}:/mnt/web/m.demo.com/public/css/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/image/* root@${server}:/mnt/web/m.demo.com/public/image/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/js_src/* root@${server}:/mnt/web/m.demo.com/public/js_src/
sshpass -f /etc/test_password.txt rsync -aP /mnt/web/m.demo.com/public/js/* root@${server}:/mnt/web/m.demo.com/public/js/

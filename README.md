# surf
Moves S.A.F.E. blocks into UFW



1) Load the script to your Endpoints server (suggest /usr/local/scripts/surf.php)

2) Edit constants at top of file (define lines)

3) Make the script executable chmod +x surf.php

4) Install php curl if not installed: apt-get install php-curl

4) Create cron job edit /etc/crontab, add line like */5 * * * * root /usr/local/scripts/surf.php 0

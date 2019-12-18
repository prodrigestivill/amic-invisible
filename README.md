Amic Invisible
Amigo Invisible
Secret Santa

Tools to send mails with this kind of game.
Replace list.txt and configure send-conf.inc.php following the examples.
Run the app using php-cli:
```
php relations-test.php [list.txt]
php send-test.php [list.txt] [send-conf.inc.php]
php send.php [list.txt] [send-conf.inc.php]
```

It also can be run also using Docker:
```
./docker-run.sh relations-test.php [list.txt]
./docker-run.sh send-test.php [list.txt] [send-conf.inc.php]
./docker-run.sh send.php [list.txt] [send-conf.inc.php]
```

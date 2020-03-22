#!/bin/sh

php /home/php/src/bin/console "doctrine:migrations:migrate" "-n"
php /home/php/src/bin/console "server:run" "0.0.0.0:8000"
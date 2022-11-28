web: $(composer config bin-dir)/heroku-php-apache2 public/
release: php bin/console cache:clear && php bin/console cache:warmup && php bin/console doctrine:migrations:migrate


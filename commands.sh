#!/bin/sh

composer install
chmod -R 777 tests/bin/yii;
while ! printf 'Y\ny'| php yii migrate; do sleep 5; done
apache2ctl -DFOREGROUND

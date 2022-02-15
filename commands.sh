#!/bin/sh

composer install
while ! printf 'Y\ny'| php yii migrate; do sleep 5; done
apache2ctl -DFOREGROUND

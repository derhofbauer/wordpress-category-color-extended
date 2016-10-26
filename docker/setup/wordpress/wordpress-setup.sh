#!/bin/bash

#############################################
# Importing wp-config.php on every startup! #
#############################################
echo 'importing wp-config.php'
rm wp-config.php
ln -s /docker/setup/wordpress/wp-config.php wp-config.php

#######################################################
# Running default entrypoint script of this container #
#######################################################
/usr/local/bin/docker-entrypoint.sh 'apache2-foreground'
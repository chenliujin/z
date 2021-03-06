#!/bin/bash

rsync --exclude "*.swp" -avz --exclude "zc_install" --delete ../src/images/ /data/www/z/images/
rsync --exclude "*.swp" -avz --exclude "zc_install" --exclude "*configure.php" ../src/* /data/www/z/
rsync --exclude "*.swp" -avz --exclude "zc_install" --exclude "*configure.php" ../src/admin/* /data/www/z/chen/
rsync --exclude "*.swp" -avz --exclude "zc_install" --exclude "*configure.php" --delete ../src/includes/* /data/www/z/includes/


chmod a+w /data/www/z/logs
chmod a+w /data/www/z/cache
chmod a+w /data/www/z/images
chmod a+w /data/www/z/includes/languages/english/html_includes
chmod a+w /data/www/z/media
chmod a+w /data/www/z/pub


#!/bin/bash

rsync --exclude "*.swp" -avz --exclude "zc_install" --delete ../src/images/ /data/www/z/images/
rsync --exclude "*.swp" -avz --exclude "zc_install" ../src/* /data/www/z/

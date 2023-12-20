#!/bin/bash
set -e

while ! mysqladmin ping -h"localhost" --silent; do
    sleep 1
done

mysql -uroot < /data/mooc.sql

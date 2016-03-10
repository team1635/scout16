#!/bin/sh

#TODO: this shell does not work on hostgator
read -p "Database name: " db_name
read -p "Application user name: " user_name
read -p "Application user password: " passwd
read -p "FRC API user name: " api_user
read -p "FRC API token: " api_token

#TODO: the variables for cleaning up should be read from the existing infodb file.
sed -e "s/_scout16_/$db_name/g" cleandb_raw.sql | sed -e "s/_app_/$user_name/g" > cleandb.sql

sed -e "s/_scout16_/$db_name/g" createdb_raw.sql | sed -e "s/_password_/$passwd/g" | sed -e "s/_app_/$user_name/g" > createdb.sql
#TODO: the password appears in variable names and in comments and gets changed
# there too.  Fix it
sed -e "s/_scout16_/$db_name/g" infodb_raw.php | sed -e "s/_password_/$passwd/g" | sed -e "s/_app_/$user_name/g" > infodb.php
sed -e "s/_scout16_/$db_name/g" insert_event_raw.sql > insert_event.sql

sed -e "s/_user_/$api_user/g" token_info_raw.php | sed -e "s/_token_/$api_token/g" > token_info.php

#TODO: write install file
#shell> mysql db_name < script.sql > output.tab:

* index.html -> main landing page for the app. Scouting match page 
  (lib/css/bootstrap.min.css, lib/css/main.css)
  (lib/js/jquery-1.10.1.js, lib/js/bootstrap.min.js, lib/js/index/stat.js)
  getMatch.php
  saveStat.php
  tab: Match
  tab: Auto
  tab: Tele Op
  tab: Save
  tab: Help
----------
* adminMenu.html -> admin menu page
  (lib/css/bootstrap.min.css, lib/css/main.css)
  (lib/js/jquery-1.10.1.js, lib/js/bootstrap.min.js, lib/js/index/saveCurrent.js)
  getMatch.php
  loadMatches.php
  tab: Set Current
  tab: Load Matches
----------
* infodb.php -> database login to be included in php files
----------
* getMatch.php -> gets data for the current match for the scouting page, so
  the scout can pick a team to follow through the match. Also used in 
  the adminMenu.html to determine the current match
----------
* saveStat.php -> saves the team stats for the match. used in index.html
----------
* saveCurrent.php -> saves what the next match is from the admin Menu
----------
* loadMatches.php -> called from adminMenu to scrape event info and load
  into table.
  lib/simple_html_dom.php
----------
* report.html -> the list of all matches (left) with links to the teams
----------
* getTeamReport.php ->  stats so far for a team
----------
lib/
  * simple_html_dom.php -> used to scrape the event to load matches
  css/
    * bootstrap.min.css
    * main.css -> empty, but there is stuff to be put there.
  js/
    * bootstrap.min.js
    * jquery-1.0.1.js
    index/
      * stat.js -> some functions for index.html
    adminMenu/
      * saveCurrent.js -> some functions for adminMenu
        saveCurrent.php
    report/
      report.js

=================
TODO

1) figure out how the first row is to be inserted into current_;
8) decide file naming convention: camel case or underscore separated
9) upgrade bootstrap, jquery, html_dom.php
10) should have build commands (ant, whatever) to stage the programs
  (fill in the real password), and sync with the website

101) Low priority: use Angular.js

=================
Junk (appears to be)
template.html
* getReport.php -> attempt to implement TODO #6
* report_temp.html -> attempt to implement TODO #6

Other:
Getting the following error from VS Code:
  Cannot validate the php file. The php program was not found. 
  Use the 'php.validate.executablePath' setting to conf ...
  
For event codes use:
http://frc-events.firstinspires.org/

Web services project:
https://usfirst.collab.net/sf/projects/first_community_developers/

Web services documentation:
http://docs.frcevents2.apiary.io/#reference

=================
Create database in cpanel
Create dba user in cpanel (let them pick the password)
Add dba user to database in cpanel
Add app user to database in cpanel

On your development machine run
build/clean.bat
On your web server run (if already deployed)
~/dev/scout16/clean.sh
On your development machine run
build/build.bat
build/deploy.bat
On your web server
cd ~/dev/scout16
chmod u+x configure.sh
chmod u+x clean.sh
chmod u+x deploy.sh
./configure.sh
mysql --user=teamadmn_dba --password=dba_pass teamadmn_scout16 < createdb.sql > createdb.log
mysql --user=teamadmn_app --password='app_pass' teamadmn_scout16 < insert_event.sql > insert_event.log


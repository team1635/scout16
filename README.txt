=================
Installation
------------

* Prerequisites
Install putty from http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html
Make sure you have the putty utilities in your path (especially pscp.exe)

* Instructions
Create database in cpanel
Create dba user in cpanel (let them pick the password)
Add dba user to database in cpanel
Add app user to database in cpanel
On the server create the *application directory* in a directory
 served by a web server (~/www/scout16) with php working
And the *config directory* somewhere else not served (~/dev/scout16)

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


=================
Deploy changes
--------------
On your development machine from the root of the project run
cd build
clean.bat
On your web server run (if already deployed)
cd ~/dev/scout16
./clean.sh
On your development machine run (still in the build directory)
build.bat
Answer D to the first question
Answer D to the second question
deploy.bat

=================
Helpful links
-------------
For event codes use:
http://frc-events.firstinspires.org/

Web services project:
https://usfirst.collab.net/sf/projects/first_community_developers/

Web services documentation:
http://docs.frcevents2.apiary.io/#reference

=================
Structure
---------

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

Junk (appears to be)
--------------------
template.html
* getReport.php -> attempt to implement TODO #6
* report_temp.html -> attempt to implement TODO #6

=================
TODO
----
2) write code that will load the defenses from the api. (test on NY)
  change the constants used for defense names to match the API
    in the database
DONE -    in the code
DONE -      Change the admin menu:
DONE -        separate match loading to a different page
DONE -        separate set current to two tabs 
DONE -          (one for setting current and one for setting defenses)
DONE -        if the match we're going to has defenses set, load them.
3) write code that will compute the match stats using the defenses.
4) write the team report to show the actual defenses, not the generic ones
5) Make HTML report that works like getTeamReport, but returns all the teams 
  with the stats as columns. For AJ's AppSheet scouting app.
6) AJ is doing this. Playoff alliance building screen:
    Only list teams that we can pick (below us);
    If a team gets picked before we pick them, take them off the list.
    Figure out what our picking criteria is.
      Bogdan: pick high shooter.
      Gus: robot shouldn't die first;      

Medium Priority
7) figure out how the first row is to be inserted into current_;
8) report.html should be dynamically generated (i.e. php)
9) report.html should be called ourMatches.php
10) decide file naming convention: camel case or underscore separated
11) upgrade bootstrap, jquery, html_dom.php
12) Add null to the list of defense choices.


Low Priority
101) Use Angular.js
102) Prevent event matches from loading a second time.
103) better build commands (ant, whatever) to stage the programs
  (fill in the real password), and sync with the website
104) Write test scripts
105) Find better way to layout the buttons other than current bootstrap hack.
106) Clean up getMatchReport.php.  It has weird backslash at top.

DONE
DONE - 1) clean duplicate NY matches from database;
  DONE - a) backup the database: Bogdan xps c:\dev\scout16\db\backup\teamadmn_scout16.20160326_01.sql  
  DONE - b) move scouting records from second load to first load 
    none of the duplicate records were scouted
    script used is in Bogdan xps c:\dev\scout16\db\backup\fix_dbl_match.sql
  NOT DONE - x) low: deploy app to test server
NOT DONE - 1.2) (bad crieteria I think) Level of 1-4 about how accurately do they drive.
    (use the number of high goals)
DONE - 1.1) add scouting variable for robot dying during match.
  DONE - added column to db/createdb_raw.sql
  DONE - added column to team1635.org/teamadmn_scout16 db
  DONE - modify Reference.xlsx to add the new column
  DONE - add new button to app/index.html right column
  DONE - modify app/saveStat.php
  DONE - modify app/lib/js/index/stat.js
  DONE - had to fix build/deploy.bat
  DONE - add stat to getTeamReport.php

=================
Questions
---------
How do I set up php so VS code knows about the syntax?
Getting the following error from VS Code:
  Cannot validate the php file. The php program was not found. 
  Use the 'php.validate.executablePath' setting to conf ...
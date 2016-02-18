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
1) Move js from the html to the appropriate file
  a) the AJAX stuff seems identical
2) Move css from the html to the appropriate file
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
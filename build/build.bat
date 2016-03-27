xcopy ..\app\lib app\lib /s /e /y
xcopy ..\app\index.html app
xcopy ..\app\adminMenu.html app
xcopy ..\app\saveCurrent.php app
xcopy ..\app\getMatch.php app
xcopy ..\app\loadMatches.php app
xcopy ..\app\loadMatchesApi.php app
xcopy ..\app\saveStat.php app
xcopy ..\app\report.html app
xcopy ..\app\getTeamReport.php app
xcopy ..\app\loadMatchResult.php app

rem xcopy ..\db db /s /e /y
xcopy ..\db\clean.sh db
xcopy ..\db\cleandb_raw.sql db
xcopy ..\db\configure.sh db
xcopy ..\db\createdb_raw.sql db
xcopy ..\db\deploy.sh db
xcopy ..\db\infodb_raw.php db
xcopy ..\db\insert_current_raw.sql db
xcopy ..\db\insert_event_raw.sh db
xcopy ..\db\token_info_raw.php db

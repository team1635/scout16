@ECHO OFF
SET /p login=Enter login (teamadmn@team1635.org):
IF NOT DEFINED login (set login=teamadmn@tam1635.org)
SET /p appdir=Enter remote application directory (www/scout16): 
IF NOT DEFINED appdir (set appdir=www/scout16)
SET /p devdir=Enter remote config area (dev/scout16):
IF NOT DEFINED confdir (set confdir=dev/scout16)

pscp -P 2222 -sftp -r app/* %login%:%appdir%
pscp -P 2222 -sftp -r db/* %login%:%devdir%


@echo off
rem Purpose: To set the path automatically and to start the console
rem Double click this batch file to start bake
rem You have to create app folder first, otherwise, it will be automatically created
if not exist ..\..\..\..\app md ..\..\..\..\app
cmd /k "title=bake && echo Usage: cake commands && echo Note: For inital bake, just type: cake bake && echo Files to tweak: .htaccess, config.php, database.php  && echo Suggested order of baking: (Project - auto), Models, Controllers, Views && cd ..\..\..\..\app && path=%path%;%cd%;D:\Program Files\xampp\php"
## Test task for PHP developer
Overview

The game is like "Who Wants to Be a Millionaire?"

•	During each game, the player is asked 5 questions randomly selected from the base and not repeated during one game. For each question there are possible answer options (n number) and only one of them is correct. When the player chooses one of the answer options, the system informs about the problem being right or wrong.
•	Each question has its corresponding point. (for example, according to its complexity). If the answer is correct, the point for the given question is added to the points calculated for the given game, and each question can have 5-20 points. In case of an incorrect answer, the points are not added and the player is notified about the correct answer.
•	At the end of the game, the player is shown the number of points he has collected. This is the main problem where you need to manually add data to the Database; the content of the questions, of course, is not essential.
•	After completing this part, send it to us and continue working on the rest. Add Login Admin who can add / delete / modify questions, options for answering those questions and the right option, as well as the point for each question. Create a sign-in and log-in possibility (Name, Surname, Password). Playing is possible only after logging in. The best result is calculated for each user and the top ten is displayed on the screen (names and the highest score) based on the users’ best results.


## How to run project
project info:
- it is done using Laravel framework
- I used Mysql for db
- just copy/pull the code and then run following commands

config the .env file according to your system, just add a table in DB and copy info to the .env file
mine was:

`DB_CONNECTION=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=stdtest`

`DB_USERNAME=stdtest`

`DB_PASSWORD=stdtest`

`APP_URL=http://localhost:8000` or something like this
just remember to enter url completely

then run following commands

`composer install` to install required packages

`php artisan migrate:fresh --seed` to generate tables and admin panel and import some data

And finally run 

`php artisan serve`

you can access admin panel using

APP_URL/admin

admin email:`admin@std.co`

admin password:`admin123`



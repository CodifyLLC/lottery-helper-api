# Install / Setup Instructions
1. Clone the repository to your local system
2. Create a new database
3. Make a copy of /env.dist.php and call it env.php
4. Add your database name, username, and password to the define functions
5. run `php composer.phar update` This will install the project dependencies AND execute the project SQL update files
6. run `php crons/fetchNumbers.php` This will populate the lottery numbers in the database


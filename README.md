# Install / Setup Instructions
1. Clone the repository to your local system
2. Create a new database
3. Make a copy of /env.dist.php and call it env.php
4. Add your database name, username, and password to the define functions
5. run `php composer.phar update` This will install the project dependencies AND execute the project SQL update files
6. run `php crons/fetchNumbers.php` This will populate the lottery numbers in the database
7. Create a virtual host entry in your httpd.conf file

# Api Documentation
To generate the API documentation run the following commands:

### Install apidoc command:
 `npm install apidoc -g`
 
### Generate the docs
`apidoc -i . -f index.php  -o docs/`

### View the documents
Open your web browser and browse to the domain / hostname you setup in your virtual host file, for example:
http://your.host.name/docs
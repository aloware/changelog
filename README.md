## About Changelog Mgr

Changelog Mgr is a web application for managing application changelogs. It houses modules for creating, updating and deleting changelogs as well as changelog categories.
This provides two outputs, changelog public page and the embeddable widget.


## Deployment Setup
1. Install Docker
    - Refer to https://docs.docker.com/engine/install/ for installation details.
2. Clone the project repository at https://github.com/aloware/changelog.
3. Create projects .env file using ```cp .env.example .env```, add/set the following environment variables.
   For Database and Redis, this is important as these variables will be used to configure the docker container. 
   ### Database
   - ```DB_HOST=mysql```
   - ```DB_PORT=3306```
   - ```DB_DATABASE=your_db_name```
   - ```DB_USERNAME=your_db_user```
   - ```DB_PASSWORD=your_db_user_pw```
    ### Redis
    - ```REDIS_CLIENT=predis```
    - ```REDIS_PORT=6379```
    ### Swagger / Open API
    - ```L5_SWAGGER_GENERATE_ALWAYS=true```
    

4. At the root of the project directory, open command line and run ```docker-compose up -d```, please note that it may take several seconds when running for the first time as it will download all necessary Docker images.
5. Run ```docker-compose exec app bash``` command to access app container command line and execute the following command,
    - ```composer install```
    - ```php artisan key:generate```
    

6. Run ```docker-compose exec mysql bash``` command to access mysql container command line. Login to mysql by executing the following command,
    - ```mysql -u root -p``` - when prompt for password, use DB_PASSWORD value.
    
    Add new user and grant privileges for that user using the following sql script.
    - ```CREATE USER 'db_user_defined_in_env_file'@'%' IDENTIFIED BY 'db_pw_defined_in_env_file';```
    - ```GRANT ALL ON *.* TO 'db_user_defined_in_env_file'@'%';```
    - ```FLUSH PRIVILEGES;```
7. Access app container command line (Step #5) and run ```php artisan migrate``` to run project migration.
8. Restart docker, ```docker-compose restart```.
9. Once done with the above steps, visit http://localhost:80 or http://your_server_ip, and you should see the login page of the Changelog Mgr.

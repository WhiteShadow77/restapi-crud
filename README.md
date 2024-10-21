###How to run (with Docker):

* Clone the repo https://github.com/WhiteShadow77/restapi-crud
* Create file ".env" and paste the content from file ".env.example"
* Run docker-compose up -d
* Run composer install
* Go inside the container docker exec -it restapi-crud_php-apache_1 bash
* Run php artisan migrate
* Run chmod -R 777 storage
* Run php artisan optimize
* Run php artisan migrate
* Run php artisan db:seed
* Open http://localhost/api/documentation
* To exit, press ctrl+D and run docker-compose down

git pull origin master
docker exec -it blog_backend composer update
docker exec -it blog_backend php artisan migrate:rollback
docker exec -it blog_backend php artisan migrate
sh!
ENV=./backend/.env
ENV_DEV=./backend/.env.dev

if [ -f "$ENV" ]; then
    echo "$ENV exists."
    docker-compose up -d
else 
    echo "$ENV does not exist."
    cp "$ENV_DEV" "$ENV"
    docker-compose up -d --build
    docker-compose exec -it backend composer install
    docker-compose exec -it backend php artisan migrate:fresh
    docker-compose exec -it backend php artisan db:seed
fi

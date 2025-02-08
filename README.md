# BUILD PROD:
- simvn-api:
cd /var/www/html/simthanglong
docker compose build simvn-api
<!-- docker cp simvn-api:/app/dist ./simvn-api/ -->
docker compose up -d

- stl_web
cd /var/www/html/simthanglong
docker compose build stl_web
docker compose up -d
docker exec -it stl_web php artisan optimize:clear

- how to change nginx.conf and apply to docker container
change file dtl-stl-new/deploy/nginx_vps.conf and run statement: 
docker compose up -d --force-recreate stl_web

- switch ve site cu tren con 96
cd /var/www/html/simthanglong
vi docker-compose.yaml
comment line: - ./dth_stl_new/deploy/nginx_vps.conf:/etc/nginx/nginx.conf
uncoment line: - ./dth_stl_new/deploy/nginx_old.conf:/etc/nginx/nginx.conf

docker compose up -d

- update .env stl_web hay simvn-api
run: 
cd /var/www/html/simthanglong
docker compose up -d
docker exec -it stl_web php artisan optimize

- change nginx.conf file
docker compose restart stl_web
docker exec -it stl_web nginx -t


# loi thuong gap
-1, sau khi pull code ve loi 500, check log permission denied
docker exec -it stl_web php artisan optimize
- loi Empty reply from server,
tang max_memory_restart trong ecosystem.config.js
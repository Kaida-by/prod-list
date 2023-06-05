FROM nginx:1.20-alpine

COPY ./docker/nginx-backend/dev.nginx.conf /etc/nginx/conf.d/default.conf
#COPY ./docker/ssl/edu.crt /etc/nginx/ssl/edu.crt
#COPY ./docker/ssl/edu.key /etc/nginx/ssl/edu.key

ARG NGINX_PORT
RUN sed -i "s|__LISTEN_PORT__|$NGINX_PORT|" /etc/nginx/conf.d/default.conf

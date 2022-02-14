FROM nginx:1.21.5

LABEL maintainer="Muhammad Raza <razachohan@gmail.com>"

RUN mkdir -p /etc/nginx/templates \
    mkdir -p /tmp/nginx

COPY nginx.conf /etc/nginx/
COPY application.conf /etc/nginx/conf.d/

ARG NGINX_SERVER_NAME

RUN echo "upstream php-upstream { server php:9001; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
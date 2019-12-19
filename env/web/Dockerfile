FROM nginx:1.14.2-alpine

COPY default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/app
CMD exec nginx -g 'daemon off;'
FROM nginx:stable-alpine

RUN mkdir -p /var/www/SellNow/public

ADD nginx.default.conf /etc/nginx/conf.d/default.conf

ENV NGINXUSER=sellnow
ENV NGINXGROUP=sellnow

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}
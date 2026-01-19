FROM composer:2

ENV COMPOSERUSER=sellnow

ENV COMPOSERGROUP=sellnow

RUN adduser -g ${COMPOSERGROUP} -s /bin/sh -D ${COMPOSERUSER}
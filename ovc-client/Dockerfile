FROM node:19-alpine3.16

WORKDIR /var/www

RUN apk update && apk add \
  yarn \
  make \
  g++ \
  bash

COPY package.json .
RUN yarn

COPY . .

ADD . .

EXPOSE 80
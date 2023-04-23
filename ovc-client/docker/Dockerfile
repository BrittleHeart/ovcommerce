FROM node:20-alpine3.16

WORKDIR /var/www

RUN apk update && apk add \
    yarn

COPY package.json .

RUN yarn

EXPOSE 80

CMD yarn dev
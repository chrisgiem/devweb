#lightweight node.js
FROM node:10-slim

WORKDIR /usr/src/app

COPY package*.json ./

RUN npm install --only=production

# copy local code to the container image
COPY . ./

CMD [ "npm", "start" ]
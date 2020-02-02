FROM node:lts-alpine

RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app

# create app directory
WORKDIR /home/node/app

# rowniez lock
COPY package*.json ./

USER node

# albo npm ci --only=production
RUN npm install

# bundle app source
COPY --chown=node:node . .

EXPOSE 8080

CMD [ "nodemon", "server.js" ]

# docker build -t chat . && docker run -p 80:8080 -it chat  
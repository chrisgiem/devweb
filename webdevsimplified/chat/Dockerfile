FROM node:lts-alpine

##RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app
#RUN npm install -g nodemon

# create app directory
#WORKDIR /home/node/app
WORKDIR /usr/src/app

# rowniez lock
COPY package*.json ./

#USER node

# albo npm ci --only=production
RUN npm install

#RUN npm install -g nodemon
#COPY --chown=node:node . .
COPY . .

#EXPOSE 8080
EXPOSE 3000

#CMD [ "nodemon", "server.js" ]
#CMD [ "node", "server.js" ]
CMD [ "npm", "devStart" ]

# docker build -t chat . && docker run -p 443:8080 -it chat  

//const Person = require('./person');
////import Person from './person'; nie
//
////console.log(person.name);
//const person1 = new Person('John Doe', 30);
//
//person1.greeting();

///const Logger = require('./logger');
///
///const logger = new Logger();
///
///logger.on('message', data => console.log('Called Listener', data));
///
///logger.log('Hello World');
///logger.log('Hi');
///logger.log('Hello');

const http = require('http');
const path = require('path');
const fs = require('fs');

const server = http.createServer((req, res) => {
    if(req.url === '/'){
        res.end('<h1>Homepage</h1>');
    }
    //console.log(req.url);
});

const PORT = process.env.PORT || 5000;

server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
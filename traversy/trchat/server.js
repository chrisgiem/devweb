const mongo = require('mongodb').MongoClient;
const client = require('socket.io').listen(4000).sockets;

// connect to mongodb
mongo.connect('mongodb://127.0.0.1/mongochat', function (err, db) {
  if (err) {
    throw err;
  }

  console.log('MongoDB connected');

  //connect do socket.io
  client.on('connection', function (socket) {
    let chat = db.collection('chats');

    // Create function to send status
    sendStatus = function (s) {
      socket.emit('status', s);
    };

    //get chats from mongo collection
    chat
      .find()
      .limit(100)
      .sort({ _id: 1 })
      .toArray(function (err, res) {
        if (err) {
          throw err;
        }

        //emit the messages
        socket.emit('output', res);
      });

    //handle input events
    socket.on('input', function (data) {
      let name = data.name;
      let message = data.message;

      //check for name and message
      if (name == '' || message == '') {
        //send error status
        sendStatus('podaj nick i wiadomość');
      } else {
        // insert message
        chat.insert({ name: name, message: message }, function () {
          client.emit('output', [data]);

          // send status object
          sendStatus({
            message: 'Wiadomość wysłana',
            clear: true
          });
        });
      }
    });

    // handle clear
    socket.on('clear', function (data) {
      // remove all chats from collection
      chat.remove({}, function () {
        //emit cleared
        socket.emit('cleared');
      });
    });
  });
});
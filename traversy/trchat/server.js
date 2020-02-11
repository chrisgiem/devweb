const mongo = require('mongodb').MongoClient;
const klient = require('socket.io').listen(4000).sockets;                         // port !!!!!!!!!!!!!!!!!

// connect to mongodb 3!!
///mongo.connect('mongodb://127.0.0.1/mongochat', (err, client) => {
///  var db = client.db('mongochat');
///  if (err) {
///    throw err;
///  }
mongo.connect('mongodb://mongochat:27017/mongochat', (err, client) => {
  var db = client.db('mongochat');                                                  // port !!!!!!!!!!!!!!!!!
  if (err) {
    throw err;
  }

  console.log('MongoDB connected');

  //connect do socket.io
  klient.on('connection', function (socket) {
    let chat = db.collection('chats');

    // Create function to send status
    sendStatus = function (s) {
      socket.emit('status', s);
    }

    //get chats from mongo collection
    chat.find().limit(100).sort({ _id: 1 }).toArray(function (err, res) {
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
        sendStatus('podaj nazwę użytkownika i wiadomość');
      } else {
        // insert message
        chat.insert({ name: name, message: message }, function () {
          klient.emit('output', [data]);

          // Send status object
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

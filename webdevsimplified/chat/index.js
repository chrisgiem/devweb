<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>komunikator</title>
    <script defer src="https://localhost:3000/socket.io/socket.io.js"></script>
    <script defer src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <!--<div class="main">-->
    <div id="message-container"></div>
    <form id="send-container">
      <input type="text" id="message-input" />
      <button type="submit" id="send-button">Wyślij</button>
    </form>
  </body>
</html>

const socket = io('http://localhost:3000')
const messageContainer = document.getElementById('message-container')
const messageForm = document.getElementById('send-container')
const messageInput = document.getElementById('message-input')

const name = prompt('wpisz nick')
appendMessage('połączono poprawnie')
socket.emit('new-user', name)

socket.on('chat-message', data => {
  appendMessage(`${data.name}: ${data.message}`)
})

socket.on('user-connected', name => {
  appendMessage(`${name} połączony`)
})

socket.on('user-disconnected', name => {
  appendMessage(`${name} rozłączony`)
})

messageForm.addEventListener('submit', e => {
  e.preventDefault();
  const message = messageInput.value
  appendMessage(`Ty: ${message}`)
  socket.emit('send-chat-message', message)
  messageInput.value = ''
})

function appendMessage(message) {
  const messageElement document.createElement('div')
  messageElement.innerText = message
  messageContainer.append(messageElement)
}
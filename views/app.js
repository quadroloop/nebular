
const socket = io()

function callDB() {
  socket.emit("updatedb")
}
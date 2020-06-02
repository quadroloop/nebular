

function callDB() {
  var info = { id: '1234' }
  socket.emit("init", info)
}
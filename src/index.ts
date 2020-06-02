import express from 'express'
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http);

import moment from 'moment'

require('dotenv').config();

io.set('origins', '*:*');

let port = process.env.PORT || 7000;

app.use(express.static('views'));
http.listen(port);

console.log(`===============================`)
console.log(`Nebular Server: ${port}`)
console.log(`===============================`)




app.get("/", (req, res) => {
  res.send({
    message: "Nebular Core v. 1.0",
    status: "running"
  })
})



io.sockets.on('connection', function (socket) {
  socket.on("update", () => {
    console.log('nebular ====> update')
  })
});
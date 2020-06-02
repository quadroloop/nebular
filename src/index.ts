import express from 'express'
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http);

import moment from 'moment'
import { deflate } from 'zlib';
import { ENGINE_METHOD_ALL } from 'constants';

require('dotenv').config();

io.set('origins', '*:*');

let port = process.env.PORT || 7000;

app.use(express.static('views'));
http.listen(port);

var nodeList = [];


console.log(`===============================`)
console.log(`Nebular Server: ${port}`)
console.log(`===============================`)


app.get("/", (req, res) => {
  res.send({
    message: "Nebular Core v. 1.0",
    status: "running"
  })
})


io.sockets.on('connection', function (socket: any) {



  // for initilisation of a node
  socket.on("init",(data) => {
  console.log(`[nebular] :: init :: nodeID => ${data.nodeID} : ${Date.now()}`)

  if (!nodeList.includes(data.nodeID)) {
    nodeList.push(data.nodeID)
    }

    io.emit("nodes",nodeList)

  })


  socket.on("getNodes",()=>{
    io.emit("nodes",nodeList)
  })

// for datastore updates
  socket.on("update",(delta)=>{
   if(typeof delta === "object"){

  if (typeof delta.data === "object") {
    let date = Date.now()
    let newDelta = {
      date: date,
      origin: delta.nodeID,
      data: delta.data
    }

io.emit('updateDB',newDelta)
  } else {
    console.log('ERROR: (DB update ignored, format incorrect data format from source!)')
  }

    }else{
     console.log('ER ROR: ( DB  update ignored, format incorrect request format from source!)')
}
  })


});
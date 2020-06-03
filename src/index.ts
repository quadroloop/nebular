import express from 'express'
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http);

require('dotenv').config();

io.set('origins', '*:*');

let port = process.env.PORT || 7000;

app.use(express.static('client'));
http.listen(port);

var collections = {};
var nodeList = [];


console.log(`===============================`)
console.log(`Nebular Server: ${port}`)
console.log(`===============================`)


app.get("/nebular", (req, res) => {
  res.send({
    message: "Nebular Core v. 1.0",
    status: "running",
    total_nodes: nodeList.length,
    total_collections: Object.keys(collections).length
  })
})

io.sockets.on('connection', function (socket: any) {

  // for initilisation of a node
  socket.on("init", (node) => {
    console.log(`[nebular] :: init :: nodeID => ${node.nodeID} : ${Date.now()}`)

    if (!collections[node.uid]) {
      collections[node.uid] = {
        lastUpdate: Date.now(),
        data: node.data
      }

      if (!nodeList.includes(node.nodeID)) {
        nodeList.push(node.nodeID)
      }
      io.emit("nodes", nodeList)
    } else {
      console.log(`[nebular] :: init :: nodeId => ${node.nodeID}: Joined collection`);
      io.emit("syncSearch", { key: node.uid })
    }
  })


  socket.on("getNodes", () => {
    io.emit("nodes", nodeList)
  })

  socket.on("nebular_event", (data) => {
    io.emit("nebularEvent", data)
  })


  // for datastore updates
  socket.on("update", (delta) => {
    if (typeof delta === "object") {

      if (typeof delta.newData === "object") {
        let date = Date.now()
        let newDelta = {
          lastUpdate: date,
          key: delta.key,
          data: delta.newData
        }
        io.emit('updateDB', newDelta)

      } else {
        console.log('ERROR: (DB update ignored, format incorrect data format from source!)')
      }

    } else {
      console.log('ERROR: ( DB  update ignored, format incorrect request format from source!)')
    }
  })
});
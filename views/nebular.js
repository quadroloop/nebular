



const socket = io();


const guid = () => {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

var seed;

function createNode() {

  var node = {
    nodeID: guid(),
    date: Date.now(),
    data: {}
    }

  localStorage.nebular = JSON.stringify(node);
socket.emit('init', node);
}

function nebularSeed(data) {
  if (typeof data === "object") {
    socket.emit("getNodes")
  }
  seed = data;
}

socket.on("nodes", nodes => {
  if (nodes.length === 1) {
    alert('seed it man!')
  } else {
    alert('check if seend is valid first')
  }
})


function nebularInit() {
  if (!localStorage.nebular) {
    createNode()
  }
}

nebularInit()


nebularSeed({ x: 1, y: 1 })
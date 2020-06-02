
const socket = io();


const guid = () => {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

var seed;

function createNode(key) {

  var node = {
    nodeID: guid(),
    uid: key,
    createdAt: Date.now(),
    lastUpdate: Date.now(),
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

// socket.on("nodes", nodes => {
//   if (nodes.length === 1) {
//     alert('seed it man!')
//   } else {
//     alert('check if seed is valid first')
//   }
// })

socket.on("updateDB", (dx) => {
  let key = JSON.parse(localStorage.nebular).uid
  if (dx.key === key) {
    let nebular = JSON.parse(localStorage.nebular);
    nebular.lastUpdate = dx.lastUpdate;
    nebular.data = dx.data;
    localStorage.nebular = JSON.stringify(nebular)
    }
  })


function nebularInit(key) {
  if (!localStorage.nebular) {
    createNode(key)
  }
}

function setNebula(data) {
  if (data && typeof data === 'object') {
    let key = JSON.parse(localStorage.nebular).uid
    socket.emit('update', { newData: data, key: key })
    }
}



function useNebula() {
    if (localStorage.nebular) {
         let dy = JSON.parse(localStorage.nebular)
          if(typeof dy === 'object') {
        return dy.data;
      } else {
        return undefined
      }
  }
  }




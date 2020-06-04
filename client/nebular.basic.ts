// Nebular Client Module: for JS / React no types:

/*
 Dependencies:

 socket.io-client

*/

import io from 'socket.io-client'

// must be replaced with proper nebular server instance
const nebular_url = 'http://test-server.com'

const socket = io(nebular_url)

const guid = () => {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

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

socket.on("updateDB", (dx) => {
  let key = JSON.parse(localStorage.nebular).uid
  if (dx.key === key) {
    let nebular = JSON.parse(localStorage.nebular);
    nebular.lastUpdate = dx.lastUpdate;
    nebular.data = dx.data;
    localStorage.nebular = JSON.stringify(nebular)
  }
})

socket.on("syncSearch", (data) => {
  let db = useNebula();
  if (db && data.key === JSON.parse(localStorage.nebular).uid) {
    if (Object.keys(db).length > 0) {
      setNebula(db)
    }
  }
})

// main exports

export function validKey(key) {
  let result = false;
  if (localStorage.nebular) {
    let collection_key = JSON.parse(localStorage.nebular).uid;
    if (collection_key === key) {
      result = true;
    }
  }
  return result;
}

export function nebularEvent(name, data) {
  if (localStorage.nebular) {
    let key = JSON.parse(localStorage.nebular).uid
    socket.emit("nebular_event", { uid: key, name: name, data: data })
  } else {
    console.error("Nebular: invalid event call, nebular is not initialized.")
  }
}

export function nebularInit(key) {
  if (!localStorage.nebular) {
    createNode(key)
  }
}

export function setNebula(data) {
  if (data && typeof data === 'object') {
    let key = JSON.parse(localStorage.nebular).uid
    socket.emit('update', { newData: data, key: key })
  }
}

export function useNebula() {
  if (localStorage.nebular) {
    let dy = JSON.parse(localStorage.nebular)
    if (typeof dy === 'object') {
      return dy.data;
    } else {
      console.error('Nebular: useNebula: cannot fetch data, source must be an object')
      return undefined
    }
  }
}

// Event handling

socket.on("nebularEvent", (data) => {
  if (validKey(data.uid)) {
    console.log('valid session!')
  }
})
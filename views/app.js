

nebularInit('02fac7d2-9f59-47da-91ac-7724ee99a6f8')


function callDB() {
  localStorage.clear()
}


function addData() {
  setNebula({ tx: Date.now() })
}

function getData() {
  let data = JSON.stringify(useNebula())
  document.getElementById('x-data').innerHTML = data;
}
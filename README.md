![alt text](https://mist.now.sh/mist/nebular.png "Logo Title Text 1")
## nebular
> A super small, distributed, real-time and event-driven database for rapid web application prototyping.

##### Project Goal:
Remove the complexity required to create Web application prototypes that demonstrate real-time data processing across devices and networks. Which would allow faster and easier prototyping of concepts for the modern web.

##### Features:

- Real-time data updates
- Real-time events
- Client-side data store using LocalStorage (5MB limit in most browsers)
- Automatic data sync, (new and reinitialized nodes within an instance can instantly obtain previews data state as long as it remains intact in one of the nodes)

##### Client Usage:
nebular has multiple client-side modules that you can import to your project.
nebular has one dependency: socket.io

`ReactJS`
[ReactJS Client Module](/client/nebular.basic.ts)
[React with TypeSrcipt Client Module](/client/nebular.ts)
- nebular.basic.ts, can be renamed to `.js` to run it in react applications
```js
import { fetchNebula,
        nebularEvent,
        setNebula,
        validKey,
        socket } from './nebular'

 // create nebular instance
 // generate your random key to create instance id

 nebularInit('random-key-here');

 // get data from Instance

 let storage = fetchNebula();

 // update data of instance
 let data = {a:1, b:2, c:3};
 setNebula(data);
```
once `fetchNebula()` is called after an update, with will retrieve the updated data,
and the same will be true across every device running on the same instance.

`Real-time events without Persistence`
nebular supports a wrapper for data emits events through WebSockets, for sending data without persistence, hence, a remote procedure call.
```js

// broadcast event
nebularEvent("EVENT_NAME",{a:1,b:2,c:3})


// catch event
 socket.on("nebularEvent", (data) => {
    if (validKey(data.uid)) {
      if (data.name === "EVENT_NAME") {
         console.log(data) // {name: "EVENT_NAME", data: {a:1,b:2,c:3}}
      }
    }
  })
```

##### Vanilla JS Usage
if you prefer to code in vanilla JS the usage is simply use the same functions as with React the only difference is the import method.
[vanilla JS Client Module](/client/nebular.js)
```html
  <!-- include socket.io cdn -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
  <script src="nebular.js"></script>
```



##### Server Usage:
> You can simply clone this repository and deploy it in Heroku to have your server instance or run it locally. The client module highly depends on a server instance to work properly



##### Notes:

> Before using nebular, consider the list below. Since nebular is made solely for experimental purposes, no security measures for protecting data is implemented. Use the software at your own risk.

Recommended uses:
- POC (Proof of concept) Applications
- Prototypes
- Experiments

##### `Don't use for:`
  - Production Web Apps
  - Anything more advanced than a rough __Prototype.__
  - Anything handling sensitive user information




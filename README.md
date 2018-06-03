# nebular
![Shippable branch](https://img.shields.io/shippable/5444c5ecb904a4b21567b0ff/master.svg)  [![PHP from Packagist](https://img.shields.io/packagist/php-v/symfony/symfony.svg)]()

[![nebular](https://quadroloop.github.io/Apps/img/nebular.png)]()

> __nebular__ is a simple experimental Database/Web Storage Application written in Javascript and PHP

#### About the Project
>the goal of the project is to build a simple Web-base Database application that has the properties of webstorage. the object has a default property of a string and can be manipulated by Javascript. It's built mainly to support small scale Web-applications and rapid prototyping, as it only requires a PHP environment to run. 

## Usage:
> __Setting up nebular__
  these files and folder/s must be in the same directory
  you can clone this repo, by pasting this command on your terminal
  ```sh
    git clone https://github.com/quadroloop/nebular
  ```
  __or__ get the files manually.
  1.) __nebular.php__ - API and Web UI
  2.) __nebular-src__ -  (Folder) nebular depedencies
  3.) __nebular.api.js__ - Javascript API helper file
  4.) __[your web app file]__ - your index.php,index.html..etc that is going to access data from nebular API
  5.) __Running Nebular__ -- All you need is a PHP server environment to run nebular and the files listed above. (1-4), you can use Apache2, XAMPP, __or__ just use PHP 7+ and the command:
  ```sh
     php -S 127.0.0.1:80
  ```
  > __then__ open your browser and goto to http://127.0.0.1/__[your_path]__/nebular.php
  
  >> __Using the Web User Interface__
  > __Default login:__
  > __username:__ root
  > __password:__ admin
  > from here you can play around with the dashboard UI, its pretty simple and intuitive. although some what buggy on it's early stage.

  >> __Include JS API file in your webapp and setting up DB connection__
   ```html
     <script src="./nebular.api.js"></script>
     <script>
          var nb_DB = "db_sample"; // default sample database.
              nb_auth('X2X-VCX-KV11'); // X2X-VCX-KV11 - is the default API key you can add your own and delete existing keys.
     </script>
   ```
  >> __Communicating with Database__
  >> if Database connection is successful, you can use the DB calls below to communicate with the API 
  ```Javascript
  // nb_set(object,content) setting / creating and object
 // creates an object with the name of 'newObject' and content of 'this is an object'
   nb_set('newObject','this is an object');
   // nb_put(object,content) appending data to an existing object..
   nb_put('newObject','this is some added content');
   //nb_get(object) getting an object content ,this function will return the object content
   nb_get('newObject');
   
   // nb_select(object) performs an HTTP Promise request that allows the user to directy manipulate the response data
   nb_select('newObject').then((res)=> {
     alert(res.data);
   });
  ```
  
 
  

#### Project Status
  > Current Version : __Version 0.1__
  > Built-in UI Dashboard

#### Tech

__nebular__ uses the following techonologies to work.

| Project | Link |
| ------ | ------ |
| axios | https://github.com/axios/axios. |
| jquery | https://github.com/jquery/jquery |
| paper-dashboard | https://github.com/creativetimofficial/paper-dashboard  |
| sweetalert2 | https://github.com/sweetalert2/sweetalert2  |
| chart.js |https://github.com/chartjs/Chart.js |


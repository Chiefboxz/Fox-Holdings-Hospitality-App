//This is the place i got it from, with alot of related node db stuff. 
//This is just a start to test the connection ill properly integrate in when needed.
//https://github.com/Meeks91/nodeJS_OAuth2Example/tree/master/node_modules/mysql

var mysql = require('mysql');
var pool  = mysql.createPool({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'db_name'
});

pool.getConnection(function(err, connection) {
  // connected! (unless `err` is set)
});

//--->these may need to be on seperate pagtes the create and then connect to database

var mysql = require('mysql');
var pool  = mysql.createPool(...);

pool.getConnection(function(err, connection) {
  // Use the connection
  connection.query('SELECT * FROM user', function (error, results, fields) {
    // And done with the connection.
    connection.release();

    // Handle error after the release.
    if (error) throw error;

    // Don't use the connection here, it has been returned to the pool.
  });
});

//---> description from source...Events to handle the database pool connections...
//The pool will emit an acquire event when a connection is acquired from the pool.
//This is called after all acquiring activity has been performed on the connection, 
//right before the connection is handed to the callback of the acquiring code.

pool.on('acquire', function (connection) {
  console.log('Connection %d acquired', connection.threadId);
});

//The pool will emit a connection event when a new connection is made within the pool.
//If you need to set session variables on the connection before it gets used, you can listen to the connection event.

pool.on('connection', function (connection) {
  connection.query('SET SESSION auto_increment_increment=1')
});

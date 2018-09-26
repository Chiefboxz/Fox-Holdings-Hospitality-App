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

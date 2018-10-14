//cant do any testing just created this in hopes it can help untill i figure out how rrynards db con works
var mysql      = require('mysql')
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'lecafe'
});
connection.connect(function(err){
if(!err) {
    console.log("Database is connected")
} else {
    console.log("Error while connecting with database")
}
});
module.exports = connection 

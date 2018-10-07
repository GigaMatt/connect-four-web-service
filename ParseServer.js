var express = require('express');
var ParseServer = require('parse-server').ParseServer;
var app = express();
var api = new ParseServer({
  databaseURI: process.env.DATABASE_URI, // Connection string for your MongoDB database
  appId: process.env.APP_ID,
  masterKey: process.env.MASTER_KEY,
  serverURL: process.env.SERVER_URL,
});
// Serve the Parse API on the /parse URL prefix
app.use('/parse', api);
app.listen(process.env.PORT || 5000, function() {
  console.log('parse-server-example running on port ' + process.env.PORT);
});
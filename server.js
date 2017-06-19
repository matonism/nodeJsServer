var http = require('http');
var fs = require('fs');
var url = require('url');

const ERROR_PAGE_PATH = '/error';
const DEFUALT_HTML_FILE = '/index.html';


// Console will print the message
console.log('Server running at http://127.0.0.1:8081/');

http.createServer( function (request, response) {  
   var pathname = url.parse(request.url).pathname;
   console.log(url.parse(request.url).toString());
   console.log("Request for " + pathname + " received.");
   
   pathname = refinePathnameForDirectoryInput(pathname);
   attemptServeWebPage(pathname, response);

}).listen(8080);


function attemptServeWebPage(pathname, response){

   fs.readFile(pathname.substr(1), function (error, data) {
      if (!error) {
         if(pathname.includes('.png')){
            response.writeHead(200, {'Content-Type': 'image/png' });
            response.write(data);
         }if(pathname.includes('jpg')){
            response.writeHead(200, {'Content-Type': 'image/jpg' })
            response.write(data);
         }else{
            response.writeHead(200, {'Content-Type': 'text/html'});  
            response.write(data.toString());  
         }
         endResponse(response);

      }else {  
         catchMissingPathError(pathname, error);
         serveDefault404Page(fs, response);
      }

   });   
}

function serveDefault404Page(fs, response){
   var errorPagePath = refinePathnameForDirectoryInput(ERROR_PAGE_PATH).substr(1);
   fs.readFile(errorPagePath, function (error, data) {
      if(!error){
         response.writeHead(200, {'Content-Type': 'text/html'});
         response.write(data.toString());
      }else{
         console.log(error);
         response.writeHead(404, {'Content-Type': 'text/html'});
      }
      endResponse(response);
   });
}

function refinePathnameForDirectoryInput(pathname){
   if(pathname == '/'){
      if(fs.lstatSync('./' + DEFUALT_HTML_FILE).isFile()){
         pathname = DEFUALT_HTML_FILE;
      }
   }else if(fs.lstatSync('./' + pathname).isDirectory()){
      if(fs.lstatSync('./' + pathname + DEFUALT_HTML_FILE).isFile()){
         pathname = pathname + DEFUALT_HTML_FILE;
      }
   }

   return pathname;
}

function endResponse(response){
   console.log('end response');
   response.end();
}

function catchMissingPathError(pathname, error){
   if(error.toString().includes('no such file or directory')){
      console.log(pathname + ' does not exist');
   }else{
      console.log(error);
   }
}


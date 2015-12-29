<?php
header('Access-Control-Allow-Origin: *');
$query = $_SERVER["QUERY_STRING"];
$file = "log.txt";
$current = file_get_contents($file);
function keepLines($str, $num=10) {
    $lines = explode("\n", $str);
    $firsts = array_slice($lines, 0, $num);
    return implode("\n", $firsts);
}
if ($query == "inspect") {
	/*echo str_replace("\n", "<br>", $current);*/
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Micro RequestBin</title>
<style type='text/css'>
    * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0; 
    margin: 0; 
}
body {
    background-color: #0099cc;
    color: #ffffff;
    font-size: 180%;
    margin: 10px;
}
.centre {
    text-align: center;
}
textarea {  /* position is inherited */
    left: 0; 
    top: 0; 
    right: 0;
    bottom: 100px;  /* Actually the height of select and input */
    width: 100%;
}
</style>
</head>
<body>
<div class="centre">
<textarea name="paste" rows="50"><?php echo "$current" ?></textarea>
</div>
</body>
</html>
<?php } else if ($query == "clear") {
	file_put_contents($file, "");
	header("Location: ?inspect");
	exit();
} else { 
	$postdata = file_get_contents("php://input");
	$newlog = "Datetime: ".date('Y-m-d H:i:s')."\n";
	$newlog .= "Query: ".$query."\n";
	$newlog .= "IP: ".$_SERVER['REMOTE_ADDR']."\n";
	$newlog .= "URI: ".$_SERVER['REQUEST_URI']."\n";
	$newlog .= "Method: ".$_SERVER["REQUEST_METHOD"]."\n";
	$newlog .= "-------Header:------\n";
	foreach (getallheaders() as $name => $value) {
		$newlog .= "$name: $value\n";
	}
	$newlog .= "--------Body:-------\n".$postdata;
	$newlog .= "\n---------End--------\n\n";
	$current = $newlog.$current;
	$current = keepLines($current, 700);
	file_put_contents($file, $current);
	header("HTTP/1.1 200 OK");
	echo "OK ?inspect";
	exit();
}
function movePage($num,$url){
   static $http = array (
       100 => "HTTP/1.1 100 Continue",
       101 => "HTTP/1.1 101 Switching Protocols",
       200 => "HTTP/1.1 200 OK",
       201 => "HTTP/1.1 201 Created",
       202 => "HTTP/1.1 202 Accepted",
       203 => "HTTP/1.1 203 Non-Authoritative Information",
       204 => "HTTP/1.1 204 No Content",
       205 => "HTTP/1.1 205 Reset Content",
       206 => "HTTP/1.1 206 Partial Content",
       300 => "HTTP/1.1 300 Multiple Choices",
       301 => "HTTP/1.1 301 Moved Permanently",
       302 => "HTTP/1.1 302 Found",
       303 => "HTTP/1.1 303 See Other",
       304 => "HTTP/1.1 304 Not Modified",
       305 => "HTTP/1.1 305 Use Proxy",
       307 => "HTTP/1.1 307 Temporary Redirect",
       400 => "HTTP/1.1 400 Bad Request",
       401 => "HTTP/1.1 401 Unauthorized",
       402 => "HTTP/1.1 402 Payment Required",
       403 => "HTTP/1.1 403 Forbidden",
       404 => "HTTP/1.1 404 Not Found",
       405 => "HTTP/1.1 405 Method Not Allowed",
       406 => "HTTP/1.1 406 Not Acceptable",
       407 => "HTTP/1.1 407 Proxy Authentication Required",
       408 => "HTTP/1.1 408 Request Time-out",
       409 => "HTTP/1.1 409 Conflict",
       410 => "HTTP/1.1 410 Gone",
       411 => "HTTP/1.1 411 Length Required",
       412 => "HTTP/1.1 412 Precondition Failed",
       413 => "HTTP/1.1 413 Request Entity Too Large",
       414 => "HTTP/1.1 414 Request-URI Too Large",
       415 => "HTTP/1.1 415 Unsupported Media Type",
       416 => "HTTP/1.1 416 Requested range not satisfiable",
       417 => "HTTP/1.1 417 Expectation Failed",
       500 => "HTTP/1.1 500 Internal Server Error",
       501 => "HTTP/1.1 501 Not Implemented",
       502 => "HTTP/1.1 502 Bad Gateway",
       503 => "HTTP/1.1 503 Service Unavailable",
       504 => "HTTP/1.1 504 Gateway Time-out"
   );
   header($http[$num]);
   header ("Location: $url");
}
?>
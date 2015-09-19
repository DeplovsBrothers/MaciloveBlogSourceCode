

<html>
<head>

<script language="javascript" type="text/javascript">
//var request = new XMLHttpRequest();


var obj;
function ProcessXML(url){
if(window.XMLHttpRequest){
obj = new XMLHttpRequest();
obj.onReadyStateChange = processChange;
obj.open("GET", url, true);
obj.send(null);
}
else if(window.ActiveXObject){
obj = new ActiveXObject("Microsoft.XMLHTTP");
if(obj){
obj.onReadyStateChange = processChange;
obj.open("GET", url, true);
obj.send();
}
}
else{
alert("your browser does not support AJAX");
}
}


function processChange(){
alert("ok");
	if(obj.readyState == 4){
		if(obj.status == 200){
		//alert(obj.responseXml);
		checkUserName('', obj.responseText);
		
		}
		else{
			alert("there was a problem in returned data:\n");
		}
	}
}


function checkUserName(input, response){

if(response != ''){
	if(response == '1'){
	 alert("username in use");
	}
	else{

	url = "http://macilove.com/test/handler.php?q="+input;
	ProcessXML(url);
}
}
}

</script>
</head>
<body>
Enter your Username:  <input id="username" name="username" type="text" onblur="checkUserName(this.value, '')" >
<br />
 </body>
</html>
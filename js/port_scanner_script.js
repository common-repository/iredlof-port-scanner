// JavaScript Document
var xmlhttp
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	 try {
	  xmlhttp = new XMLHttpRequest();
	 } catch (e) {
	  xmlhttp=false
	 }
	}
	function myXMLHttpRequest() {
	  var xmlhttplocal;
	  try {
	    xmlhttplocal= new ActiveXObject("Msxml2.XMLHTTP")
	 } catch (e) {
	  try {
	    xmlhttplocal= new ActiveXObject("Microsoft.XMLHTTP")
	  } catch (E) {
	    xmlhttplocal=false;
	  }
	 }

	if (!xmlhttplocal && typeof XMLHttpRequest!='undefined') {
	 try {
	  var xmlhttplocal = new XMLHttpRequest();
	 } catch (e) {
	  var xmlhttplocal=false;
	  alert('couldn\'t create xmlhttp object');
	 }
	}
	return(xmlhttplocal);
}

function portScannerupdate()
{
	var time= new Date();
	var wpAddress=document.getElementById("wp-address").value;
	document.getElementById('port_scanner_status').style.backgroundColor="";
	document.getElementById('port_scanner_status').innerHTML='<img src="'+wpAddress+'/wp-content/plugins/port_scanner/indicator.gif" alt="" title="Loading"/>';
	var host=document.getElementById("psHost").value;
	var port=document.getElementById("psPort").value;
	if(host=="" || port=="")
	{
		document.getElementById('port_scanner_status').style.color="RED";	  
        document.getElementById('port_scanner_status').innerHTML="Empty Fields.";
	}
	else
	{
		xmlhttp.open('get', wpAddress+'/wp-content/plugins/port_scanner/portcheck.php?time='+time.getSeconds()+'&host='+host+'&port='+port);
    	xmlhttp.onreadystatechange = handleResponse;
    	xmlhttp.send(null);
	}
}

function handleResponse()
{
	if(xmlhttp.readyState == 4)
	{
		if (xmlhttp.status == 200)
		{
          var response = xmlhttp.responseText;
		  if(response=="Open")
  	      document.getElementById('port_scanner_status').style.color="GREEN";	  
		  else
		  document.getElementById('port_scanner_status').style.color="RED";	  
	      document.getElementById('port_scanner_status').innerHTML=response;
		}
	}
}
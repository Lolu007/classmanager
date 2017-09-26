// JavaScript Document
//a method that creates the httpRespondObject
function createObject()
{
	var xHttp;
 	var browser = navigator.appName;
	if(browser=="Microsoft Internet Explorer")
	{
		xHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		xHttp = new XMLHttpRequest();
	}
	
	return xHttp;
}	

function loadDays()
{
	
	var http=createObject();
	// Get the state from the web form
	var month = document.getElementById('mon').value;
	var obj=document.getElementById('days');
	
	// Build the URL to connect to
	var url = "ajax/loaddays.php?type=days&month=" + escape(month);
	//alert(url);
	// Open a connection to the server
	http.open("GET",url,true);
	
	// Setup a function for the server to run when it's done
	http.onreadystatechange = function()
							{	
							 
							      //alert(http.readyState);
								  if(http.readyState==4)
								  {   
								     //alert(http.readyState+" "+http.responseText);
									 var response = http.responseText;
									 //document.getElementById('yes').value = response;	
									 obj.innerHTML=response;									
								 }
							};
	    //Send the request
		http.send(null);
}

function loadBirthdays()
{
	//alert('us');
	var http=createObject();
	// Get the state from the web form
	var month = document.getElementById('month').value;
	var obj=document.getElementById('betday');
	
	// Build the URL to connect to
	var url = "ajax/loaddays.php?type=brthdays&month=" + escape(month);
	//alert(url);
	// Open a connection to the server
	http.open("GET",url,true);
	
	// Setup a function for the server to run when it's done
	http.onreadystatechange = function()
							{	
							 
							      //alert(http.readyState);
								  if(http.readyState==4)
								  {   
								     //alert(http.readyState+" "+http.responseText);
									 var response = http.responseText;
									 //document.getElementById('yes').value = response;	
									 obj.innerHTML=response;									
								 }
							};
	    //Send the request
		http.send(null);
}


function searchBirthdays()
{
	//alert('us');
	var http=createObject();
	// Get the state from the web form
	var keyword = document.getElementById('keyword').value;
	var obj=document.getElementById('betday');
	
	// Build the URL to connect to
	var url = "ajax/loaddays.php?type=search&keyword=" + escape(keyword);
	//alert(url);
	// Open a connection to the server
	http.open("GET",url,true);
	
	// Setup a function for the server to run when it's done
	http.onreadystatechange = function()
							{	
							 
							      //alert(http.readyState);
								  if(http.readyState==4)
								  {   
								     //alert(http.readyState+" "+http.responseText);
									 var response = http.responseText;
									 //document.getElementById('yes').value = response;	
									 obj.innerHTML=response;									
								 }
							};
	    //Send the request
		http.send(null);
}
// JavaScript Document
//***********************************************************
//create the xmlhttp object first
//************************************************************
function getxmlhttp(){
	//Create a boolean variable to check for a valid Internet Explorer instance.
	var xmlhttp = false;
	//Check if we are using IE.
	try {
		//If the Javascript version is greater than 5.
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		//If not, then use the older active x object.
		try {
			//If we are using Internet Explorer.
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			//Else we must be using a non-IE browser.
			xmlhttp = false;
		}
	}
	//If we are using a non-IE browser, create a javascript instance of the object.
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function loadPage(serverPage, objID) {
		//document.getElementById('validatesearch').innerHTML="";
		xmlhttp=getxmlhttp();
		//setStatus("Loading...",objID);
		var obj=document.getElementById(objID);
		xmlhttp.open("GET",serverPage);
		xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			obj.innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);
}
	
	//*****************************************************
 //this setstatus function is made basically because of the get total function
//*********************************************************
function setStatus(theStatus,theobj){
	obj=document.getElementById(theobj);
	if(obj){
		obj.innerHTML="<br /><br /><br /><center><img src='images/ajax-loader.gif'>&nbsp;&nbsp;"+ theStatus + "</center><br />";
	}
}

function register(form, serverpage, objid)
{
	
	theform=document.getElementById(form);
	setStatus("Please wait...",objid);
	var str=getFormValues(theform);
	loadPage(serverpage+"?type=register&"+str,objid);
	//process(serverpage,obj,"post",str);
}

function results(form, serverpage, objid)
{
	
	theform=document.getElementById(form);
	setStatus("Please wait...",objid);
	var str=getFormValues(theform);
	loadPage(serverpage+"?type=results&"+str,objid);
	//process(serverpage,obj,"post",str);
}

function editstud(form, serverpage, objid)
{
	
	theform=document.getElementById(form);
	setStatus("Please wait...",objid);
	var str=getFormValues(theform);
	loadPage(serverpage+"?type=editstud&"+str,objid);
	//process(serverpage,obj,"post",str);
}

function payForMaterial(form, serverpage, objid)
{
	//alert("ok");
	theform=document.getElementById(form);
	setStatus("Making payment please wait...",objid);
	var str=getFormValues(theform);
	loadPage(serverpage+"?type=payment&"+str,objid);
	//process(serverpage,obj,"post",str);
}


function editPayment(form, serverpage, objid)
{
	//alert("ok");
	theform=document.getElementById(form);
	setStatus("Making changes...",objid);
	var str=getFormValues(theform);
	loadPage(serverpage+"?type=editpayment&"+str,objid);
	//process(serverpage,obj,"post",str);
}
//

function editbal(form, serverpage, objid)
{
	//alert("ok");
	theform=document.getElementById(form);
	setStatus("Making changes...",objid);
	var str=getFormValues(theform);
	loadPage(serverpage+"?type=editbal&"+str,objid);
	//process(serverpage,obj,"post",str);
}

function getFormValues(fobj)
{
	var str="";
	for(var i=0;i<fobj.elements.length;i++)
		str+=fobj.elements[i].name+"="+escape(fobj.elements[i].value)+"&";
	return str;
}



function getTotal()
{
	var num1 = document.getElementById('pages').value;
	var num3 = document.getElementById('price').value;
	
	document.getElementById('totalcost').value = multiply(parseInt(num1),parseInt(num3));
	
}//end function sum
	
function multiply(a,b)
{
	return a*b;
}//end addem 


function getBalance()
{
	var materialCost = document.getElementById('totalcost').value;
	var amountPaid = document.getElementById('amountpaid').value;
	
	if(parseInt(materialCost) > parseInt(amountPaid))
	{
		var bal = parseInt(materialCost) - parseInt(amountPaid);
		
		document.getElementById('balance').value = bal;
		document.getElementById('change').value = 0;
		//alert(bal);
	}
	else if(parseInt(materialCost) < parseInt(amountPaid))
	{
		var intAmountPaid=0;
		try{
			 intAmountPaid = parseInt(amountPaid);	
		}catch(ex){
			alert('Invalid input');
		}
		var chan = intAmountPaid - parseInt(materialCost);
		
		
		document.getElementById('change').value = chan;
		document.getElementById('balance').value = 0;
	}
	
	else
	{
		document.getElementById('balance').value = 0;
		document.getElementById('change').value = 0;
		
	}
	
}

function editBalance()
{
	var iniBal = document.getElementById('getBal').value;
	var paidNow = document.getElementById('balpaid').value;
	if(paidNow=="")
	{
		var paidNow=0;
	}
	if(parseInt(iniBal) > parseInt(paidNow))
	{
		var bal = parseInt(iniBal) - parseInt(paidNow);
		
		document.getElementById('balance').value = bal;
		document.getElementById('change').value = 0;
		//alert(bal);
	}
	else if(parseInt(iniBal) < parseInt(paidNow))
	{
		var chan = parseInt(paidNow) - parseInt(iniBal);
		
		document.getElementById('change').value = chan;
		document.getElementById('balance').value = 0;
	}
	
	else
	{
		document.getElementById('balance').value = 0;
		document.getElementById('change').value = 0;
		
	}
	
}
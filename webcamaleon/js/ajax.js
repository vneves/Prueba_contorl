var xmlHttp=null;

function GetXmlHttpObject()
{
	try
	{// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{//Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		result = xmlHttp.responseText;
		document.getElementById(span).innerHTML = result;    
	} 
}

function ajaxC(span1,url,poststr)
{
	span=span1;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open('POST',url,true);
	xmlHttp.send(poststr);
}

function removeEvent(divNum){
		var d = document.getElementById('content');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
	}
function agregarfila()
{
	var aux=document.getElementById("content").innerHTML;
	var Contenedor = document.getElementById('content');
	var cont=document.getElementById("valortext").value;

	var divIdName = "d_"+cont;
	var newdiv = document.createElement('div');
	newdiv.setAttribute("id",divIdName);

	newdiv.style.width="688px";
	newdiv.style.paddingTop="3px";
	newdiv.style.paddingBottom="3px";
	
	newdiv.style.background ="#eeeeee";
/*	newdiv.style.borderRight = "1px solid #FFFFFF"; 
	newdiv.style.borderBottom = "1px solid #FFFFFF"; 
	newdiv.style.borderLeft = "1px solid #FFFFFF"; */
	
	

//newdiv.innerHTML =	'	<span style="border:#FFFFFF;padding-left:10px;  font-size:10px;width:124"><input type="text" id="fecha' + cont + '" name="fecha' + cont + '" size="10" ><a href="' + "javascript:showCal('Calendar" + cont + "')"+'">' + '<img src="images/fecha.gif" border="0"></a></span><span style="border:#FFFFFF;padding-left:20px; padding-right:20px;width:124px"><textarea name="titulo' + cont + '" rows="2" cols="19" id="titulo' + cont + '"></textarea></span><span style="padding-left:20px; padding-right:20px; font-family:Arial, Helvetica, sans-serif;font-size:12px;width:124px">		<b>EN REVISIN</b>		</span>		<span style="border:#FFFFFF;padding-left:25px; padding-right:20px;">		<textarea name="obs' + cont + '" rows="2" cols="19" id="obs' + cont + '"></textarea>		</span>		<span><a href="' + "javascript:removeEvent('"+divIdName+"')"+'">' + '<img src="images/cancel.gif" border="0" alt="Borrar Fila"></a></span>	';
newdiv.innerHTML =	'<table border="0" width="690" cellpadding="0" cellspacing="0"><tr><td width="5"></td><td width="145"><input type="text" class="fieldText" id="nombres' + cont + '" name="nombres' + cont + '" size="17" /></td><td width="145"><input type="text" class="fieldText" id="ap' + cont + '" name="ap' + cont + '" size="17" /></td><td width="145"><input type="text" class="fieldText" id="doci' + cont + '" name="doci' + cont + '" size="16" /></td><td width="135"><input type="text" class="fieldText" id="nac' + cont + '" name="nac' + cont + '" size="16" /></td><td width="75"><input type="text" class="fieldText" id="edad' + cont + '" name="edad' + cont + '" size="10" /></td><td width="42"  align="center"><a href="' + "javascript:removeEvent('"+divIdName+"')"+'">' + '<img src="images/cancel.gif" border="0" alt="Borrar Fila"></a></td><td width="5"></td></tr></table>';
	/*	newdiv.innerHTML = '<tr> <td align="center" height="18" noWrap width="140" bgcolor="#eeeeee"> <input type="text" id="fecha' + cont + '" name="fecha' + cont + '" size="15" value="fecha' + cont + '"/><small><a href="' + "javascript:showCal('Calendar" + cont + "')"+'">' + '<img src="images/fecha.gif" border="0"></a></small> </td>  <td align="center" height="18" noWrap width="208" bgcolor="#eeeeee">  <textarea name="titulo' + cont + '" rows="2" cols="22"></textarea>		</td>		 <td align="center"  noWrap  bgcolor="#eeeeee"> 			<small><B>EN REVISIN</B></small>		</td> <td align="center" height="18" noWrap width="169" bgcolor="#eeeeee">         	<textarea name="obs' + cont + '" rows="2" cols="22">	 		 </textarea>		  </td>      </tr></tbody></table>';    */
	cont=	parseInt(cont)+1;
	document.getElementById("valortext").value=cont;
	Contenedor.appendChild(newdiv);
		
}


function closeajax(span1)
{
	document.getElementById(span1).innerHTML = '&nbsp;';
}
function confirmSubmit(value){
	var agree=confirm(value);
	if (agree)
		return true ;
	else
		return false ;
}

function addEvent(obj, evType, fn){
 if (obj.addEventListener){
    obj.addEventListener(evType, fn, false);
    return true;
 } else if (obj.attachEvent){
    var r = obj.attachEvent("on"+evType, fn);
    return r;
 } else {
    return false;
 }
} 
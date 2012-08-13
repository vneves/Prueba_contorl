function ConfirmSave(form)
{
	var contvacios=0;
	var	 varerror=0;	
	var cont=document.getElementById("valortext").value;
	for(i=0;i<cont;i++)
	{
		//validacion del nombre
		nombresn="nombres" + i  ;
		if(	document.getElementById(nombresn))
		{
			contvacios++;
			 var nombre= new String(document.getElementById(nombresn).value);
			
			if (nombre.replace(/ /g, '')=="") 
			 {
				 varerror++;
				 document.getElementById(nombresn).style.background="#FFCCCC";
			 }
			 else
			 {
				  document.getElementById(nombresn).style.background="#FFFFFF";
			 }
		}
		//end validacion del nombre
		
		
		//validacion del apellido
		apn="ap" + i  ;
		if(	document.getElementById(apn))
		{
			var ap= new String(document.getElementById(apn).value);
			
			if (ap.replace(/ /g, '')=="") 
			 {
				 varerror++;
				 document.getElementById(apn).style.background="#FFCCCC";
			 }
			 else
			 {
				  document.getElementById(apn).style.background="#FFFFFF";
			 }
		}
		//end validacion del apellido
		
		//validacion del Doci
		docin="doci" + i  ;
		if(	document.getElementById(docin))
		{
			var doci= new String(document.getElementById(docin).value);
			
			if (doci.replace(/ /g, '')=="") 
			 {
				 varerror++;
				 document.getElementById(docin).style.background="#FFCCCC";
			 }
			 else
			 {
				  document.getElementById(docin).style.background="#FFFFFF";
			 }
		}
		//end validacion del Doci
		//validacion de la Nacionalidad
		nacn="nac" + i  ;
		if(	document.getElementById(nacn))
		{
			var nac= new String(document.getElementById(nacn).value);
			
			if (nac.replace(/ /g, '')=="") 
			 {
				 varerror++;
				 document.getElementById(nacn).style.background="#FFCCCC";
			 }
			 else
			 {
				  document.getElementById(nacn).style.background="#FFFFFF";
			 }
		}
		//end validacion de la Nacionalidad
		
		//validacion del importe
		importen="importe" + i  ;
		if(	document.getElementById(importen))
		{
			var importe= new String(document.getElementById(importen).value);
			
			if (importe.replace(/ /g, '')=="") 
			 {
				 varerror++;
				 document.getElementById(importen).style.background="#FFCCCC";
			 }
			 else
			 {
				  document.getElementById(importen).style.background="#FFFFFF";
			 }
		}
		//end validacion del importe
		//validacion Asiento
		asienton="asiento" + i  ;
		if(	document.getElementById(asienton))
		{
			var asiento= new String(document.getElementById(asienton).value);
			
			if (asiento.replace(/ /g, '')=="") 
			 {
				 varerror++;
				 document.getElementById(asienton).style.background="#FFCCCC";
			 }
			 else
			 {
				  document.getElementById(asienton).style.background="#FFFFFF";
			 }
			 
		}
		//end validacion de la Nacionalidad
/*		if (varerror==0)
		{
			i=cont;
		}*/
		
	}
	
	
	if(contvacios>0 && varerror==0)
	{
		save = window.confirm('Esta seguro de guardar los registros');

		(save)?form.submit():'return false';
		
	}
	else
	{ 
	//if(varux2==-1)
		//alert("Solo se permiten archivos Excel(.xls) y Word (.doc)");
//		if(varuxf==-1)
		//alert("Fechas Invalidas");
		if(contvacios<=0)
		{
			alert("Debe ingresar al menos una fila");
		}
	}
}

function ConfirmSearch(form)
{	
	var fecha1=new String(document.getElementById("sel1").value);
	var fecha2=new String(document.getElementById("sel3").value);
	var origen=new String(document.getElementById("origen").value);
	var destino=new String(document.getElementById("destino").value);
//	 alert(fecha1+" "+fecha2+" "+origen+" "+destino);
//	 	if (fecha1.replace(/ /g, '')=="" && fecha2.replace(/ /g, '')=="" && origen.replace(/ /g, '') && destino.replace(/ /g, '') ) 
 	if (fecha1.replace(/ /g, '')=="" && fecha2.replace(/ /g, '')=="" && origen.replace(/ /g, '')=="-1" && destino.replace(/ /g, '')=="-1" ) 
	 {
		 window.alert("Llene al menos un campo para la busqueda.");
// 		 alert("si hay vacios");
	 }
	 else
	 {		 
		re=/^[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]$/
		if(fecha1.length>0)
		if(fecha1.length==0 || !re.exec(fecha1))
		{
			alert("La fecha de Salida no tiene formato correcto.")
			return
		}
		if(fecha2.length>0)
		if(fecha2.length==0 || !re.exec(fecha2))
		{
			alert("La fecha de Llegada no tiene formato correcto.")
			return
		}
//		 alert("no hay vacios");
		 form.submit();
	 }

}


function ValidTestimonial()
{
	for (var i=0;i < document.FrmTestimonial.elements.length;i++)
	{
		var element = document.FrmTestimonial.elements[i];		
		if(element.type=="text")
		{
			if(element.name=="TestimonialAuthor")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Author is required."); element.focus(); return false;
				}				
			}
		}
		if(element.type=="textarea")
		{
			if(element.name=="richEdit0")
			{
				var f=element.value;
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Testimonial is required."); return false;
				}				
			}
		}
	}//for
	document.FrmTestimonial.submit(); 
}

function dontEmpty()
{
    var controle = true;
    var controleCheck = 0;
    
    //var error = "";
    
	for (i=0;i<document.formnewhome.elements.length;i++){
        if (document.formnewhome.elements[i].type == "text"){
			if (document.formnewhome.elements[i].value == ""){
                error = "There name is empty. Please write a name and try again";
                controle = false;
			}
		}
        if(document.formnewhome.elements[i].id == "quantity"){
            if (document.formnewhome.elements[i].value == ""){
                controle=true;
            }
        }
        if (document.formnewhome.elements[i].type == "checkbox"){
			if (document.formnewhome.elements[i].checked == true){
                controleCheck += 1;
			}
            else no=false;
		}
	}
    if (controle==false){
        alert(error);
        return false;
    }
    
    if (controleCheck==0 && no == false){
        alert("you must select a item");
        return false;
    }
    
}

function dontEmptyUpdate()
{
    var controle = true;
    var controleCheck = 0;
    //var error = "";
	for (i=0;i<document.formnewhome.elements.length;i++){
        if (document.formnewhome.elements[i].type == "text"){
			if (document.formnewhome.elements[i].value == ""){
                error = "There name is empty. Please write a name and try again";
                controle = false;
			}
		}
        if(document.formnewhome.elements[i].id == "quantity"){
            if (document.formnewhome.elements[i].value == ""){
                controle=true;
            }
        }
        if (document.formnewhome.elements[i].type == "checkbox"){
			if (document.formnewhome.elements[i].checked == true){
                controleCheck += 1;
			}
            else no=false;
		}
	}
    if (controle==false){
        alert(error);
        return false;
    }
    
    if (controleCheck==0 && no == false){
        alert("you must select a item");
        return false;
    }
}

function CalcHW(cont,actual,id,dcId){
  var y = "";
  var z = 0;
  var i = 0;
  var total = 0;
  
  y = "HW" + actual;
  z = parseFloat(document.getElementById(y).value);
  m = document.getElementById(y).value;
  if (isNaN(z))
  {
    document.getElementById(y).value = "";
    return false;
  }
  z1 = Math.round(z*100)/100;
  if(z<0)
  {
    document.getElementById(y).value = "";
    return false;
  }
  else
  {
    if(m.substring(m.length - 1)!=".")
      document.getElementById(y).value = z1;
  }
  for (i=0;i<cont;i++)
  {
    y = "HW" + i;
    z = parseFloat(document.getElementById(y).value);
    total = total + z;
  }
  var HW = document.getElementById("TotalHW");

  HW.value = Math.round(total*100)/100;
  CalcTotal(dcId);
  ajax('popup','evaluatedesign.php?action=changehwprice&id=' + id + '&price='+ z1,'');
  return false;
}

function CalcPack(cont,actual,id,dcId){
  var y = "";
  var z = 0;
  var i = 0;
  var total = 0;

  y = "Pack" + actual;
  z = parseFloat(document.getElementById(y).value);
  m = document.getElementById(y).value;
  if (isNaN(z))
  {
    document.getElementById(y).value = "";
    return false;
  }
  z1 = Math.round(z*100)/100;
  if(z<0)
  {
    document.getElementById(y).value = "";
    return false;
  }
  else
  {
    if(m.substring(m.length - 1)!=".")
      document.getElementById(y).value = z1;
  }
  for (i=0;i<cont;i++)
  {
    y = "Pack" + i;
    z = parseFloat(document.getElementById(y).value);
    total = total + z;
  }
  var Pack = document.getElementById("TotalPack");    
  Pack.value = Math.round(total*100)/100;
  CalcTotal(dcId);
  ajax('popup','evaluatedesign.php?action=changepackprice&id=' + id + '&price='+ z1,'');
  return false;
}

function CalcTotal(dcId){
  var Pack = document.getElementById("TotalPack");
  var HW = document.getElementById("TotalHW");
  var Total = document.getElementById("Total");
  var Discount = document.getElementById("Discount");
  var Amount = document.getElementById("Amount");
  Total.value = Math.round((parseFloat(Pack.value) + parseFloat(HW.value))*100)/100;
  if (Discount.value != 0)
    Amount.value = Math.round((Total.value - (Total.value * Discount.value / 100))*100)/100;
  else
    Amount.value = Total.value;
  ajax('popup','evaluatedesign.php?action=changetotal&dcId=' + dcId + '&total='+ Total.value + '&discount=' + Discount.value,'');
  return false;
}
// validate featured homes

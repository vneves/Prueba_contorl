<?
    $Child=page::listPages($APP['Contacto'], $pageData['lang']);     
?>	
<div class="formContacto">
<?

/*		  ENVIAR CORREO		   */
	function enviar($mensaje,$correo,$contacto){
            
//$admin='ricardoevora2011@hotmail.com';
$admin='univandro@gmail.com';
//$admin='ajimenez@ilatina.com';
		require_once('./includes/class.phpmailer.php');
                $respuesta=true;
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
                $mail->Host       = "mail.dev.informaticalatina.com"; // SMTP server
		$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "dev@dev.informaticalatina.com"; // SMTP account username
                $mail->Password   = "DESARROLLADORilatina";        // SMTP account password
                $mail->SetFrom("dev@informaticalatina.com","Control Experto");
                $mail->Subject    = "Mensaje de ".$contacto;
		$mail->MsgHTML($mensaje);
		$mail->AddAddress($admin,$admin);
		if(!$mail->Send()){
			echo '<script>alert ("Error inesperado. El mensaje no se envio.")</script>';
                        return false;
		}else{
			echo '<script>alert ("El mensaje fue enviado correctamente!")</script>';
                        return true;
		}
	}
	/*		FIN ENVIAR CORREO	   */


if(isset($_POST['nombre']))
    $nombre = $_POST['nombre'];
if(isset($_POST['email']))
    $email = $_POST['email'];
if(isset($_POST['telefono']))
    $telefono = $_POST['telefono'];
if(isset($_POST['pais']))
    $pais = $_POST['pais'];
if(isset($_POST['mensage']))
    $mensage = $_POST['mensage'];
if(isset($_POST['ciudad']))
    $cuidad = $_POST['ciudad'];
    
if (isset ($_POST['enviar']) and $_POST['enviar']=="ENVIAR") {

    if ($nombre != "" AND $email != "" AND $mensage != "" ) {
      
    #procedo a enviar el email
        
      $telefono_="";
      if($telefono!="")
          $telefono_=" <br> Numero de telefono " . $telefono ;
      
      $mensaje = "Este mensaje fue enviado por " . $nombre . $telefono_." <br>";
      $mensaje .= "Su e-mail es: " . $email . " <br>";
      if($cuidad!="" or $cuidad!=null)
        $mensaje .= "CIUDAD: " . $cuidad . " <br>";
      if($pais!="" or $pais!=null)
        $mensaje .= "PAIS: " . $pais . " <br>";      
      if($mensage!="" or $mensage!=null)
        $mensaje .= "Dejo el seguiente Mensagen: " . $mensage . " <br>";
      
      $mensaje .= "Enviado el " . date('d/m/Y', time());
      
            $body = file_get_contents('./includes/contents.html');
            $body = eregi_replace("{titulo}",'Contacto',$body);
            $body = eregi_replace("{para}","Se&ntilde;or(a): Administrador de Control Experto<br>",$body);
            $body = eregi_replace("{mensaje}",$mensaje,$body);
//            $body = eregi_replace("{de}",$nombre,$body);
           
            $body = eregi_replace("{logo}",$APP['base_url'].'img/logo_2.png',$body);
            $body = eregi_replace("{dir}",$APP['base_url'],$body);
            /*		fin generando mensaje		*/
            if(enviar($body,$email,$nombre)){
                    
                    echo '<script> window.parent.location="'.$APP['base_url'].'"; </script>';
            }
    }
    else{      
       # Caso contrario, Muestro mensaje de error
      echo '<script>alert ("Complete los campos obligatorios(*)")</script>';
    }
}

?> 
        <div style="color:#FFFFFF;width: 180px;height: 29px;margin-left: 85px; background-color: #B2B2B2;"> 
            <? echo'(<span style="color:#E6007E;">*</span>) Campos Obligatorios';?>
        </div>
         
        <div style="margin-left: 85px; width: 960px;">            
            <form method="post" action="?" id="fields-in-call">              
                <div style="float: left; height: 193px; margin: 20px 20px 20px 0px; padding: 20px 20px 0px; background-color: rgb(178, 178, 178); width: 400px;">    
                    <label style="color: rgb(255, 255, 255); float: left; margin-bottom: 17px;">Nombre y apellidos<span style="color:#E6007E;">*</span> : </label> 
                    <input id="fic-username" class="required" type="text" style="width: 220px; margin-top: 0px; padding-top: 1px; margin-bottom: 10px; float: right; margin-left: 0px;" name="nombre" size="30" maxlength="80" /><br />
                    <label style="color: rgb(255, 255, 255); float: left; margin-bottom: 17px; width: 160px;">Email<span style="color:#E6007E;">*</span> : </label>
                    <input id="fic-email" class="required" type="text" style="width: 220px; margin-top: 0px; padding-top: 1px; margin-bottom: 10px; float: right;" name="email" size="30" maxlength="60" /><br /> 
                    <label style="color: rgb(255, 255, 255); float: left; margin-bottom: 18px; width: 160px;">Telefono : </label>
                    <input  type="text" style="width: 220px; margin-top: 0px; padding-top: 1px; margin-bottom: 10px; float: right;" name="telefono" size="30" maxlength="60" /><br />
                    <label style="margin-bottom: 17px; color: rgb(255, 255, 255); float: left; width: 170px;">Ciudad : </label>
                    <input  type="text" style="width: 220px; margin-top: 0px; padding-top: 1px; margin-bottom: 10px; float: right;" name="ciudad" size="30" maxlength="60" /><br />
                    <label style="margin-bottom: 4px; color: rgb(255, 255, 255); float: left;">Pais : </label>
                    <input  type="text" style="width: 220px; margin-top: 0px; padding-top: 1px; margin-bottom: 10px; float: right;" name="pais" size="30" maxlength="60" /><br />
                </div>
                <div style="height: 173px; margin-top: 20px; margin-left: 23px; background-color: rgb(178, 178, 178); width: 400px; float: left; padding: 20px;">
                    <label style="color:#FFFFFF;">Mensaje<span style="color:#E6007E;">*</span> : <br /></label>
                    <textarea class="required" name="mensage" cols="30" rows="6" style="height: 145px; width: 395px;"><? if(isset($_GET['producto'])) echo $_GET['producto'];?></textarea>
                </div>
                <div style="margin-top: 8px; width: 162px; float: right; margin-bottom: 10px; margin-right: 37px;">
                    <label><input type="submit" name="enviar" value="ENVIAR" class="boton" style="background-color:#B2B2B2;color:#C4007A;float: right;font-size:25px;font-family:'Gothic-Bolt';border-width: 0px; height: 37px; width: 162px;" /></label>
                </div>
            </form>
        </div>                
</div>

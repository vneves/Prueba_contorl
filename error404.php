<?php
session_start();
require_once("config/config.php");
require_once $APP['base_admin_path'].'include/connection.php';
require_once $APP['base_admin_path'].'pages/class/page.php';
require_once $APP['base_path'].'lib/process_page.php';
require_once $APP['base_path']."lib/process_file.php";
require_once $APP['base_admin_path'].'pages/class/product.php';
require_once $APP['base_admin_path'].'pages/class/product_category.php';
require_once $APP['base_admin_path'].'pages/class/product_file.php';
//$defaultPage = printPage($APP['home']);//la pagina por defecto es en español
$defaultPage = printPageBypage(1, 'es');
if (!isset($_REQUEST['permalink'])) {	
	$pageData=$defaultPage;
}else{
	$pageData = printPage($_REQUEST['permalink']);
}
$arr_page_error = array(
	'id_content' => 'error',
	'id_page' => 'error',
	'meta_description' => '',
	'meta_keywords' => '',
	'lang' => 'es',
	'title' => 'P&aacute;gina no encontrada',
	'introtext' => '',
	'maintext' => 'No se encontr&oacute; el archivo solicitado.'
);
if (empty($pageData)) {
	$arr_permalink = explode('.', $_REQUEST['permalink']);
	$pageData = $arr_page_error;
}
if (!isset($_REQUEST['page']) or ($_REQUEST['page'] == '')) {
	$_REQUEST['page'] = 1;
}
$linkHome=0;
if (!isset($pageData)) {
	$pageData = printPage($_REQUEST['page']);
	if (empty($pageData)) {
		$pageData = $arr_page_error;
	}
}
//print_r($pageData);
switch ($pageData['id_page']) {
	case 1:
		$arr_path = Page::getPath(0, $pageData['lang']);
		$contentFile = 'plantilla.php';
		$linkHome=1;
		break;
	default:
		$arr_path = Page::getPath($pageData['id_page'], $pageData['lang']);
		$contentFile = 'plantilla2.php';
		break;
}

if (isset($pageData)) {
	$fileList = process_files($pageData,$APP,$Labeldescargas);
}else{
	$fileList = "";
}
$lengujes=Page::listPagesLanguage($pageData['id_page']);

foreach($lengujes as $index => $value) {										
	$auxL=printPage($value['id_content']);
	$LEGP[$value['lang']]=$APP['base_url'].$auxL['permalink'];					
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$pageData['title'];?></title>
       
<meta name="description" content="<?php echo str_replace('"', '&quot;', $pageData['meta_description']); ?>" />
<meta name="keywords" content="<?php echo str_replace('"', '&quot;', $pageData['meta_keywords']); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--CSS-->
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/mainstyle.css" media="screen" />

<?php
if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) {
?>
<link rel="stylesheet" href="css/fuente_helvetica.css" type="text/css" media="screen" />
<?php
}else{
?>
<link rel="stylesheet" href="css/fuente.css" type="text/css" media="screen" />
<?php
}
?>


<!--CSS-->
<!--SIMPLE SLIDER (TOP SLIDER)-->
    <link rel="stylesheet" type="text/css" href="css/topSlider.css" media="screen" />
  <!-- END SIMPLE SLIDER (TOP SLIDER)-->

<!--SIMPLE SLIDER (LEFT SLIDER)-->
    <link rel="stylesheet" type="text/css" href="css/simpleslider.css" media="screen" />
    <script type="text/javascript" src="js/simpleSlider/jquery-1.2.6.min.js"></script>
    <script type="text/javascript" src="js/simpleSlider/simpleslider.js"></script>
<!-- END SIMPLE SLIDER (LEFT SLIDER)-->


<!--SlideDeck (MID SLIDER)-->
    <!-- Include jQuery first. -->
		<script type="text/javascript" src="js/slideDeck/slider/jquery-1.3.2.min.js"></script>
		<!-- Include the below script, Copyright 2010, Brandon Aaron (http://brandonaaron.net/) for scrollwheel support. -->
    <script type="text/javascript" src="js/slideDeck/slider/jquery-mousewheel/jquery.mousewheel.min.js"></script>
		<link rel="stylesheet" type="text/css" href="js/slideDeck/slider/slidedeck.skin.css" media="screen" />
    <!-- Styles for the skin that only load for Internet Explorer -->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="slidedeck.skin.ie.css" media="screen,handheld" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/midslider.css" media="screen" />
     <link rel="stylesheet" type="text/css" href="css/skin.css" media="screen" />
	  <!-- Include the SlideDeck jQuery script. -->
		<script type="text/javascript" src="js/slideDeck/slider/slidedeck.jquery.lite.pack.js"></script>
<!-- END SlideDeck (MID SLIDER)-->
<!--prettyPhoto-->	
<script src="js/prettyPhoto/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<!--FIN prettyphoto-->	

<!--easySlider (BOTTOM SLIDER)-->
<script type="text/javascript" src="js/easyslider1.5/js/easySlider1.5.js"></script>
  <script type="text/javascript" src="js/easyslider1.5/easyslider.js"></script>
  <link rel="stylesheet" type="text/css" href="css/bottomslider.css" media="screen" />
<!--FAV ICON-->
<link rel="shortcut icon" href="favicon.ico"/>
<!--FAV ICON-->	






<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen" />
        <script type="text/javascript">

		jQuery(document).ready(function() {

		 /*** menu **/
                 //$('ul.menu li').css('padding','1px');
		  $('ul.menu li').hover(function(){
                      //$(this).css('padding-bottom','8px');
                            var cssObj = {
                                "background-color": "#F4E728"
                            }
                            $(this).find('div.itemMenu').css(cssObj);

                            $(this).find('ul.subMenu').css('display','block');

                            var a = $(this).find('div.itemMenu').css('width');
                            //alert(a)
                            $(this).find('ul.subMenu li').css('width',a);
			},
				function(){
				    $(this).find("ul.subMenu").css('display','none');
                                     var cssObj = {
                                         "background-color": "transparent"
                                       }
                                       $(this).find('div.itemMenu').css(cssObj);
                                       //$(this).css('padding','2px');
				}
			);
		});
</script> 
 
</head>
<body >
<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
   

  });
</script>
<div class="bodyWrapper">
    <!-- HEADER -->
    <div class="headerWrapper">
    		<div class="headerContent">
        		<!-- HEADER SLIDER -->
            <div class="headerSliderWrapper">  
            		<div class="headerSlider">
                	<img class="imglarge" src="img/top-background.png" />
									
		<?php

  
     $pageTemp=printPageByPage($APP['topslider'], 'es');
			
			
				
                                    
						?><a href='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.
							 $pageTemp['template_images'][0]['filename']?>' rel="prettyPhoto"><img width="980" height="150" src='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>'  title="<?=$pageTemp['title']?>" alt="<?=$pageTemp['title']?>" class="active"/></a>
               
            
					
        
    
  

									
                </div>	
            </div>
    <!-- END HEADER SLIDER -->
            <!-- LOGO -->
            <div class="logoWrapper">
            		<a href="./index.php">	<?  include("./pages/logo.html"); ?></a>
            </div>
            
            <!-- END LOGO -->
        </div>
    </div>
    <!-- END HEADER -->
		
    <!-- MENU -->
    <div class="menuWrapper">
    
    	<div class="menuContent">
            <a href="http://www.facebook.com"><img class="fblogo" src="img/facebook-logo.png"/> </a>
    	<?php
                        require_once("pages/menu.php");
                     ?>
      </div>
          
      <div class="yellowLine"></div>
      <div class="migadepan"><? include("pages/migadepan.php"); ?></div>
     </div>
    
  
    <!-- END MENU -->
    
     <? switch($pageData['id_page']){
         case 1:
         {     ?>
    
    <!-- MAIN CONTENT -->
    <div class="mainContentWrapper">
    	   	<!-- LEFT SLIDER -->
          <div class="leftSliderWrapper">
          		
          
          </div>
          <!-- INNER CONTENT -->
          <div class="innerContentWrapper">
          	<!-- MID SLIDER -->
            <div class="midSliderWrapper">
            	UUUPPPPSS HAY UN ERROR!!!
                La pagina a la que esta intentando ingresar no existe!
                
            </div>
            <!-- END MID SLIDER -->
            
            <!-- BOTTOM SLIDERS -->
            <div class="bottomSliderWrapper">
            		
              </div>
              <!-- END BOTTOM SLIDERS -->
              
              
             <?  }break;
          

// PLANTILLA 2    
               case 127: { include_once
                  ('pages/plantilla2.php');
               
                }break;
             case 117: { include_once
                  ('pages/noticias.php');
               
                }break; 
//Servicio info            
                case 132: { include_once
                  ('pages/servicio.php');
               
                }break; 
// UNETE A NOSOTROS
                     case 130: { include_once
                  ('pages/unete.php');
               
                }break; 
// PRODUCTOS
               case 128: { include_once
                  ('pages/productos.php');
               
                }break; 
// PRODUCTOS -> AGUAS
    case 144: { include_once
                  ('pages/aguas.php');
               
                }break;   
// PRODUCTOS -> Carbonatadas
    case 145: { include_once
                  ('pages/carbonatadas.php');
               
                }break;   
// MAPA DEL SITIO    
               case 141: { include_once('pages/mapa.php');
               
                }break;
// Politicas de provacidad
               case 157: { include_once('pages/politica.php');
               
                }break; 
// Terminos de uso    
               case 158: { include_once('pages/termino.php');
               
                }break; 
// CONTACTO              
               case 131: { include_once('pages/contacto.php');
               
                }break; ?>           
              
            
              <?  } //FIN DEL CASE ?>
              
              
              <!--FOOTER-->    
                    <div class="footerWrapper">
                       
                        <? include("./pages/footer.php");?>
                    
                    </div>    
              <!-- END FOOTER-->
          </div>
    			<!-- END INNER CONTENT -->       
    </div>
    <!--  END MAIN CONTENT -->

</div>
    <?
  /*
echo "<pre>";
//print_r($pageData);
print_r(printPageByPage(157,$pageData['lang']));
echo "</pre>";
    */
?>
		<?php 
		  //  include_once('./pages/'.$contentFile);
        ?>
		


</body>
</html>
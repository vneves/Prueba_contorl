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
	'introtext' => 'ERROR',
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

<?php
if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) {
?>
<!--<link rel="stylesheet" href="css/fuente_helvetica.css" type="text/css" media="screen" />-->
<?php
}else{
?>
<!--<link rel="stylesheet" href="css/fuente.css" type="text/css" media="screen" />-->
<?php
}
?>

        <link rel="stylesheet" type="text/css" media="screen" href="js/ketchup/css/jquery.ketchup.css" />

        <script type="text/javascript" src="js/ketchup/js/jquery.js"></script>       
        <!--FAV ICON-->
        <link rel="shortcut icon" href="favicon.ico"/>
        <!--FAV ICON-->	
        
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <link rel="stylesheet" type="text/css" href="css/tablestyle.css" />
        
        <!--CARRUSELL-->
        <link href="js/carrusel/style.css" rel="stylesheet" type="text/css" />
        <!--jQuery library -->
<!--        <script type="text/javascript" src="js/carrusel/lib/jquery-1.4.2.min.js"></script>
        <!--jCarousel library-->
        <script type="text/javascript" src="js/carrusel/lib/jquery.jcarousel.min.js"></script>
        <script type="text/javascript" src="js/carrusel/carrusel.js"></script>-->
        <!--jCarousel skin stylesheet-->
        <link rel="stylesheet" type="text/css" href="js/carrusel/skins/tango/skin.css" />
        
        <!--prettyPhoto-->	
        <link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
        <script src="js/prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
        <!--FIN prettyphoto-->	
        
        <script type="text/javascript" src="js/ketchup/js/jquery.ketchup.all.min.js"></script> 
        <script type="text/javascript">
            jQuery(document).ready(function() {
             $('#fields-in-call').ketchup({} ,{
               '.required' : 'required',
               '#fic-username' : 'username',
               '#fic-number' : 'number',
               '#fic-email' : 'email',
               '#fic-user_name' : 'username'
             }
            );
            })
        </script>
                
</head>
<body>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $("a[rel^='prettyPhoto']").prettyPhoto();
        });
    </script>
    <div id="page">
        <div id="header">
            <img alt="" src="img/header.png" width="1150" height="117" />
            <div id="logo_image">
                <img alt="" src="img/logo.png" width="966" height="96" />
            </div>
        </div>
        <div id="line"></div>
        <div id="content">
<?php
    require_once("pages/menu.php");
?>
  
<!--******** Inicio Switch *********-->    
<? 
 switch($pageData['id_page']){
         case 1:
         { 
            require_once("pages/slideShow.php");
?>
  
                <div id="content_notice">
                    <div id="bullete" style="width: 11px; height: 10px; float: right; margin-top: -7px;">
                        <img style="z-index: 10;" src="img/bullete.png" width="11" height="10" alt="thumbs" />
                    </div>
<?php
            require_once("pages/videosSlide.php");
?>
<?php
            require_once("pages/noticiasSlide.php");
?>
                    <div id="bullete1" style="width: 11px; height: 10px; margin-top: 272px;">
                        <img style="z-index: 10;" src="img/bullete.png" width="11" height="10" alt="thumbs" />
                    </div>
                </div> 

<?      
        }break; 
    case 3:
         { 
            require_once("pages/productos.php");               
        }break; 
    case 5:
         { 
            require_once("pages/contacto.php");               
        }break;      
    case 11:
         { 
            require_once("pages/noticias.php");               
        }break;
    case 25:
        { 
            include_once('pages/mapa.php');
               
        }break;
        default:
        {
            include_once('pages/default.php');            
        }  
    ?>                                
<? } //<!--******** Inicio Switch *********-->  
?>
              
              
    </div> 
              <!--FOOTER-->    

        <? include("./pages/footer.php");?>
</div>
</body>
</html>

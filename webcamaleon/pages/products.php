<?php
if (!defined("FROM_MAIN")) die("");

require_once $APP['base_admin_path'].'pages/class/product_category.php';

$arr_subsection = array(
	'products_list' => array(
		'title' => $label['manage_products'],
		'file' => 'products_list.php'
	),
	
	'products_edit' => array(
		'title' => $label['manage_products'],
		'file' => 'products_edit.php'
	),
	
	'products_delete' => array(
		'title' => $label['manage_products'],
		'file' => 'products_delete.php'
	),
	
	'filemanager' => array(
		'title' => $label['attached_files'],
		'file' => 'products_filemanager.php'
	),
	
	'filemanager_edit' => array(
		'title' => $label['attached_files'],
		'file' => 'products_filemanager.php'
	),
	
	'filemanager_delete' => array(
		'title' => $label['attached_files'],
		'file' => 'products_filemanager_delete.php'
	)
);

reset($arr_subsection);
$subsection_request = initRequestVar('subsection', 'str', key($arr_subsection));
$subsection_request = (array_key_exists($subsection_request, $arr_subsection)) ? $subsection_request : key($arr_subsection);

$subsection = $arr_subsection[$subsection_request];
?>
<div style="float:left; padding-left:12px; width:600px;" id="div_form">
	<div>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td nowrap="nowrap" class="page_title" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $subsection['title']; ?></td>
			<?php
			if ($subsection_request=='products_list') {
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					$id_product_category = $_POST['id_product_category'];
					if ($id_product_category!='all' && !Product_category::exists($id_product_category)) {
						$id_product_category = isset($_SESSION[$section_request.'_id_product_category']) ? $_SESSION[$section_request.'_id_product_category'] : '';
					} else {
						$_SESSION[$section_request.'_id_product_category'] = $id_product_category = $_POST['id_product_category'];
					}
				} else {
					$id_product_category = isset($_SESSION[$section_request.'_id_product_category']) ? $_SESSION[$section_request.'_id_product_category'] : 'all';
				}
				if (!empty($id_product_category) && $id_product_category!='all') {					
					$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=products_edit&action=insert&id_product_category=$id_product_category";
					echo '<td align="right" valign="bottom" width="100%">';					
					echo '<a href="'.$href.'" class="form_submit">Agregar Producto</a>';					
					echo '</td>';
				}else{
					$var=product_category::listProduct_category();
					if (!empty($var)){
						$id_product_cat=$var[0]['id_product_category'];
						$id_product_category="all";
						$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=products_edit&action=insert&id_product_category=$id_product_category&id_product_cat=$id_product_cat";
						echo '<td align="right" valign="bottom" width="100%">';
						echo '<a href="'.$href.'" class="form_submit">Agregar Producto</a>';
						echo '</td>';
					}					
				}
			} else if ($subsection_request=='filemanager') {
				$id_product = isset($_REQUEST['id_product']) ? $_REQUEST['id_product'] : 0;
				
				$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request";
				echo '<td align="right" valign="bottom" width="100%" nowrap="nowrap">';
				echo '<a href="'.$href.'" class="form_submit">Volver a la lista de productos</a>&nbsp;';
				echo '</td>';
				
				$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=filemanager_edit&action=insert&id_product=$id_product";
				echo '<td align="right" valign="bottom" width="100%" nowrap="nowrap">';
				echo '<a href="'.$href.'" class="form_submit">Agregar archivo</a>';
				echo '</td>';
			}
			?>
		</tr>
		</table>
		<div><img src="images/spacer.gif" width="1" height="14" alt="" /></div>
	</div>
	<div>
	<?php
	require_once 'pages/'.$subsection['file'];
	?>
	</div>
</div>
<?php
if (!defined("FROM_MAIN")) die("");

$arr_subsection = array(
	'productscategories_list' => array(
		'title' => $label['manage_category_products'],
		'file' => 'productscategories_list.php'
	),
	
	'productscategories_edit' => array(
		'title' => $label['manage_category_products'],
		'file' => 'productscategories_edit.php'
	),
	
	'productscategories_delete' => array(
		'title' => $label['manage_category_products'],
		'file' => 'productscategories_delete.php'
	)
);

reset($arr_subsection);
$subsection_request = initRequestVar('subsection', 'str', key($arr_subsection));
$subsection_request = (array_key_exists($subsection_request, $arr_subsection)) ? $subsection_request : key($arr_subsection);

$subsection = $arr_subsection[$subsection_request];

$id_parent = !isset($_REQUEST['id_parent']) ? 0 : intval($_REQUEST['id_parent']);
?>
<div style="float:left; padding-left:12px; width:600px" id="div_form">
	<div>
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="page_title" nowrap="nowrap" style="padding-top:13px; padding-bottom:13px; border-bottom:1px solid #AFCD5B; "><?php echo $subsection['title']; ?></td>
			<?php
			if ($subsection_request=='productscategories_list') {
				$href = $_SERVER['PHP_SELF']."?page=$page_request&section=$section_request&subsection=productscategories_edit&id_parent=$id_parent&action=insert";
				echo '<td align="right" valign="bottom" width="100%">';
				echo '<a href="'.$href.'" class="form_submit">Agregar categor&iacute;a</a>';
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
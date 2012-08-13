<?php
require_once $APP['base_admin_path']."pages/class/page.php";
require_once $APP['base_admin_path']."pages/class/product.php";
require_once $APP['base_admin_path']."pages/class/product_category.php";
require_once $APP['base_admin_path']."pages/class/content.php";

function printPagePath($id_parent, $lang) {
	$arr_path = Page::getPath($id_parent, $lang);
	if (!empty($arr_path)) {
		$left = 12;
		echo '<div id="div_path">';
		echo '<div><a href="main.php?page=sections&content_language='.$lang.'">Secciones</a></div>';
		foreach ($arr_path as $key => $value) {
			echo '<div>';
			if ($left>0) {
				echo '<div style="padding-left:'.($left-12).'px; float:left"><img src="images/rowpath.gif" width="12" height="12" alt="" /></div>';
			}
			echo '<div><a href="main.php?page=sections&id_parent='.$key.'&content_language='.$lang.'">'.$value.'</a></div>';
			echo '</div>';
			$left+=12;
		}
		echo '</div>';
	}
}

function saveEmptyContent ($content) {
	global $APP;
	global $cn;
	
	foreach ($APP['content_languages'] as $key=>$value) {
		if ($key == $content->_data['lang']) {
			$content->saveData();
			$content->_data['permalink'] = generate_permalink($content->_data['title'])."_".$content->_data['id_content'].".html";
			$sql = "UPDATE `content` SET `permalink`='".$content->_data['permalink']."' WHERE id_content='".$content->_data['id_content']."'";
			$cn->Execute($sql);
		} else {
			$contentEmpty = new Content('');
			foreach ($contentEmpty->_cols as $field => $fieldvalue) {
				$contentEmpty->_data[$field] = '';
			}
			
			$tmp_permalink = random_string(20);
			while (Content::existsPermalink($tmp_permalink)) {
				$tmp_permalink = random_string(20);
			}
			$contentEmpty->_data['permalink'] = $tmp_permalink;
			
			$contentEmpty->_data['title'] = $content->_data['title'];
			$contentEmpty->_data['lang'] = $key;
			$contentEmpty->_data['key'] = '';
			$contentEmpty->_data['date_last_update'] = date('Y-m-d H:i:s');
			$contentEmpty->_data['id_page'] = $content->_data['id_page'];
			$contentEmpty->_data['introtext'] = $content->_data['introtext'];
			$contentEmpty->_data['maintext'] = $content->_data['maintext'];
			$contentEmpty->_data['id_user_last_update'] = $content->_data['id_user_last_update'];
			
			$contentEmpty->saveData();
			
			$contentEmpty->_data['permalink'] = generate_permalink($contentEmpty->_data['title'])."_".$contentEmpty->_data['id_content'].".html";
			$sql = "UPDATE `content` SET `permalink`='".$contentEmpty->_data['permalink']."' WHERE id_content='".$contentEmpty->_data['id_content']."'";
			$cn->Execute($sql);
		}
	}
}
function saveEmptyProducts ($content) {
	global $APP;
	global $cn;
	
	foreach ($APP['content_languages'] as $key=>$value) {
		if ($key == $content->_data['lang']) {
			$content->saveData();
			$content->_data['permalink'] = "product_".$content->_data['id_product'].".html";
			$sql = "UPDATE `product` SET `permalink`='".$content->_data['permalink']."' WHERE id_product='".$content->_data['id_product']."'";
			$cn->Execute($sql);
		} else {
			$contentEmpty = new Product('');
			foreach ($contentEmpty->_cols as $field => $fieldvalue) {
				$contentEmpty->_data[$field] = '';
			}
			
			$tmp_permalink = random_string(20);
			while (Content::existsPermalink_products($tmp_permalink)) {
				$tmp_permalink = random_string(20);
			}
			$contentEmpty->_data['permalink'] = $tmp_permalink;
			
			$contentEmpty->_data['title'] = $content->_data['title'];
			$contentEmpty->_data['lang'] = $key;
			$contentEmpty->_data['order'] = $content->_data['order'];
			$contentEmpty->_data['available'] = $content->_data['available'];
			$contentEmpty->_data['id_product_category'] = $content->_data['id_product_category'];
			$contentEmpty->_data['description'] = $content->_data['description'];
			$contentEmpty->_data['t_nutricional'] = $content->_data['t_nutricional'];
			$contentEmpty->_data['unitary_price'] = $content->_data['unitary_price'];
			$contentEmpty->_data['thumb_image'] = $content->_data['thumb_image'];
			$contentEmpty->_data['big_image'] = $content->_data['big_image'];
			$contentEmpty->_data['is_sponsor'] = $content->_data['is_sponsor'];
			$contentEmpty->_data['is_private'] = $content->_data['is_private'];
			$contentEmpty->_data['envase'] = $content->_data['envase'];
			$contentEmpty->_data['c_envase'] = $content->_data['c_envase'];
			$contentEmpty->_data['ingredientes'] = $content->_data['ingredientes'];
			$contentEmpty->_data['preparacion'] = $content->_data['preparacion'];
			
			$contentEmpty->saveData();
			
			$contentEmpty->_data['permalink'] = "product_".$contentEmpty->_data['id_product'].".html";
			$sql = "UPDATE `product` SET `permalink`='".$contentEmpty->_data['permalink']."' WHERE id_product='".$contentEmpty->_data['id_product']."'";
			$cn->Execute($sql);
		}
	}
}
function saveEmptyProducts_category ($content) {
	global $APP;
	global $cn;
	
	foreach ($APP['content_languages'] as $key=>$value) {
		if ($key == $content->_data['lang']) {
			$content->saveData();
			$content->_data['permalink'] = "category_".$content->_data['id_product_category'].".html";
			$sql = "UPDATE `product_category` SET `permalink`='".$content->_data['permalink']."' WHERE id_product_category='".$content->_data['id_product_category']."'";
			$cn->Execute($sql);
		} else {
			$contentEmpty = new Product_category('');
			foreach ($contentEmpty->_cols as $field => $fieldvalue) {
				$contentEmpty->_data[$field] = '';
			}
			
			$tmp_permalink = random_string(20);
			while (Content::existsPermalink_products($tmp_permalink)) {
				$tmp_permalink = random_string(20);
			}
			$contentEmpty->_data['permalink'] = $tmp_permalink;
			
			$contentEmpty->_data['title'] = $content->_data['title'];
			$contentEmpty->_data['lang'] = $key;
			$contentEmpty->_data['order'] = $content->_data['order'];
			$contentEmpty->_data['image'] = $content->_data['image'];
			$contentEmpty->_data['id_parent'] = $content->_data['id_parent'];
			$contentEmpty->_data['description'] = $content->_data['description'];			
			
			$contentEmpty->saveData();
			
			$contentEmpty->_data['permalink'] = "category_".$contentEmpty->_data['id_product_category'].".html";
			$sql = "UPDATE `product_category` SET `permalink`='".$contentEmpty->_data['permalink']."' WHERE id_product_category='".$contentEmpty->_data['id_product_category']."'";
			$cn->Execute($sql);
		}
	}
}
?>
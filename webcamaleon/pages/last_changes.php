<?php
if (!defined("FROM_MAIN")) die("");
require_once dirname(__FILE__)."/class/content.php";
$arr_changes = Content::getLastChanges();
?>
<div class="div_content">
	<div class="space_up"></div>
	<div><img src="images/spacer.gif" width="" height="14" alt="" /></div>
	<div>
		<div class="page_title" style="padding-top:13px; padding-bottom:13px; padding-left:24px;">
			<?php echo $label["welcome"]; ?>! <?php echo $_SESSION["name"]." ".$_SESSION["lastname"];  ?>
		</div>
		<div style="padding-left:24px;"><img src="images/line1.gif" alt="" /></div>
		<div><img src="images/spacer.gif" width="1" height="17" alt="" /></div>
		<div style="padding-left:24px;">
			<table cellpadding="0" cellspacing="0" border="0" width="730">
			<tr>
				<td width="5"><img src="images/green_title_left.gif" width="5" height="28" alt="" /></td>
				<td width="425" class="green_title"><?php echo $label["last_changes"]; ?></td>
				<td width="218" class="green_title" align="center"><?php echo $label["user"]; ?></td>
				<td class="green_title" align="center" width="77"><?php echo $label["date"]; ?></td>
				<td width="5"><img src="images/green_title_right.gif" width="5" height="28" alt="" /></td>
			</tr>
			<?php
			$conta=0;
			foreach ($arr_changes as $value) {
				$class = ($conta%2==0) ?  "even_row" : "odd_row";
				$sql = "SELECT name, lastname FROM user_acct WHERE id_user_acct='".$value['id_user_last_update']."' LIMIT 1";
				$user_array = $cn->GetRow($sql);
				if (!empty($user_array)>0) {
					$str_user = implode(" ", $user_array);
				} else {
					$str_user = "";
				}
				echo '<tr class="'.$class.'">';
					echo '<td><img src="images/spacer.gif" width="1" height="28" alt="" /></td>';
					echo '<td><a class="a" title="'.$label['edit_page'].'" href="main.php?page=sections&section=edit&action=edit&id_page='.$value['id_page'].'&lang='.$value['lang'].'">'.$value['title'].'</a></td>';
					echo '<td align="center">'.$str_user.'</td>';
					echo '<td align="center">'.date("Y/m/d", strtotime($value['date_last_update'])).'</td>';
					echo '<td></td>';
				echo '</tr>';
				$conta++;
			}
			?>
			</table>
		</div>
	</div>
	<div class="space_down"></div>
</div>
<?php

?>
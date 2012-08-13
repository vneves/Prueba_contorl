<div id="content_brad">
    <ul id="content_brad_ul"> 
<?php
	reset($arr_path);
	$cont=count($arr_path);
	$c=1;
	reset($arr_path);
	while($c<=$cont){
		$root=key($arr_path);
		$arr = printPageBypage($root, $pageData['lang']);
                
                if($c==1){
    ?>  <li style="list-style:none;"><?
                }else{
    ?>  <li><?
                }
                if($c==$cont){
?>
            <a style="color:#E6007E;text-decoration:none;" href="<?=$arr['permalink']?>" title="<?=$arr['title']?>" ><?=$arr['title']?></a>
        </li>
<?php	
                }else{
?>
            <a style="color:#575756;text-decoration:none;" href="<?=$arr['permalink']?>" title="<?=$arr['title']?>" ><?=$arr['title']?></a>
        </li>
       
<?php	
                }
		$c++;
		next($arr_path);
	}
?>
    </ul>
</div>
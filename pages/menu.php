<?php
$nivel_cero=page::listPages(0,"es");
function cargar_hijos($menu,$pageData)
{
    if($menu['contenido']!="contenido")
    {
        $nivel_1=page::listPages($menu['id_page'],"es");
        
//					echo "<pre>";
//					print_r($nivel_1);
//					echo "</pre>";
//					die();
        if($nivel_1!=null){
?>
            <ul>
<?php
            foreach($nivel_1 as $nivel)
            {
                $desc=$nivel['meta_description'];
                if($pageData==$nivel['title']){
                    ?>
                <script>
                    document.getElementById('link_<?=$nivel['id_parent']?>').style.color='#E6007E';
                </script>
                    <?
                }
//                if(strcmp($desc,'tabla')!=0){
//                    if(strcmp($desc,'lista')!=0){
//                        if(strcmp($desc,'enlace')!=0){
                    
?>
               <li>
                    <a style="color:#FFFFFF;" href="<?=$nivel['permalink']?>"><?=$nivel['title']?></a>
               </li>
<? //                      }
//                    }
//                }
        
        } ?>
            </ul>
<?php
        }
    }
}
?>


<div id="content_menu">
    <ul id="ul_menu">
<?php
    foreach ($nivel_cero as $menu){

        if($menu['is_published']==0) continue;
?>
        <li class="nivel1">                              
    <? if($pageData['title']==$menu['title']){ ?> 
            
            <a id="link_<?=$menu['id_page']?>" style="color:#E6007E;" href="<?=$menu['permalink']?>"><?=$menu['title']?></a>
            
        <?=cargar_hijos($menu,$pageData['title']);?>
<?php
        }
        else
        {
?>
            <a id="link_<?=$menu['id_page']?>" style="color:#FFFFFF;" href="<?=$menu['permalink']?>"><?=$menu['title']?></a>

        <?=cargar_hijos($menu,$pageData['title']);?>
    <?  } ?>

        </li>
<?  } ?>
    </ul> 
    <a style="margin-left: 3px;" href="#"><img alt="" src="img/twitter_logo.png" height="25" width="27" /></a>
</div>

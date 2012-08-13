   
    	<div id="title">
            <p>Mapa Del Sitio</p>
        </div>
    <div id="content_text"  class="mapa" >
					
  
          	
<?php
$arr_level0 = Page::listPages(0, "es");
	//print_r($arr_level0);
function cargar_hijos_1($menu)
{
    //print_r($menu);
	if($menu['contenido']!="contenido")
    {
        $nivel_1=page::listPages($menu['id_page'],"es");
        ?>
            <ul>
        <?
        foreach($nivel_1 as $nivel)
        {
            ?>
               <li>
                   <div >
                       <a  href="<?=$nivel['permalink']?>"><?=$nivel['title']?></a>
                   </div>
               </li>
            <?
        }
            ?>
            </ul>
            <?
    }
   
}
?>


<div >
      <ul >
        <?php
             foreach ($nivel_cero as $menu)
                {
                    if($menu['is_published']==0) continue;?>
                        <li>
                              <?php if($menu['title']=="Preguntas Frecuentes")
                                {?>
                                    <div >
                                        <a href="<?=$menu['permalink']?>" style="top:-2px;"><?=$menu['title']?></a>
                                    <?
                                    if($menu['contenido']!="contenido")
                                        {
                                            $nivel_1=page::listPages($menu['id_page'],"es");
                                            ?>
                                                <ul >
                                            <?
                                            foreach($nivel_1 as $nivel)
                                            {
                                                ?>
                                                   <li >
                                                       <div>
                                                           <a href="<?=$nivel['permalink']?>"><?=$nivel['title']?></a>
                                                       </div>
                                                   </li>
                                                <?
                                            }
                                                ?>
                                                </ul>
                                                <?
                                           /* if($nivel_1!=NULL)
                                            {
                                                print_r($nivel_1);
                                                exit();
                                                echo "hay menus!xD";
                                            }*/
                                        }?>
                                        
                                    </div>
                                <?php }
                                else
                                {
                                    //print_r($pageData);
									if($pageData['title']==$menu['title'])
                                    {
                                        ?>
                                        <div>
                                            <a href="<?=$menu['permalink']?>"><?=$menu['title']?></a>
                                            <?=cargar_hijos_1($menu);?>
                                        </div>
                                        <?
                                    }
                                    else
                                    {?>
                                        <div >
                                            <a href="<?=$menu['permalink']?>"><?=$menu['title']?></a>
                                            <?=cargar_hijos_1($menu);?>
                                        </div>
                                    <?php }

                                }?>
                            
                        </li>
                    <?
                }
        ?>
        </ul>
</div>
</div>
<?php

 $rpta="";
    
 $pageTemp=printPageByPage($APP['Noticias'], "es");
    
 $Child=page::listPages($APP['Noticias'], 'es');
 ?>
 <div id="title">
    <p><? echo $pageTemp['title']?></p>
</div>
<center>
    <div>
        <div>
<?php 
            for($i=0;$i<count($Child);$i++)
            {
                if($Child[$i]['is_published']==1){
                    $pageTemp=printPageByPage($Child[$i]['id_page'], "es");
                    $fecha=$pageTemp['date_creation'];
?>
            <div style=" margin-top: 10px;min-height: 120px;">
                <div style="width:599px; height:auto;border-bottom: 1px solid #E6007E; min-height: 120px;">
                    <?if($pageTemp['template_images']!=null){?>
                        <div style="position: absolute;float: left;margin-right: 15px;border:1px #000 solid;width: 111px; height: 83px;">
                            <a href="<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>" rel="prettyPhoto">
                                <img src='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>'  title="<?=$pageTemp['title']?>" alt="<?=$pageTemp['title']?>" style="z-index:0;" width="111" height="83"  />
                            </a>
                        </div>
                    <?}else{?>
                    <div style="position: absolute;float: left;margin-right: 15px;border:1px #000 solid;width: 111px; height: 83px;">
                        <img src='img/no-image.jpeg'  title="<?=$pageTemp['title']?>" alt="no-image" style="z-index:0;" width="111" height="83"  />
                    </div>
                    <? } ?>
                    <div style="width: 470px;margin-left: 130px;position: absolute;">
                        <div class="notice_title">

                            <a href="<?=$pageTemp['permalink']?>" style="margin-top: 0px;font-family:'Gothic-Bolt';font-size: 17px;"><?=$pageTemp['title']?></a>
                            <div align="left" class="intro">
                                <?=$pageTemp['meta_description']?>
                            </div>
                        </div>
                            <p style="margin: 0px;font-family:'Gothic';font-size: 15px; float: right"><? echo date("d/m/Y", strtotime($fecha));?></p>
<!--                            <div class="more">
                            <a  href="<?=$pageTemp['permalink']?>"><img style="z-index:0;" src="img/more.png" width="15" height="15" alt="more" /></a>
                        </div>-->
                    </div>
                </div>
            </div>                       
<?              }
            
            }
            echo($rpta); 
?>                    
        </div>
    </div>
</center>

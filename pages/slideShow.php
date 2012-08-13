<div id="content_slide_show">
    <ul id="mycarousel" class="jcarousel-skin-tango">
<?php
    $pageTemp=printPageByPage($APP['SlideShow'], 'es');

    for($i=0;$i<count($pageTemp['template_images']);$i++){ 
?>
        <li>
            <a rel="prettyPhoto" href='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][$i]['filename']?>'>
                <img style="z-index:0;" width="292" height="180" src='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][$i]['filename']?>'  title="<?=$pageTemp['title']?>" alt="<?=$pageTemp['title']?>" />
            </a>
        </li>
<? }?>
    </ul>
</div>

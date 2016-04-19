<div class="center">
<b><legend style="color: green">NHẬT KÝ HOẠT ĐỘNG</legend></b>
<ul>
    <?php

    if(isset($activities)){
    foreach($activities as $ac){
    ?>
    <li>
        <p><?php echo "<b>".$ac['Electronic']['name'].'</b><i> bật lúc '. date("H:i:s / d-m-Y",$ac['Activity']['time_on'])."</i>"; ?></p>
    </li>

    <?php if($ac['Activity']['time_off']!=0 & $ac['Activity']['time_off']!= null){ ?>
    <li>
        <p><?php echo "<b>".$ac['Electronic']['name'].'</b><i> tắt lúc '. date('H:i:s / d-m-Y',$ac['Activity']['time_off'])."</i>";  ?></p>
    </li>
    <? } ?>
    <? }} ?>
</ul>
</div>
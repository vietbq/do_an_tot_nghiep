<?php
?>
<div class="x_panel">
    <? echo $this->element('x_title'); ?>
    <div class="x_content">
        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
            <div class="clear"></div>
            <? echo $this->element('data_show'); ?>
            <table id="example" class="table table-striped responsive-utilities jambo_table dataTable" aria-describedby="example_info">
                <thead>
                    <tr class="headings" role="row">
                        <th class="sorting" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 36px;">Stt</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 98px;">Tên thiết bị</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 98px;">Phòng</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 223px;">Loại</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 223px;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all" id="list-electronic">
                    <? foreach($electronics as $k => $v){ ?>
                    <tr class="pointer odd">
                        <td class="a-center sorting_1"><? echo $k + 1 ?></td>
                        <td><a href="electronics/show/<? echo $v['Electronic']['id'] ?>"><b><? echo $v['Electronic']['name'] ?></b></a></td>
                        <td><? echo $v['Electronic']['room'] ?></td>
                        <td><? echo $v['Electronic']['type'] ?></td>
                        <td id="<? echo 'button-'.$v['Electronic']['id'] ?>">
                            <input type="hidden" value="<? echo $v['Electronic']['id'] ?>">
                            <? if($v['Electronic']['type']!=2){ ?>
                                <? $checked = ($v['Electronic']['status'] == 1) ? "checked" : "" ?>
                                <? $class = ($v['Electronic']['status'] == 1) ? "switch-on-btn" : "switch-off-btn" ?>
                                <label>
                                    <input type="checkbox" <? echo $checked ?> class="js-switch" checked="" data-switchery="true" style="display: none;">
                                    <span class="<? echo 'switchery '.$class ?>" 
                                        rel="<? echo $v['Electronic']['status']?>" data="<? echo $v['Electronic']['id'] ?>">
                                        <small></small>
                                    </span>
                                </label>
                            <? }else{ ?>
                            <b><? echo $v['Electronic']['term']."°C" ?></b>
                            <? } ?>
                        </td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<link href="assets/css/switchery/switchery.min.css" rel="stylesheet">
<script type="text/javascript">
    setTimeout(function(){
       window.location.reload(1);
    }, 30000);
</script>

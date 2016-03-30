<?php
?>
<div class="x_panel">
    <? echo $this->element('x_title'); ?>
    <div class="x_content">
        <div id="example_wrapper" class="dataTables_wrapper" role="grid">
            <div class="clear"></div>
            <? echo $this->element('data_show'); ?>
            <div class="dataTables_filter" id="example_filter">
                <label>Search all columns: <input type="text" aria-controls="example"></label>
            </div>
            <table id="example" class="table table-striped responsive-utilities jambo_table dataTable" aria-describedby="example_info">
                <thead>
                    <tr class="headings" role="row">
                        <th class="sorting" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 36px;">Stt</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 98px;">Tên thiết bị</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 98px;">Phòng</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 223px;">Loại</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 223px;">Công suất</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 223px;">Trạng thái</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 116px;">Ngày đăng ký</th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <? foreach($electronics as $k => $v){ ?>
                    <tr class="pointer odd">
                        <td class="a-center sorting_1"><? echo $k + 1 ?></td>
                        <td><? echo $v['Electronic']['name'] ?></td>
                        <td><? echo $v['Electronic']['room'] ?></td>
                        <td><? echo $v['Electronic']['type'] ?></td>
                        <td><? echo $v['Electronic']['energy'] ?></td>
                        <td id="<? echo 'button-'.$v['Electronic']['id'] ?>">
                            <? if($v['Electronic']['type']==1){ ?>
                                <? if($v['Electronic']['status'] == 0){ ?>
                                <a id="<? echo 'turn-on-'.$v['Electronic']['id'] ?>" class="btn btn-default" title="Tắt">
                                    <i class="fa fa-lightbulb-o"></i>
                                </a>
                                <?php
                                echo $this->Js->get('#'.'turn-on-'.$v['Electronic']['id'])->event(
                                'click', 
                                $this->Js->request(
                                array(
                                'controller' => 'electronics', 
                                'action' => 'change_status/'.$v['Electronic']['id']), 
                                array(
                                'update' => '#'.'button-'.$v['Electronic']['id'],
                                'async' => true,
                                )
                                )
                                );
                                ?>
                                <? }else{ ?>
                                <a id="<? echo 'turn-off-'.$v['Electronic']['id'] ?>" class="btn btn-warning" title="Bật">
                                    <i style="color: yellow" class="fa fa-lightbulb-o"></i></a>
                                </a>

                                <? } ?>
                            <? }else{ ?>
                            <b><? echo $v['Electronic']['term']."°C" ?></b>
                            <? } ?>
                        </td>
                        <td><? echo date('d-m-Y/H:i:s',$v['Electronic']['created_at']) ?></td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
            <!--<?php echo $this->element('pagination'); ?>-->
        </div>
    </div>
</div>

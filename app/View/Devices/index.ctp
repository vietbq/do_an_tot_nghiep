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
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 223px;">ID</th>
                        <th class="sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 116px;">Ngày đăng ký</th>
                        <th class="no-link last sorting" role="columnheader" tabindex="0" rowspan="1" colspan="1" style="width: 64px;">
                            <span class="nobr">Action</span>
                        </th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <? foreach($devices as $k => $v){ ?>
                        <tr class="pointer odd">
                            <td class="a-center sorting_1"><? echo $k + 1 ?></td>
                            <td><? echo $v['Device']['name'] ?></td>
                            <td><? echo $v['Device']['device_id'] ?></td>
                            <td><? echo $v['Device']['created_at'] ?></td>
                            <td class="last"><a href="#">View</a></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
<!--            <?php echo $this->element('pagination'); ?>-->
        </div>
    </div>
</div>


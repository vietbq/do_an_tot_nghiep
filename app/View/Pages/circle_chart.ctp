<?php
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Đồ thị tiêu thụ năng lượng<small>Theo các thiết bị điện</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row" style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
                    <div class="col-md-12">
                        <div class="row" style="text-align: center;">
                            <div class="col-md-4">
                                <canvas id="canvasDoughnut-day"></canvas>
                                <h4 style="margin:0">Trong ngày (<? echo Configure::read('day_week')[date("D",time())]; ?>)</h4>
                            </div>
                            <div class="col-md-4">
                                <canvas id="canvasDoughnut-week"></canvas>
                                <h4 style="margin:0">Trong tuần <? echo GetTime::getWeeks(time()); ?></h4>
                            </div>
                            <div class="col-md-4">
                                <canvas id="canvasDoughnut-month"></canvas>
                                <h4 style="margin:0">Trong tháng <? echo GetTime::getMonth(time()); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

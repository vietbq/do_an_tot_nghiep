<?php
/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
?>
<div class="row">
<div class="x_panel">
    <?php echo $this->element("x_title") ?>
    <div class="x_content">
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-clock-o"></i>
                    </div>
                    <div class="count"><?php echo $sum[0].$unit ?></div>
                    <h3><? echo Configure::read('day_week')[date("D",time())]; ?></h3>
                    <p>Năng lượng tiêu thụ trong ngày.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-calendar"></i>
                    </div>
                    <div class="count"><?php echo $sum[1].$unit ?></div>

                    <h3>Tuần <? echo GetTime::getWeeks(time()); ?></h3>
                    <p>Năng lượng tiêu thụ trong tuần.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-calendar-o"></i>
                    </div>
                    <div class="count"><?php echo $sum[2].$unit ?></div>

                    <h3>Tháng <? echo GetTime::getMonth(time()); ?></h3>
                    <p>Năng lượng tiêu thụ trong tháng.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-plug"></i>
                    </div>
                    <div class="count"><?php echo $num[0] ?> Thiết bị</div>

                    <h3></h3>
                    <p>Số lượng thiết bị điện.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-fire"></i>
                    </div>
                    <div class="count">Nhiệt độ</div>

                    <h3></h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cảm biến</th>
                                <th>Phòng</th>
                                <th>Nhiệt độ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($t_array as $t){ ?>
                            <tr>
                                <td><? echo $t['Electronic']['name'];  ?></td>
                                <td><? echo $t['Electronic']['room'];  ?></td>
                                <td><? echo $t['Electronic']['term'];  ?>°C</td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-eyedropper"></i>
                    </div>
                    <div class="count"><?php echo $num[1] ?> Cảm biến</div>

                    <h3></h3>
                    <p>Số lượng cảm biến nhiệt</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "chart.ctp" ?>
<?php include "circle_chart.ctp" ?>
<script src="assets/js/moment/moment.min.js"></script>
<script src="assets/js/chartjs/chart.min.js"></script>
<script>
    function getDataChart(input) {
        var data = {
        labels: input.labels,
        datasets: [{
                data: input.datasets.data,
                backgroundColor: input.datasets.color,
                hoverBackgroundColor: input.datasets.hover
            }]
    };
        return data;
    }
    Chart.defaults.global.legend = {
        enabled: false
    };
    //get data from database
    <?php 
        foreach($data as $key=>$value){
            echo 'var '.$key.' = '.json_encode($value).';';
        }
    ?>
    // Doughnut chart
    var e_day = document.getElementById("canvasDoughnut-day");
    var e_week = document.getElementById("canvasDoughnut-week");
    var e_month = document.getElementById("canvasDoughnut-month");
    var data_day = getDataChart(canvas_day);
    var data_week = getDataChart(canvas_week);
    var data_month = getDataChart(canvas_month);
    
    var canvasDoughnut = new Chart(e_day, {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: data_day
    });
    var canvasDoughnut_week = new Chart(e_week, {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: data_week
    });
    var canvasDoughnut_month = new Chart(e_month, {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: data_month
    });
    // Bar chart
    var ctx = document.getElementById("mybarChart");
    var bar_data = getDataChart(bar_month);
    var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: bar_data,
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });

</script>

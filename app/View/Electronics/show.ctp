<?php
if(isset($electronic)){
?>
<div class="x_panel">
    <? echo $this->element('x_title'); ?>
    <div class="x_content">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <b><legend style="color: green">ĐỒ THỊ NĂNG LƯỢNG TIÊU THỤ CỦA THIẾT BỊ</legend></b>
            
            <canvas id="lineChart"></canvas>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <?php include "activities.ctp"; ?>
        </div>
    </div>
</div>
<?
}else{

}
?>
<script src="assets/js/moment/moment.min.js"></script>
<script src="assets/js/chartjs/chart.min.js"></script>
<!-- sparkline -->
<script src="assets/js/sparkline/jquery.sparkline.min.js"></script>
<script>
    Chart.defaults.global.legend = {
        enabled: false
    };

    // Line chart
    var ctx = document.getElementById("lineChart");
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($data['labels']); ?>,
            datasets: [{
                    labels: <?php echo json_encode($data['label']); ?>,
                    backgroundColor: "rgba(38, 185, 154, 0.31)",
                    borderColor: "rgba(38, 185, 154, 0.7)",
                    pointBorderColor: "rgba(38, 185, 154, 0.7)",
                    pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointBorderWidth: 0.5,
                    data: <?php echo json_encode($data['data']); ?>
                }]
        },
    });
</script>
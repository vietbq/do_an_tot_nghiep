<?php
?>
<div class="x_panel">
    <? echo $this->element('x_title'); ?>
    <div class="x_content">
      <?php echo $this->Form->create('Electronic'); ?>
        <?
          echo $this->Form->input('id');

          echo $this->Form->input('name', array(
            'label' => false,
            'placeholder' => 'Tên thiết bị',
            'class' => 'form-control col-md-7 col-xs-12',
            'div' => array(
              'class' => 'form-group'
              ),
            'style' => "margin-bottom: 20px"
            ));

          echo $this->Form->input('type', array(
            'options' => array('1' => 'Thiết bị chiếu sáng', '2' => 'Cảm biến nhiệt', '3' => 'Thiết bị điện khác'),
            'label' =>  false,
            'class' => 'form-control col-md-7 col-xs-12',
            'div' => array(
              'class' => 'form-group'
              ),
            'style' => "text-align: center; margin-bottom: 20px"
            ));
        ?>
        <div class="form-group text-center">
          <input type="submit" class="btn btn-success" value="Thêm thiết bị" />
        </div>
      <?php echo $this->Form->end(); ?>
    </div>
</div>



<?php
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <? echo $this->element('x_title') ?>
            <div class="x_content">
                <br>
                <?php echo $this->Form->create('User', array('type' => 'file')); ?>
                <?php echo $this->Flash->render(); ?>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12 text-center" >
                        <img id="user-avatar" width="256" height="256" class="img-circle" src="<?php echo Configure::read('user_icon_url') ?>">
                        <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 10px">
                            <div class="form-group">
                                <label for="avatarInputFile">
                                    <span  class="btn btn-info">
                                        <i class="fa fa-file-image-o"></i> Thay ảnh
                                    </span>
                                    <input type="file" id="avatarInputFile" name="avatar" style="display:none">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <h2>Nhập thông tin</h2>
                        </div>
                       
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('email', array('type' => 'text',
                            'class' => 'form-control', 'placeholder' => 'Email', 'label' => false)); ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('username', array('type' => 'text',
                            'class' => 'form-control', 'placeholder' => 'Username', 'label' => false)); ?>
                        </div>

                        <div class="text-center" style='margin-bottom: 20px' >
                            <?php echo $this->Form->button("<i class='fa fa-plus'></i> Đăng ký",
                            array('class' => 'btn btn-success submit', 'escape' => false)); ?>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#user-avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#avatarInputFile").change(function () {
        readURL(this);
    });

</script>
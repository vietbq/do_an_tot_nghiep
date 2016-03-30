<?php
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <? echo $this->element('x_title') ?>
            <div class="x_content">
                <br>
                <?php echo $this->Form->create(); ?>
                
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12 text-center" >
                        <img id="user-avatar" width="256" height="256" class="img-circle" src="<?php echo Configure::read('user_icon_url') ?>">
                        <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 10px">
                            <div class="form-group">
                                <label for="avatarInputFile">
                                    <span  class="btn btn-info">
                                        <i class="fa fa-file-image-o"></i> Thay ảnh
                                    </span>
<!--                                    <input type="file" id="avatarInputFile" name="avatar" style="display:none">-->
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <h2>Cập nhật thông tin</h2>
                        </div>
                        <?php echo $this->Session->flash('edit_user'); ?>
                        <br>
                        <?php echo $this->Form->hidden('id',array('value' => $user['User']['id'])) ?>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('email', array('value' => $user['User']['email'], 'type' => 'text',
                            'class' => 'form-control', 'disabled', 'label' => false)); ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('User.username', array('value' => $user['User']['username'] ,'type' => 'text',
                            'class' => 'form-control', 'placeholder' => 'Username', 'label' => false)); ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('data.password', array('type' => 'password',
                            'class' => 'form-control', 'placeholder' => 'Current password', 'label' => false)); ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('password', array('type' => 'password',
                            'class' => 'form-control', 'placeholder' => 'New password', 'label' => false,'required' => false)); ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <?php echo $this->Form->input('password_confirmation', array('type' => 'password',
                            'class' => 'form-control', 'placeholder' => 'Confirmation password', 'label' => false,'required' => false)); ?>
                        </div>
                        <div class="text-center" style='margin-bottom: 20px' >
                            <?php echo $this->Form->button("<i class='glyphicon glyphicon-cog'></i> Cập nhật",
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


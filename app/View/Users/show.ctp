<?php
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <? echo $this->element('x_title') ?>
            <div class="x_content">
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12 text-center" >
                        <img id="user-avatar" width="256" height="256" class="img-circle" src="<?php echo Configure::read('user_icon_url') ?>">

                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12" style='text-align: center; margin-bottom: 20px'>
                            <h2>Nhập thông tin</h2>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" style='margin-bottom: 20px'>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <span class="label label-info"><?php echo $user['User']['email'] ?></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='margin-bottom: 20px'>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <span class="label label-info"><?php echo $user['User']['username'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style='margin-bottom: 20px'>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Thời gian đăng ký</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <span class="label label-info"><?php echo date('d-m-Y',$user['User']['created_at']) ?></span>
                                </div>
                            </div>
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
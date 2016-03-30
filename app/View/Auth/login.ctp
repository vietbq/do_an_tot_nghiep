<?php
?>
<div id="wrapper">
    <section class="login_content">
        <h1>Login Form</h1>

        <?php echo $this->Form->create('User', array('url' => array('controller' => 'auth', 'action' => 'login'))); ?>

        <div class="text-danger"><?php echo $this->Session->flash('auth'); ?></div>

        <?php echo $this->Form->input('email', array('type'	=> 'text', 'class' => 'form-control', 'placeholder' => 'Email', 'label' => false, 'value' => 'buiquocviet1993@gmail.com' )); ?>
        <?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'label' => false, 'value' => '123456' )); ?>

        <div class="clearfix"></div>
        <?php echo $this->Form->button('Log in', array( 'class' => 'btn btn-info col-xs-12')); ?>
        
        <?php echo $this->Form->end() ?>
        <div class="clearfix"></div>
        <hr />
        <h4>Forgot Password?</h4>
        <p>
            No problem, <a href="#">click here</a> to get a new password.
        </p>	
        <div class="separator">
            <div class="clearfix"></div>
            <br />
            <div>
                <h1><i class="fa fa-paw" style="font-size: 26px;"></i>Smart Home</h1>

                <p>©2015 All Rights Reserved by VietBui! Privacy and Terms</p>
            </div>
        </div>
        <!-- form -->
    </section>
    <!-- content -->
</div>

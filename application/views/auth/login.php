<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 aligncenter">
                <h1 style="margin-top: 40px; text-align: center;"><?php echo lang('login_heading');?></h1>
                <p style="margin-top: 10px; margin-bottom: 20px; text-align: center;"><?php echo lang('login_subheading');?></p>

                <div id="infoMessage"><?php echo $message;?></div>

                <?php echo form_open("auth/login");?>
                <fieldset>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-12">
                            <?php echo form_input($identity);?>
                            </div>
                        </div>
                    </div>
                    <div class="row"><p></p></div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-12">
                            <?php echo form_input($password);?>
                            </div>
                        </div>
                    </div>

                        <div class="checkbox-inline">
                                <label><?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> Remember me</label> | <a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
                            </div> 


                        <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" style="margin-top: 30px;">
                            <div class="form-group">
                                <?php echo form_submit('submit', lang('login_submit_btn'), "class='btn btn-block btn-primary'");?>
                            </div>
                        </div>
                </fieldset>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
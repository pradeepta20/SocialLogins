
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <!--<i class="ace-icon fa fa-leaf green"></i>-->
                            <a style="text-decoration: none;" href="<?php echo HTTP_ROOT; ?>">
                            <span class="red">SMA</span>
                            <span class="white" id="id-text2">Application</span>
                            </a>
                        </h1>
                        <!--<h4 class="blue" id="id-company-text">&copy; Company Name</h4>-->
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="ace-icon fa fa-coffee green"></i>
                                        Please Enter New Password
                                    </h4>

                                    <div class="space-6"></div>

                                    <?php echo $this->Form->create("User", array('data-toggle' => "validator")) ?>
                                    <fieldset>                                    

                                        <div class="form-group has-feedback">
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input('password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'New password', 'id' => 'password1', 'class' => 'form-control', 'data-error' => "Enter your password", 'required' => 'required']) ?>
                                                <i class="ace-icon fa fa-lock"></i>
                                            </span>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input('confirm_password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'Retype new password', 'id' => 'retype-password', 'data-error' => "Retype your password", 'data-match' => "#password1", 'data-match-error' => "Whoops, these don't match", 'class' => 'form-control', 'required' => 'required']) ?>
                                                <div class="help-block with-errors"></div>
                                                <i class="ace-icon fa fa-retweet"></i>
                                            </span>
                                        </div>

                                        <div class="space"></div>
                                        <button class="width-55 pull-right btn btn-sm btn-primary" type="submit">                                            
                                            <span class="bigger-110">Reset Password</span>
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </button>
                                        <div class="space-4"></div>
                                    </fieldset>                                    
                                    <?php echo $this->Form->end(); ?>

                                    <!--                                    <div class="social-or-login center">
                                                                            <span class="bigger-110">Or Login Using</span>
                                                                        </div>-->

                                    <div class="space-6"></div>

                                    <!--                                    <div class="social-login center">
                                                                            <a  onclick="window.open('<?php echo HTTP_ROOT . 'fblogin'; ?>', '_blank');" class="btn btn-primary">
                                                                                <i class="ace-icon fa fa-facebook"></i>
                                                                            </a>
                                    
                                                                            <a class="btn btn-info" onclick="window.open('<?php echo HTTP_ROOT . 'twitters/twitterlogin'; ?>', '_blank');">
                                                                                <i class="ace-icon fa fa-twitter"></i>
                                                                            </a>
                                    
                                                                            <a class="btn btn-danger" onclick="window.open('<?php echo HTTP_ROOT . 'googlelogin'; ?>', '_blank');">
                                                                                <i class="ace-icon fa fa-google-plus"></i>
                                                                            </a>                                       
                                                                            <a class="btn btn-danger" onclick="window.open('https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=<?php echo CLIENT_ID; ?>&redirect_uri=<?php echo CALLBACK_URL; ?>&state=78l3ln36n7w41aqSmDINGn70wOm6zT&scope=r_basicprofile r_emailaddress', '_blank');">
                                                                                <i class="ace-icon fa fa-linkedin"></i>
                                                                            </a>
                                                                        </div>-->


                                </div><!-- /.widget-main -->


                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->





                    </div><!-- /.position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->



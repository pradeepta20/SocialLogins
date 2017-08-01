
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <!--<i class="ace-icon fa fa-leaf green"></i>-->
                            <a style="text-decoration: none;" href="#"
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
                                        Please Enter Your Information
                                    </h4>

                                    <div class="space-6"></div>

                                    <?php echo $this->Form->create("User", array('data-toggle' => "validator")) ?>
                                    <fieldset>

                                        <div class="form-group has-feedback"> 
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input('email', ['type' => 'email', 'label' => false, 'placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required']) ?>
                                                <i class="ace-icon fa fa-envelope"></i>
                                            </span>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input('password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'Password', 'class' => 'form-control', 'required' => 'required']) ?>
                                                <i class="ace-icon fa fa-lock"></i>
                                            </span>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="space"></div>
                                        <button class="width-35 pull-right btn btn-sm btn-primary" type="submit">
                                            <i class="ace-icon fa fa-key"></i>
                                            <span class="bigger-110">Login</span>
                                        </button>												
                                        <div class="clearfix">
                                            <label class="inline">
                                                <input type="checkbox" name="remberme" value="rember" class="ace" />
                                                <span class="lbl"> Remember Me</span>
                                            </label> 
                                        </div>

                                        <div class="space-4"></div>
                                    </fieldset>                                    
                                    <?php echo $this->Form->end(); ?>
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

                                <div class="toolbar clearfix">
                                    <div>
                                        <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                            <i class="ace-icon fa fa-arrow-left"></i>
                                            I forgot my password
                                        </a>
                                    </div>

                                    <div>
                                        <a href="#" data-target="#signup-box" class="user-signup-link">
                                            I want to register
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->


                        <div id="forgot-box" class="forgot-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="forgot-message"></div>
                                    <h4 class="header red lighter bigger">
                                        <i class="ace-icon fa fa-key"></i>
                                        Retrieve Password
                                    </h4>

                                    <div class="space-6"></div>
                                    <p>
                                        Enter your email and to receive instructions
                                    </p>

                                    <?php echo $this->Form->create("User", array('data-toggle' => "validator", 'id' => "forgot_assword", 'onsubmit' => "return forgotPassword()")) ?>
                                    <fieldset>

                                        <div class="form-group has-feedback">  
                                            <span class="block input-icon input-icon-right">
                                                <?= $this->Form->input('email', ['type' => 'email', 'label' => false, 'placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required']) ?>
                                                <i class="ace-icon fa fa-envelope"></i>
                                            </span>
                                            <div class="help-block with-errors"></div>
                                        </div>                                        
                                        <button class="width-35 pull-right btn btn-sm btn-danger" type="submit">
                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                            <span class="bigger-110">Send Me!</span>
                                        </button>
                                    </fieldset>
                                    <?php echo $this->Form->end() ?>
                                </div><!-- /.widget-main -->

                                <div class="toolbar center">
                                    <a href="#" data-target="#login-box" class="back-to-login-link">
                                        Back to login
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /.widget-body -->
                        </div><!-- /.forgot-box -->

                        <div id="signup-box" class="signup-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="register-status-message"></div>
                                    <h4 class="header green lighter bigger">
                                        <i class="ace-icon fa fa-users blue"></i>
                                        New User Registration
                                    </h4>

                                    <div class="space-6"></div>
                                    <p> Enter your details to begin: </p>

                                    <?php echo $this->Form->create("User", array('data-toggle' => "validator", 'id' => "registerForm", 'onsubmit' => "return registerUser()")) ?>
                                    <fieldset>
                                        <div class="col2-box">
                                            <div class="form-group">  
                                                <span class="block input-icon input-icon-right">
                                                    <?php echo $this->Form->input('name', array('class' => "form-control", 'placeholder' => "Name", 'label' => false, 'div' => false, 'id' => "name", 'data-error' => "Enter your  name", 'required' => "required")); ?>
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <span class="block input-icon input-icon-right">
                                                <?php echo $this->Form->input('email', array('type' => "email", 'placeholder' => "Email", 'class' => "form-control", 'label' => false, 'id' => "email", 'required' => "required", 'onblur' => 'checkEmailAvail(this.value)')); ?>
                                                <i class="ace-icon fa fa-envelope"></i>
                                            </span>
                                            <div class="help-block with-errors"></div>
                                            <span style="font-size: 12px;font-weight: normal;color:#f84b4b" id="email_validation_msg"></span>
                                            <div id="eloader" style="position: absolute; margin-top: -12.5%; margin-left: 250px;"></div>
                                        </div>



                                        <div class="col2-box">
                                            <div class="form-group">   
                                                <span class="block input-icon input-icon-right">
                                                    <?php echo $this->Form->input('password', array('class' => "form-control", 'placeholder' => "Password", 'label' => false, 'div' => false, 'id' => "password1", 'data-error' => "Enter your password", 'required' => "required")); ?>
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>



                                        <div class="col2-box">
                                            <div class="form-group">     
                                                <span class="block input-icon input-icon-right">                                           
                                                    <?php echo $this->Form->input('confirm_password', array('type' => 'password', 'class' => "form-control", 'placeholder' => "Retype Password", 'label' => false, 'div' => false, 'data-error' => "Retype your password", 'data-match' => "#password1", 'data-match-error' => "Whoops, these don't match", 'required' => "required")); ?>
                                                    <i class="ace-icon fa fa-retweet"></i>
                                                </span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>


                                        <div class="space-24"></div>

                                        <div class="clearfix">
                                            <button type="reset" class="width-30 pull-left btn btn-sm">
                                                <i class="ace-icon fa fa-refresh"></i>
                                                <span class="bigger-110">Reset</span>
                                            </button>
                                            <button class="width-65 pull-right btn btn-sm btn-success" type="submit">
                                                <span class="bigger-110">Register</span>                                                
                                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                            </button>
                                        </div>
                                    </fieldset>
                                    <?php echo $this->Form->end() ?>
                                </div>

                                <div class="toolbar center">
                                    <a href="#" data-target="#login-box" class="back-to-login-link">
                                        <i class="ace-icon fa fa-arrow-left"></i>
                                        Back to login
                                    </a>
                                </div>
                            </div><!-- /.widget-body -->
                        </div>
                    </div><!-- /.position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->

<script>
    function registerUser() {
        var url = $("#pageurl").val();
        var formData = $("#registerForm").serialize();
        $.ajax({
            type: "POST",
            data: formData,
            dataType: 'json',
            url: url + 'users/ajaxRegister',
            success: function (response) {
                if (response.status == 'success') {
                    $("#register-status-message").html("<p style='top:8px;'>Registered Successfully.Redirecting...</p>").css({'color': 'green'}).show().delay(40000).fadeOut();
                    $('#registerForm')[0].reset();
                    setTimeout(function () {
                        window.location = response.url;
                    }, 3000);
                }
            }
        });
        return false;
    }

</script>
<script>
    function forgotPassword() {
        var url = $("#pageurl").val();
        var formData = $("#forgot_assword").serialize();
        $.ajax({
            type: "POST",
            data: formData,
            dataType: 'json',
            url: url + 'users/ajaxforgotPassword',
            success: function (response) {
                if (response.status == 'success') {
                    $("#forgot-message").html("<p style='top:8px;'>Password Reset Email send Successfully.</p>").css({'color': 'green'}).show().delay(2000).fadeOut();
                    $('#forgot_assword')[0].reset();
                    setTimeout(function () {
                        window.location = url;
                    }, 3000);
                }
            }
        });
        return false;
    }

</script>

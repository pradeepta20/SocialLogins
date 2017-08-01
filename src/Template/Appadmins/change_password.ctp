<div class="page-content">

    <div class="page-header">
        <h1>          
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Change Password
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <?php echo $this->Form->create("User", array('data-toggle' => "validator", 'class' => 'form-horizontal')) ?> 

            <div class="form-group has-feedback">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Current Password</label>
                <div class="col-sm-9">
                    <?= $this->Form->input('current_password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'Current password', 'id' => 'current_password', 'class' => 'col-xs-10 col-sm-5', 'data-error' => "Enter current password ", 'required' => 'required']) ?>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> New Password</label>
                <div class="col-sm-9">
                    <?= $this->Form->input('password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'New password', 'id' => 'new_password', 'class' => 'col-xs-10 col-sm-5', 'data-error' => "Enter new password ", 'required' => 'required']) ?>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Retype New Password</label>
                <div class="col-sm-9">
                    <?= $this->Form->input('retype_password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'Retype New password', 'id' => 'retype_password', 'class' => 'col-xs-10 col-sm-5', 'data-error' => "Retype new password ", 'data-match' => "#new_password", 'data-match-error' => "Whoops, these don't match", 'required' => 'required']) ?>
                    <div class="help-block with-errors"></div>
                </div>
            </div>




            <div class="space-4"></div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" value="Change Password" name="changepassword" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Change Password
                    </button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
            <?php echo $this->Form->end() ?>

        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
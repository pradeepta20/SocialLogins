<?php echo $this->Html->script(array('ckeditor/ckeditor')); ?> 

<div class="page-content">
    <div class="page-header">
        <h1>        
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Edit Email Setting
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <?php echo $this->Form->create("User", array('data-toggle' => "validator", 'class' => 'form-horizontal')) ?> 

            <div class="form-group has-feedback">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Name</label>
                <div class="col-sm-9">
                    <?= $this->Form->input('name', ['label' => false, 'escape' => false, 'placeholder' => 'Name', 'id' => 'name', 'class' => 'col-xs-10 col-sm-5', 'data-error' => "Enter your name", 'required' => 'required', 'value' => $settings->name]) ?>
                    <?= $this->Form->input('id', [ 'type' => 'hidden', 'value' => $settings->id]) ?>
                    <div class="help-block with-errors"></div>
                </div>
            </div>


            <div class="form-group has-feedback">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Value</label>
                <div class="col-sm-9">
                    <?= $this->Form->input('value', ['type' => 'textarea', 'label' => false, 'id' => 'email', 'class' => 'col-xs-10 col-sm-5 ckeditor', 'data-error' => "Enter your email", 'required' => 'required', 'value' => $settings->value]) ?>
                    <div class="help-block with-errors"></div>                   

                </div>
            </div>


            <div class="space-4"></div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Update
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
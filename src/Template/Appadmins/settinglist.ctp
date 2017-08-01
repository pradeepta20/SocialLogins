<div class="page-content">
    <div class="page-header">
        <h1>
            System Setup
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Email Listing
            </small>
        </h1>
    </div><!-- /.page-header -->
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div>
        <div class="row">

        </div> 
        <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">                  
            <?php if ($settings->count() > 0) { ?>
                <table class="table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable" id="dynamic-table" role="grid" aria-describedby="dynamic-table_info">
                    <thead>
                        <tr>                                    
                            <th>Name</th>                    

                            <th class="hidden-480" style="text-align: center;">Action</th> 
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($settings as $setting) { ?>
                            <tr>
                                <td><?php echo $setting->name; ?></td>

                                <td style="text-align: center">                                
                                    <a href="<?php echo HTTP_ROOT . 'appadmins/editsetting/' . $setting->id; ?>"> <?= $this->Form->button('<i class="ace-icon fa fa-pencil bigger-120"></i>', ['class' => "btn btn-xs btn-info"]) ?> </a>
                                </td>

                            </tr>

                        <?php } ?>


                    </tbody>
                </table>
            <?php } else { ?>

                <p style="color: red;text-align: center;">No data found...</p>
            <?php } ?>

        </div>
    </div>
</div>
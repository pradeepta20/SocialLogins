<?php
$paramNamed = $this->request->query;
$name = !empty($paramNamed['name']) ? $paramNamed['name'] : '';
$from = !empty($paramNamed['from']) ? $paramNamed['from'] : '';
$to = !empty($paramNamed['to']) ? $paramNamed['to'] : '';
?>
<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<?php echo $this->Html->script(array('jquery.autocomplete')); ?>
<link href="<?php echo HTTP_ROOT; ?>css/jquery.autocomplete.css" rel="stylesheet" />
<script type="text/javascript">
    $(document).ready(function () {
        var URL = '<?php echo HTTP_ROOT; ?>';
        $("#loader").show();
        $('#name').autocomplete(URL + "appadmins/searchUser");

        $('#name').result(function (event, data, formatted) {
            $("#loader").hide();
            $('#name').val(data);
        });
    });
</script>



<div class="page-content">
    <div class="page-header">
        <h1>
            Manage User
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                User Listing
            </small>
        </h1>
    </div><!-- /.page-header -->
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div>
        <div class="row">
            <div class="col-xs-8 col-sm-11" style="width: 66.66%;margin-left: 160px;margin-bottom: 15px;">
                <form method="Filter" class="form-inline filter-form">
                    <div class="input-group">
                        <?php echo $this->Form->input('name', array('autocomplete' => 'off', 'div' => false, 'id' => 'name', 'label' => false, 'placeholder' => "Name", 'class' => "form-control", 'value' => $name)); ?>

                    </div>
                    <div class="input-group">
                        <?php echo $this->Form->input('from', array('div' => false, 'id' => 'from', 'data-date-format' => "yyyy-mm-dd", 'label' => false, 'placeholder' => "From", 'class' => "form-control date-picker", 'value' => $from)); ?>
                        <span class="input-group-addon">
                            <i class="fa fa-calendar bigger-110"></i>
                        </span>
                    </div>
                    <div class="input-group" style="margin-right: 0;">
                        <?php echo $this->Form->input('to', array('div' => false, 'id' => 'from', 'data-date-format' => "yyyy-mm-dd", 'label' => false, 'placeholder' => "To", 'class' => "form-control date-picker", 'value' => $to)); ?>
                        <span class="input-group-addon">
                            <i class="fa fa-calendar bigger-110"></i>
                        </span>
                    </div>

                    <span class="input-group-btn">
                        <button class="btn btn-purple btn-sm" type="submit" style="margin-left: 10px;">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                            Search
                        </button>
                        <?php if (count($this->request->query)) { ?>
                            <a href="<?php echo HTTP_ROOT; ?>appadmins/user_listing">
                                <button class="btn btn-default btn-sm" type="button" style="margin-left: 10px;">
                                    <span class="ace-icon fa fa-undo icon-on-right bigger-110"></span>
                                    Reset
                                </button>
                            </a>
                        <?php } ?>
                    </span>
                </form>                 

            </div>
        </div> 
        <div>
            <a href="<?php echo HTTP_ROOT . 'appadmins/twitter_listing'; ?>"><img style="padding-bottom: 8px;" src="<?php echo HTTP_ROOT; ?>img/twitter.png"></a>
            <!--<a href="<?php echo HTTP_ROOT . 'appadmins/instagram_listing'; ?>"><img style="padding-bottom: 8px;padding-left: 5px;" src="<?php echo HTTP_ROOT; ?>img/instagram.png"></a>-->
            <a href="<?php echo HTTP_ROOT . 'appadmins/facebook_listing'; ?>"><img style="padding-bottom: 8px;padding-left: 5px;" src="<?php echo HTTP_ROOT; ?>img/facebook-button.png"></a>
            <a href="<?php echo HTTP_ROOT . 'appadmins/googleplus_listing'; ?>"><img style="padding-bottom: 8px;padding-left: 5px;" src="<?php echo HTTP_ROOT; ?>img/googleplus-button.png"></a>
        </div>


        <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">                  
            <?php if ($userListings->count() > 0) { ?>
                <table class="table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable" id="dynamic-table" role="grid" aria-describedby="dynamic-table_info">
                    <thead>
                        <tr>                                    
                            <th>Name</th>
                            <th>Email</th>
                            <th class="hidden-480" style="text-align: center;">
                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                Last login
                            </th>
                            <th class="hidden-480"> Last login IP</th>
                            <th style="text-align: center;">
                                <i class="ace-icon fa fa-calendar-o  bigger-110 hidden-480"></i>
                                Created
                            </th>

                            <th class="hidden-480" style="text-align: center;">Status</th> 
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($userListings as $userListing) { ?>
                            <tr>
                                <td><?php echo $userListing->name; ?></td>
                                <td><?php echo $userListing->email; ?></td>
                                <td class="hidden-480" style="text-align: center;"><?php echo $this->Custom->dateDisplayTime($userListing->last_login_date); ?></td>
                                <td><?php echo $userListing->last_login_ip; ?></td>
                                <td style="text-align: center;"><?php echo $this->Custom->dateDisplayTime($userListing->created); ?></td>
                                <td style="text-align: center">
                                    <?php if ($userListing->is_active == 1) { ?>                                             
                                        <a href="<?php echo HTTP_ROOT . 'appadmins/deactive/' . $userListing->id . '/Users'; ?>"> <?= $this->Form->button('<i class="ace-icon fa fa-check bigger-120"></i>', ['class' => "btn btn-xs btn-success"]) ?> </a>
                                    <?php } else { ?>
                                        <a href="<?php echo HTTP_ROOT . 'appadmins/active/' . $userListing->id . '/Users'; ?>"><?= $this->Form->button('<i class="ace-icon fa fa-times bigger-120"></i>', ['class' => "btn btn-xs btn-danger"]) ?></a>
                                    <?php } ?>
                                    <a  data-toggle="tooltip" data-placement="top" title="Hooray!" onclick="return confirm('Are you sure want to delete?')" href="<?php echo HTTP_ROOT . 'appadmins/delete/' . $userListing->id . '/Users'; ?>"> <?= $this->Form->button('<i class="ace-icon fa fa-trash-o bigger-120"></i>', ['class' => "btn btn-xs btn-danger", 'confirm' => 'Are you sure you want to delete the user?']) ?> </a>
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
<style>
    .input-group{
        float: left;
        margin-right: 10px;
    }
    .input-group-btn{
        float: left;
    }

    .ac_results{
        width: 190px !important;
    }
</style>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
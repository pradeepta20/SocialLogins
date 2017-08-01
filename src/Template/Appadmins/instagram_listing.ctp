<?php
$paramNamed = $this->request->query;
$username = !empty($paramNamed['username']) ? $paramNamed['username'] : '';
?>
<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<?php echo $this->Html->script(array('jquery.autocomplete')); ?>
<link href="<?php echo HTTP_ROOT; ?>css/jquery.autocomplete.css" rel="stylesheet" />
<script type="text/javascript">
    $(document).ready(function () {
        var URL = '<?php echo HTTP_ROOT; ?>';
        $('#name').autocomplete(URL + "appadmins/searchInstagramName");

        $('#name').result(function (event, data, formatted) {
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
                Instagram Listing
            </small>
        </h1>
        <ul class="nav nav-pills" style="float: right;position: relative;bottom: 22px;">
            <li class="active">
                <a style="padding: 5px 15px;" href="<?php echo HTTP_ROOT . 'appadmins/user_listing'; ?>">User Listing</a>
            </li>
        </ul>
    </div><!-- /.page-header -->
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div>
        <div class="row">
            <div class="col-xs-8 col-sm-11" style="width: 50%;margin-left: 280px;">
                <div class="widget-main">
                    <form method="Filter" class="form-search">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8">
                                <div class="input-group">	
                                    <?php echo $this->Form->input('username', array('autocomplete' => 'off', 'div' => false, 'id' => 'name', 'style' => 'width:250px;', 'label' => false, 'placeholder' => "Name", 'class' => "form-control search-query", 'value' => $username)); ?>
                                    <span class="input-group-btn">
                                        <button class="btn btn-purple btn-sm" type="submit" style="margin-left: 10px;">
                                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                            Search
                                        </button>
                                        <?php if (count($this->request->query)) { ?>
                                            <a href="<?php echo HTTP_ROOT; ?>appadmins/instagram_listing">
                                                <button class="btn btn-default btn-sm" type="button" style="margin-left: 10px;">
                                                    <span class="ace-icon fa fa-undo icon-on-right bigger-110"></span>
                                                    Reset
                                                </button>
                                            </a>
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
        <?php if (!empty($instagramListings->count() > 0)) { ?>
            <div style="float: right; margin-top: -40px;">
                <a download='' href="<?php echo HTTP_ROOT . 'appadmins/instagram_report'; ?>"><img src="<?php echo HTTP_ROOT; ?>img/expt.png"></a>
            </div>
        <?php } ?>
        <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">                  
            <?php if ($instagramListings->count() > 0) { ?>
                <table class="table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable" id="dynamic-table" role="grid" aria-describedby="dynamic-table_info">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Bio</th>
                            <th>website</th>
                            <th>Profile Image</th>                            
                            <th class="hidden-480" style="text-align: center;">
                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                Last login
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($instagramListings as $instagramListing) { ?>
                            <tr>
                                <td><?php echo $instagramListing->username; ?></td>
                                <td><?php echo $instagramListing->full_name; ?></td>
                                <td><?php echo $instagramListing->bio; ?></td>
                                <td><?php echo $instagramListing->website; ?></td>                                
                                <td><img style="width: 50px;height: 50px;" src="<?php echo ($instagramListing->profile_image) ? HTTP_ROOT . DIR_INSTAGRAM_IMAGE . $instagramListing->profile_image : HTTP_ROOT . 'img/no-image.jpg'; ?>"></td>
                                <td class="hidden-480" style="text-align: center;"><?php echo $this->Custom->dateDisplayTime($instagramListing->last_login); ?></td>                               
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

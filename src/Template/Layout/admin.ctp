<!DOCTYPE html>
<html>   
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>SMA Admin</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />       
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>fonts/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/datepicker.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.2.1.1.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/validator.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/ace-extra.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/common.js"></script>
    </head>
    <body class="no-skin">
        <?php echo $this->element('admin_header'); ?>
        <?php echo $this->element('admin_sidebar'); ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?> 

        <?php echo $this->element('admin_footer'); ?>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>             

        </div>

        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo HTTP_ROOT; ?>js/jquery.min.js'>" + "<" + "/script>");
        </script>
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='<?php echo HTTP_ROOT; ?>js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="<?php echo HTTP_ROOT; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery-ui.custom.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.dataTables.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.dataTables.bootstrap.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/dataTables.colVis.min.js"></script>

        <script src="<?php echo HTTP_ROOT; ?>js/jquery.easypiechart.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.sparkline.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.flot.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.flot.pie.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.flot.resize.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/ace-elements.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/ace.min.js"></script>

        <script type="text/javascript">
            jQuery(function ($) {

                //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
                //but sometimes it brings up errors with normal resize event handlers
                $.resize.throttleWindow = false;

                var placeholder = $('#piechart-placeholder').css({'width': '90%', 'min-height': '150px'});
                var data = [
                    {label: "social networks", data: 38.7, color: "#68BC31"},
                    {label: "search engines", data: 24.5, color: "#2091CF"},
                    {label: "ad campaigns", data: 8.2, color: "#AF4E96"},
                    {label: "direct traffic", data: 18.6, color: "#DA5430"},
                    {label: "other", data: 10, color: "#FEE074"}
                ]
                //pie chart tooltip example
                var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
                var previousPoint = null;

                placeholder.on('plothover', function (event, pos, item) {
                    if (item) {
                        if (previousPoint != item.seriesIndex) {
                            previousPoint = item.seriesIndex;
                            var tip = item.series['label'] + " : " + item.series['percent'] + '%';
                            $tooltip.show().children(0).text(tip);
                        }
                        $tooltip.css({top: pos.pageY + 10, left: pos.pageX + 10});
                    } else {
                        $tooltip.hide();
                        previousPoint = null;
                    }

                });


                var oTable1 =
                        $('#dynamic-table')
                        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                        .dataTable({
                            bAutoWidth: false,
//                            "aoColumns": [
//                                {"bSortable": false},
//                                null, null, null,
//                                {"bSortable": false}
//                            ],
                            "aaSorting": [],
                            //,
                            //"sScrollY": "200px",
                            //"bPaginate": false,

                            //"sScrollX": "100%",
                            //"sScrollXInner": "120%",
                            //"bScrollCollapse": true,
                            //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
                            //you may want to wrap the table inside a "div.dataTables_borderWrap" element

                            //"iDisplayLength": 50
                        });

                //TableTools settings

                /////////////////////////////////////
                $(document).one('ajaxloadstart.page', function (e) {
                    $tooltip.remove();
                });
                $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('.tab-content')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();

                    var off2 = $source.offset();
                    //var w2 = $source.width();

                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                        return 'right';
                    return 'left';
                }

                $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true
                })
                        //show datepicker when clicking on the icon
                        .next().on(ace.click_event, function () {
                    $(this).prev().focus();
                });


                $('.dialogs,.comments').ace_scroll({
                    size: 300
                });


                //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
                //so disable dragging when clicking on label
                var agent = navigator.userAgent.toLowerCase();
                if ("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
                    $('#tasks').on('touchstart', function (e) {
                        var li = $(e.target).closest('#tasks li');
                        if (li.length == 0)
                            return;
                        var label = li.find('label.inline').get(0);
                        if (label == e.target || $.contains(label, e.target))
                            e.stopImmediatePropagation();
                    });

                $('#tasks').sortable({
                    opacity: 0.8,
                    revert: true,
                    forceHelperSize: true,
                    placeholder: 'draggable-placeholder',
                    forcePlaceholderSize: true,
                    tolerance: 'pointer',
                    stop: function (event, ui) {
                        //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                        $(ui.item).css('z-index', 'auto');
                    }
                }
                );
                $('#tasks').disableSelection();
                $('#tasks input:checkbox').removeAttr('checked').on('click', function () {
                    if (this.checked)
                        $(this).closest('li').addClass('selected');
                    else
                        $(this).closest('li').removeClass('selected');
                });


                //show the dropdowns on top or bottom depending on window height and menu position
                $('#task-tab .dropdown-hover').on('mouseenter', function (e) {
                    var offset = $(this).offset();

                    var $w = $(window)
                    if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
                        $(this).addClass('dropup');
                    else
                        $(this).removeClass('dropup');
                });

            })
        </script>

        <input type="hidden" id="pageurl" value="<?php echo HTTP_ROOT; ?>"/>

    </body>
</html>

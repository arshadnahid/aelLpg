<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/16/2019
 * Time: 9:46 AM
 */?>


<script src="//code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jQueryUI/jquery-new-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/q_jquery.mCustomScrollbar.min.css">
<script src="<?php echo base_url(); ?>assets/js/q_jquery.mCustomScrollbar.concat.min.js"></script>

<style type="text/css">
    .ui-autocomplete {
        max-height: 250px!important;
        max-width: 300px!important;
        overflow: auto!important;
        height: auto!important;
        margin-left: -38px!important;
    }
    .ui-autocomplete .ui-menu-item {
        font-size: 14px!important;
        background: #fff;
        border-bottom: 1px solid rgba(128, 128, 128, 0.20);
        border-top: none!important;
        border-left: none!important;
        border-right: none!important;
        height: 30px!important;
        line-height: 30px!important;
        color: gray;
        padding-bottom: 15px!important;
        margin: 0px!important;
        font-weight: normal!important;
    }
</style>

<?php
if (isset($_POST['start_date'])):
    $cusType = $this->input->post('cusType');
    $customer_id = $this->input->post('customer_id');
    $from_date = $this->input->post('start_date');
    $to_date = $this->input->post('end_date');
endif;
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state  noPrint" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/2'); ?>">Sales</a>
                </li>
                <li class="active">Daily Sales Statement</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a href="<?php echo site_url('DistributorDashboard/2'); ?>">
                        <i class="ace-icon fa fa-list"></i>
                        List
                    </a>
                </li>
            </ul>
        </div>
        <br>
        <div class="page-content">
            <div class="row  noPrint">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="get" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="table-header">
                                Daily Sales Statement
                            </div>
                            <br>


                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label no-padding-right" for="form-field-1"> Customer </label>
                                        <div class="col-md-8">
                                            <input type="hidden" name="customer_id" id="customer_id" />
                                            <input type="text" name="customer_id_autocomplete" id="customer_id_autocomplete" class="form-control"/>
                                        </div>
                                    </div>
                                </div><div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label no-padding-right" for="form-field-1"> From </label>
                                        <div class="col-md-8">
                                            <input type="text"class="date-picker" id="start_date" name="start_date" value="<?php
                                            if (!empty($from_date)) {
                                                echo $from_date;
                                            } else {
                                                echo date('d-m-Y');
                                            }
                                            ?>" data-date-format='dd-mm-yyyy' placeholder=" dd-mm-yyyy" style="width:100%"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label no-padding-right" for="form-field-1">&nbsp;&nbsp;To</label>
                                        <div class="col-md-8">
                                            <input type="text" class="date-picker" id="end_date" name="end_date" value="<?php
                                            if (!empty($to_date)):
                                                echo $to_date;
                                            else:
                                                echo date('d-m-Y');
                                            endif;
                                            ?>" data-date-format='dd-mm-yyyy' placeholder="End Date: dd-mm-yyyy" style="width:100%"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-6">
                                        <button type="submit"  class="btn btn-success btn-sm">
                                            Search
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-info btn-sm"  onclick="window.print();" style="cursor:pointer;">

                                            Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.col -->
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>



                        <tr>

                            <th class="text-center">Sales Date</th>
                            <th class="text-center">Total Sales</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Customer Due</th>
                            <th class="text-center">Customer Due Rec.</th>
                            <th class="text-center">Net Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($daily_sales_statement as $ind => $element2) {
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $element2->invoice_date ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $element2->sales_amount ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $element2->customer_paid_amount ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $element2->discount_amount ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $element2->invoice_date ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $element2=$element2->sales_amount-$customer_paid_amount-$element2->discount_amount-$discount_amount+$element2->customer_paid_amount-$customer_paid_amount ?>
                                </td>

                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    var customer_info =<?php echo $customer_info; ?>;
    console.log(customer_info);



    $("#customer_id_autocomplete").autocomplete({

        source: function (request, response) {
            var term = $.ui.autocomplete.escapeRegex(request.term)
                , startsWithMatcher = new RegExp("^" + term, "i")
                , startsWith = $.grep(customer_info, function (value) {
                return startsWithMatcher.test(value.label || value.value || value);
            })
                , containsMatcher = new RegExp(term, "i")
                , contains = $.grep(customer_info, function (value) {
                return $.inArray(value, startsWith) < 0 &&
                    containsMatcher.test(value.label || value.value || value);
            });

            response(startsWith.concat(contains));
        },
        minLength: 0,
        select: function (event, ui) {
            var item_id = ui.item.value;
            $("#customer_id").val(item_id);
            $('#customer_id').trigger('change');
            $(this).val(ui.item.label);


            //create formatted friend
            //var friend = ui.item.label,
            //    span = $("<span>").text(friend),
            //    a = $("<a>").addClass("remove").attr({
            //        href: "javascript:",
            //        title: "Remove " + friend
             //   }).text("x").appendTo(span);

            //add friend to friend div
           // span.insertBefore("#customer_id_autocomplete");


            return false;
        },
        focus: function (event, ui) {
            //this is to prevent showing an ID in the textbox instead of name
            //when the user tries to select using the up/down arrow of his keyboard
            //$("#customer_id_autocomplete").val(ui.item.label);
            $("#customer_id").val(ui.item.label);
            return false;
        },
        close: function (e, ui) {
            // $(this).autocomplete('search', '');
            /* destroy the scrollbar each time autocomplete menu closes */
            //$(".ui-autocomplete").mCustomScrollbar("destroy");
        }

    }).click(function () {

        //show_hide_add_button();
        $(this).autocomplete('search', '');
    });

    $.ui.autocomplete.prototype._renderItem = function (ul, item) {
        var term = this.term.split(' ').join('|');
        var re = new RegExp("(" + term + ")", "gi");
        var t = item.label.replace(re, "<b style='color:red'>$1</b>");
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a>" + t + "</a>")
            .appendTo(ul);
    };



</script>



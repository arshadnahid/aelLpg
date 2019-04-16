<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/8/2019
 * Time: 10:11 AM
 */?>

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
                <li class="active">Cylinder Sales Report</li>
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
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="col-sm-12">
                            <div class="table-header">
                                Customer Wise Sales Report
                            </div><br>
                            <div style="background-color: grey!important;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Type</label>
                                        <div class="col-sm-8">
                                            <select onchange="showTypeWiseCusList(this.value)" name="cusType"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Select Type">

                                                <option value="all">All</option>
                                                <?php foreach ($customerType as $key => $each_type): ?>
                                                    <option <?php
                                                    if (!empty($cusType) && $cusType == $each_type->type_id): echo "selected";
                                                    endif;
                                                    ?> value="<?php echo $each_type->type_id; ?>"><?php echo $each_type->typeTitle; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div id="newValue"></div>
                                    <div id="oldValue">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer</label>
                                            <div class="col-sm-9">
                                                <select  id="customerTypeList" name="customer_id"  class="chosen-select form-control" data-placeholder="Search by Customer">
                                                    <option value="all">All</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label no-padding-right" for="form-field-1"> From Date</label>
                                        <div class="col-sm-7">
                                            <input type="text"class="date-picker" id="start_date" name="start_date" value="<?php
                                            if (!empty($from_date)) {
                                                echo $from_date;
                                            } else {
                                                echo date('Y-m-d');
                                            }
                                            ?>" data-date-format='yyyy-mm-dd' placeholder="Start Date: yyyy-mm-dd" style="width:100%"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> To Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="date-picker" id="end_date" name="end_date" value="<?php
                                            if (!empty($to_date)):
                                                echo $to_date;
                                            else:
                                                echo date('Y-m-d');
                                            endif;
                                            ?>" data-date-format='yyyy-mm-dd' placeholder="End Date: yyyy-mm-dd" style="width:100%"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                            Search
                                        </button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-info btn-sm"  onclick="window.print();" style="cursor:pointer;">
                                            <i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
                                            Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div><!-- /.col -->
        <div class="page-content">
            <?php
            if (isset($_POST['start_date'])):
                $customer_id = $this->input->post('customer_id');


                if (!empty($salesList)):


                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-xs-12">
                                <div class="table-header">
                                    Customer Sales Report Period <span style="color:greenyellow;">From <?php echo $from_date; ?> To <?php echo $to_date; ?></span>
                                </div>
                                <table class="table table-responsive">
                                    <tr>
                                        <td style="text-align:center;">
                                            <h3><?php echo $companyInfo->companyName; ?></h3>
                                            <p><?php echo $companyInfo->dist_address; ?></p>
                                            <strong>Phone : </strong><?php echo $companyInfo->dist_phone; ?><br>
                                            <strong>Email : </strong><?php echo $companyInfo->dist_email; ?><br>
                                            <strong>Website : </strong><?php echo $companyInfo->dis_website; ?><br>
                                            <strong><?php echo $pageTitle; ?></strong>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <thead style="text-align:center">
                                    <tr>
                                        <td align="center" style="width: 10%;"><strong>Date</strong></td>
                                        <td align="center" style="width: 10%;"><strong>Invoice No.</strong></td>
                                        <td align="center" style="width: 12%;"><strong>Sold Product</strong></td>
                                        <td align="center" style="width: 26%;"><strong>Recive Product </strong></td>
                                        <td align="center"><strong>Quentity Recive</strong></td>
                                        <td align="center"><strong>Quentity Sold</strong></td>
                                        <td align="center"><strong>Rate</strong></td>
                                        <td align="center"><strong>Payment Type</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align:center">
                                    <?php
                                    $totalAmount = 0;
                                    $totalOpening = 0;
                                    foreach ($salesList as $key => $row):
                                        //echo'<pre>';print_r($row);

                                        ?>

                                        <tr>
                                            <td><?php echo date('M d, Y', strtotime($row['invoice_date'])); ?></td>
                                            <td><?php echo $row['invoice_no']; ?></td>
                                            <td colspan="3">
                                                <table class="table table-bordered" style="    margin-bottom: 0px !important;">
                                                    <?php
                                                    foreach($row['sales_producr'] as $key1 =>$value1){
                                                        ?>
                                                        <tr>
                                                            <td style="width: 21%;"><?php echo $value1['title'].' '.$value1['productName'] .' '.$value1['unitTtile'] .' ['.$value1['brandName'] .' ]'?></td>
                                                            <td>
                                                                <table class="table table-bordered" style="    margin-bottom: 0px !important;">
                                                                    <?php

                                                                    foreach ($value1['return'] as $key2 => $value2) {
                                                                        foreach ($value2 as $key3 => $value3) {
                                                                            ?>
                                                                            <tr>
                                                                                <?php
                                                                                if($value3['return_product_cat']=='') {?>
                                                                                    <td colspan="2"> </td>
                                                                               <?php }else{

                                                                                ?>
                                                                                <td style="width: 58%;"><?php echo $value3['return_product_cat'] . ' ' . $value3['return_product_name'] . ' ' . $value3['return_product_unit'] . ' [' . $value3['return_product_brand'] . ' ]' ?></td>
                                                                                <td><?php echo $value3['return_quantity'] ; ?></td>
                                                                                    <?php
                                                                                }
                                                                                    ?>
                                                                            </tr>


                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </td>



                                                        </tr>



                                                        <?php
                                                    }
                                                    ?>


                                                </table>



                                            </td>


                                            <td>
                                                <?php echo $value1['quantity']?>
                                            </td>
                                            <td>
                                                <?php echo $value1['unit_price']?>
                                            </td>

                                            <td><?php
                                                if ($row['payment_type'] == 1) {
                                                    echo "Cash";
                                                } elseif ($row['payment_type'] == 2) {
                                                    echo "Credit";
                                                } else if ($row['payment_type'] == 3) {
                                                    echo "Bank";
                                                } else {
                                                    echo "Cash";
                                                }
                                                ?></td>


                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- /Search Balance -->
                                    </tbody>
                                    <tfoot>
                                    <!-- <tr>
                                        <td colspan="4" align="right"><strong>Total Sales Amount</strong></td>
                                        <td align="right"><strong><?php echo number_format((float) abs($total_debit + $totalOpening), 2, '.', ','); ?>&nbsp;</strong></td>
                                    </tr>-->
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script>
    <?php if (!empty($cusType) && !empty($customer_id)): ?>
    var url = '<?php echo site_url("SalesController/getCustomerListByType") ?>';
    $.ajax({
        type: 'POST',
        url: url,
        data:{ 'type': '<?php echo $cusType; ?>','customer_id':'<?php echo $customer_id; ?>'},
        success: function (data)
        {
            $(".chosenRefesh").trigger("chosen:updated");
            $("#newValue").show();
            $("#oldValue").html(data);
            $("#oldValue").show();
            $('.chosenRefesh').chosen();
            $(".chosenRefesh").trigger("chosen:updated");
        }
    });

    <?php endif; ?>
    function showTypeWiseCusList(type){
        var url = '<?php echo site_url("SalesController/getCustomerListByType") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data:{ 'type': type},
            success: function (data)
            {
                $(".chosenRefesh").trigger("chosen:updated");
                $("#newValue").show();
                $("#oldValue").html(data);
                $("#oldValue").show();
                $('.chosenRefesh').chosen();
                $(".chosenRefesh").trigger("chosen:updated");
            }
        });
    }
</script>



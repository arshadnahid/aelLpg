<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/16/2019
 * Time: 9:46 AM
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




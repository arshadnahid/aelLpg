<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/11/2019
 * Time: 10:07 AM
 */
?>



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
                        <div class="col-md-12">
                            <div class="table-header">
                                Cylinder Combine Report
                            </div>
                            <br>
                            <div class="col-md-7">

                                <div class="col-md-2">

                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Brand</label>
                                        <div class="col-sm-8">
                                            <select  name="brandId" class="chosen-select form-control " id="form-field-select-3" data-placeholder="Search by Category">
                                                <option <?php
                                                if (!empty($brandId) && $brandId == '0') {
                                                    echo "selected";
                                                }
                                                ?> value="0">All</option>
                                                <?php foreach ($brandList as $eachInfo): ?>
                                                    <option <?php
                                                    if (!empty($brandId) && $brandId == $eachInfo->brandId) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $eachInfo->brandId; ?>"><?php echo $eachInfo->brandName; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
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
        <?php
        if (isset($_POST['start_date'])):?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-responsive">
                        <tr>
                            <td style="text-align:center;">
                                <h3><?php echo $companyInfo->companyName; ?></h3>
                                <p><?php echo $companyInfo->dist_address; ?></p>
                                <strong>Phone : </strong><?php echo $companyInfo->dist_phone; ?><br>
                                <strong>Email : </strong><?php echo $companyInfo->dist_email; ?><br>
                                <strong>Website : </strong><?php echo $companyInfo->dis_website; ?><br>
                                <strong><?php echo $pageTitle; ?></strong>
                                <strong>From <?php echo $from_date; ?> To <?php echo $to_date; ?></span></strong>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">Brand</th>
                            <?php
                            foreach ($product  as $ind => $element) {
                            ?>
                            <th  class="text-center" colspan="3"><?php echo $element .'Kg'?></th>
                            <?php }?>
                        </tr>
                        <tr>
                            <th></th>
                            <?php
                            foreach ($product  as $ind => $element) {
                            ?>
                            <th class="<?php echo 'package_'.$element?>">
                                Pack
                            </th>
                            <th class="<?php echo 'package_'.$element?>">
                                Ref
                            </th>
                            <th class="<?php echo 'package_'.$element?>">
                                Emp
                            </th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($sales_list  as $ind => $element2) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $element2['brand_name']?>
                                </td>
                                <?php
                                foreach ($product  as $ind => $element) {
                                   $package_th= ('package_'.$element)?'package_'.$element:'package_0';
                                   $refial_th= ('refial_'.$element)?'refial_'.$element:'refial_0';
                                   $empty_th= ('empty_'.$element)?'empty_'.$element:'empty_0';
                                    $packageValue= isset($element2[$element.'_package'])?$element2[$element.'_package']:'';
                                    $refialValue= isset($element2[$element.'_refial'])?$element2[$element.'_refial']:'';
                                    $emptyValue= isset($element2[$element.'_empty'])?$element2[$element.'_empty']:'';
                                    ?>
                                    <th class="<?php echo $package_th?>">
                                        <?php echo $packageValue;?>
                                    </th>
                                    <th class="<?php echo $refial_th?>">
                                        <?php echo $refialValue;?>
                                    </th>
                                    <th class="<?php echo $empty_th ?>">
                                        <?php echo $emptyValue;?>
                                    </th>
                                <?php }?>
                            </tr>
                        <?php }?>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div><!-- /.page-content -->
    <?php endif;?>
</div>



<style>
    table tr td{
        margin: 0px!important;
        padding: 2px!important;
    }

    table tr td  tfoot .form-control {
        width: 100%;
        height: 25px;
    }
</style>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/2'); ?>">Sales</a>
                </li>
                <li class="active">Sales Invoice Add</li>
                <li class="active"><span style="color:red;"> *</span> <span style="color: red">Mark field must be fill up</span></li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li class="active">
                    <i class="ace-icon fa fa-list"></i>
                    <a href="<?php echo site_url('salesInvoice'); ?>">List</a>
                </li>
            </ul>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <table class="mytable table-responsive table table-bordered">
                            <tr>
                                <td  style="padding: 10px!important;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1">Customer ID <span style="color:red;"> *</span></label>
                                            <div class="col-sm-6">
                                                <select  id="customerid" name="customer_id"  class="chosen-select form-control" onchange="getCustomerCurrentBalace(this.value)" id="form-field-select-3" data-placeholder="Search by Customer ID OR Name">
                                                    <option></option>
                                                    <?php foreach ($customerList as $key => $each_info): ?>
                                                        <option value="<?php echo $each_info->customer_id; ?>"><?php echo $each_info->typeTitle . ' - ' . $each_info->customerID . ' [ ' . $each_info->customerName . ' ] '; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-2" id="newCustomerHide">
                                                <a  data-toggle="modal" data-target="#myModal" class="saleAddPermission btn btn-xs btn-success"><i class="fa fa-plus"></i>&nbsp;New</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Invoice No</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="form-field-1" name="userInvoiceId" value="" class="form-control" placeholder="Invoice No"/>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" id="form-field-1" name="voucherid" readonly value="<?php echo $voucherID; ?>" class="form-control" placeholder="Invoice ID" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Reference</label>
                                            <div class="col-sm-6">
                                                <select  name="reference"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Reference ID OR Name">
                                                    <option></option>
                                                    <?php foreach ($referenceList as $key => $each_ref): ?>
                                                        <option value="<?php echo $each_ref->reference_id; ?>"><?php echo $each_ref->referenceName; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <!--                                    <input type="text" id="form-field-1" name="reference"  value="" class="form-control" placeholder="Reference" />
                                                                                    -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sales Date  <span style="color:red;"> *</span></label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input class="form-control date-picker" name="saleDate" id="saleDate" type="text" value="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Loader</label>
                                            <div class="col-sm-6">
                                                <select  name="loader"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Loader">
                                                    <option></option>
                                                    <?php foreach ($employeeList as $key => $eachEmp): ?>
                                                        <option value="<?php echo $eachEmp->id; ?>"><?php echo $eachEmp->personalMobile . ' [ ' . $eachEmp->name . ']'; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Transportation</label>
                                            <div class="col-sm-7">
                                                <select  name="transportation"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Transportation">
                                                    <option></option>
                                                    <?php foreach ($vehicleList as $key => $eachVehicle): ?>
                                                        <option value="<?php echo $eachVehicle->id; ?>"><?php echo $eachVehicle->vehicleName . ' [ ' . $eachVehicle->vehicleModel . ' ]'; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1">Payment Type  <span style="color:red;"> *</span></label>
                                            <div class="col-sm-6">
                                                <select onchange="showBankinfo(this.value)"  name="paymentType"  class="chosen-select form-control" id="paymentType" data-placeholder="Select Payment Type">
                                                    <option></option>
                                                    <!--<option value="1">Full Cash</option>-->
                                                    <option selected value="4">Cash</option>
                                                    <option value="2">Credit</option>
                                                    <option value="3">Cheque / DD/ PO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Shipping Address</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" placeholder="Shipping Address" name="shippingAddress" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div id="showBankInfo" style="display:none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-2">
                                                    <input type="text" value="" name="bankName" id="bankName" class="form-control" placeholder="Bank Name"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" value="" name="branchName" id="branchName" class="form-control" placeholder="Branch Name"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" value="" class="form-control" id="checkNo" name="checkNo" placeholder="Check NO"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input class="form-control date-picker" name="checkDate" name="purchasesDate" id="checkDate" type="text" value="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px!important;">

                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="table-header">
                                                        Sales Item
                                                    </div>


                                                    <table class="table table-bordered table-hover tableAddItem" id="show_item">
                                                        <thead>
                                                        <tr>


                                                            <th nowrap  align="center" id="product_th"><strong>Product <span style="color:red;"> *</span></strong></th>
                                                            <th nowrap  align="center"><strong>Quantity <span style="color:red;"> *</span></strong></th>
                                                            <th nowrap  align="center"><strong>Receivable(Qty)</strong></th>
                                                            <th nowrap  align="center"><strong>Unit Price(BDT)  <span style="color:red;"> *</span></strong></th>
                                                            <th nowrap  align="center"><strong>Total Price(BDT) <span style="color:red;"> *</span></strong></th>
                                                            <th nowrap style="width:20%;border-radius:10px;" align="center"><strong>Returned Cylinder <span style="color:red;"> </th>
                                                            <th nowrap style="width:10%;border-radius:10px;" align="center"><strong>Returned Qty <span style="color:red;"></th>
                                                            <th align="center"><strong>Action</strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>

                                                            <td id="product_td">
                                                                <select id="productID" onchange="getProductPrice(this.value)" class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Product">
                                                                    <option value=""></option>
                                                                    <?php foreach ($productList as $key => $eachProduct):
                                                                        ?>
                                                                        <optgroup label="<?php echo $eachProduct['categoryName']; ?>">
                                                                            <?php
                                                                            foreach ($eachProduct['productInfo'] as $eachInfo) :

                                                                                $productPreFix = substr($eachInfo->productName, 0, 5);
                                                                                //  if ($productPreFix != 'Empty'):
                                                                                ?>
                                                                                <option ispackage="0" categoryName="<?php echo $eachProduct['categoryName']; ?>" categoryId="<?php echo $eachProduct['categoryId']; ?>" productName="<?php echo $eachInfo->productName . " [ " . $eachInfo->brandName . " ] "; ?>" value="<?php echo $eachInfo->product_id; ?>"><?php echo $eachInfo->productName . " [ " . $eachInfo->brandName . " ] "; ?></option>
                                                                                <?php
                                                                                //  endif;
                                                                            endforeach;
                                                                            ?>
                                                                        </optgroup>

                                                                        <?php
                                                                    endforeach;
                                                                    ?>
                                                                    <optgroup label="Package">
                                                                        <?php
                                                                        foreach ($productList['packageList'] as $eachInfo) :


                                                                            ?>
                                                                            <option ispackage="1" categoryId="<?php echo $eachInfo->category_id; ?>"  product_id="<?php echo $eachInfo->product_id;?>"  value="<?php echo $eachInfo->package_id; ?>"><?php echo $eachInfo->package_name . " [ " . $eachInfo->package_code . " ] "; ?></option>
                                                                            <?php
                                                                            // endif;
                                                                        endforeach;
                                                                        ?>
                                                                    </optgroup>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control text-right is_same decimal"  value="0"><input type="hidden" value="" id="stockQty"/><input type="text"  onkeyup="checkStockOverQty(this.value)" class="form-control text-right quantity decimal"  placeholder="0"></td>
                                                            <td><input type="hidden" value="" id="returnStockQty"/><input type="text" readonly onkeyup="checkReturnStockOverQty(this.value)" class="form-control text-right returnQuantity decimal"   placeholder="0"></td>
                                                            <td><input type="text" class="form-control text-right rate decimal" placeholder="0.00"  ></td>
                                                            <td><input type="text" class="form-control text-right price decimal" placeholder="0.00" readonly="readonly"></td>
                                                            <td>
                                                                <select  id="productID2"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by product name">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($cylinderProduct as $eachProduct):
                                                                        $productPreFix = substr($eachProduct->productName, 0, 5);
                                                                        if ($eachProduct->category_id == 1):
                                                                            ?>
                                                                            <option  categoryName2="<?php echo $eachProduct->productCat; ?>" brand_id="<?php echo $eachProduct->brand_id?>" productName2="<?php echo $eachProduct->productName .' '. $eachProduct->unitTtile .' [ ' . $eachProduct->brandName . ']'; ?>" value="<?php echo $eachProduct->product_id; ?>">
                                                                                <?php echo $eachProduct->productName . ' [ ' . $eachProduct->brandName . ' ] '; ?>
                                                                            </option>
                                                                            <?php
                                                                        endif;
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control text-right returnQuentity decimal" placeholder="0.00" ></td>
                                                            <td><a id="add_item" class="btn btn-info form-control" href="javascript:;" title="Add Item"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Item</a></td>
                                                        </tr>

                                                        </tbody>
                                                        <tfoot></tfoot>
                                                    </table>
                                                    <table class="table table-bordered table-hover table-success">
                                                        <tr>
                                                            <td>
                                                                <textarea style="border:none;" cols="120"  class="form-control" name="narration" placeholder="Narration......" type="text"></textarea>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="panel  panel-default">
                                                <div class="panel-body">
                                                    <div class="table-header success">
                                                        Payment Calculation
                                                    </div>
                                                    <table class="table table-bordered table-hover ">
                                                        <tbody>
                                                        <tr>
                                                            <td nowrap  align="right"><strong>Total </strong></td>
                                                            <td   align="right"><strong class="total_price"></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap align="right"><strong>Discount ( - ) </strong></td>
                                                            <td><input type="text"  onkeyup="calDiscount()" id="disCount" style="text-align: right" name="discount" value="" class="form-control" placeholder="0.00"   oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap   align="right"><strong>Grand Total</strong></td>
                                                            <td><input readonly id="grandTotal" type="text" style="text-align: right" name="grandtotal" value="" class="form-control"  placeholder="0.00"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap    align="right"><strong>VAT(%) ( + )</strong></td>
                                                            <td><input type="text" id="vatAmount"  style="text-align: right" name="vat" readonly value="<?php
                                                                if (!empty($configInfo->vat)): echo $configInfo->vat;
                                                                endif;
                                                                ?>" class="form-control totalVatAmount"  placeholder="0.00"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" /></td>

                                                        </tr>
                                                        <tr>
                                                            <td nowrap  align="right"><strong>Loader ( + )</strong></td>
                                                            <td><input type="text" id="loader" onkeyup="calcutateFinal()"   style="text-align: right" name="loaderAmount" value=""  class="form-control"  placeholder="0.00"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap  align="right"><strong>Transportation ( + )</strong></td>
                                                            <td><input type="text" id="transportation" onkeyup="calcutateFinal()"   style="text-align: right" name="transportationAmount" value=""  class="form-control"  placeholder="0.00"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap  align="right"><strong>Net Total</strong></td>
                                                            <td><input type="text" id="netAmount"  style="text-align: right" name="netTotal" value="" readonly class="form-control"  placeholder="0.00"/></td>
                                                        </tr>
                                                        <tr class="chaque_amount_class" style="display:none">
                                                            <td nowrap  align="right"><strong>Chaque Amount</strong></td>
                                                            <td><input type="text" id="chaque_amount"  style="text-align: right" name="chaque_amount" value=""  class="form-control"  placeholder="0.00"/></td>
                                                        </tr>
                                                        <tr class="partisals"  >
                                                            <td  nowrap   align="right"><strong>Account <span style="color:red;"> * </span></strong></td>
                                                            <td >
                                                                <select style="width:100%!important;"  name="accountCrPartial" class="chosen-select   checkAccountBalance" id="partialHead" data-placeholder="Search by Account Head">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($accountHeadList as $key => $head) {
                                                                        if ($key != 51 || $key != 112) {
                                                                            ?>
                                                                            <optgroup label="<?php echo $head['parentName']; ?>">
                                                                                <?php
                                                                                foreach ($head['Accountledger'] as $eachLedger) :
                                                                                    ?>
                                                                                    <option <?php
                                                                                    if ($eachLedger->chartId == '54') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?> value="<?php echo $eachLedger->chartId; ?>"><?php echo $eachLedger->title . " ( " . $eachLedger->code . " ) "; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </optgroup>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr  class="partisals">
                                                            <td nowrap  align="right"><strong>Payment ( - )<span style="color:red;"> * </span></strong></td>
                                                            <td><input type="text" id="payment" onkeyup="calculatePartialPayment()" style="text-align: right" name="partialPayment" value=""  class="form-control" autocomplete="off"  placeholder="0.00"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" /></td>
                                                            <input type="hidden" id="duePayment"  style="text-align: right" name="duePayment" value="" readonly  class="form-control"  placeholder="0.00"/>
                                                        </tr>
                                                        <tr class="creditDate" style="display:none;">
                                                            <td nowrap   align="right"><strong>Due Date</strong></td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input class="form-control date-picker" name="creditDueDate" id="dueDate" type="text" value="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td nowrap align="right"><strong>Due Amount</strong></td>
                                                            <td><input type="text" id="currentDue"  readonly style="text-align: right" name="" value=""  class="form-control" autocomplete="off"  placeholder="0.00"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td  nowrap align="right"><strong>Previous Due</strong></td>
                                                            <td><input type="text" id="previousDue"  readonly style="text-align: right" name="" value=""  class="form-control" autocomplete="off"  placeholder="0.00"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" /></td>

                                                        </tr>
                                                        <tr>
                                                            <td  nowrap align="right"><strong>Total Due</strong></td>
                                                            <td><input type="text" id="totalDue"  readonly style="text-align: right" name="" value=""  class="form-control" autocomplete="off"  placeholder="0.00"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" /></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px!important;">
                                    <div class="col-md-12">
                                        <div id="culinderReceive">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="table-header">
                                                        Received Cylinder Item
                                                    </div>
                                                    <table class="table table-bordered table-hover" id="show_item2">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:18%" align="center"><strong>Product <span style="color:red;"> *</span></strong></th>
                                                            <th style="width:17%" align="center"><strong><span style="color:red;"> *</span>Received(Qty)</strong></th>
                                                            <th style="width:15%" align="center"><strong>Action</strong></th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <td>
                                                                <select  id="productID2" onchange="getProductPrice2(this.value)" class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Product Name">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($cylinderProduct as $eachProduct):
                                                                        $productPreFix = substr($eachProduct->productName, 0, 5);
                                                                        if ($productPreFix == 'Empty'):
                                                                            ?>
                                                                            <option  brand_id="<?php echo $eachProduct->brand_id?>" productName2="<?php echo $eachProduct->productName . ' [ ' . $eachProduct->brandName . ']'; ?>" value="<?php echo $eachProduct->product_id; ?>">
                                                                                <?php echo $eachProduct->productName . ' [ ' . $eachProduct->brandName . ' ] '; ?>
                                                                            </option>
                                                                            <?php
                                                                        endif;
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="hidden" value="" id="stockQty2"/><input type="text"  onkeyup="checkStockOverQty2(this.value)" class="form-control text-right quantity2" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="0"></td>
                                                            <!--<td><input type="hidden" value="" id="returnStockQty"/><input type="text"  onkeyup="checkReturnStockOverQty(this.value)" class="form-control text-right returnQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="0"></td>-->
                                                            <td><a id="add_item2" class="btn btn-info form-control" href="javascript:;" title="Add Item"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Item</a></td>
                                                        </tr>
                                                        </tfoot>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="clearfix"></div>
                                    <div class="clearfix form-actions" >
                                        <div class="col-md-offset-1 col-md-10">
                                            <button onclick="return isconfirm2()" id="subBtn" class="btn btn-info" type="button">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Save
                                            </button>
                                            &nbsp; &nbsp; &nbsp;
                                            <button class="btn" onclick="showCylinder()" type="button">
                                                <i class="ace-icon fa fa-shopping-cart bigger-110"></i>
                                                Receive Cylinder
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script>




    function isconfirm2() {




        var customerid = $("#customerid").val();
        var saleDate = $("#saleDate").val();
        var paymentType = $("#paymentType").val();
        var paymentType = $("#paymentType").val();
        var dueDate = $("#dueDate").val();
        var partialHead = $("#partialHead").val();
        var thisAllotment = $("#payment").val();
        var bankName = $("#bankName").val();
        var branchName = $("#branchName").val();
        var checkNo = $("#checkNo").val();
        var checkDate = $("#checkDate").val();
        var cylinder = 0;
        if ($("#culinderReceive").css('display') == 'none') {
            cylinder = 0;
        } else {
            //  var cylinderItem=parseFloat($(".total_quantity2").text());
            var rowCount = $('#show_item2 tfoot tr').length;
            cylinder = 1;
        }
        var totalPrice = parseFloat($(".total_price").text());
        if (isNaN(totalPrice)) {
            totalPrice = 0;
        }
        if (customerid == '') {
            swal("Select Customer Name!", "Validation Error!", "error");
        } else if (saleDate == '') {
            swal("Select Sale Date!", "Validation Error!", "error");
        } else if (paymentType == '') {
            swal("Select Payment Type", "Validation Error!", "error");
        } else if (paymentType == 2 && dueDate == '') {
            swal("Select Due Date!", "Validation Error!", "error");
        } else if (paymentType == 3 && bankName == '') {
            swal("Type Bank Name!", "Validation Error!", "error");
        } else if (paymentType == 3 && branchName == '') {
            swal("Type Branch Name!", "Validation Error!", "error");
        } else if (paymentType == 3 && checkNo == '') {
            swal("Type Check No!", "Validation Error!", "error");
        } else if (paymentType == 3 && checkDate == '') {
            swal("Select Check Date!", "Validation Error!", "error");
        } else if (totalPrice == '' || totalPrice < 0) {
            swal("Add Sales Item!", "Validation Error!", "error");
        } else if (paymentType == 4 && partialHead == '') {
            swal("Select Account Head!", "Validation Error!", "error");
        } else if (paymentType == 4 && thisAllotment == '') {
            swal("Given Cash Amount!", "Validation Error!", "error");
        } else if (cylinder == 1 && rowCount <= 1) {
            swal("Add Receive Cylinder Item!", "Validation Error!", "error");
        } else {
            swal({
                    title: "Are you sure ?",
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#73AE28',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    type: 'success'
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $("#publicForm").submit();
                    } else {
                        return false;
                    }
                });
        }
    }

    $(document).ready(function () {
        var j = 0;
        var slNo = 1;
        $("#add_item").click(function () {
            var productCatID = $('#productID').find('option:selected').attr('categoryId');
            console.log(productCatID);
            var productCatName = $('#productID').find('option:selected').attr('categoryName');
            var productID = $('#productID').val();
            var productName = $('#productID').find('option:selected').attr('productName');

            var ispackage = $('#productID').find('option:selected').attr('ispackage');
            var package_id2 = $('#productID2').val();
            var productCatName2 = $('#productID2').find('option:selected').attr('categoryName2');
            var productName2 = $('#productID2').find('option:selected').attr('productName2');
            var brand_id = $('#productID').find('option:selected').attr('brand_id');


            var quantity = $('.quantity').val();
            var rate = $('.rate').val();
            var price = $('.price').val();
            var returnQuantity = $('.returnQuantity').val();

            var returnQuentity = $('.returnQuentity').val();

            if(ispackage==0){

                var tab;

                if(productCatID == 2){
                    if($('.is_same').val()==0){
                        slNo++;
                        tab ='<tr class="new_item' + j + '">' +
                            '<input type="hidden" name="slNo['+slNo+']" value="'+slNo+'"/>' +
                            '<input type="hidden" name="brand_id[]" value="'+brand_id+'"/>' +
                            '<input type="hidden" name="is_package_'+ slNo +'" value="0">' +
                            '<input type="hidden" name="category_id[]" value="'  + productCatID + '">' +
                            '<td style="padding-left:15px;"> [ ' + productCatName + '] - ' + productName +
                            '<input type="hidden"  name="product_id_'+ slNo +'" value="' + productID + '">' +
                            '</td>' +
                            '<td align="right">' +
                            '<input type="text" id="qty_'+ j +'" class="form-control text-right add_quantity decimal" onkeyup="checkStockOverQty(this.value)" name="quantity_'+ slNo +'" value="' + quantity + '">' +
                            '</td>' +
                            '<td align="right"><input type="text" class="add_ReturnQuantity  text-right form-control decimal" name="returnQuantity[]" value="' + returnQuantity + '">' +
                            '</td>' +
                            '<td align="right"><input type="text" id="rate_'+ j +'" class="form-control add_rate text-right decimal" name="rate_'+ slNo +'" value="' + rate + '">' +
                            '</td>' +
                            '<td align="right"><input readonly type="text" class="add_price text-right form-control" id="tprice_'+ j +'" name="price[]" value="' + price + '">' +
                            '</td>' +
                            '<td colspan="2">' +
                            '<table class="table table-bordered table-hover" style="margin-bottom: 0px;" id="return_product_'+slNo+'">'+
                            '<tr>'+
                            '<td>'+
                            productName2+
                            '</td>'+
                            '<td>'+
                            returnQuentity+
                            '</td>'+
                            '</tr>'+
                            '</table>'+
                            '</td>' +
                            '<td>' +
                            '<a del_id="'+j+'" class="delete_item btn form-control btn-danger" href="javascript:;" title=""><i class="fa fa-times"></i>&nbsp;Remove</a>' +
                            '</td>' +
                            '</tr>';
                        console.log(tab);
                        $("#show_item tfoot").append(tab);
                    }else {
                        slNo;
                        var tab2="<tr>" +
                            "<td>" +
                            productName2+
                            "</td>" +
                            "<td>" +
                            returnQuentity+
                            "</td>" +
                            "</tr>";

                        $("#return_product_"+slNo).append(tab2);

                    }


                    $('.is_same').val('1')
                }else{
                    slNo++;
                    tab ='<tr class="new_item' + j + '">' +
                        '<input type="hidden" name="slNo['+slNo+']" value="'+slNo+'"/>' +
                        '<input type="hidden" name="brand_id[]" value="'+brand_id+'"/>' +
                        '<input type="hidden" name="is_package_'+ slNo +'" value="0">' +
                        '<input type="hidden" name="category_id[]" value="'  + productCatID + '">' +
                        '<td style="padding-left:15px;"> [ ' + productCatName + '] - ' + productName +
                        '<input type="hidden"  name="product_id_'+ slNo +'" value="' + productID + '">' +
                        '</td>' +
                        '<td align="right">' +
                        '<input type="text" id="qty_'+ j +'" class="form-control text-right add_quantity decimal" onkeyup="checkStockOverQty(this.value)" name="quantity_'+ slNo +'" value="' + quantity + '">' +
                        '</td>' +
                        '<td align="right"><input type="text" class="add_ReturnQuantity  text-right form-control decimal" name="returnQuantity[]" value="' + returnQuantity + '">' +
                        '</td>' +
                        '<td align="right"><input type="text" id="rate_'+ j +'" class="form-control add_rate text-right decimal" name="rate_'+ slNo +'" value="' + rate + '">' +
                        '</td>' +
                        '<td align="right"><input readonly type="text" class="add_price text-right form-control" id="tprice_'+ j +'" name="price[]" value="' + price + '">' +
                        '</td>' +
                        '<td colspan="2">' +
                        '<table class="table table-bordered table-hover" style="margin-bottom: 0px;" id="return_product_'+slNo+'">'+
                        '<tr>'+
                        '<td>'+
                        productName2+
                        '</td>'+
                        '<td>'+
                        returnQuentity+
                        '</td>'+
                        '</tr>'+
                        '</table>'+
                        '</td>' +
                        '<td>' +
                        '<a del_id="'+j+'" class="delete_item btn form-control btn-danger" href="javascript:;" title=""><i class="fa fa-times"></i>&nbsp;Remove</a>' +
                        '</td>' +
                        '</tr>';
                    console.log(tab);
                    $("#show_item tfoot").append(tab);





                }
            }else{
                var quantity = $('.quantity').val();
                var returnAble = $('.returnAble').val();
                var rate = $('.rate').val();
                var price = $('.price').val();
                $.ajax({
                    type: "POST",
                    dataType:'json',
                    url:baseUrl + "lpg/PurchaseController/package_product_list",
                    data: 'package_id=' + productID,
                    success: function (data) {

                        $.each(data, function (key, value) {
                            slNo++;
                            $("#show_item tfoot").append('<tr class="new_item' + j + '"><input type="hidden" name="slNo['+slNo+']" value="'+slNo+'"/><input type="hidden" name="is_package_'+ slNo +'" value="1"><input type="hidden" name="category_id_'+ slNo +'" value="' + value['category_id'] + '">' +
                                '<td style="padding-left:15px;"> [ ' + value['title'] + '] - ' + value['productName'] +'&nbsp;'+ value['unitTtile'] +'&nbsp;[ '+ value['brandName']+" ]"+
                                ' <input type="hidden"  name="product_id_'+ slNo +'" value="' + value['product_id'] + '"></td>' +
                                '</td><td align="right"><input type="text" class="add_quantity decimal form-control text-right" id="qty_'+ j +'" name="quantity_'+ slNo +'" value="' + quantity + '"></td><td align="right"><input type="text" class="add_return form-control text-right decimal "  id="qtyReturn_'+ j +'"   name="add_returnAble[]" value=""  readonly></td><td align="right"><input type="text" id="rate_'+ j +'" class="add_rate form-control decimal text-right" name="rate_'+ slNo +'" value="' + rate + '"></td><td align="right"><input type="text" class="add_price  text-right form-control" id="tprice_'+ j +'" readonly name="price[]" value="' + price + '"></td><td></td><td></td><td><a del_id="' + j + '" class="delete_item btn form-control btn-danger" href="javascript:;" title=""><i class="fa fa-times"></i>&nbsp;Remove</a></td></tr>');
                            j++;

                        });
                        console.log(slNo);
                    }
                });
                $('.quantity').val('');
                $('.rate').val('');
                $('.price').val('');
                $('.returnAble').val('');
            }

        })
        j++;


    });


    function getProductPrice(product_id) {
        $("#stockQty").val('');
        $(".quantity").val('');
        $('.is_same').val('0');
        var productCatID = parseFloat($('#productID').find('option:selected').attr('categoryId'));
        console.log('getProductPrice');
        console.log(productCatID);
        var ispackage = $('#productID').find('option:selected').attr('ispackage');
        if(ispackage==1){
            product_id= $('#productID').find('option:selected').attr('product_id');
        }



        console.log('getProductPrice');
        console.log(productCatID);
        if(productCatID ==2){
            console.log('PPP');
            $(".returnQuantity").attr('readonly',false);
        }else{
            $(".returnQuantity").attr('readonly',true);
        }
        $.ajax({
            type: "POST",
            url: baseUrl + "FinaneController/getProductPriceForSale",
            data: 'product_id=' + product_id,
            success: function (data) {
                $('.rate').val('');
            }
        });
        $.ajax({
            type: "POST",
            url: baseUrl+ "FinaneController/getProductStock",
            data: {product_id:product_id,category_id:productCatID,ispackage:ispackage},
            success: function (data) {
                var mainStock = parseFloat(data);
                if(isNaN(mainStock)){
                    mainStock=0;
                }

                console.log('data');
                console.log(data);
                if(data !=''){
                    $("#stockQty").val(data);
                    $(".quantity").attr("disabled",false);
                    if(mainStock <= 0){
                        $(".quantity").attr("disabled",true);
                        $(".quantity").attr("placeholder", "0 ");
                    }else{
                        $(".quantity").attr("disabled",false);
                        $(".quantity").attr("placeholder", ""+mainStock);
                    }
                }else{
                    $("#stockQty").val('');
                    $(".quantity").attr("disabled",true);
                    $(".quantity").attr("placeholder", "0");
                }
            }
        });
    }

</script>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Customer</h4>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12">
                        <form id="publicForm2" action=""  method="post" class="form-horizontal">

                            <?php
                            $this->db->select("*");
                            $this->db->from("customertype");
                            $this->db->where_in('dist_id', array($this->dist_id, 1));
                            $customerType = $this->db->get()->result();

                            // echo $this->db->last_query();die;
                            //$customerType = $this->Common_model->get_data_list_by_single_column('customertype', 'dist_id', $this->dist_id);
                            ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Customer Type</label>
                                <div class="col-sm-9">
                                    <select  name="customerType"  class=" form-control" id="form-field-select-3"  data-placeholder="Search by Customer Type">
                                        <option>-Select Type-</option>
                                        <?php foreach ($customerType as $key => $eachType): ?>
                                            <option value="<?php echo $eachType->type_id; ?>"><?php echo $eachType->typeTitle; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Customer ID </label>
                                <div class="col-sm-9">
                                    <input type="text" id="customerId" name="customerID" readonly value="<?php echo isset($customerID) ? $customerID : ''; ?>" class="form-control" placeholder="Customer ID" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Customer Name </label>
                                <div class="col-sm-9">
                                    <input type="text" id="customerName" name="customerName" class="form-control" placeholder="Customer Name" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone</label>
                                <div class="col-sm-9">
                                    <input type="text"  maxlength="11" id="form-field-1 cstPhone" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onblur="checkDuplicatePhone(this.value)" name="customerPhone" placeholder="Customer Phone" class="form-control" />
                                    <span id="errorMsg"  style="color:red;display: none;"><i class="ace-icon fa fa-spinner fa-spin orange bigger-120"></i> &nbsp;&nbsp;Phone Number already Exits!!</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email</label>
                                <div class="col-sm-9">
                                    <input type="email" id="form-field-1" name="customerEmail" placeholder="Email" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address</label>
                                <div class="col-sm-9">
                                    <!--<textarea id="editor1" cols="10" rows="5" name="comp_add"></textarea>-->
                                    <textarea  cols="6" rows="3" placeholder="Type Address.." class="form-control" name="customerAddress"></textarea>
                                </div>
                            </div>
                            <div class="clearfix form-actions" >
                                <div class="col-md-offset-3 col-md-9">
                                    <button onclick="saveNewCustomer()" id="subBtn2" class="btn btn-info" type="button">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        Save
                                    </button>
                                    &nbsp; &nbsp; &nbsp;
                                    <button class="btn" type="reset" data-dismiss="modal">
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/sales/saleInvoice.js'); ?>"></script>
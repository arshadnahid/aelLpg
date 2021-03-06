<?php if ($payType == 1): ?>
    <div class="form-group">
        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Miscellaneous</label>
        <div class="col-sm-8">
            <input type="text" name="miscellaneous" id="miscellaneous" value="<?php
    if (!empty($userId)) {
        echo $userId;
    }
    ?>" class="form-control" placeholder="Type Miscellaneous"/>
        </div>
    </div>
<?php elseif ($payType == 2): ?>
    <div class="form-group">
        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Customer</label>
        <div class="col-sm-8">
            <select name="searchId"  class="chosen-select form-control  chosenRefesh" id="userId" data-placeholder="Search Customer">
                <option value=""></option>

                <?php foreach ($payList as $key => $value): ?>
                    <option <?php
            if (!empty($userId) && $userId == $value->customer_id) {
                echo "selected";
            }
                    ?> value="<?php echo $value->customer_id; ?>"><?php echo $value->customerID . ' [ ' . $value->customerName . ' ] ' ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php else: ?>
    <div class="form-group">
        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Supplier</label>
        <div class="col-sm-8">
            <select name="searchId"  class="chosen-select form-control chosenRefesh" id="userId" data-placeholder="Search  Supplier">
                <option value=""></option>
                <?php foreach ($payList as $key => $value): ?>
                    <option <?php
            if (!empty($userId) && $userId == $value->sup_id) {
                echo "selected";
            }
                    ?> value="<?php echo $value->sup_id; ?>"><?php echo $value->supID . ' [ ' . $value->supName . ' ] ' ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?>

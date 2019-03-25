<?php

$adminId = $this->session->userdata('admin_id');



$addCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '101',
);
$addPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $addCondition);
$editCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '102',
);
$editPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $editCondition);

$deleteCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '103',
);
$deletePermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $deleteCondition);

$saleAddCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '110',
);
$saleAddPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $saleAddCondition);
$saleEditCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '111',
);
$saleEditPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $saleEditCondition);

$saleDeleteCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '112',
);
$saleDeletePermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $saleDeleteCondition);

/*sale add end*/


/*Inventory add start*/
$inventoryAddCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '116',
);
$inventoryAddPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $inventoryAddCondition);
$inventoryEditCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '117',
);
$inventoryEditPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $inventoryEditCondition);

$inventoryDeleteCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '118',
);
$inventoryDeletePermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $inventoryDeleteCondition);
/*inventory add end*/

/*finacne add start*/
$financeAddCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '113',
);
$financeAddPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $financeAddCondition);
$financeEditCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '114',
);
$financeEditPermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $financeEditCondition);

$financeDeleteCondition = array(
    'admin_id' => $adminId,
    'navigation_id' => '115',
);
$financeDeletePermition = $this->Common_model->get_single_data_by_many_columns('admin_role', $financeDeleteCondition);
/*finacne add end*/




$url = $this->uri->segment(1, 0);
if ($this->uri->segment(1) != FALSE) {
    $isPermissionValid = $this->Common_model->checkMenuAccessValid($url, $adminId);
    if ($isPermissionValid === FALSE) {
        exception("Sorry,You are not permitted to access this page!!!");
        redirect(site_url('moduleDashboard'));
    }
}






?>
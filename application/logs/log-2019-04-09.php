INFO - 2019-04-09 11:54:12 --> Config Class Initialized
INFO - 2019-04-09 11:54:12 --> Hooks Class Initialized
DEBUG - 2019-04-09 11:54:12 --> UTF-8 Support Enabled
INFO - 2019-04-09 11:54:12 --> Utf8 Class Initialized
INFO - 2019-04-09 11:54:12 --> URI Class Initialized
INFO - 2019-04-09 11:54:12 --> Router Class Initialized
INFO - 2019-04-09 11:54:12 --> Output Class Initialized
INFO - 2019-04-09 11:54:12 --> Security Class Initialized
DEBUG - 2019-04-09 11:54:12 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 11:54:12 --> Input Class Initialized
INFO - 2019-04-09 11:54:12 --> Language Class Initialized
INFO - 2019-04-09 11:54:12 --> Loader Class Initialized
INFO - 2019-04-09 11:54:12 --> Helper loaded: url_helper
INFO - 2019-04-09 11:54:12 --> Helper loaded: file_helper
INFO - 2019-04-09 11:54:12 --> Helper loaded: utility_helper
INFO - 2019-04-09 11:54:12 --> Helper loaded: unit_helper
INFO - 2019-04-09 11:54:12 --> Database Driver Class Initialized
INFO - 2019-04-09 11:54:12 --> Email Class Initialized
DEBUG - 2019-04-09 11:54:12 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 11:54:12 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 11:54:12 --> Helper loaded: form_helper
INFO - 2019-04-09 11:54:12 --> Form Validation Class Initialized
INFO - 2019-04-09 11:54:12 --> Controller Class Initialized
INFO - 2019-04-09 11:54:12 --> Model "Common_model" initialized
INFO - 2019-04-09 11:54:12 --> Model "Finane_Model" initialized
INFO - 2019-04-09 11:54:12 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 11:54:12 --> Model "Sales_Model" initialized
ERROR - 2019-04-09 11:54:12 --> cylinder_stock_report querySELECT
                brand.brandId,
                brand.brandName,
                IFNULL(purchase_refill_qty_table.purchase_refill_qty,0) as purchase_refill_qty,
                IFNULL(purchase_empty_qty_table.purchase_empty_qty,0) as purchase_empty_qty,
                IFNULL(purchase_refill_qty_table.purchase_returnable_quantity,0) as purchase_returnable_quantity,
                IFNULL(purchase_refill_qty_table.purchase_return_quentity,0) as purchase_return_quentity,
                IFNULL(purchase_refill_qty_table.purchase_supplier_due,0) as purchase_supplier_due,
                IFNULL(purchase_refill_qty_table.purchase_supplier_advance,0) as purchase_supplier_advance,
                IFNULL(sales_refill_qty_table.sales_refill_qty,0) as sales_refill_qty,
                IFNULL(sales_empty_qty_table.sales_empty_qty,0) as sales_empty_qty,
                IFNULL(sales_refill_qty_table.sales_returnable_quantity,0) as sales_returnable_quantity,
                IFNULL(sales_refill_qty_table.sales_return_quentity,0) as sales_return_quentity,
                IFNULL(sales_refill_qty_table.sales_customer_due,0) as sales_customer_due,
                IFNULL(sales_refill_qty_table.sales_customer_advance,0) as sales_customer_advance
            
            FROM
                brand
            LEFT JOIN(
            
                SELECT
                    product.product_id,
                    product.brand_id,
                    SUM(IFNULL(purchase_details.quantity,0)) AS purchase_refill_qty,
                    SUM(IFNULL(purchase_details.returnable_quantity,0))AS purchase_returnable_quantity,
                    SUM(IFNULL(purchase_details.return_quentity,0))AS purchase_return_quentity,
                    SUM(IFNULL(purchase_details.supplier_due,0))AS purchase_supplier_due,
                    SUM(IFNULL(purchase_details.supplier_advance,0))AS purchase_supplier_advance,
                    product.category_id
                FROM
                    product
                LEFT JOIN purchase_details ON purchase_details.product_id = product.product_id
                WHERE
                    product.category_id = 2
                GROUP BY
                    product.brand_id
            )AS purchase_refill_qty_table ON purchase_refill_qty_table.brand_id =brand.brandId
            AND purchase_refill_qty_table.category_id = 2
            LEFT JOIN(
                SELECT
                    product.brand_id,
                    product.category_id,
                    (SUM(IFNULL(purchase_details.quantity,0))- IFNULL(SUM(purchase_return_details.return_quantity),0))AS purchase_empty_qty
                FROM
                    product
                LEFT JOIN purchase_details ON purchase_details.product_id = product.product_id
                AND purchase_details.is_package = 0
                LEFT JOIN purchase_return_details ON purchase_return_details.product_id = product.product_id
                WHERE
                    product.category_id = 1
                GROUP BY
                    product.brand_id
            )AS purchase_empty_qty_table ON purchase_empty_qty_table.brand_id = brand.brandId
            AND purchase_empty_qty_table.category_id = 1
            LEFT JOIN(
                SELECT
                    product.product_id,
                    product.brand_id,
                    SUM(IFNULL(sales_details.quantity,0)) AS sales_refill_qty,
                    SUM(IFNULL(sales_details.returnable_quantity,0))AS sales_returnable_quantity,
                    SUM(IFNULL(sales_details.return_quentity,0))AS sales_return_quentity,
                    SUM(IFNULL(sales_details.customer_due,0))AS sales_customer_due,
                    SUM(IFNULL(sales_details.customer_advance,0))AS sales_customer_advance,
                    product.category_id
                FROM
                    product
                LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                WHERE
                    product.category_id = 2
                GROUP BY
                    product.brand_id
            )AS sales_refill_qty_table ON sales_refill_qty_table.brand_id =brand.brandId
            AND sales_refill_qty_table.category_id = 2
            LEFT JOIN(
                SELECT
                    product.brand_id,
                    product.category_id,
                    (SUM(IFNULL(sales_details.quantity,0))- IFNULL(SUM(sales_return_details.return_quantity),0))AS sales_empty_qty
                FROM
                    product
                LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                AND sales_details.is_package = 0
                LEFT JOIN sales_return_details ON sales_return_details.product_id = product.product_id
                WHERE
                    product.category_id = 1
                GROUP BY
                    product.brand_id
            )AS sales_empty_qty_table ON sales_empty_qty_table.brand_id = brand.brandId
            AND sales_empty_qty_table.category_id = 1
INFO - 2019-04-09 11:54:12 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_report.php
INFO - 2019-04-09 11:54:12 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 11:54:12 --> Final output sent to browser
DEBUG - 2019-04-09 11:54:12 --> Total execution time: 0.2146
INFO - 2019-04-09 12:05:49 --> Config Class Initialized
INFO - 2019-04-09 12:05:49 --> Hooks Class Initialized
DEBUG - 2019-04-09 12:05:49 --> UTF-8 Support Enabled
INFO - 2019-04-09 12:05:49 --> Utf8 Class Initialized
INFO - 2019-04-09 12:05:49 --> URI Class Initialized
INFO - 2019-04-09 12:05:49 --> Router Class Initialized
INFO - 2019-04-09 12:05:49 --> Output Class Initialized
INFO - 2019-04-09 12:05:49 --> Security Class Initialized
DEBUG - 2019-04-09 12:05:49 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 12:05:49 --> Input Class Initialized
INFO - 2019-04-09 12:05:49 --> Language Class Initialized
INFO - 2019-04-09 12:05:49 --> Loader Class Initialized
INFO - 2019-04-09 12:05:49 --> Helper loaded: url_helper
INFO - 2019-04-09 12:05:49 --> Helper loaded: file_helper
INFO - 2019-04-09 12:05:49 --> Helper loaded: utility_helper
INFO - 2019-04-09 12:05:49 --> Helper loaded: unit_helper
INFO - 2019-04-09 12:05:49 --> Database Driver Class Initialized
INFO - 2019-04-09 12:05:49 --> Email Class Initialized
DEBUG - 2019-04-09 12:05:49 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 12:05:49 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 12:05:49 --> Helper loaded: form_helper
INFO - 2019-04-09 12:05:49 --> Form Validation Class Initialized
INFO - 2019-04-09 12:05:49 --> Controller Class Initialized
INFO - 2019-04-09 12:05:49 --> Model "Common_model" initialized
INFO - 2019-04-09 12:05:49 --> Model "Finane_Model" initialized
INFO - 2019-04-09 12:05:49 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 12:05:49 --> Model "Sales_Model" initialized
INFO - 2019-04-09 12:05:49 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_report.php
INFO - 2019-04-09 12:05:49 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 12:05:49 --> Final output sent to browser
DEBUG - 2019-04-09 12:05:49 --> Total execution time: 0.2147
INFO - 2019-04-09 12:28:14 --> Config Class Initialized
INFO - 2019-04-09 12:28:14 --> Hooks Class Initialized
DEBUG - 2019-04-09 12:28:14 --> UTF-8 Support Enabled
INFO - 2019-04-09 12:28:14 --> Utf8 Class Initialized
INFO - 2019-04-09 12:28:14 --> URI Class Initialized
INFO - 2019-04-09 12:28:14 --> Router Class Initialized
INFO - 2019-04-09 12:28:14 --> Output Class Initialized
INFO - 2019-04-09 12:28:14 --> Security Class Initialized
DEBUG - 2019-04-09 12:28:14 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 12:28:14 --> Input Class Initialized
INFO - 2019-04-09 12:28:14 --> Language Class Initialized
INFO - 2019-04-09 12:28:14 --> Loader Class Initialized
INFO - 2019-04-09 12:28:14 --> Helper loaded: url_helper
INFO - 2019-04-09 12:28:14 --> Helper loaded: file_helper
INFO - 2019-04-09 12:28:14 --> Helper loaded: utility_helper
INFO - 2019-04-09 12:28:14 --> Helper loaded: unit_helper
INFO - 2019-04-09 12:28:14 --> Database Driver Class Initialized
INFO - 2019-04-09 12:28:14 --> Email Class Initialized
DEBUG - 2019-04-09 12:28:14 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 12:28:14 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 12:28:14 --> Helper loaded: form_helper
INFO - 2019-04-09 12:28:14 --> Form Validation Class Initialized
INFO - 2019-04-09 12:28:14 --> Controller Class Initialized
INFO - 2019-04-09 12:28:14 --> Model "Common_model" initialized
INFO - 2019-04-09 12:28:14 --> Model "Finane_Model" initialized
INFO - 2019-04-09 12:28:14 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 12:28:14 --> Model "Sales_Model" initialized
INFO - 2019-04-09 12:28:14 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_report.php
INFO - 2019-04-09 12:28:14 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 12:28:14 --> Final output sent to browser
DEBUG - 2019-04-09 12:28:14 --> Total execution time: 0.2080
INFO - 2019-04-09 12:28:40 --> Config Class Initialized
INFO - 2019-04-09 12:28:40 --> Hooks Class Initialized
DEBUG - 2019-04-09 12:28:40 --> UTF-8 Support Enabled
INFO - 2019-04-09 12:28:40 --> Utf8 Class Initialized
INFO - 2019-04-09 12:28:40 --> URI Class Initialized
INFO - 2019-04-09 12:28:40 --> Router Class Initialized
INFO - 2019-04-09 12:28:40 --> Output Class Initialized
INFO - 2019-04-09 12:28:40 --> Security Class Initialized
DEBUG - 2019-04-09 12:28:40 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 12:28:40 --> Input Class Initialized
INFO - 2019-04-09 12:28:40 --> Language Class Initialized
INFO - 2019-04-09 12:28:40 --> Loader Class Initialized
INFO - 2019-04-09 12:28:40 --> Helper loaded: url_helper
INFO - 2019-04-09 12:28:40 --> Helper loaded: file_helper
INFO - 2019-04-09 12:28:40 --> Helper loaded: utility_helper
INFO - 2019-04-09 12:28:40 --> Helper loaded: unit_helper
INFO - 2019-04-09 12:28:40 --> Database Driver Class Initialized
INFO - 2019-04-09 12:28:40 --> Email Class Initialized
DEBUG - 2019-04-09 12:28:40 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 12:28:40 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 12:28:40 --> Helper loaded: form_helper
INFO - 2019-04-09 12:28:40 --> Form Validation Class Initialized
INFO - 2019-04-09 12:28:40 --> Controller Class Initialized
INFO - 2019-04-09 12:28:40 --> Model "Common_model" initialized
INFO - 2019-04-09 12:28:40 --> Model "Finane_Model" initialized
INFO - 2019-04-09 12:28:40 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 12:28:40 --> Model "Sales_Model" initialized
INFO - 2019-04-09 12:28:40 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_report.php
INFO - 2019-04-09 12:28:40 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 12:28:40 --> Final output sent to browser
DEBUG - 2019-04-09 12:28:40 --> Total execution time: 0.1954
INFO - 2019-04-09 12:29:06 --> Config Class Initialized
INFO - 2019-04-09 12:29:06 --> Hooks Class Initialized
DEBUG - 2019-04-09 12:29:06 --> UTF-8 Support Enabled
INFO - 2019-04-09 12:29:06 --> Utf8 Class Initialized
INFO - 2019-04-09 12:29:06 --> URI Class Initialized
INFO - 2019-04-09 12:29:06 --> Router Class Initialized
INFO - 2019-04-09 12:29:06 --> Output Class Initialized
INFO - 2019-04-09 12:29:06 --> Security Class Initialized
DEBUG - 2019-04-09 12:29:06 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 12:29:06 --> Input Class Initialized
INFO - 2019-04-09 12:29:06 --> Language Class Initialized
INFO - 2019-04-09 12:29:06 --> Loader Class Initialized
INFO - 2019-04-09 12:29:06 --> Helper loaded: url_helper
INFO - 2019-04-09 12:29:06 --> Helper loaded: file_helper
INFO - 2019-04-09 12:29:06 --> Helper loaded: utility_helper
INFO - 2019-04-09 12:29:06 --> Helper loaded: unit_helper
INFO - 2019-04-09 12:29:06 --> Database Driver Class Initialized
INFO - 2019-04-09 12:29:06 --> Email Class Initialized
DEBUG - 2019-04-09 12:29:06 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 12:29:06 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 12:29:06 --> Helper loaded: form_helper
INFO - 2019-04-09 12:29:06 --> Form Validation Class Initialized
INFO - 2019-04-09 12:29:06 --> Controller Class Initialized
INFO - 2019-04-09 12:29:06 --> Model "Common_model" initialized
INFO - 2019-04-09 12:29:06 --> Model "Finane_Model" initialized
INFO - 2019-04-09 12:29:06 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 12:29:06 --> Model "Sales_Model" initialized
INFO - 2019-04-09 12:29:06 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 12:29:06 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 12:29:06 --> Final output sent to browser
DEBUG - 2019-04-09 12:29:06 --> Total execution time: 0.2154
INFO - 2019-04-09 12:29:16 --> Config Class Initialized
INFO - 2019-04-09 12:29:16 --> Hooks Class Initialized
DEBUG - 2019-04-09 12:29:16 --> UTF-8 Support Enabled
INFO - 2019-04-09 12:29:16 --> Utf8 Class Initialized
INFO - 2019-04-09 12:29:16 --> URI Class Initialized
INFO - 2019-04-09 12:29:16 --> Router Class Initialized
INFO - 2019-04-09 12:29:16 --> Output Class Initialized
INFO - 2019-04-09 12:29:16 --> Security Class Initialized
DEBUG - 2019-04-09 12:29:16 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 12:29:16 --> Input Class Initialized
INFO - 2019-04-09 12:29:16 --> Language Class Initialized
INFO - 2019-04-09 12:29:16 --> Loader Class Initialized
INFO - 2019-04-09 12:29:16 --> Helper loaded: url_helper
INFO - 2019-04-09 12:29:16 --> Helper loaded: file_helper
INFO - 2019-04-09 12:29:16 --> Helper loaded: utility_helper
INFO - 2019-04-09 12:29:16 --> Helper loaded: unit_helper
INFO - 2019-04-09 12:29:16 --> Database Driver Class Initialized
INFO - 2019-04-09 12:29:16 --> Email Class Initialized
DEBUG - 2019-04-09 12:29:16 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 12:29:16 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 12:29:16 --> Helper loaded: form_helper
INFO - 2019-04-09 12:29:16 --> Form Validation Class Initialized
INFO - 2019-04-09 12:29:16 --> Controller Class Initialized
INFO - 2019-04-09 12:29:16 --> Model "Common_model" initialized
INFO - 2019-04-09 12:29:16 --> Model "Finane_Model" initialized
INFO - 2019-04-09 12:29:16 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 12:29:16 --> Model "Sales_Model" initialized
INFO - 2019-04-09 12:29:16 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 12:29:16 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 12:29:16 --> Final output sent to browser
DEBUG - 2019-04-09 12:29:16 --> Total execution time: 0.1814
INFO - 2019-04-09 13:13:09 --> Config Class Initialized
INFO - 2019-04-09 13:13:09 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:13:09 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:13:09 --> Utf8 Class Initialized
INFO - 2019-04-09 13:13:09 --> URI Class Initialized
INFO - 2019-04-09 13:13:09 --> Router Class Initialized
INFO - 2019-04-09 13:13:09 --> Output Class Initialized
INFO - 2019-04-09 13:13:09 --> Security Class Initialized
DEBUG - 2019-04-09 13:13:09 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:13:09 --> Input Class Initialized
INFO - 2019-04-09 13:13:09 --> Language Class Initialized
INFO - 2019-04-09 13:13:09 --> Loader Class Initialized
INFO - 2019-04-09 13:13:09 --> Helper loaded: url_helper
INFO - 2019-04-09 13:13:09 --> Helper loaded: file_helper
INFO - 2019-04-09 13:13:09 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:13:09 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:13:09 --> Database Driver Class Initialized
INFO - 2019-04-09 13:13:09 --> Email Class Initialized
DEBUG - 2019-04-09 13:13:09 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:13:09 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:13:09 --> Helper loaded: form_helper
INFO - 2019-04-09 13:13:09 --> Form Validation Class Initialized
INFO - 2019-04-09 13:13:09 --> Controller Class Initialized
INFO - 2019-04-09 13:13:09 --> Model "Common_model" initialized
INFO - 2019-04-09 13:13:09 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:13:09 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:13:09 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:13:09 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:13:09 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:13:09 --> Final output sent to browser
DEBUG - 2019-04-09 13:13:09 --> Total execution time: 0.2332
INFO - 2019-04-09 13:13:11 --> Config Class Initialized
INFO - 2019-04-09 13:13:11 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:13:11 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:13:11 --> Utf8 Class Initialized
INFO - 2019-04-09 13:13:11 --> URI Class Initialized
INFO - 2019-04-09 13:13:11 --> Router Class Initialized
INFO - 2019-04-09 13:13:11 --> Output Class Initialized
INFO - 2019-04-09 13:13:11 --> Security Class Initialized
DEBUG - 2019-04-09 13:13:11 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:13:11 --> Input Class Initialized
INFO - 2019-04-09 13:13:11 --> Language Class Initialized
INFO - 2019-04-09 13:13:11 --> Loader Class Initialized
INFO - 2019-04-09 13:13:11 --> Helper loaded: url_helper
INFO - 2019-04-09 13:13:11 --> Helper loaded: file_helper
INFO - 2019-04-09 13:13:11 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:13:11 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:13:11 --> Database Driver Class Initialized
INFO - 2019-04-09 13:13:11 --> Email Class Initialized
DEBUG - 2019-04-09 13:13:11 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:13:11 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:13:11 --> Helper loaded: form_helper
INFO - 2019-04-09 13:13:11 --> Form Validation Class Initialized
INFO - 2019-04-09 13:13:11 --> Controller Class Initialized
INFO - 2019-04-09 13:13:11 --> Model "Common_model" initialized
INFO - 2019-04-09 13:13:11 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:13:11 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:13:11 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:13:29 --> Config Class Initialized
INFO - 2019-04-09 13:13:29 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:13:29 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:13:29 --> Utf8 Class Initialized
INFO - 2019-04-09 13:13:29 --> URI Class Initialized
INFO - 2019-04-09 13:13:29 --> Router Class Initialized
INFO - 2019-04-09 13:13:29 --> Output Class Initialized
INFO - 2019-04-09 13:13:29 --> Security Class Initialized
DEBUG - 2019-04-09 13:13:29 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:13:29 --> Input Class Initialized
INFO - 2019-04-09 13:13:29 --> Language Class Initialized
INFO - 2019-04-09 13:13:29 --> Loader Class Initialized
INFO - 2019-04-09 13:13:29 --> Helper loaded: url_helper
INFO - 2019-04-09 13:13:29 --> Helper loaded: file_helper
INFO - 2019-04-09 13:13:29 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:13:29 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:13:29 --> Database Driver Class Initialized
INFO - 2019-04-09 13:13:29 --> Email Class Initialized
DEBUG - 2019-04-09 13:13:29 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:13:30 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:13:30 --> Helper loaded: form_helper
INFO - 2019-04-09 13:13:30 --> Form Validation Class Initialized
INFO - 2019-04-09 13:13:30 --> Controller Class Initialized
INFO - 2019-04-09 13:13:30 --> Model "Common_model" initialized
INFO - 2019-04-09 13:13:30 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:13:30 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:13:30 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:13:30 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:13:30 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:13:30 --> Final output sent to browser
DEBUG - 2019-04-09 13:13:30 --> Total execution time: 0.2005
INFO - 2019-04-09 13:14:41 --> Config Class Initialized
INFO - 2019-04-09 13:14:41 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:14:41 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:14:41 --> Utf8 Class Initialized
INFO - 2019-04-09 13:14:41 --> URI Class Initialized
INFO - 2019-04-09 13:14:41 --> Router Class Initialized
INFO - 2019-04-09 13:14:41 --> Output Class Initialized
INFO - 2019-04-09 13:14:41 --> Security Class Initialized
DEBUG - 2019-04-09 13:14:41 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:14:41 --> Input Class Initialized
INFO - 2019-04-09 13:14:41 --> Language Class Initialized
INFO - 2019-04-09 13:14:41 --> Loader Class Initialized
INFO - 2019-04-09 13:14:41 --> Helper loaded: url_helper
INFO - 2019-04-09 13:14:41 --> Helper loaded: file_helper
INFO - 2019-04-09 13:14:41 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:14:41 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:14:41 --> Database Driver Class Initialized
INFO - 2019-04-09 13:14:41 --> Email Class Initialized
DEBUG - 2019-04-09 13:14:41 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:14:41 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:14:41 --> Helper loaded: form_helper
INFO - 2019-04-09 13:14:41 --> Form Validation Class Initialized
INFO - 2019-04-09 13:14:41 --> Controller Class Initialized
INFO - 2019-04-09 13:14:41 --> Model "Common_model" initialized
INFO - 2019-04-09 13:14:41 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:14:41 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:14:41 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:14:41 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:14:41 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:14:41 --> Final output sent to browser
DEBUG - 2019-04-09 13:14:41 --> Total execution time: 0.2284
INFO - 2019-04-09 13:15:54 --> Config Class Initialized
INFO - 2019-04-09 13:15:54 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:15:54 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:15:54 --> Utf8 Class Initialized
INFO - 2019-04-09 13:15:54 --> URI Class Initialized
INFO - 2019-04-09 13:15:54 --> Router Class Initialized
INFO - 2019-04-09 13:15:54 --> Output Class Initialized
INFO - 2019-04-09 13:15:54 --> Security Class Initialized
DEBUG - 2019-04-09 13:15:54 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:15:54 --> Input Class Initialized
INFO - 2019-04-09 13:15:54 --> Language Class Initialized
INFO - 2019-04-09 13:15:54 --> Loader Class Initialized
INFO - 2019-04-09 13:15:54 --> Helper loaded: url_helper
INFO - 2019-04-09 13:15:54 --> Helper loaded: file_helper
INFO - 2019-04-09 13:15:54 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:15:54 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:15:54 --> Database Driver Class Initialized
INFO - 2019-04-09 13:15:54 --> Email Class Initialized
DEBUG - 2019-04-09 13:15:54 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:15:54 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:15:54 --> Helper loaded: form_helper
INFO - 2019-04-09 13:15:54 --> Form Validation Class Initialized
INFO - 2019-04-09 13:15:54 --> Controller Class Initialized
INFO - 2019-04-09 13:15:54 --> Model "Common_model" initialized
INFO - 2019-04-09 13:15:54 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:15:54 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:15:54 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:15:54 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:15:54 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:15:54 --> Final output sent to browser
DEBUG - 2019-04-09 13:15:54 --> Total execution time: 0.1978
INFO - 2019-04-09 13:20:26 --> Config Class Initialized
INFO - 2019-04-09 13:20:26 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:26 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:26 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:26 --> URI Class Initialized
INFO - 2019-04-09 13:20:26 --> Router Class Initialized
INFO - 2019-04-09 13:20:26 --> Output Class Initialized
INFO - 2019-04-09 13:20:26 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:26 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:26 --> Input Class Initialized
INFO - 2019-04-09 13:20:26 --> Language Class Initialized
INFO - 2019-04-09 13:20:26 --> Loader Class Initialized
INFO - 2019-04-09 13:20:26 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:26 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:26 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:26 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:26 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:26 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:26 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:26 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:26 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:26 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:26 --> Controller Class Initialized
INFO - 2019-04-09 13:20:26 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:26 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:26 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:26 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:26 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:20:26 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:20:26 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:26 --> Total execution time: 0.2074
INFO - 2019-04-09 13:20:39 --> Config Class Initialized
INFO - 2019-04-09 13:20:39 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:39 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:39 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:39 --> URI Class Initialized
INFO - 2019-04-09 13:20:39 --> Router Class Initialized
INFO - 2019-04-09 13:20:39 --> Output Class Initialized
INFO - 2019-04-09 13:20:39 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:39 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:39 --> Input Class Initialized
INFO - 2019-04-09 13:20:39 --> Language Class Initialized
INFO - 2019-04-09 13:20:39 --> Loader Class Initialized
INFO - 2019-04-09 13:20:39 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:39 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:39 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:39 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:39 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:39 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:39 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:39 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:39 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:39 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:39 --> Controller Class Initialized
INFO - 2019-04-09 13:20:39 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:39 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:39 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:39 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:39 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinderCombineReport_1.php
INFO - 2019-04-09 13:20:39 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:20:39 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:39 --> Total execution time: 0.4217
INFO - 2019-04-09 13:20:43 --> Config Class Initialized
INFO - 2019-04-09 13:20:43 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:43 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:43 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:43 --> URI Class Initialized
INFO - 2019-04-09 13:20:43 --> Router Class Initialized
INFO - 2019-04-09 13:20:43 --> Output Class Initialized
INFO - 2019-04-09 13:20:43 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:43 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:43 --> Input Class Initialized
INFO - 2019-04-09 13:20:43 --> Language Class Initialized
INFO - 2019-04-09 13:20:43 --> Loader Class Initialized
INFO - 2019-04-09 13:20:43 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:43 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:43 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:43 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:43 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:43 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:43 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:43 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:43 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:43 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:43 --> Controller Class Initialized
INFO - 2019-04-09 13:20:43 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:43 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:43 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:43 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:43 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:43 --> Total execution time: 0.1529
INFO - 2019-04-09 13:20:49 --> Config Class Initialized
INFO - 2019-04-09 13:20:49 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:49 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:49 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:49 --> URI Class Initialized
INFO - 2019-04-09 13:20:49 --> Router Class Initialized
INFO - 2019-04-09 13:20:49 --> Output Class Initialized
INFO - 2019-04-09 13:20:49 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:49 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:49 --> Input Class Initialized
INFO - 2019-04-09 13:20:49 --> Language Class Initialized
INFO - 2019-04-09 13:20:49 --> Loader Class Initialized
INFO - 2019-04-09 13:20:49 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:49 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:49 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:49 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:49 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:49 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:49 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:49 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:49 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:49 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:49 --> Controller Class Initialized
INFO - 2019-04-09 13:20:49 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:49 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:49 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:49 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:49 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinderCombineReport_1.php
INFO - 2019-04-09 13:20:49 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:20:49 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:49 --> Total execution time: 0.1817
INFO - 2019-04-09 13:20:49 --> Config Class Initialized
INFO - 2019-04-09 13:20:49 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:49 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:49 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:49 --> URI Class Initialized
INFO - 2019-04-09 13:20:49 --> Router Class Initialized
INFO - 2019-04-09 13:20:49 --> Output Class Initialized
INFO - 2019-04-09 13:20:49 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:49 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:49 --> Input Class Initialized
INFO - 2019-04-09 13:20:49 --> Language Class Initialized
INFO - 2019-04-09 13:20:49 --> Loader Class Initialized
INFO - 2019-04-09 13:20:49 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:49 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:49 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:49 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:49 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:49 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:49 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:49 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:49 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:49 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:49 --> Controller Class Initialized
INFO - 2019-04-09 13:20:49 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:49 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:49 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:49 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:49 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:49 --> Total execution time: 0.1870
INFO - 2019-04-09 13:20:53 --> Config Class Initialized
INFO - 2019-04-09 13:20:53 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:53 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:53 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:53 --> URI Class Initialized
INFO - 2019-04-09 13:20:53 --> Router Class Initialized
INFO - 2019-04-09 13:20:53 --> Output Class Initialized
INFO - 2019-04-09 13:20:53 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:53 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:53 --> Input Class Initialized
INFO - 2019-04-09 13:20:53 --> Language Class Initialized
INFO - 2019-04-09 13:20:53 --> Loader Class Initialized
INFO - 2019-04-09 13:20:53 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:53 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:53 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:53 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:53 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:53 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:53 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:53 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:53 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:53 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:53 --> Controller Class Initialized
INFO - 2019-04-09 13:20:53 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:53 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:53 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:53 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:53 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinderCombineReport_1.php
INFO - 2019-04-09 13:20:53 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:20:53 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:53 --> Total execution time: 0.2035
INFO - 2019-04-09 13:20:54 --> Config Class Initialized
INFO - 2019-04-09 13:20:54 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:54 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:54 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:54 --> URI Class Initialized
INFO - 2019-04-09 13:20:54 --> Router Class Initialized
INFO - 2019-04-09 13:20:54 --> Output Class Initialized
INFO - 2019-04-09 13:20:54 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:54 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:54 --> Input Class Initialized
INFO - 2019-04-09 13:20:54 --> Language Class Initialized
INFO - 2019-04-09 13:20:54 --> Loader Class Initialized
INFO - 2019-04-09 13:20:54 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:54 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:54 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:54 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:54 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:54 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:54 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:54 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:54 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:54 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:54 --> Controller Class Initialized
INFO - 2019-04-09 13:20:54 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:54 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:54 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:54 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:54 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:54 --> Total execution time: 0.1891
INFO - 2019-04-09 13:20:57 --> Config Class Initialized
INFO - 2019-04-09 13:20:57 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:57 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:57 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:57 --> URI Class Initialized
INFO - 2019-04-09 13:20:57 --> Router Class Initialized
INFO - 2019-04-09 13:20:57 --> Output Class Initialized
INFO - 2019-04-09 13:20:57 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:57 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:57 --> Input Class Initialized
INFO - 2019-04-09 13:20:57 --> Language Class Initialized
INFO - 2019-04-09 13:20:57 --> Loader Class Initialized
INFO - 2019-04-09 13:20:57 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:57 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:57 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:57 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:57 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:57 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:57 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:57 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:57 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:57 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:57 --> Controller Class Initialized
INFO - 2019-04-09 13:20:57 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:57 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:57 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:57 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:57 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinderCombineReport_1.php
INFO - 2019-04-09 13:20:57 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:20:57 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:58 --> Total execution time: 0.1930
INFO - 2019-04-09 13:20:58 --> Config Class Initialized
INFO - 2019-04-09 13:20:58 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:20:58 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:20:58 --> Utf8 Class Initialized
INFO - 2019-04-09 13:20:58 --> URI Class Initialized
INFO - 2019-04-09 13:20:58 --> Router Class Initialized
INFO - 2019-04-09 13:20:58 --> Output Class Initialized
INFO - 2019-04-09 13:20:58 --> Security Class Initialized
DEBUG - 2019-04-09 13:20:58 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:20:58 --> Input Class Initialized
INFO - 2019-04-09 13:20:58 --> Language Class Initialized
INFO - 2019-04-09 13:20:58 --> Loader Class Initialized
INFO - 2019-04-09 13:20:58 --> Helper loaded: url_helper
INFO - 2019-04-09 13:20:58 --> Helper loaded: file_helper
INFO - 2019-04-09 13:20:58 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:20:58 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:20:58 --> Database Driver Class Initialized
INFO - 2019-04-09 13:20:58 --> Email Class Initialized
DEBUG - 2019-04-09 13:20:58 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:20:58 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:20:58 --> Helper loaded: form_helper
INFO - 2019-04-09 13:20:58 --> Form Validation Class Initialized
INFO - 2019-04-09 13:20:58 --> Controller Class Initialized
INFO - 2019-04-09 13:20:58 --> Model "Common_model" initialized
INFO - 2019-04-09 13:20:58 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:20:58 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:20:58 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:20:58 --> Final output sent to browser
DEBUG - 2019-04-09 13:20:58 --> Total execution time: 0.1877
INFO - 2019-04-09 13:21:00 --> Config Class Initialized
INFO - 2019-04-09 13:21:00 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:21:00 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:21:00 --> Utf8 Class Initialized
INFO - 2019-04-09 13:21:00 --> URI Class Initialized
INFO - 2019-04-09 13:21:00 --> Router Class Initialized
INFO - 2019-04-09 13:21:00 --> Output Class Initialized
INFO - 2019-04-09 13:21:00 --> Security Class Initialized
DEBUG - 2019-04-09 13:21:00 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:21:00 --> Input Class Initialized
INFO - 2019-04-09 13:21:00 --> Language Class Initialized
INFO - 2019-04-09 13:21:00 --> Loader Class Initialized
INFO - 2019-04-09 13:21:00 --> Helper loaded: url_helper
INFO - 2019-04-09 13:21:00 --> Helper loaded: file_helper
INFO - 2019-04-09 13:21:00 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:21:00 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:21:00 --> Database Driver Class Initialized
INFO - 2019-04-09 13:21:00 --> Email Class Initialized
DEBUG - 2019-04-09 13:21:00 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:21:00 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:21:00 --> Helper loaded: form_helper
INFO - 2019-04-09 13:21:00 --> Form Validation Class Initialized
INFO - 2019-04-09 13:21:00 --> Controller Class Initialized
INFO - 2019-04-09 13:21:00 --> Model "Common_model" initialized
INFO - 2019-04-09 13:21:00 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:21:00 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:21:00 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:21:00 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinderCombineReport_1.php
INFO - 2019-04-09 13:21:00 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:21:00 --> Final output sent to browser
DEBUG - 2019-04-09 13:21:00 --> Total execution time: 0.2127
INFO - 2019-04-09 13:21:01 --> Config Class Initialized
INFO - 2019-04-09 13:21:01 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:21:01 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:21:01 --> Utf8 Class Initialized
INFO - 2019-04-09 13:21:01 --> URI Class Initialized
INFO - 2019-04-09 13:21:01 --> Router Class Initialized
INFO - 2019-04-09 13:21:01 --> Output Class Initialized
INFO - 2019-04-09 13:21:01 --> Security Class Initialized
DEBUG - 2019-04-09 13:21:01 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:21:01 --> Input Class Initialized
INFO - 2019-04-09 13:21:01 --> Language Class Initialized
INFO - 2019-04-09 13:21:01 --> Loader Class Initialized
INFO - 2019-04-09 13:21:01 --> Helper loaded: url_helper
INFO - 2019-04-09 13:21:01 --> Helper loaded: file_helper
INFO - 2019-04-09 13:21:01 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:21:01 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:21:01 --> Database Driver Class Initialized
INFO - 2019-04-09 13:21:01 --> Email Class Initialized
DEBUG - 2019-04-09 13:21:01 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:21:01 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:21:01 --> Helper loaded: form_helper
INFO - 2019-04-09 13:21:01 --> Form Validation Class Initialized
INFO - 2019-04-09 13:21:01 --> Controller Class Initialized
INFO - 2019-04-09 13:21:01 --> Model "Common_model" initialized
INFO - 2019-04-09 13:21:01 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:21:01 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:21:01 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:21:01 --> Final output sent to browser
DEBUG - 2019-04-09 13:21:01 --> Total execution time: 0.2052
INFO - 2019-04-09 13:23:56 --> Config Class Initialized
INFO - 2019-04-09 13:23:56 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:23:56 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:23:56 --> Utf8 Class Initialized
INFO - 2019-04-09 13:23:56 --> URI Class Initialized
INFO - 2019-04-09 13:23:56 --> Router Class Initialized
INFO - 2019-04-09 13:23:56 --> Output Class Initialized
INFO - 2019-04-09 13:23:56 --> Security Class Initialized
DEBUG - 2019-04-09 13:23:56 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:23:56 --> Input Class Initialized
INFO - 2019-04-09 13:23:56 --> Language Class Initialized
INFO - 2019-04-09 13:23:56 --> Loader Class Initialized
INFO - 2019-04-09 13:23:56 --> Helper loaded: url_helper
INFO - 2019-04-09 13:23:56 --> Helper loaded: file_helper
INFO - 2019-04-09 13:23:56 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:23:56 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:23:56 --> Database Driver Class Initialized
INFO - 2019-04-09 13:23:56 --> Email Class Initialized
DEBUG - 2019-04-09 13:23:56 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:23:56 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:23:56 --> Helper loaded: form_helper
INFO - 2019-04-09 13:23:56 --> Form Validation Class Initialized
INFO - 2019-04-09 13:23:56 --> Controller Class Initialized
INFO - 2019-04-09 13:23:56 --> Model "Common_model" initialized
INFO - 2019-04-09 13:23:56 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:23:56 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:23:56 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:23:56 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:23:56 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:23:56 --> Final output sent to browser
DEBUG - 2019-04-09 13:23:56 --> Total execution time: 0.1861
INFO - 2019-04-09 13:23:59 --> Config Class Initialized
INFO - 2019-04-09 13:23:59 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:23:59 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:23:59 --> Utf8 Class Initialized
INFO - 2019-04-09 13:23:59 --> URI Class Initialized
INFO - 2019-04-09 13:23:59 --> Router Class Initialized
INFO - 2019-04-09 13:23:59 --> Output Class Initialized
INFO - 2019-04-09 13:23:59 --> Security Class Initialized
DEBUG - 2019-04-09 13:23:59 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:23:59 --> Input Class Initialized
INFO - 2019-04-09 13:23:59 --> Language Class Initialized
INFO - 2019-04-09 13:23:59 --> Loader Class Initialized
INFO - 2019-04-09 13:23:59 --> Helper loaded: url_helper
INFO - 2019-04-09 13:23:59 --> Helper loaded: file_helper
INFO - 2019-04-09 13:23:59 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:23:59 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:23:59 --> Database Driver Class Initialized
INFO - 2019-04-09 13:23:59 --> Email Class Initialized
DEBUG - 2019-04-09 13:23:59 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:23:59 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:23:59 --> Helper loaded: form_helper
INFO - 2019-04-09 13:23:59 --> Form Validation Class Initialized
INFO - 2019-04-09 13:23:59 --> Controller Class Initialized
INFO - 2019-04-09 13:23:59 --> Model "Common_model" initialized
INFO - 2019-04-09 13:23:59 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:23:59 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:23:59 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:23:59 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:23:59 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:23:59 --> Final output sent to browser
DEBUG - 2019-04-09 13:23:59 --> Total execution time: 0.1895
INFO - 2019-04-09 13:24:01 --> Config Class Initialized
INFO - 2019-04-09 13:24:01 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:24:01 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:24:01 --> Utf8 Class Initialized
INFO - 2019-04-09 13:24:01 --> URI Class Initialized
INFO - 2019-04-09 13:24:01 --> Router Class Initialized
INFO - 2019-04-09 13:24:01 --> Output Class Initialized
INFO - 2019-04-09 13:24:01 --> Security Class Initialized
DEBUG - 2019-04-09 13:24:01 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:24:01 --> Input Class Initialized
INFO - 2019-04-09 13:24:01 --> Language Class Initialized
ERROR - 2019-04-09 13:24:01 --> 404 Page Not Found: Assets/js
INFO - 2019-04-09 13:24:19 --> Config Class Initialized
INFO - 2019-04-09 13:24:19 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:24:19 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:24:19 --> Utf8 Class Initialized
INFO - 2019-04-09 13:24:19 --> URI Class Initialized
INFO - 2019-04-09 13:24:19 --> Router Class Initialized
INFO - 2019-04-09 13:24:19 --> Output Class Initialized
INFO - 2019-04-09 13:24:19 --> Security Class Initialized
DEBUG - 2019-04-09 13:24:19 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:24:19 --> Input Class Initialized
INFO - 2019-04-09 13:24:19 --> Language Class Initialized
INFO - 2019-04-09 13:24:19 --> Loader Class Initialized
INFO - 2019-04-09 13:24:19 --> Helper loaded: url_helper
INFO - 2019-04-09 13:24:19 --> Helper loaded: file_helper
INFO - 2019-04-09 13:24:19 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:24:19 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:24:19 --> Database Driver Class Initialized
INFO - 2019-04-09 13:24:19 --> Email Class Initialized
DEBUG - 2019-04-09 13:24:19 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:24:19 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:24:19 --> Helper loaded: form_helper
INFO - 2019-04-09 13:24:19 --> Form Validation Class Initialized
INFO - 2019-04-09 13:24:19 --> Controller Class Initialized
INFO - 2019-04-09 13:24:19 --> Model "Common_model" initialized
INFO - 2019-04-09 13:24:19 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:24:19 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:24:19 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:24:19 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:24:19 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:24:19 --> Final output sent to browser
DEBUG - 2019-04-09 13:24:19 --> Total execution time: 0.2118
INFO - 2019-04-09 13:24:20 --> Config Class Initialized
INFO - 2019-04-09 13:24:20 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:24:20 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:24:20 --> Utf8 Class Initialized
INFO - 2019-04-09 13:24:20 --> URI Class Initialized
INFO - 2019-04-09 13:24:20 --> Router Class Initialized
INFO - 2019-04-09 13:24:20 --> Output Class Initialized
INFO - 2019-04-09 13:24:20 --> Security Class Initialized
DEBUG - 2019-04-09 13:24:20 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:24:20 --> Input Class Initialized
INFO - 2019-04-09 13:24:20 --> Language Class Initialized
ERROR - 2019-04-09 13:24:20 --> 404 Page Not Found: Assets/js
INFO - 2019-04-09 13:24:45 --> Config Class Initialized
INFO - 2019-04-09 13:24:45 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:24:45 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:24:45 --> Utf8 Class Initialized
INFO - 2019-04-09 13:24:45 --> URI Class Initialized
INFO - 2019-04-09 13:24:45 --> Router Class Initialized
INFO - 2019-04-09 13:24:45 --> Output Class Initialized
INFO - 2019-04-09 13:24:45 --> Security Class Initialized
DEBUG - 2019-04-09 13:24:45 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:24:45 --> Input Class Initialized
INFO - 2019-04-09 13:24:45 --> Language Class Initialized
INFO - 2019-04-09 13:24:45 --> Loader Class Initialized
INFO - 2019-04-09 13:24:45 --> Helper loaded: url_helper
INFO - 2019-04-09 13:24:45 --> Helper loaded: file_helper
INFO - 2019-04-09 13:24:45 --> Helper loaded: utility_helper
INFO - 2019-04-09 13:24:45 --> Helper loaded: unit_helper
INFO - 2019-04-09 13:24:45 --> Database Driver Class Initialized
INFO - 2019-04-09 13:24:45 --> Email Class Initialized
DEBUG - 2019-04-09 13:24:45 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 13:24:45 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 13:24:45 --> Helper loaded: form_helper
INFO - 2019-04-09 13:24:45 --> Form Validation Class Initialized
INFO - 2019-04-09 13:24:45 --> Controller Class Initialized
INFO - 2019-04-09 13:24:45 --> Model "Common_model" initialized
INFO - 2019-04-09 13:24:45 --> Model "Finane_Model" initialized
INFO - 2019-04-09 13:24:45 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 13:24:45 --> Model "Sales_Model" initialized
INFO - 2019-04-09 13:24:45 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 13:24:45 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 13:24:45 --> Final output sent to browser
DEBUG - 2019-04-09 13:24:45 --> Total execution time: 0.2636
INFO - 2019-04-09 13:24:46 --> Config Class Initialized
INFO - 2019-04-09 13:24:46 --> Hooks Class Initialized
DEBUG - 2019-04-09 13:24:46 --> UTF-8 Support Enabled
INFO - 2019-04-09 13:24:46 --> Utf8 Class Initialized
INFO - 2019-04-09 13:24:46 --> URI Class Initialized
INFO - 2019-04-09 13:24:46 --> Router Class Initialized
INFO - 2019-04-09 13:24:46 --> Output Class Initialized
INFO - 2019-04-09 13:24:46 --> Security Class Initialized
DEBUG - 2019-04-09 13:24:46 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 13:24:46 --> Input Class Initialized
INFO - 2019-04-09 13:24:46 --> Language Class Initialized
ERROR - 2019-04-09 13:24:46 --> 404 Page Not Found: Assets/js
INFO - 2019-04-09 15:26:20 --> Config Class Initialized
INFO - 2019-04-09 15:26:20 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:20 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:20 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:20 --> URI Class Initialized
INFO - 2019-04-09 15:26:20 --> Router Class Initialized
INFO - 2019-04-09 15:26:20 --> Output Class Initialized
INFO - 2019-04-09 15:26:20 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:20 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:20 --> Input Class Initialized
INFO - 2019-04-09 15:26:20 --> Language Class Initialized
INFO - 2019-04-09 15:26:20 --> Loader Class Initialized
INFO - 2019-04-09 15:26:20 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:20 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:20 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:20 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:21 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:21 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:21 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:21 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:21 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:21 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:21 --> Controller Class Initialized
INFO - 2019-04-09 15:26:21 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:21 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:21 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:21 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:21 --> Config Class Initialized
INFO - 2019-04-09 15:26:21 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:21 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:21 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:21 --> URI Class Initialized
DEBUG - 2019-04-09 15:26:21 --> No URI present. Default controller set.
INFO - 2019-04-09 15:26:21 --> Router Class Initialized
INFO - 2019-04-09 15:26:21 --> Output Class Initialized
INFO - 2019-04-09 15:26:21 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:21 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:21 --> Input Class Initialized
INFO - 2019-04-09 15:26:21 --> Language Class Initialized
INFO - 2019-04-09 15:26:21 --> Loader Class Initialized
INFO - 2019-04-09 15:26:21 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:21 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:21 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:21 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:21 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:21 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:21 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:21 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:21 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:21 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:21 --> Controller Class Initialized
INFO - 2019-04-09 15:26:21 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:21 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:21 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:21 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:21 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\auth/login.php
INFO - 2019-04-09 15:26:21 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:21 --> Total execution time: 0.1828
INFO - 2019-04-09 15:26:22 --> Config Class Initialized
INFO - 2019-04-09 15:26:22 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:22 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:22 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:22 --> URI Class Initialized
INFO - 2019-04-09 15:26:22 --> Router Class Initialized
INFO - 2019-04-09 15:26:22 --> Output Class Initialized
INFO - 2019-04-09 15:26:22 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:22 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:22 --> Input Class Initialized
INFO - 2019-04-09 15:26:22 --> Language Class Initialized
ERROR - 2019-04-09 15:26:22 --> 404 Page Not Found: Assets/vendor
INFO - 2019-04-09 15:26:23 --> Config Class Initialized
INFO - 2019-04-09 15:26:23 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:23 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:23 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:23 --> URI Class Initialized
INFO - 2019-04-09 15:26:23 --> Router Class Initialized
INFO - 2019-04-09 15:26:23 --> Output Class Initialized
INFO - 2019-04-09 15:26:23 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:23 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:23 --> Input Class Initialized
INFO - 2019-04-09 15:26:23 --> Language Class Initialized
INFO - 2019-04-09 15:26:23 --> Loader Class Initialized
INFO - 2019-04-09 15:26:23 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:23 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:23 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:23 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:23 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:23 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:23 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:23 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:23 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:23 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:23 --> Controller Class Initialized
INFO - 2019-04-09 15:26:23 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:23 --> Config Class Initialized
INFO - 2019-04-09 15:26:23 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:23 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:23 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:23 --> URI Class Initialized
INFO - 2019-04-09 15:26:23 --> Router Class Initialized
INFO - 2019-04-09 15:26:23 --> Output Class Initialized
INFO - 2019-04-09 15:26:23 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:23 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:23 --> Input Class Initialized
INFO - 2019-04-09 15:26:23 --> Language Class Initialized
INFO - 2019-04-09 15:26:23 --> Loader Class Initialized
INFO - 2019-04-09 15:26:23 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:23 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:23 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:23 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:23 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:23 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:23 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:23 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:23 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:23 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:23 --> Controller Class Initialized
INFO - 2019-04-09 15:26:23 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:23 --> Model "Dashboard_Model" initialized
INFO - 2019-04-09 15:26:23 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/module.php
INFO - 2019-04-09 15:26:23 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterTemplate.php
INFO - 2019-04-09 15:26:24 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:24 --> Total execution time: 0.3733
INFO - 2019-04-09 15:26:24 --> Config Class Initialized
INFO - 2019-04-09 15:26:24 --> Hooks Class Initialized
INFO - 2019-04-09 15:26:24 --> Config Class Initialized
DEBUG - 2019-04-09 15:26:24 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:24 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:24 --> Config Class Initialized
INFO - 2019-04-09 15:26:24 --> Hooks Class Initialized
INFO - 2019-04-09 15:26:24 --> Hooks Class Initialized
INFO - 2019-04-09 15:26:24 --> URI Class Initialized
DEBUG - 2019-04-09 15:26:24 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:24 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:24 --> Router Class Initialized
DEBUG - 2019-04-09 15:26:24 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:24 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:24 --> URI Class Initialized
INFO - 2019-04-09 15:26:24 --> Output Class Initialized
INFO - 2019-04-09 15:26:24 --> Security Class Initialized
INFO - 2019-04-09 15:26:24 --> URI Class Initialized
INFO - 2019-04-09 15:26:24 --> Router Class Initialized
DEBUG - 2019-04-09 15:26:24 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:24 --> Output Class Initialized
INFO - 2019-04-09 15:26:24 --> Config Class Initialized
INFO - 2019-04-09 15:26:24 --> Input Class Initialized
INFO - 2019-04-09 15:26:24 --> Security Class Initialized
INFO - 2019-04-09 15:26:24 --> Router Class Initialized
INFO - 2019-04-09 15:26:24 --> Hooks Class Initialized
INFO - 2019-04-09 15:26:24 --> Language Class Initialized
DEBUG - 2019-04-09 15:26:24 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:24 --> Output Class Initialized
INFO - 2019-04-09 15:26:24 --> Input Class Initialized
INFO - 2019-04-09 15:26:24 --> Loader Class Initialized
DEBUG - 2019-04-09 15:26:24 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:24 --> Security Class Initialized
INFO - 2019-04-09 15:26:24 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:24 --> Language Class Initialized
INFO - 2019-04-09 15:26:24 --> Helper loaded: url_helper
DEBUG - 2019-04-09 15:26:24 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:24 --> Input Class Initialized
INFO - 2019-04-09 15:26:24 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:24 --> Loader Class Initialized
INFO - 2019-04-09 15:26:24 --> URI Class Initialized
INFO - 2019-04-09 15:26:24 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:24 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:24 --> Language Class Initialized
INFO - 2019-04-09 15:26:24 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:24 --> Router Class Initialized
INFO - 2019-04-09 15:26:24 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:24 --> Loader Class Initialized
INFO - 2019-04-09 15:26:24 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:24 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:24 --> Output Class Initialized
INFO - 2019-04-09 15:26:24 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:25 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:25 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:25 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:25 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:25 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:25 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:25 --> Email Class Initialized
INFO - 2019-04-09 15:26:25 --> Input Class Initialized
INFO - 2019-04-09 15:26:25 --> Helper loaded: unit_helper
DEBUG - 2019-04-09 15:26:25 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:25 --> Email Class Initialized
INFO - 2019-04-09 15:26:25 --> Language Class Initialized
DEBUG - 2019-04-09 15:26:25 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:25 --> Session: Class initialized using 'files' driver.
ERROR - 2019-04-09 15:26:25 --> 404 Page Not Found: Assets/js
INFO - 2019-04-09 15:26:25 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:25 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:25 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:25 --> Controller Class Initialized
INFO - 2019-04-09 15:26:25 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:25 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:25 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Dashboard_Model" initialized
ERROR - 2019-04-09 15:26:25 --> Severity: Warning --> Invalid argument supplied for foreach() E:\xampp\htdocs\aelErp_master_2\application\views\distributor\ajax\showTodaySummary.php 224
INFO - 2019-04-09 15:26:25 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/ajax/showTodaySummary.php
INFO - 2019-04-09 15:26:25 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:25 --> Total execution time: 0.4496
INFO - 2019-04-09 15:26:25 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:25 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:25 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:25 --> Controller Class Initialized
INFO - 2019-04-09 15:26:25 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Dashboard_Model" initialized
INFO - 2019-04-09 15:26:25 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/ajax/companySummary.php
INFO - 2019-04-09 15:26:25 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:25 --> Total execution time: 0.6089
INFO - 2019-04-09 15:26:25 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:25 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:25 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:25 --> Controller Class Initialized
INFO - 2019-04-09 15:26:25 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:25 --> Model "Dashboard_Model" initialized
INFO - 2019-04-09 15:26:25 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/ajax/incentive.php
INFO - 2019-04-09 15:26:25 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:25 --> Total execution time: 0.7436
INFO - 2019-04-09 15:26:27 --> Config Class Initialized
INFO - 2019-04-09 15:26:27 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:27 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:27 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:27 --> URI Class Initialized
INFO - 2019-04-09 15:26:27 --> Router Class Initialized
INFO - 2019-04-09 15:26:27 --> Output Class Initialized
INFO - 2019-04-09 15:26:27 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:27 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:27 --> Input Class Initialized
INFO - 2019-04-09 15:26:27 --> Language Class Initialized
INFO - 2019-04-09 15:26:27 --> Loader Class Initialized
INFO - 2019-04-09 15:26:27 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:27 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:27 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:27 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:27 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:27 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:27 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:27 --> Controller Class Initialized
INFO - 2019-04-09 15:26:27 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Dashboard_Model" initialized
INFO - 2019-04-09 15:26:27 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/dashboard.php
INFO - 2019-04-09 15:26:27 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 15:26:27 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:27 --> Total execution time: 0.4243
INFO - 2019-04-09 15:26:27 --> Config Class Initialized
INFO - 2019-04-09 15:26:27 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:27 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:27 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:27 --> URI Class Initialized
INFO - 2019-04-09 15:26:27 --> Router Class Initialized
INFO - 2019-04-09 15:26:27 --> Output Class Initialized
INFO - 2019-04-09 15:26:27 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:27 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:27 --> Input Class Initialized
INFO - 2019-04-09 15:26:27 --> Language Class Initialized
ERROR - 2019-04-09 15:26:27 --> 404 Page Not Found: DistributorDashboard/assets
INFO - 2019-04-09 15:26:27 --> Config Class Initialized
INFO - 2019-04-09 15:26:27 --> Config Class Initialized
INFO - 2019-04-09 15:26:27 --> Config Class Initialized
INFO - 2019-04-09 15:26:27 --> Hooks Class Initialized
INFO - 2019-04-09 15:26:27 --> Hooks Class Initialized
INFO - 2019-04-09 15:26:27 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:27 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:27 --> Utf8 Class Initialized
DEBUG - 2019-04-09 15:26:27 --> UTF-8 Support Enabled
DEBUG - 2019-04-09 15:26:27 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:27 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:27 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:27 --> URI Class Initialized
INFO - 2019-04-09 15:26:27 --> URI Class Initialized
INFO - 2019-04-09 15:26:27 --> URI Class Initialized
INFO - 2019-04-09 15:26:27 --> Router Class Initialized
INFO - 2019-04-09 15:26:27 --> Output Class Initialized
INFO - 2019-04-09 15:26:27 --> Router Class Initialized
INFO - 2019-04-09 15:26:27 --> Router Class Initialized
INFO - 2019-04-09 15:26:27 --> Security Class Initialized
INFO - 2019-04-09 15:26:27 --> Output Class Initialized
INFO - 2019-04-09 15:26:27 --> Output Class Initialized
INFO - 2019-04-09 15:26:27 --> Security Class Initialized
INFO - 2019-04-09 15:26:27 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:27 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:27 --> Input Class Initialized
DEBUG - 2019-04-09 15:26:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2019-04-09 15:26:27 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:27 --> Input Class Initialized
INFO - 2019-04-09 15:26:27 --> Input Class Initialized
INFO - 2019-04-09 15:26:27 --> Language Class Initialized
INFO - 2019-04-09 15:26:27 --> Language Class Initialized
INFO - 2019-04-09 15:26:27 --> Language Class Initialized
INFO - 2019-04-09 15:26:27 --> Loader Class Initialized
INFO - 2019-04-09 15:26:27 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:27 --> Loader Class Initialized
INFO - 2019-04-09 15:26:27 --> Loader Class Initialized
INFO - 2019-04-09 15:26:27 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:27 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:27 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:27 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:27 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:27 --> Email Class Initialized
INFO - 2019-04-09 15:26:27 --> Email Class Initialized
INFO - 2019-04-09 15:26:27 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:27 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
DEBUG - 2019-04-09 15:26:27 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
DEBUG - 2019-04-09 15:26:27 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:27 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:27 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:27 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:27 --> Controller Class Initialized
INFO - 2019-04-09 15:26:27 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:27 --> Model "Dashboard_Model" initialized
ERROR - 2019-04-09 15:26:27 --> Severity: Warning --> Invalid argument supplied for foreach() E:\xampp\htdocs\aelErp_master_2\application\views\distributor\ajax\showTodaySummary.php 224
INFO - 2019-04-09 15:26:27 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/ajax/showTodaySummary.php
INFO - 2019-04-09 15:26:27 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:27 --> Total execution time: 0.2353
INFO - 2019-04-09 15:26:27 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:28 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:28 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:28 --> Controller Class Initialized
INFO - 2019-04-09 15:26:28 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Dashboard_Model" initialized
INFO - 2019-04-09 15:26:28 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/ajax/incentive.php
INFO - 2019-04-09 15:26:28 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:28 --> Total execution time: 0.3010
INFO - 2019-04-09 15:26:28 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:28 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:28 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:28 --> Controller Class Initialized
INFO - 2019-04-09 15:26:28 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:28 --> Model "Dashboard_Model" initialized
INFO - 2019-04-09 15:26:28 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/ajax/companySummary.php
INFO - 2019-04-09 15:26:28 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:28 --> Total execution time: 0.4125
INFO - 2019-04-09 15:26:29 --> Config Class Initialized
INFO - 2019-04-09 15:26:29 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:29 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:29 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:29 --> URI Class Initialized
INFO - 2019-04-09 15:26:29 --> Router Class Initialized
INFO - 2019-04-09 15:26:29 --> Output Class Initialized
INFO - 2019-04-09 15:26:29 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:29 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:29 --> Input Class Initialized
INFO - 2019-04-09 15:26:29 --> Language Class Initialized
INFO - 2019-04-09 15:26:29 --> Loader Class Initialized
INFO - 2019-04-09 15:26:29 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:29 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:29 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:29 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:29 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:30 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:30 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:30 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:30 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:30 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:30 --> Controller Class Initialized
INFO - 2019-04-09 15:26:30 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:30 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:30 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:30 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:30 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_report.php
INFO - 2019-04-09 15:26:30 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 15:26:30 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:30 --> Total execution time: 0.2481
INFO - 2019-04-09 15:26:32 --> Config Class Initialized
INFO - 2019-04-09 15:26:32 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:32 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:32 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:32 --> URI Class Initialized
INFO - 2019-04-09 15:26:32 --> Router Class Initialized
INFO - 2019-04-09 15:26:32 --> Output Class Initialized
INFO - 2019-04-09 15:26:32 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:32 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:32 --> Input Class Initialized
INFO - 2019-04-09 15:26:32 --> Language Class Initialized
INFO - 2019-04-09 15:26:32 --> Loader Class Initialized
INFO - 2019-04-09 15:26:32 --> Helper loaded: url_helper
INFO - 2019-04-09 15:26:32 --> Helper loaded: file_helper
INFO - 2019-04-09 15:26:32 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:26:32 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:26:32 --> Database Driver Class Initialized
INFO - 2019-04-09 15:26:32 --> Email Class Initialized
DEBUG - 2019-04-09 15:26:32 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:26:32 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:26:32 --> Helper loaded: form_helper
INFO - 2019-04-09 15:26:32 --> Form Validation Class Initialized
INFO - 2019-04-09 15:26:32 --> Controller Class Initialized
INFO - 2019-04-09 15:26:32 --> Model "Common_model" initialized
INFO - 2019-04-09 15:26:32 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:26:32 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:26:32 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:26:32 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_report.php
INFO - 2019-04-09 15:26:32 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 15:26:32 --> Final output sent to browser
DEBUG - 2019-04-09 15:26:32 --> Total execution time: 0.2415
INFO - 2019-04-09 15:26:48 --> Config Class Initialized
INFO - 2019-04-09 15:26:48 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:26:48 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:26:48 --> Utf8 Class Initialized
INFO - 2019-04-09 15:26:48 --> URI Class Initialized
INFO - 2019-04-09 15:26:48 --> Router Class Initialized
INFO - 2019-04-09 15:26:48 --> Output Class Initialized
INFO - 2019-04-09 15:26:48 --> Security Class Initialized
DEBUG - 2019-04-09 15:26:48 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:26:48 --> Input Class Initialized
INFO - 2019-04-09 15:26:48 --> Language Class Initialized
ERROR - 2019-04-09 15:26:48 --> 404 Page Not Found: Cylinder_stock_group_report/index
INFO - 2019-04-09 15:27:11 --> Config Class Initialized
INFO - 2019-04-09 15:27:11 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:27:11 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:27:11 --> Utf8 Class Initialized
INFO - 2019-04-09 15:27:11 --> URI Class Initialized
INFO - 2019-04-09 15:27:11 --> Router Class Initialized
INFO - 2019-04-09 15:27:11 --> Output Class Initialized
INFO - 2019-04-09 15:27:11 --> Security Class Initialized
DEBUG - 2019-04-09 15:27:11 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:27:11 --> Input Class Initialized
INFO - 2019-04-09 15:27:11 --> Language Class Initialized
INFO - 2019-04-09 15:27:11 --> Loader Class Initialized
INFO - 2019-04-09 15:27:11 --> Helper loaded: url_helper
INFO - 2019-04-09 15:27:11 --> Helper loaded: file_helper
INFO - 2019-04-09 15:27:11 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:27:11 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:27:11 --> Database Driver Class Initialized
INFO - 2019-04-09 15:27:11 --> Email Class Initialized
DEBUG - 2019-04-09 15:27:11 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:27:11 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:27:11 --> Helper loaded: form_helper
INFO - 2019-04-09 15:27:11 --> Form Validation Class Initialized
INFO - 2019-04-09 15:27:11 --> Controller Class Initialized
INFO - 2019-04-09 15:27:11 --> Model "Common_model" initialized
INFO - 2019-04-09 15:27:11 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:27:11 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:27:11 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:27:11 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 15:27:11 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 15:27:11 --> Final output sent to browser
DEBUG - 2019-04-09 15:27:11 --> Total execution time: 0.3274
INFO - 2019-04-09 15:27:14 --> Config Class Initialized
INFO - 2019-04-09 15:27:14 --> Hooks Class Initialized
DEBUG - 2019-04-09 15:27:14 --> UTF-8 Support Enabled
INFO - 2019-04-09 15:27:14 --> Utf8 Class Initialized
INFO - 2019-04-09 15:27:14 --> URI Class Initialized
INFO - 2019-04-09 15:27:14 --> Router Class Initialized
INFO - 2019-04-09 15:27:14 --> Output Class Initialized
INFO - 2019-04-09 15:27:14 --> Security Class Initialized
DEBUG - 2019-04-09 15:27:14 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 15:27:14 --> Input Class Initialized
INFO - 2019-04-09 15:27:14 --> Language Class Initialized
INFO - 2019-04-09 15:27:14 --> Loader Class Initialized
INFO - 2019-04-09 15:27:14 --> Helper loaded: url_helper
INFO - 2019-04-09 15:27:14 --> Helper loaded: file_helper
INFO - 2019-04-09 15:27:14 --> Helper loaded: utility_helper
INFO - 2019-04-09 15:27:14 --> Helper loaded: unit_helper
INFO - 2019-04-09 15:27:14 --> Database Driver Class Initialized
INFO - 2019-04-09 15:27:14 --> Email Class Initialized
DEBUG - 2019-04-09 15:27:14 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 15:27:14 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 15:27:14 --> Helper loaded: form_helper
INFO - 2019-04-09 15:27:14 --> Form Validation Class Initialized
INFO - 2019-04-09 15:27:14 --> Controller Class Initialized
INFO - 2019-04-09 15:27:14 --> Model "Common_model" initialized
INFO - 2019-04-09 15:27:14 --> Model "Finane_Model" initialized
INFO - 2019-04-09 15:27:14 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 15:27:14 --> Model "Sales_Model" initialized
INFO - 2019-04-09 15:27:14 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 15:27:14 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 15:27:14 --> Final output sent to browser
DEBUG - 2019-04-09 15:27:14 --> Total execution time: 0.1881
INFO - 2019-04-09 16:33:00 --> Config Class Initialized
INFO - 2019-04-09 16:33:00 --> Hooks Class Initialized
DEBUG - 2019-04-09 16:33:00 --> UTF-8 Support Enabled
INFO - 2019-04-09 16:33:00 --> Utf8 Class Initialized
INFO - 2019-04-09 16:33:00 --> URI Class Initialized
INFO - 2019-04-09 16:33:00 --> Router Class Initialized
INFO - 2019-04-09 16:33:00 --> Output Class Initialized
INFO - 2019-04-09 16:33:00 --> Security Class Initialized
DEBUG - 2019-04-09 16:33:00 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 16:33:00 --> Input Class Initialized
INFO - 2019-04-09 16:33:00 --> Language Class Initialized
INFO - 2019-04-09 16:33:00 --> Loader Class Initialized
INFO - 2019-04-09 16:33:00 --> Helper loaded: url_helper
INFO - 2019-04-09 16:33:00 --> Helper loaded: file_helper
INFO - 2019-04-09 16:33:00 --> Helper loaded: utility_helper
INFO - 2019-04-09 16:33:00 --> Helper loaded: unit_helper
INFO - 2019-04-09 16:33:00 --> Database Driver Class Initialized
INFO - 2019-04-09 16:33:00 --> Email Class Initialized
DEBUG - 2019-04-09 16:33:00 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 16:33:00 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 16:33:00 --> Helper loaded: form_helper
INFO - 2019-04-09 16:33:00 --> Form Validation Class Initialized
INFO - 2019-04-09 16:33:00 --> Controller Class Initialized
INFO - 2019-04-09 16:33:00 --> Model "Common_model" initialized
INFO - 2019-04-09 16:33:00 --> Model "Finane_Model" initialized
INFO - 2019-04-09 16:33:00 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 16:33:00 --> Model "Sales_Model" initialized
ERROR - 2019-04-09 16:33:00 --> Severity: Warning --> Invalid argument supplied for foreach() E:\xampp\htdocs\aelErp_master_2\application\views\distributor\inventory\purchases\purchasesWithPos.php 255
INFO - 2019-04-09 16:33:00 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/purchases/purchasesWithPos.php
INFO - 2019-04-09 16:33:00 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 16:33:00 --> Final output sent to browser
DEBUG - 2019-04-09 16:33:00 --> Total execution time: 0.3139
INFO - 2019-04-09 16:33:05 --> Config Class Initialized
INFO - 2019-04-09 16:33:05 --> Hooks Class Initialized
DEBUG - 2019-04-09 16:33:05 --> UTF-8 Support Enabled
INFO - 2019-04-09 16:33:05 --> Utf8 Class Initialized
INFO - 2019-04-09 16:33:05 --> URI Class Initialized
INFO - 2019-04-09 16:33:05 --> Router Class Initialized
INFO - 2019-04-09 16:33:05 --> Output Class Initialized
INFO - 2019-04-09 16:33:05 --> Security Class Initialized
DEBUG - 2019-04-09 16:33:05 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 16:33:05 --> Input Class Initialized
INFO - 2019-04-09 16:33:05 --> Language Class Initialized
INFO - 2019-04-09 16:33:05 --> Loader Class Initialized
INFO - 2019-04-09 16:33:05 --> Helper loaded: url_helper
INFO - 2019-04-09 16:33:05 --> Helper loaded: file_helper
INFO - 2019-04-09 16:33:05 --> Helper loaded: utility_helper
INFO - 2019-04-09 16:33:05 --> Helper loaded: unit_helper
INFO - 2019-04-09 16:33:05 --> Database Driver Class Initialized
INFO - 2019-04-09 16:33:05 --> Email Class Initialized
DEBUG - 2019-04-09 16:33:05 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 16:33:05 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 16:33:05 --> Helper loaded: form_helper
INFO - 2019-04-09 16:33:05 --> Form Validation Class Initialized
INFO - 2019-04-09 16:33:05 --> Controller Class Initialized
INFO - 2019-04-09 16:33:05 --> Model "Common_model" initialized
INFO - 2019-04-09 16:33:05 --> Model "Finane_Model" initialized
INFO - 2019-04-09 16:33:05 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 16:33:05 --> Model "Sales_Model" initialized
INFO - 2019-04-09 16:33:05 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 16:33:05 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 16:33:05 --> Final output sent to browser
DEBUG - 2019-04-09 16:33:05 --> Total execution time: 0.1805
INFO - 2019-04-09 16:33:07 --> Config Class Initialized
INFO - 2019-04-09 16:33:07 --> Hooks Class Initialized
DEBUG - 2019-04-09 16:33:07 --> UTF-8 Support Enabled
INFO - 2019-04-09 16:33:07 --> Utf8 Class Initialized
INFO - 2019-04-09 16:33:07 --> URI Class Initialized
INFO - 2019-04-09 16:33:07 --> Router Class Initialized
INFO - 2019-04-09 16:33:07 --> Output Class Initialized
INFO - 2019-04-09 16:33:07 --> Security Class Initialized
DEBUG - 2019-04-09 16:33:07 --> Global POST, GET and COOKIE data sanitized
INFO - 2019-04-09 16:33:07 --> Input Class Initialized
INFO - 2019-04-09 16:33:07 --> Language Class Initialized
INFO - 2019-04-09 16:33:07 --> Loader Class Initialized
INFO - 2019-04-09 16:33:07 --> Helper loaded: url_helper
INFO - 2019-04-09 16:33:07 --> Helper loaded: file_helper
INFO - 2019-04-09 16:33:07 --> Helper loaded: utility_helper
INFO - 2019-04-09 16:33:07 --> Helper loaded: unit_helper
INFO - 2019-04-09 16:33:07 --> Database Driver Class Initialized
INFO - 2019-04-09 16:33:07 --> Email Class Initialized
DEBUG - 2019-04-09 16:33:07 --> Session: "sess_save_path" is empty; using "session.save_path" value from php.ini.
INFO - 2019-04-09 16:33:07 --> Session: Class initialized using 'files' driver.
INFO - 2019-04-09 16:33:07 --> Helper loaded: form_helper
INFO - 2019-04-09 16:33:07 --> Form Validation Class Initialized
INFO - 2019-04-09 16:33:07 --> Controller Class Initialized
INFO - 2019-04-09 16:33:07 --> Model "Common_model" initialized
INFO - 2019-04-09 16:33:07 --> Model "Finane_Model" initialized
INFO - 2019-04-09 16:33:07 --> Model "Inventory_Model" initialized
INFO - 2019-04-09 16:33:07 --> Model "Sales_Model" initialized
INFO - 2019-04-09 16:33:07 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/inventory/report/cylinder_stock_group_report.php
INFO - 2019-04-09 16:33:07 --> File loaded: E:\xampp\htdocs\aelErp_master_2\application\views\distributor/masterDashboard.php
INFO - 2019-04-09 16:33:07 --> Final output sent to browser
DEBUG - 2019-04-09 16:33:08 --> Total execution time: 0.1796

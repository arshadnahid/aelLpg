<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;
if ($_SERVER['HTTP_HOST'] == 'localhost'):
    $db['default'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        //'database' => 'ael09-04-2017',
//        'database' => 'aelbfopi_ael_erp',
       // 'database' => 'aelbfopi_ael_erp',
       //  'database' => 'hazi',
        'database' => 'freshdatabase_5',
        //'username' => 'sflcl_aelfinal',
        //'password' => 'P7AH[?wgdL?,',
        //'database' => 'ael18',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );
else:
    $db['default'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
       // 'username' => 'aelbfopi_qc',
       // 'password' => '#)Rf?cSk&$V%',
       // 'database' => 'aelbfopi_qc',
       'username' => 'aelbfopi_qcFreshUser',
       'password' => 'ePazZVac[SC&',
       'database' => 'aelbfopi_qcFreshdb',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );
endif;
<?php

require dirname(__FILE__) . '/vendor/autoload.php';

// include the frame work
require(__DIR__ . '/vendor/cclark61/phpopenfw2/framework/phplitefw.inc.php');

// Start the liteFW controller and load the form engine and the database engine
$pco = new phplitefw_controller();
$pco->load_db_engine();
$pco->load_db_config(__DIR__ . "/db.php", true);
$pco->default_data_source('main');

$pco->set_plugin_folder(dirname(__FILE__) . '/classes');
$pco->set_plugin_folder(dirname(__FILE__) . '/functions');
$pco->load_plugin('all_apps');
spl_autoload_register('load_plugin');


$GLOBALS['data1'] = $data1 = new data_trans('main');
$data1->set_opt('make_bind_params_refs', 1);
$data1->set_opt('charset', 'utf8');
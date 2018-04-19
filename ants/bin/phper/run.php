<?php
$loader = require './vendor/autoload.php';

// use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;
function _initDatabaseEloquent($database_config) {
	$capsule = new DB;
	$capsule->addConnection($database_config);
	$capsule->setAsGlobal();
	$capsule->bootEloquent();
	$capsule::connection()->enableQueryLog();
}

$database_config = [
	'driver' => 'mysql',
	'host' => '127.0.0.1',
	// 'read.0.host' => '127.0.0.1',
	// 'write.0.host' => '127.0.0.1',
	'database' => 'ants',
	'username' => 'root',
	'password' => '123456',
	'port' => 3306,
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => "",
];

_initDatabaseEloquent($database_config);

$data = DB::table('m_gp_list')->first();

print_r($data);

?>
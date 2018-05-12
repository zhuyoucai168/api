<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app_http.php';
require_once __DIR__ . '/auth.php';

$app = new App("http://0.0.0.0:2345");
$app->count = 4;
$app->name = 'http';

$app->onWorkerStart = function($worker) {
	require_once __DIR__ . '/db.php';
};

$app->get('/', function($req) {
	global $db;
	$all_tables = $db->query('show tables');
	return $all_tables;
});

$app->post('/', function($req) {
	return "666";
});

$app->before('/api', function($req) {
	return Auth::verify_sign($req->params);
});

$app->get('/api/test', function($req) {
	$data = array('name'=>'dad');
	return $data;
});

App::runAll();
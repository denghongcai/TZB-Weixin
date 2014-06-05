<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL | E_STRICT);
require BASEPATH . '/notorm/NotORM.php';
require_once BASEPATH . '/config.inc.php';
define("PDO_DSN", "mysql:dbname=" . $config['db']['dbname'] . ";host=" . $config['db']['hostname']);
define("PDO_USER", $config['db']['username']);
define("PDO_PASS", $config['db']['password']);

class DB {

	public static function connect() {
		echo PDO_DSN;

		$pdo = new PDO(PDO_DSN, PDO_USER, PDO_PASS);

		return new NotORM($pdo);
	}
}

$db = DB::connect();
?>
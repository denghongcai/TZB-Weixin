<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL | E_STRICT);
require BASEPATH . '/notorm/NotORM.php';

define("PDO_DSN", "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";port=" . DB_PORT);
define("PDO_USER", DB_USER);
define("PDO_PASS", DB_PASS);

class DB {

	public static function connect() {
                                    
		$pdo = new PDO(PDO_DSN, PDO_USER, PDO_PASS);
                                    $pdo->exec("SET NAMES 'utf8';"); 
		return new NotORM($pdo);
	}
}

?>

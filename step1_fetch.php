<?php
// DBコネクト用
define('DSN','mysql:host=localhost;dbname=refshiz_teamlab');
define('DB_USER','refshiz_teamlab');
define('DB_PASSWORD','teamlab843');
define('TABLE_NAME', 'board');
// DBへの接続
try {
	$pdo = new PDO( DSN, DB_USER, DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch ( PDOException $e ) {
	 exit( 'Failed to connect to DB : '.$e->getMessage() );
}

$sql = $pdo -> prepare("SELECT * FROM ".TABLE_NAME);
$sql->execute();
$data = $sql -> fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);

?>
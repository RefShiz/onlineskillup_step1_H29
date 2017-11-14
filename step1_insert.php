<?php
// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');
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

// 整合性チェック
// 入力がNULLの場合は考慮しない
if ( isset($_POST["name"]) && isset($_POST["message"]) ) {
	// POSTデータをエラーを出さないように文字列として安全に展開する
	$name = (string)filter_input(INPUT_POST, 'name');
	$message = (string)filter_input(INPUT_POST, 'message');
} else {
	$name = False;
	$message = False;
}
// 入力の文字数チェック
	if ( mb_strlen($name) > 20 || mb_strlen($message) > 200 ) {
		$error = "文字数が多すぎます。";
	}

// エラーがあった場合に表示
if ( isset($error) ) {
	echo "Error : ".$error;
}

if ( !isset($error) && $name && $message ) {
	$sql = $pdo -> prepare("INSERT INTO ".TABLE_NAME." (date,name,message) VALUES (:date,:name,:message)");
	$sql->bindValue(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
	$sql->bindParam(':name', $name, PDO::PARAM_STR);
	$sql->bindParam(':message', $message, PDO::PARAM_STR);
	$sql->execute();
	echo "wrote!";
}

?>
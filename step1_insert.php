<?php
// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');
// DBコネクト用
define('DSN','mysql:host=localhost;dbname=refshiz_teamlab');
define('DB_USER','refshiz_teamlab');
define('DB_PASSWORD','teamlab843');
define('TABLE_NAME', 'board');

// 整合性チェック
if ( isset($_POST["name"]) && isset($_POST["message"]) ) {
	// POSTデータを文字列として展開する
	$name = (string)$_POST["name"];
	$message = (string)$_POST["message"];
	// HTMLをエスケープする
	$name = htmlspecialchars($name);
	$message = htmlspecialchars($message);
} else {
	$name = False;
	$message = False;
}

// 入力の文字数チェック
	if ( mb_strlen($name) >= 20 || mb_strlen($message) >= 200 ) {
		$error = "文字数が多すぎます。";
	}
/*全角半角スペースのみの入力の場合の処理をしていない*/

// エラーがあった場合に表示
if ( isset($error) ) {
	echo "Error : ".$error;
}
// postがありエラーがないとき
if ( !isset($error) && $name && $message ) {
	// DBへの接続
	try {
		$pdo = new PDO( DSN, DB_USER, DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	} catch ( PDOException $e ) {
		 exit( 'Failed to connect to DB : '.$e->getMessage() );
	}
	// SQL
	$sql = $pdo -> prepare("INSERT INTO ".TABLE_NAME." (date,name,message) VALUES (:date,:name,:message)");
	$sql->bindValue(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
	$sql->bindParam(':name', $name, PDO::PARAM_STR);
	$sql->bindParam(':message', $message, PDO::PARAM_STR);
	$sql->execute();
	echo "wrote!";
}

?>
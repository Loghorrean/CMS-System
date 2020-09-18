<?php
$db['db_host'] = "localhost";
$db['db_port'] = "3307";
$db['db_name'] = "cms";
$db['db_user'] = "fred";
$db['db_pass'] = "zap";
foreach($db as $key => $value) {
	define(strtoupper($key), $value);
}
$dsn = "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
$pdo = new PDO($dsn, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$query = $pdo->query("SELECT * from firms");
//while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
//    var_dump($row);
//    echo "<br>";
//}
?>
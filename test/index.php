<?php
require '../Manager/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new ChatManager_PDO($db);


$chats = $manager->count();

echo 'Messages : '.$chats;

?>
<?php
include('bdd/bdd.php');  

$pdo = db_connect();  

$req = $pdo->prepare('SELECT * FROM categories'); 
$req->execute();  
$allDomaine = $req->fetchAll();  
?>

<?php
include('bdd/bdd.php');  

$pdo = db_connect();  

$req = $pdo->prepare('SELECT * FROM fichiers_pdf'); 
$req->execute();  
$allDomaine = $req->fetchAll();  
?>

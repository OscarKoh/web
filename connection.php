<?php 
 	try { 
 		$connection = new PDO('mysql:host=localhost;dbname=gradgala','root','');
	} 
	catch (PDOException $e) { 
 		echo $e->getMessage(); 
	} 
?>
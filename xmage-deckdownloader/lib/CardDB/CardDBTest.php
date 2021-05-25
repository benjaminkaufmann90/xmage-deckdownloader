<?php
	require_once 'CardDB.php';
	
	$cbd = new CardDB('../../card_db.csv');
	var_dump($cbd->getDataByName('Rhox'));
	var_dump($cbd->getDataByName('Pouncing Shoreshark'));
?>
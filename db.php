<?php
/* Database connection settings */
$host = 'mysql.hostinger.com'; //DB host website
$user = 'u341414993_rspur'; //DB username
$pass = 'Cosc412';  //DB password
$db = 'u341414993_proj1'; //DB name
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error); //Log into db 

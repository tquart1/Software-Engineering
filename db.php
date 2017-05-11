<?php
/* Website atabase connection settings */
$host = 'mysql.hostinger.com';
$user = 'u341414993_rspur';
$pass = 'Cosc412';
$db = 'u341414993_proj1';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

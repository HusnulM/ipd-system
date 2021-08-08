<?php

if( !session_id() ) session_start();
ini_set('date.timezone', 'Asia/Jakarta');
require_once 'app/init.php';

$app = new App;
<?php
include 'config.php';
include('engine/encrypt.php');
//delete old files
deleteoldfiles();
header("Location: $redirect");
?>
<?php
// connect to db
$db = new mysqli('localhost', 'work_test', 'Ler3pU85Z7dcYNdp', 'work_test');
// die errmsg if connection error occurs
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
?>
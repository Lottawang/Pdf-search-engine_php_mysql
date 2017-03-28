<?php
$hostname='localhost';
$databasename='amf';
$username='root1';
$password='wdf123';
// create connector

$obj=new mysqli($hostname,$username,$password,$databasename);
// check connector and handle error
if($obj->connect_error){
	die("cannot connect with database:".$obj->connect_error);
}
//echo "connect successfully!";
?> 
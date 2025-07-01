<?php
function connect_to_server($server,$dbname,$username,$password)
{
try
{
    $conn = new PDO("mysql:host=$server;dbname=$dbname",$username,$password);
    return $conn;
} catch(PDOException $ex)
{
    die("Connection Failed " . $ex->getMessage());
}
} 
?>
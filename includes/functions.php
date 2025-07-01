<?php
function connect_to_server()
{
try
{
    $conn = new PDO("mysql:host=localhost;dbname=shop",'root','');
    return $conn;
} catch(PDOException $ex)
{
    die("Connection Failed " . $ex->getMessage());
}
} 
?>
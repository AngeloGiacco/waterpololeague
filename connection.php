<?php
$servername = "fdb22.awardspace.net";
$username="2872791_emiswaterpolo";
$password = "F9vvk5gWBGtMrZ5";
$dbname = "2872791_emiswaterpolo";
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
  echo "Connection failed: ".$e->getMessage();
}
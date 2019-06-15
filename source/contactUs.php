<?php
  $message = $_POST["message"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  echo $message ." from ". $name ." who's email is ".$email;
?>

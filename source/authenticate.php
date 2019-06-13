<?php
  array_map("htmlspecialchars", $_POST);
  include_once("connection.php");
  try {
    $userType = $_POST["userType"];
    $email = $_POST["email"];
    $attempt = $_POST["pswd"];
    switch ($userType) {
      case "admin":
        echo "admin";
        break;
      case "coach":
        echo "coach";
        break;
      case "player":
        echo "player";
        break;
    }
  $conn=null;
}
catch(PDOException $e)
  	{
  		echo "error".$e->getMessage();
  	}
?>

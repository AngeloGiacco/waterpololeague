<?php
  session_start();
  array_map("htmlspecialchars", $_POST);
  include_once("connection.php");
  include_once("admin_credentials.php");
  try {
    $userType = $_POST["userType"];
    $email = $_POST["email"];
    $attempt = $_POST["pswd"];
    switch ($userType) {
      case "admin":
        if ($email == $admin_email and $attempt == $admin_password) {
          $_SESSION["userType"] = "admin";
          $_SESSION["email"] = $email;
          ?><script>
              window.location.replace("admin.php");
            </script><?php
          exit;
        } else {
          ?><script>
				      alert("incorrect email and password combination");
              window.location.replace("index.php");
            </script><?php
        }
        break;


      case "coach":
        $stmt = $conn->prepare("SELECT password FROM coaches WHERE email = :email");
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $hashed = $stmt->fetch(PDO::FETCH_ASSOC)["password"];
        if (password_verify($attempt,$hashed)){
          $_SESSION["userType"] = "coach";
          $_SESSION["email"] = $email;
          ?><script>
              window.location.replace("coach.php");
            </script><?php
          exit;
        } else {
          ?><script>
				      alert("incorrect email and password combination");
              window.location.replace("index.php");
            </script><?php
        }
        break;


      case "player":
        $stmt = $conn->prepare("SELECT password FROM players WHERE email = :email");
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $hashed = $stmt->fetch(PDO::FETCH_ASSOC)["password"];
        if (password_verify($attempt,$hashed)){
          $_SESSION["userType"] = "player";
          $_SESSION["email"] = $email;
          ?><script>
              window.location.replace("player.php");
            </script><?php
          exit;
        } else {
          ?><script>
              alert("incorrect email and password combination");
              window.location.replace("index.php");
            </script><?php
        }
        break;
    }
  $conn=null;
}
catch(PDOException $e)
  	{
  		echo "error".$e->getMessage();
  	}
?>

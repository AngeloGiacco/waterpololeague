<?php
  session_start();
  array_map("htmlspecialchars", $_POST);
  include_once("connection.php");
  try {
    $userType = $_POST["userType"];
    $email = $_POST["email"];
    $attempt = $_POST["pswd"];
    switch ($userType) {
      case "admin":
        if ($email == "jc2@oundleschool.org.uk" and $attempt == "julie") {
          $_SESSION["admin"] = "true";
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
          $_SESSION["coach"] = "true";
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
        $_SESSION["player"] = "true";
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

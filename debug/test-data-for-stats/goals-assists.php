<?php
  include_once("connection.php");
  $stmt = $conn->prepare("SELECT homeGoalInfo,awayGoalInfo FROM results");
  $stmt->execute();
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $hgi = $result["homeGoalInfo"];
    $agi = $result["awayGoalInfo"];
    $hgoals = explode(";",$hgi);
    $agoals = explode(";",$agi);
    foreach ($hgoals as $goal) {
      $goalScorer = explode(":",$goal)[0];
      $assister = explode(":",$goal)[1];
      $query = $conn->prepare("UPDATE players SET goals = goals + 1 WHERE playerID = :id");
      $query->bindParam(":id",$goalScorer);
      $query->execute();
      $query = $conn->prepare("UPDATE players SET assists = assists + 1 WHERE playerID = :id");
      $query->bindParam(":id",$assister);
      $query->execute();
    }
    foreach ($agoals as $goal) {
      $goalScorer = explode(":",$goal)[0];
      $assister = explode(":",$goal)[1];
      $query = $conn->prepare("UPDATE players SET goals = goals + 1 WHERE playerID = :id");
      $query->bindParam(":id",$goalScorer);
      $query->execute();
      $query = $conn->prepare("UPDATE players SET assists = assists + 1 WHERE playerID = :id");
      $query->bindParam(":id",$assister);
      $query->execute();
    }
  }
?>

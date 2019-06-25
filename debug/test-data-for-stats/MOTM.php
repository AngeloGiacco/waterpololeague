<?php
  include_once("connection.php");
  $stmt = $conn->prepare("SELECT motmHomeID,motmAwayID FROM results");
  $stmt->execute();
  while ($game = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $hid = $game["motmHomeID"];
    $aid = $game["motmAwayID"];
    foreach (array($hid,$aid) as $id) {
      $query = $conn->prepare("UPDATE players SET motm = motm + 1 WHERE playerID = :id");
      $query->bindParam(":id",$id);
      $query->execute();
    }
  }
?>

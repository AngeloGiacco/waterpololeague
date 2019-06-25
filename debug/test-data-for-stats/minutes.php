<?php
  include_once("connection.php");
  $fields = ["homeQuarter1","homeQuarter2","homeQuarter3","homeQuarter4","awayQuarter1","awayQuarter2","awayQuarter3","awayQuarter4"];
  $stmt = $conn->prepare("SELECT * FROM results");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  foreach ($fields as $field) {
    $str = $result[$field];
    print_r($str);
    $id_array = explode(",",$str);
    foreach($id_array as $id) {
      $query = $conn->prepare("UPDATE players SET minutesPlayed = minutesPlayed + 7 WHERE playerID = :id");
      $query->bindParam(":id",$id);
    }
  }
?>

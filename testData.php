<?php
  include_once("connection.php");
  $name_lst = array("angelo","bob","cameron","david","emilio","frank","geronimo","harry","ito")
  $team_name_lst = array("oundle","stamford","uppingham");
  $player_count = 0;
  $team_count = 0;
  $player_total = 9;
  $team_total = 0;
  while ($team_count <= $team_total) {
    $stmt = $conn->prepare("INSERT INTO school (schoolID,name,logo,packedLunchEmail,packedLunchLink,venueLong,venueLat) VALUES (null,:schoolName,:name,:logo,:packedLunchEmail,:venueLong,:venuelat)");

    $stmt = $conn->prepare("INSERT INTO team (teamID,)")
  }

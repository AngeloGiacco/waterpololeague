<?php
include_once("connection.php");
//games are
//oundle 5 2 uppingham
//stamford 2 4 oundle
//stamford 3 4 uppingham
//oundle 3 3 uppingham

$name_lst = array("angelo","bob","cameron","david","emilio","frank","geronimo","harry","ito","frank");
$team_name_lst = array("oundle","stamford","uppingham");
$games_played_lst = array(3,2,3);
$wins_lst = array(2,0,1);
$draws_lst = array(1,0,1);
$loss_lst = array(0,2,1);
$player_count = 0;
$team_count = 0;
$player_total = 10;
$team_total = 3;

//delete existing coaches
$stmt = $conn->prepare("DELETE FROM coaches");
$stmt->execute();

//delete the existing schools
$stmt = $conn->prepare("DELETE FROM school");
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM players");
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM results");
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM team");
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM season");
$stmt->execute();



while ($team_count < $team_total) {
  //coaches
  //create the coaches
  $stmt = $conn->prepare("INSERT INTO coaches VALUES (:id,:forename, :surname,:email,:pass,'')");
  $forename = $team_name_lst[$team_count]."coachforename";
  $surname = $team_name_lst[$team_count]."coachsurname";
  $email = "coach@".$team_name_lst[$team_count].".com";
  $stmt->bindParam(':id',$team_count);
  $stmt->bindParam(':forename',$forename);
  $stmt->bindParam(':surname',$surname);
  $stmt->bindParam(':pass',password_hash('coachpassword',PASSWORD_BCRYPT))
  $stmt->bindParam(':email',$email);
  $stmt->execute();

  //schools
  //create the schools
  $name = $team_name_lst[$team_count];
  $logo = $name.".jpg";
  if ($team_count == 0) {
    $pl = 1;
    $pllink = "packedlunch.dx.am";
  } else {
    $pl = 0;
    $pllink = "";
  }
  $long = $team_count * 10;
  $lat = $team_count * 10;
  $stmt = $conn->prepare("INSERT INTO school VALUES (:id,:name,:logo,:pl,:pllink,:long,:lat)");
  $stmt->bindParam(':id',$team_count);
  $stmt->bindParam(':name',$name);
  $stmt->bindParam(':logo',$logo);
  $stmt->bindParam(':pl',$pl);
  $stmt->bindParam(':pllink',$pllink);
  $stmt->bindParam(':long',$long);
  $stmt->bindParam(':lat',$lat);
  $stmt->execute();

  //teams

  //create the teams
  $stmt = $conn->prepare("INSERT INTO team VALUES (:id,:sid,:cid,:gamesPlayed,:wins,:draws,:losses,:teamSuffix)");
  $stmt->bindParam(':id',$team_count);
  $stmt->bindParam(':sid',$team_count);//the school ID is defined to be the team count so no need to query
  $stmt->bindParam(':cid',$team_count);//the coach ID is defined to be the team count so no need to query
  $stmt->bindParam(':wins',$wins_lst[$team_count]);
  $stmt->bindParam(':draws',$draws_lst[$team_count]);
  $stmt->bindParam(':losses',$loss_lst[$team_count]);
  if ($team_count == 0){
    $stmt->bindParam(':teamSuffix','A');
  }else{
    $stmt->bindParam(':teamSuffix','');
  }
  $stmt->execute();

  while ($player_count < $player_total) {
    $stmt = $conn->prepare("INSERT INTO players VALUES (null,:f,:s,:e,:tid,:ac,:ca,:pn,:gol,:ass,:mp,:motm,:pass,' ',:hatn)");
    $stmt->bindParam(':f',$name_lst[$player_count]);
    $stmt->bindParam(':s',$team_name_lst[$team_count]);
    $stmt->bindParam(':e',$team_name_lst[$team_count]."@".$name_lst[$player_count].".com");
    $stmt->bindParam(':tid',$team_count);
    if ($player_count == 9) {
      $stmt->bindParam(':ac',0);
      $stmt->bindParam(':ca',0);
    }else if ($player_count == 0){
      $stmt->bindParam(':ac',1);
      $stmt->bindParam(':ca',1);
    } else {
      $stmt->bindParam(':ac',1);
      $stmt->bindParam(':ca',0);
    }
    $stmt->bindParam(':pn',$player_count);
    $stmt->bindParam(':gol',0);
    $stmt->bindParam(':ass',0);
    $stmt->bindParam(':mp',0);
    $stmt->bindParam(':motm',0)
    $stmt->bindParam(':pass',password_hash('playerpassword',PASSWORD_BCRYPT));
    $stmt->bindParam(':hatn',$player_count);
    $stmt->execute();

    $player_count = $player_count + 1
  }
  $player_count = 0;

  $team_count = $team_count + 1;
}

$stmt = $conn->prepare("INSERT INTO seasons VALUES (null,:wid,:pOun,:pBSS,:pUpp,:pSta,:motmAwardID,:goalAwardID,:assistAwardID,:pMID)");
$stmt->bindParam(':wid',0);
$stmt->bindParam(':pOun',6);
$stmt->bindParam(':pBSS',0);
$stmt->bindParam(':pUpp',3);
$stmt->bindParam(':pSta',0);
$stmt->bindParam(':motmAwardID',11);
$stmt->bindParam(':goalAwardID',3);
$stmt->bindParam(':assistAwardID',3);
$stmt->bindParam(':pMID',8);
$stmt->execute();

$result_count = 0;
$team_indexes = array(0,2,1,0,1,2,0,2);
$score_lst = array(5,2,2,4,3,4,3,3);
while ($result_count < 4) {
  $index = $result_count*2;
  $stmt = $conn->prepare("SELECT schoolID FROM school LIMIT 1 OFFSET $team_indexes[$index]");
  $stmt->execute();
  $hid = $stmt->fetch(PDO::FETCH_ASSOC)['schoolID'];
  $index = ($result_count*2)+1;
  $stmt = $conn->prepare("SELECT schoolID FROM school LIMIT 1 OFFSET $team_indexes[$index]");
  $stmt->execute();
  $aid = $stmt->fetch(PDO::FETCH_ASSOC)['schoolID'];
  $stmt = $conn->prepare("SELECT teamID FROM team WHERE schoolID = :schoolID LIMIT 1");
  $stmt->bindParam(':schoolID',$hid);
  $stmt->execute();
  $homeTeamID = $stmt->fetch(PDO::FETCH_ASSOC)['teamID'];
  $stmt = $conn->prepare("SELECT playerID FROM players WHERE teamID = :id LIMIT 1");
  $stmt->bindParam(':id',$homeTeamID);
  $stmt->execute();
  $baseHome = $stmt->fetch(PDO::FETCH_ASSOC)['playerID'];
  $stmt = $conn->prepare("SELECT teamID FROM team WHERE schoolID = :schoolID LIMIT 1");
  $stmt->bindParam(':schoolID',$aid);
  $stmt->execute();
  $awayTeamID = $stmt->fetch(PDO::FETCH_ASSOC)['teamID'];
  $stmt = $conn->prepare("SELECT playerID FROM players WHERE teamID = :id LIMIT 1");
  $stmt->bindParam(':id',$awayTeamID);
  $stmt->execute();
  $baseAway = $stmt->fetch(PDO::FETCH_ASSOC)['playerID'];
  $stmt = $conn->prepare("INSERT INTO results VALUES (null,:hID,:aID,:hS,:awayS,:hgi,:agi,:hq1,:hq2,:hq3,:hq4,:aq1,:aq2,:aq3,:aq4,:d,:sT,:motmHID,:motmAID)");
  $stmt->bindParam(':hid',$hid);
  $stmt->bindParam(':aid',$aid);
  $scoreH = $score_lst[$result_count*2];
  $scoreA = $score_lst[($result_count*2)+1];
  $stmt->bindParam(':hS',$scoreH);
  $stmt->bindParam(':awayS',$scoreA);
  $homeGoalInfo = array();
  $goal_count = 0;
  while ($goal_count < $score_lst[$result_count*2]) {
    $possible_indexes = array(1,2,3,4,5,6);
    $randIndex = array_rand($possible_indexes, 2);
    $goalScorer = $baseHome + $possible_indexes[$randIndex[0]];
    $assister = $baseHome + $possible_indexes[$randIndex[1]];
    array_push($homeGoalInfo,$goalScorer.":".$assister);
    $goal_count = $goal_count + 1;
  }
  $hgi = implode($homeGoalInfo,";");
  $stmt->bindParam(':hgi',$hgi);
  $awayGoalInfo = array();
  $goal_count = 0;
  while ($goal_count < $score_lst[($result_count*2)+1]) {
    $possible_indexes = array(1,2,3,4,5,6);
    $randIndex = array_rand($possible_indexes, 2);
    $goalScorer = $baseAway + $possible_indexes[$randIndex[0]];
    $assister = $baseAway + $possible_indexes[$randIndex[1]];
    array_push($awayGoalInfo,$goalScorer.":".$assister);
    $goal_count = $goal_count + 1;
  }
  $agi = implode($awayGoalInfo,";");
  $stmt->bindParam(':agi',$agi);
  $indexesHome = array($baseHome,$baseHome+1,$baseHome+2,$baseHome+3,$baseHome+4,$baseHome+5,$baseHome+6);
  $indexesAway = array($baseAway,$baseAway+1,$baseAway+2,$baseAway+3,$baseAway+4,$baseAway+5,$baseAway+6);
  $implodedIndexesH = implode($indexesHome,",");
  $implodedIndexesA = implode($indexesAway,",");
  $stmt->bindParam(':hq1',$implodedIndexesH);
  $stmt->bindParam(':hq2',$implodedIndexesH);
  $stmt->bindParam(':hq3',$implodedIndexesH);
  $stmt->bindParam(':hq4',$implodedIndexesH);
  $stmt->bindParam(':aq1',$implodedIndexesA);
  $stmt->bindParam(':aq2',$implodedIndexesA);
  $stmt->bindParam(':aq3',$implodedIndexesA);
  $stmt->bindParam(':aq4',$implodedIndexesA);
  $start = strtotime("01 January 2019");
  $end = strtotime("30 June 2019");
  $timestamp = mt_rand($start, $end);
  $date = date("d-M-Y", $timestamp);
  $stmt->bindParam(':d',$date);
  $time = '13:45';
  $stmt->bindParam(':sT',$time);
  $motmH = $indexesHome[array_rand($indexesHome, 1)];
  $motmA = $indexesAway[array_rand($indexesAway, 1)];
  echo"<p> date: ".$date." // motm H: ".$motmH." // motmA: ".$motmA."</p>";
  $stmt->bindParam(':motmHID',$motmH);
  $stmt->bindParam(':motmAID',$motmA);
  $stmt->execute();
  $result_count = $result_count + 1;
}

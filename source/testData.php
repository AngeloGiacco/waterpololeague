<?php
include_once("connection.php");
//games are
//oundle 5 2 uppingham
//stamford 2 4 oundle
//stamford 3 4 uppingham
//oundle 3 3 uppingham
$name_lst = array("angelo","bob","cameron","david","emilio","frank","geronimo","harry","ito","jimbob");
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
$stmt = $conn->prepare("DELETE FROM seasons");
$stmt->execute();
while ($team_count < $team_total) {
  //coaches
  //create the coaches
  $stmt = $conn->prepare("INSERT INTO coaches VALUES (null,:forename, :surname,:email,:pass,'')");
  $forename = $team_name_lst[$team_count]."coachforename";
  $surname = $team_name_lst[$team_count]."coachsurname";
  $email = "coach@".$team_name_lst[$team_count].".com";
  $stmt->bindParam(':forename',$forename);
  $stmt->bindParam(':surname',$surname);
  $stmt->bindParam(':pass',password_hash('coachpassword',PASSWORD_BCRYPT));
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
  $stmt = $conn->prepare("INSERT INTO school VALUES (null,:name,:logo,:pl,:pllink,:long,:lat)");
  $stmt->bindParam(':name',$name);
  $stmt->bindParam(':logo',$logo);
  $stmt->bindParam(':pl',$pl);
  $stmt->bindParam(':pllink',$pllink);
  $stmt->bindParam(':long',$long);
  $stmt->bindParam(':lat',$lat);
  $stmt->execute();
  //teams
  //create the teams
  //but first collect sid and cid
  $stmt = $conn->prepare("SELECT schoolID FROM school LIMIT 1 OFFSET $team_count");
  $stmt->execute();
  $schoolIDrow = $stmt->fetch(PDO::FETCH_ASSOC)['schoolID'];
  $stmt = $conn->prepare("SELECT coachID FROM coaches LIMIT 1 OFFSET $team_count");
  $stmt->execute();
  $coachesIDrow = $stmt->fetch(PDO::FETCH_ASSOC)['coachID'];
  $stmt = $conn->prepare("INSERT INTO team VALUES (null,:sid,:cid,:gamesPlayed,:wins,:draws,:losses,:teamSuffix)");
  //ERROR WITH PRIMARY KEYS MUST COLLECT FROM EACH TABLE
  $stmt->bindParam(':sid',$schoolIDrow);
  $stmt->bindParam(':cid',$coachesIDrow);
  $game_count = $wins_lst[$team_count] + $draws_lst[$team_count] + $loss_lst[$team_count];
  $stmt->bindParam(':gamesPlayed',$game_count);
  $stmt->bindParam(':wins',$wins_lst[$team_count]);
  $stmt->bindParam(':draws',$draws_lst[$team_count]);
  $stmt->bindParam(':losses',$loss_lst[$team_count]);
  if ($team_count == 0){
    $ts = 'A';
  }else{
    $ts = 'B';
  }
  $stmt->bindParam(':teamSuffix',$ts);
  $stmt->execute();
  $stmt = $conn->prepare("SELECT teamID FROM team LIMIT 1 OFFSET $team_count");
  $stmt->execute();
  $teamIDrow = $stmt->fetch(PDO::FETCH_ASSOC)['teamID'];
  while ($player_count <= sizeof($name_lst)-1 and isset($name_lst[$player_count])) {
    //token does not require a value as it is generated only when a user has forgotten their password
    $stmt = $conn->prepare("INSERT INTO players VALUES (null,:f,:s,:e,:tid,:ac,:ca,:pn,:gol,:ass,:mp,:motm,:pass,' ',:hatn)");
    $stmt->bindParam(':f',$name_lst[$player_count]);
    $stmt->bindParam(':s',$team_name_lst[$team_count]);
    $email = $name_lst[$player_count]."@".$team_name_lst[$team_count].".com";
    $stmt->bindParam(':e',$email);
    $stmt->bindParam(':tid',$teamIDrow);
    if ($player_count == 9) {
      $active = 0;
      $captain = 0;
    }else if ($player_count == 0){
      $active = 1;
      $captain = 1;
    } else {
      $active = 1;
      $captain = 0;
    }
    $null = 0;
    $stmt->bindParam(':ac',$active);
    $stmt->bindParam(':ca',$captain);
    $stmt->bindParam(':pn',$player_count);
    $stmt->bindParam(':gol',$null);
    $stmt->bindParam(':ass',$null);
    $stmt->bindParam(':mp',$null);
    $stmt->bindParam(':motm',$null);
    $stmt->bindParam(':pass',password_hash('playerpassword',PASSWORD_BCRYPT));
    $stmt->bindParam(':hatn',$player_count);
    $stmt->execute();
    $player_count = $player_count + 1;
  }
  $player_count = 0;
  $team_count = $team_count + 1;
}
$null = 0;
$six = 6;
$three = 3;
$eleven = 11;
$eight = 8;
$stmt = $conn->prepare("SELECT teamID FROM team LIMIT 1 OFFSET 0");
$stmt->execute();
$winner = $stmt->fetch(PDO::FETCH_ASSOC)['teamID'];
$stmt = $conn->prepare("SELECT playerID FROM players LIMIT 1 OFFSET 5");
$stmt->execute();
$playerID = $stmt->fetch(PDO::FETCH_ASSOC)['playerID'];
$playerID2 = $playerID + 1;
$stmt = $conn->prepare("INSERT INTO seasons VALUES (null,:wid,:pOun,:pBSS,:pUpp,:pSta,:motmAwardID,:goalAwardID,:assistAwardID,:pMID)");
$stmt->bindParam(':wid',$winner);
$stmt->bindParam(':pOun',$six);
$stmt->bindParam(':pBSS',$null);
$stmt->bindParam(':pUpp',$three);
$stmt->bindParam(':pSta',$null);
$stmt->bindParam(':motmAwardID',$playerID);
$stmt->bindParam(':goalAwardID',$playerID2);
$stmt->bindParam(':assistAwardID',$playerID);
$stmt->bindParam(':pMID',$playerID2);
$stmt->execute();
$result_count = 0;
$team_indexes = array(0,2,1,0,1,2,0,2);
$score_lst = array(5,2,2,4,3,4,3,3);


while ($result_count < 4) {

  //COLLECTING DATA

  $index = $result_count*2;
  $stmt = $conn->prepare("SELECT schoolID FROM school LIMIT 1 OFFSET $team_indexes[$index]");
  $stmt->execute();
  $homeSchoolID = $stmt->fetch(PDO::FETCH_ASSOC)['schoolID'];

  $index = ($result_count*2)+1;
  $stmt = $conn->prepare("SELECT schoolID FROM school LIMIT 1 OFFSET $team_indexes[$index]");
  $stmt->execute();
  $awaySchoolID = $stmt->fetch(PDO::FETCH_ASSOC)['schoolID'];

  $stmt = $conn->prepare("SELECT teamID FROM team WHERE schoolID = :schoolID LIMIT 1");
  $stmt->bindParam(':schoolID',$homeSchoolID);
  $stmt->execute();
  $homeTeamID = $stmt->fetch(PDO::FETCH_ASSOC)['teamID'];
  $stmt = $conn->prepare("SELECT playerID FROM players WHERE teamID = :id LIMIT 1");
  $stmt->bindParam(':id',$homeTeamID);
  $stmt->execute();
  $baseHome = $stmt->fetch(PDO::FETCH_ASSOC)['playerID'];

  $stmt = $conn->prepare("SELECT teamID FROM team WHERE schoolID = :schoolID LIMIT 1");
  $stmt->bindParam(':schoolID',$awaySchoolID);
  $stmt->execute();
  $awayTeamID = $stmt->fetch(PDO::FETCH_ASSOC)['teamID'];
  $stmt = $conn->prepare("SELECT playerID FROM players WHERE teamID = :id LIMIT 1");
  $stmt->bindParam(':id',$awayTeamID);
  $stmt->execute();
  $baseAway = $stmt->fetch(PDO::FETCH_ASSOC)['playerID'];

  $scoreH = $score_lst[$result_count*2];
  $scoreA = $score_lst[($result_count*2)+1];

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

  $indexesHome = array($baseHome,$baseHome+1,$baseHome+2,$baseHome+3,$baseHome+4,$baseHome+5,$baseHome+6);
  $indexesAway = array($baseAway,$baseAway+1,$baseAway+2,$baseAway+3,$baseAway+4,$baseAway+5,$baseAway+6);
  $implodedIndexesH = implode($indexesHome,",");
  $implodedIndexesA = implode($indexesAway,",");

  $start = strtotime("01 January 2020");
  $end = strtotime("30 June 2020");
  $timestamp = mt_rand($start, $end);
  $date = date("Y-m-d", $timestamp);
  $time = '13:45:00';
  $motmH = $indexesHome[array_rand($indexesHome, 1)];
  $motmA = $indexesAway[array_rand($indexesAway, 1)];
  echo"<p> hID ".$homeTeamID." // aID ".$awayTeamID." // hS ".$scoreH." // awayS ".$scoreA." // all hq: ".$implodedIndexesH." // all aq: ".$implodedIndexesA." // agi: ".$agi." // hgi: ".$hgi." // date: ".$date." // startTime: ".$time." // motm H: ".$motmH." // motmA: ".$motmA."</p>";

  //BINDING DATA TO STATEMENT

  $stmt = $conn->prepare("INSERT INTO results VALUES (null,:hID,:aID,:hS,:awayS,:hgi,:agi,:hq1,:hq2,:hq3,:hq4,:aq1,:aq2,:aq3,:aq4,:d,:sT,:motmHID,:motmAID)");
  $stmt->bindParam(':hID',$homeTeamID);
  $stmt->bindParam(':aID',$awayTeamID);
  $stmt->bindParam(':hS',$scoreH);
  $stmt->bindParam(':awayS',$scoreA);
  $stmt->bindParam(':hgi',$hgi);
  $stmt->bindParam(':agi',$agi);
  $stmt->bindParam(':hq1',$implodedIndexesH);
  $stmt->bindParam(':hq2',$implodedIndexesH);
  $stmt->bindParam(':hq3',$implodedIndexesH);
  $stmt->bindParam(':hq4',$implodedIndexesH);
  $stmt->bindParam(':aq1',$implodedIndexesA);
  $stmt->bindParam(':aq2',$implodedIndexesA);
  $stmt->bindParam(':aq3',$implodedIndexesA);
  $stmt->bindParam(':aq4',$implodedIndexesA);
  $stmt->bindParam(':d',$date);
  $stmt->bindParam(':sT',$time);

  $stmt->bindParam(':motmHID',$motmH);
  $stmt->bindParam(':motmAID',$motmA);
  $stmt->execute();
  $result_count = $result_count + 1;
}

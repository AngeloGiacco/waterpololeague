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
  $stmt = $conn->prepare("INSERT INTO results VALUES (null,:hID,:aID,:hS,:awayS,:hgi,:agi,:hq1,:hq2,:hq3,:hq4,:aq1,:aq2,:aq3,:aq4,:d,:sT,:motmHID,:motmAID)");
  $stmt->bindParam(':hid',$team_indexes[$result_count*2]);
  $stmt->bindParam(':aid',$team_indexes[($result_count*2)+1]);
  $stmt->bindParam(':hS',$score_lst[$result_count*2]);
  $stmt->bindParam(':awayS',$score_lst[($result_count*2)+1]);
  $homeGoalInfo = array();
  $goal_count = 0;
  while ($goal_count < $score_lst[$result_count*2]) {
    $possible_indexes = array(1,2,3,4,5,6);
    $randIndex = array_rand($possible_indexes, 2);
    $goalScorer = $team_indexes[$result_count*2] * 10 + $possible_indexes[$randIndex[0]];
    $assister = $team_indexes[$result_count*2] * 10 + $possible_indexes[$randIndex[1]];
    array_push($homeGoalInfo,$goalScorer.":".$assister);
    $goal_count = $goal_count + 1
  }
  $stmt->bindParam(':hgi',implode($homeGoalInfo,";"));
  $awayGoalInfo = array();
  $goal_count = 0;
  while ($goal_count < $score_lst[($result_count*2)+1]) {
    $possible_indexes = array(1,2,3,4,5,6);
    $randIndex = array_rand($possible_indexes, 2);
    $goalScorer = $team_indexes[($result_count*2)+1] * 10 + $possible_indexes[$randIndex[0]];
    $assister = $team_indexes[($result_count*2)+1] * 10 + $possible_indexes[$randIndex[1]];
    array_push($homeGoalInfo,$goalScorer.":".$assister);
    $goal_count = $goal_count + 1
  }
  $stmt->bindParam(':agi',implode($awayGoalInfo,";"));
  $baseHome = $team_indexes[($result_count*2)] * 10
  $indexesHome = array($baseHome+0,$baseHome+1,$baseHome+2,$baseHome+3,$baseHome+4,$baseHome+5,$baseHome+6);
  $baseAway = $team_indexes[($result_count*2)+1] * 10
  $indexesAway = array($baseAway+0,$baseAway+1,$baseAway+2,$baseAway+3,$baseAway+4,$baseAway+5,v+6);
  foreach(array(':hq1',':hq2',':hq3',':hq4') as $param) {
    $stmt->bindParam($param,implode($indexesHome,","));
  }
  foreach(array(':aq1',':aq2',':aq3',':aq4' as $param)) {
    $stmt->bindParam($param,implode($indexesAway,","));
  }
  $start = strtotime("01 January 2019");
  $end = strtotime("30 June 2019");
  $timestamp = mt_rand($start, $end);
  $stmt->bindParam(':d',date("d-M-Y", $timestamp));
  $stmt->bindParam(':sT','13:45');
  $stmt->bindParam(':motmHID',$indexesHome[array_rand($indexesHome, 1)]);
  $stmt->bindParam(':motmAID',$indexesAway[array_rand($indexesAway, 1)]);
  $stmt->execute();

  $result_count = $result_count + 1;
}

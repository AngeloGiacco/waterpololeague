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
  $team_count = $team_count + 1;
}

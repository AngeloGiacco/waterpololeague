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
  $player_total = 9;
  $team_total = 3;
  while ($team_count < $team_total) {
    //coaches

    //delete existing coaches
    $stmt = $conn->prepare("DELETE FROM coaches");
    $stmt->execute();

    //create the coaches
    $stmt = $conn->prepare("INSERT INTO coaches VALUES (:id,:forename, :surname,:email,'blabla','')");
    $forename = $team_name_lst[$team_count]."coachforename";
    $surname = $team_name_lst[$team_count]."coachsurname";
    $email = "coach@".$team_name_lst[0].".com";
    $stmt->bindParam(':id',$team_count);
    $stmt->bindParam(':forename',$forename);
    $stmt->bindParam(':surname',$surname);
    $stmt->bindParam(':email',$email);
    $stmt->execute();

    //schools

    //delete the existing schools
    $stmt = $conn->prepare("DELETE FROM schools");
    $stmt->execute();

    //create the schools
    $name = $team_name_lst[$team_count];
    $logo = $name.".jpg";
    if ($team_count == 0) {
      $pl = 0;
      $pllink = "packedlunch.dx.am";
    } else {
      $pl = 1;
      $pllink = "";
    }
    $long = $team_count * 10;
    $lat = $team_count * 10;
    $stmt = $conn->prepare("INSERT INTO schools VALUES (:id,:name,:logo,:pl,:pllink,:long,:lat)");
    $stmt->bindParam(':id',$team_count);
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':logo',$logo);
    $stmt->bindParam(':pl',$pl);
    $stmt->bindParam(':pllink',$pllink);
    $stmt->bindParam(':long',$long);
    $stmt->bindParam(':lat',$lat);
    $stmt->execute();

    //teams
    //delete existing teams
    $stmt = $conn->prepare("DELETE FROM teams");
    $stmt->execute();

    //create the teams
    $stmt = $conn->prepare("INSERT INTO teams VALUES (:id,:sid,:cid,:gamesPlayed,:wins,:draws,:losses,:teamSuffix)");
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
    $team_count = $team_count + 1;
  }

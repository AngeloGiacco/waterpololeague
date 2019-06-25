<?php
  include_once("connection.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EMIS Water Polo</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href="styles/template.css" rel="stylesheet">
    <script>
    $(document).ready(function () {
      var tables = $("table");
      tables.hide().first().show();
      //Hides all the tables except first
      $("a.button").on("click", function () {
          //Adds eventListner to buttons
          tables.hide();
          //Hides all the tables
          var tableTarget = $(this).data("table");
          //Gets data# of button
          $("table#" + tableTarget).show();
          //Shows the table with an id equal to data attr of the button
      })
    });
    </script>
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a style = "color: #fbc93d" class="navbar-brand" href="#">EMIS Water Polo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="table.html">View League Table</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stats.html">View Statistics</a>
            </li>
          </ul>
          <a href = "login.html"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button></a>
        </div>
      </nav>
    </header>

    <main role="main" height = "100%">
      <div height = "50rem" id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="img-fluid" src="styles/images/waterpolo.jpg" alt="Water Polo">
            <div class="container">
              <div class="carousel-caption text-left" height="40rem">
                <h1>EMIS Water Polo League Stats</h1>
                <p>Check in on the water polo league for East Midlands Independent Schools</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <a class="button" data-table="1" href="#content">Goals</a>
      <a class="button" data-table="2" href="#content">Assists</a>
      <a class="button" data-table="3" href="#content">Minutes Played</a>
      <a class="button" data-table="4" href="#content">Man of the Match Awards</a>

      <div class="content">
        <table id="1">
          <tr><td>Player Name</td><td>Team</td><td>Goals</td></tr>
          <?php
            $stmt = $conn->prepare("SELECT TOP 5 * FROM players ORDER BY goals DESC");
            $stmt->execute();
            while ($player = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $goals = $player["goals"];
              $playerName = $player["forename"]." ".$player["surname"];
              $teamID = $player["teamID"];
              $query1 = $conn->prepare("SELECT * FROM team WHERE teamID = :tID");
              $query1->bindParam(":tID",$teamID);
              $query1->execute();
              $team = $query1->fetch(PDO::FETCH_ASSOC);
              $suffix = $team["teamSuffix"];
              $schoolID = $team["schoolID"];
              $query2 = $conn->prepare("SELECT name FROM schools WHERE schoolID = :sID");
              $query2->bindParam(":sID",$schoolID);
              $query2->execute();
              $schoolName = $query2->fetch(PDO::FETCH_ASSOC)["name"];
              $teamName = $schoolName." ".$suffix;
            }
          ?>
        </table>
        <table id="2"><tr><td>Player Name</td><td>Team</td><td>Assists</td></tr></table>
        <table id="3"><tr><td>Player Name</td><td>Team</td><td>Minutes Played</td></tr></table>
        <table id="4"><tr><td>Player Name</td><td>Team</td><td>Man of the Match Awards</td></tr></table>
      </div>

			<footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>Made by &copy;AngeloGiacco
        <a style = "font-size: 40px; margin-right: 20px; margin-left:10px" href="https://twitter.com/giaccoangelo" target="_blank"><i class="fa fa-twitter"></i></a>
        <a style = "font-size: 40px" href="https://www.linkedin.com/in/angelo-giacco-450b2017a/" target="_blank"><i class="fa fa-linkedin"></i></a></p>
        <p>Share This:
        <a style = "font-size: 40px; margin-right: 20px; margin-left: 10px;" href="https://twitter.com/home?status=Completely%20free,%20modern,%20water%20polo%20leageue%20management%20website%20by%20@giaccoangelo" target="_blank"><i class="fa fa-twitter"></i></a>
        <a style = "font-size: 40px; margin-right: 20px;" href="https://www.facebook.com/sharer/sharer.php?u=https://github.com/AngeloGiacco/waterpololeaguecoursework" target="_blank"><i class="fa fa-facebook"></i></a>
        <a style = "font-size: 40px; margin-right: 20px;"
        href="https://www.reddit.com/submit?title=Completely%20free,%20modern,%20water%20polo%20leageue%20management%20website&url=emiswaterpololeague.herokuapp.com" target="_blank"><i class="fa fa-reddit"></i></a>
        <a style = "font-size: 40px" href="https://www.linkedin.com/shareArticle?mini=true&url=emiswaterpololeague.herokuapp.com&title=Completely%20free,%20modern,%20water%20polo%20leageue%20management%20website" target="_blank"><i class="fa fa-linkedin"></i></a></p>
      </footer>
		</main>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  </body>
</html>

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
    <link href="styles/style.css" rel="stylesheet">
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a style = "color: #fbc93d" class="navbar-brand" href="#">EMIS Water Polo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="img-fluid" src="styles/images/waterpolo.jpg" alt="Water Polo">
            <div class="container">
              <div class="carousel-caption text-left" height="40rem">
                <h1>EMIS Water Polo</h1>
                <p>The water polo league for East Midlands Independent Schools</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container marketing" id = "overview">
        <div class="row">
          <div class="col-lg-4">
            <i class="fa fa-fire"></i>
            <h2>Efficiency</h2>
            <p>Coaches can spend less time writing emails and focus on the most important thing: coaching!</p>
          </div>
          <div class="col-lg-4">
            <i class="fa fa-mobile"></i>
            <h2>Tracking</h2>
            <p>Anyone can view the league table or a players stats! Viewing player stats is a great benefit for any coach.</p>
          </div>
          <div class="col-lg-4">
            <i class="fa fa-users"></i>
            <h2>User-friendly</h2>
            <p>This website is simpler to use than the legacy system used at Oundle school which will make life easier.</p>
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Oundle<span class="text-muted">School</span></h2>
            <p class="lead">Lead by Head of Swimming Julie Clipstone, Oundle School's team
              is an active and very successful member of the EMIS Water Polo League community.
              We look forward to seeing what silverware they will be taking home this year!</p>
            <p><a class="btn btn-info" href="viewTeam.php?teamname=oundle" role="button">View team &raquo;</a></p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="styles/images/oundle.jpg" alt="Oundle">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Bishop Stortford<span class="text-muted">College</span></h2>
            <p class = "lead">Bishop Storford College is a great addition to the EMIS Water Polo community!
            Their matches are always filled with action and great fun to watch.
            We wish them the best of luck this year!</p>
            <p><a class="btn btn-info" href="viewTeam.php?teamname=bss" role="button">View team &raquo;</a></p>
          </div>
          <div class="col-md-5 order-md-1">
            <br><br><img class="featurette-image img-fluid mx-auto" src="styles/images/bss.jpg" alt="Bishop Stortford">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-8">
            <h2 class="featurette-heading">Uppingham<span class="text-muted">School</span></h2>
            <p class = "lead">Uppingham are a great team to play with!
            Their matches are always filled with action and great fun to watch.
            We wish them the best of luck this year!</p>
            <p><a class="btn btn-info" href="viewTeam.php?teamname=uppingham" role="button">View team &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <br><br><img class="featurette-image img-fluid mx-auto" src="styles/images/uppingham.jpg" alt="Uppingham">
          </div>
        </div>

        <hr class="featurette-divider">

        <div style = "padding-bottom:20px;" class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Stamford<span class="text-muted">School</span></h2>
            <p class = "lead">Stamford have a great water polo team!
            Oundle's local rivals, it is always exciting to see how their matches unfold.
            We wish them the best of luck this year!</p>
            <p><a class="btn btn-info" href="viewTeam.php?teamname=stamford" role="button">View team &raquo;</a></p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="styles/images/stamford.jpg" alt="Stamford">
          </div>
        </div>
        <hr class="featurette-divider">
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

<?php
require("connectdb.php");
require("food_db.php");

$msg = '';

$all_restaurants = getAllRestaurants();
?>













<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Food</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Food App</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Search
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Account</a>
        </ul>
      </div>
    </div>
  </nav>




  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">Food</h1>
        <div class="list-group">
          <a href="#" class="list-group-item">Category 1</a>
          <a href="#" class="list-group-item">Category 2</a>
          <a href="#" class="list-group-item">Category 3</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>


        <!-- Search Bar -->
        <div class="search_bar">
          <input class = "form-control mb-4" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for restaurants" title="Search for restaurants">
          <script>
          function myFunction() {
              var input, filter, row, res_cards, a, i, txtValue;
              input = document.getElementById("myInput");
              filter = input.value.toUpperCase();
              row = document.getElementById("row");
              res_cards = row.getElementsByClassName("col-lg-4 col-md-6 mb-4")
              for (i = 0; i < res_cards.length; i++) {
                  a = res_cards[i].getElementsByTagName("a")[1];
                  txtValue = a.textContent || a.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      res_cards[i].style.display = "";
                  } else {
                      res_cards[i].style.display = "none";
                  }
              }
          }
          </script>
        </div>


        <!-- Row -->

        <body>
        <div id = "row" class="row">
          <?php foreach ($all_restaurants as $restaurant): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <!-- <a href="#"><img class="card-img-top" src="blue.jpg" alt="" style="width:700;height:400;"></a> -->
              <div class="card-body">
                <h4 class="card-title">
                  <script>
                  function getURL() {
                    url = "menu.php?id=" + "<?php echo $restaurant['id']?>"
                    document.write(url)
                  }
                  </script>
                  <a id = "res_url" href="menu.php?id=<?php echo $restaurant['restaurantID'];?>"> <?php echo $restaurant['restaurant_name']; ?></a>
                </h4>
                <h5><?php echo $restaurant['cuisine']?></h5>
                <p class="card-text"><?php echo $restaurant['restaurant_address']?></p>
              </div>
              <div class="card-footer">
                <script>
                rating = "<?php echo $restaurant['average_rating']?>"
                if (rating >= 0 && rating <= 5) {
                            rating = Math.round(rating);
                            checked = '<span class="fa fa-star checked"></span>';
                            unchecked = '<span class="fa fa-star"></span>';
                            document.write(checked.repeat(rating) + unchecked.repeat(5-rating));
                          } else{
                            document.write(unchecked.repeat(5));
                          }
                </script>
                <!-- <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> -->
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        .checked {
          color: orange;
        }
        </style>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>


<?php
require("connectdb.php");
require("food_db.php");
session_start();
$msg = '';

echo $_SESSION['user'];
$username =$_SESSION['user'];
$all_orders = getOrders($username);

?>



<!DOCTYPE html>
<html lang="en">
<body>

<?php include "./src/header.html" ?>

  <!-- Page Content -->
  <div class="container", style = "padding: 50px">

    <div class="row">

      <div class="col-lg-11" style='margin:auto'>


    


      <div class="row" >
              <?php foreach ($all_orders as $order):
                $order_number = $order['order_number'];


                $orderInfo = getOrdersDetails($order_number);
              ?>

                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="card h-100">

                   
                    <div class="card-body" >
                      <h4 class="card-title">
                      
                      </h4>
                      <h5>Order number: <?php echo $order_number;?></h5>
                      <p class="lead mb-0">Total: <?php echo $orderInfo[0]['total'];?></p>
                      <p class="lead mb-0">Tips: <?php echo $orderInfo[0]['tip'];?></p>
                      <p class="lead mb-0">Date: <?php echo $orderInfo[0]['date'];?></p>
                      <p class="lead mb-0">tracking: <?php echo $orderInfo[0]['tracking_info'];?></p>

                    </div>


                  </div>
                </div>
              <?php endforeach; ?>

        </div>
        <!-- end row -->


      </div>
      <!-- /.col-lg-11 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <?php include "./src/footer.html" ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



  
</body>

</html>

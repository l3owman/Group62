<?php
    session_start();
    include('config.php');
    include('trans_setup.php');

?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Months', 'Sales By Month'],
                ['Jan', <?php echo $sales_array["01"]/100; ?>],
                ['Feb', <?php echo $sales_array["02"]/100; ?>],
                ['Mar', <?php echo $sales_array["03"]/100; ?>],
                ['Apr', <?php echo $sales_array["04"]/100; ?>],
                ['May', <?php echo $sales_array["05"]/100; ?>],
                ['Jun', <?php echo $sales_array["06"]/100; ?>],
                ['Jul', <?php echo $sales_array["07"]/100; ?>],
                ['Aug', <?php echo $sales_array["08"]/100; ?>],
                ['Sep', <?php echo $sales_array["09"]/100; ?>],
                ['Oct', <?php echo $sales_array["10"]/100; ?>],
                ['Nov', <?php echo $sales_array["11"]/100; ?>],
                ['Dec',   <?php echo $sales_array["12"]/100; ?>]
            ],false);

            var options = {
                title: 'Sales By Calendar Year <?php echo $_SESSION["year"]?> ',
                //curveType: 'function',
                legend: {position: 'bottom'}
            };


        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.html">UniBid</a>
      
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <?php if(isset( $_SESSION['isLoggedOn'])): ?>
             <a class="nav-link" href="logout.php">Log Out</a>
        <?php else: ?>
            <a class="nav-link" href="login.html">Sign In</a>
        <?php endif; ?>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <?php if(isset( $_SESSION['isLoggedOn'])): ?>
                <h5 class="text-center"><?php
                    echo $_SESSION["forename"];
                    echo " ";
                    echo $_SESSION["surname"];
                  ?></h5>
                <h7 class="text-center"><?php
                    echo "Admin";
                  ?></h7>
                <div class="border-top my-4"></div>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link" href="admin.php">
                  <span data-feather="edit"></span>
                  Manage Complaints
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="transaction.php">
                  <span data-feather="activity"></span>
                  Transaction History<span class="sr-only">(current)</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
             <h1 class="h2">Transaction History</h1>
             <div class="btn-toolbar mb-2 mb-md-0">
             </div>
           </div>
            <ul class="nav nav-tabs nav-justified mb-3">
              <li class="nav-item">
                <a class="nav-link active" href="transaction.php">All Transactions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="specific_transaction.php">Specific Transaction</a>
              </li>
            </ul>

            <div id="curve_chart" style="width: 900px; height: 500px"></div>


                <form action="transaction_year.php" method="post">
                    <select class="custom-select" name="transactionYear" id="transactionYear" onchange='this.form.submit()'>
                        <option value=2018 >2018</option>
                        <option value=2019>2019</option>
                        <option value=2020>2020</option>
                        <option value=2021>2021</option>
                    </select>
                    <noscript>  <input type="submit" class="btn btn-primary btn-block btn-lg"></noscript>
                </form>

          </div>

        </div>

    <script type="text/javascript">
        document.getElementById('transactionYear').value = "<?php echo $_SESSION['year'];?>";
    </script>

        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>

      </body>
</html>

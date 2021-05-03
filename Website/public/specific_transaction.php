<?php
session_start();
include('config.php');
include('specific_trans_setup.php');

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
                ['Jan', <?php echo  $salesArray["01"] ;?>],
                ['Feb', <?php echo $salesArray["02"]; ?>],
                ['Mar', <?php echo $salesArray["03"]; ?>],
                ['Apr', <?php echo $salesArray["04"]; ?>],
                ['May', <?php echo $salesArray["05"]; ?>],
                ['Jun', <?php echo $salesArray["06"]; ?>],
                ['Jul', <?php echo $salesArray["07"]; ?>],
                ['Aug', <?php echo $salesArray["08"]; ?>],
                ['Sep', <?php echo $salesArray["09"]; ?>],
                ['Oct', <?php echo $salesArray["10"]; ?>],
                ['Nov', <?php echo $salesArray["11"]; ?>],
                ['Dec',   <?php echo $salesArray["12"]; ?>]
            ],false);

            var options = {
                title: 'Sales For <?php echo $_SESSION["location"]; ?> By Calendar Year <?php echo date('Y'); ?>' ,
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
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" id="search">
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
                    <a class="nav-link " href="transaction.php">All Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="specific_transaction.php">Specific Transaction</a>
                </li>
            </ul>

            <div id="curve_chart" style="width: 900px; height: 500px"></div>

            <form action="transaction_location.php" method="post">
            <select class="custom-select" name="transactionLocation" id="transactionLocation" onchange='this.form.submit()'>

                <?php
                foreach($postcodeArr as $key => $value){
                    echo "<option value='$key'>$key</option>";
                }
                ?>
                <option name="years"> </option>
            </select>
            </form>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('transactionLocation').value = "<?php echo $_SESSION['location'];?>";
</script>

<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

</body>
</html>

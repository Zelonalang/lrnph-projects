<?php
include './connection1.php';
include_once './config/Database.php';
include_once './class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (!$user->loggedIn()) {
  header("Location: index.php");
  exit;
}

include './inc/header4.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>LRNPH | Report Preview</title>
  <link rel="shortcut icon" type="image/png" href="./images/La Rose Official Logo Revised 11292017-01.jpg">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="print.css" media="print">
  <script>
    $(document).ready(function() {
      // Function to handle live search for coater column
      $('#coater-search').on('keyup', function() {
        var input = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
          $(this).toggle($(this).find('td:nth-child(1)').text().toLowerCase().indexOf(input) > -1);
        });
      });

      // Function to handle live search for shape column
      $('#shape-search').on('keyup', function() {
        var input = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
          $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(input) > -1);
        });
      });

      // Initialize datepicker for the date search input
      $('#date-search').datepicker({
        dateFormat: 'mm-dd-yy',
        onSelect: function(dateText, inst) {
          var input = $(this).val().toLowerCase();
          $('tbody tr').filter(function() {
            $(this).toggle($(this).find('td:nth-child(6)').text().toLowerCase().indexOf(input) > -1);
          });
        }
      });
    });
  </script>
  <style>
    /* Hide search input on printing */
    @media print {
      #coater-search,
      #shape-search,
      #date-search {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered print">
          <thead>
            <p align="right" style="font-size: 12px">
              <br>Coating Report Date and Time: <?php
              $current_timezone = date_default_timezone_get();
              date_default_timezone_set('Asia/Kuala_Lumpur');
              $current_timezone = date_default_timezone_get();
              echo date("m-d-Y H:i:s");
              ?>
            </p>
            <h4><a href="./dashboard.php"><img src="./images/La Rose Official Logo Revised 11292017-01.jpg" height="60px"></a> La Rose Noire Philippines, Inc.</h4>
            <tr>
              <input type="text" id="coater-search" placeholder="Select Coater">
              <input type="text" id="shape-search" placeholder="Select Shape/Size">
              <input type="text" id="date-search" placeholder="Select Date">
              <th style="padding: 1px 1px 1px 1px">Coater</th>
              <th style="padding: 1px 1px 1px 1px">Shape/Size</th>
              <th style="padding: 1px 1px 1px 1px">Total Blister</th>
              <th style="padding: 1px 1px 1px 1px">Total Pcs/Blister</th>
              <th style="padding: 1px 1px 1px 1px">Total Incentive</th>
              <th style="padding: 1px 1px 1px 1px">Date</th>
              <th style="padding: 1px 1px 1px 1px">Recorder</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sn = 1;
            $user_qry = "SELECT *, cname, csize, SUM(cszrate) as cszrate, SUM(coutput) AS coutput, SUM(totalpblispcs) AS totalpblispcs FROM lrncoating GROUP BY cname, csize ORDER BY cname ASC";
            $user_res = mysqli_query($con, $user_qry);
            while ($user_data = mysqli_fetch_assoc($user_res)) {
              ?>
              <tr>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['cname']; ?></td>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['csize']; ?></td>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['coutput']; ?></td>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['totalpblispcs']; ?></td>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['cszrate']; ?></td>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['cdate']; ?></td>
                <td style="padding: 1px 1px 1px 1px; font-size:12px"><?php echo $user_data['crecorder']; ?></td>
              </tr>
            <?php
              $sn++;
            }
            ?>
          </tbody>
        </table>
        <ul class="navbar-nav ml-auto">
          <?php if (!empty($_SESSION) && $_SESSION["userid"]) { ?>
            <li class="nav-item">
              <a class="nav-link" style="font-size: 12px">Prepared by: <?php echo ucfirst($_SESSION["first_name"]); ?><?php echo ucfirst($_SESSION["last_name"]); ?> </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./logout.php"></a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="./index.php"></a>
            </li>
          <?php } ?>
        </ul>
        <div class="text-center">
          <a href="report.php" class="btn btn-primary" id="print-btn">Back</a>
          <button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

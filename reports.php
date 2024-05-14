<?php include 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<style type="text/css">
	 header {
        background-color: rgba(51, 51, 51, 0.8);
        color: #fff;
        padding: 10px;
        display: flex;
        align-items: center;
        backdrop-filter: blur(5px);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;

         font-size: 1.2rem; /* Responsive font size for the header */
    } 


        /* CSS for the div */
        .content-container {
        	margin-top: 68px;
        	margin-left: 5px;
        	margin-right: 5px;
            padding: 20px; /* Add your desired padding */
            background-color: #f5f5f5; /* Add your desired background color */
            border: 10px solid #ccc; /* Add your desired border style */
            border-radius: 5px; /* Add border radius if needed */
        }


        /* CSS for the div */
        .content-container2 {
            margin-top: 10px;
            margin-left: 5px;
            margin-right: 5px;
            padding: 20px; /* Add your desired padding */
            background-color: #f5f5f5; /* Add your desired background color */
            border: 10px solid #ccc; /* Add your desired border style */
            border-radius: 5px; /* Add border radius if needed */
        }


</style>
</head>
<body>
 <div class="content-container">
    <h2>Shift Reports <a href="shiftreport.php"><img id="infoImage" src="images/redirect.png" alt="Info" style="width: 15px; height: 15px; margin-top: 10px;" ></a></h2>
   
    <?php include 'outputlist.php'; ?>
	
</div>
 <div class="content-container2">
     <h2>Coater Incentives</h2>
    <?php include 'Incentivelist.php'; ?>
</div>
<!-- <br><div class="content-container2">
     <h2>Update Employee table</h2>
   
</div> -->
</body>
</html>
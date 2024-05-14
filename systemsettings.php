<?php include 'header.php'; ?>
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

 <div class="content-container">
    <h2>Coating Shape/Sizes <a href="redirectedshapelist.php"><img id="infoImage" src="images/redirect.png" alt="Info" style="width: 15px; height: 15px; margin-top: 10px;" ></a></h2>
   
    <?php include 'shapelist.php'; ?>
	
</div>
 <div class="content-container2">
     <h2>System Accounts</h2>
    <?php include 'usermanagement.php'; ?>
</div>


<!-- <div class="content-container2">
     <h2>DB Table Viewer <a href="jtbv.php"><img id="infoImage" src="images/redirect.png" alt="Info" style="width: 15px; height: 15px; margin-top: 10px;" ></a></h2>
     <?php include 'tbv.php'; ?>
</div> -->
<br>

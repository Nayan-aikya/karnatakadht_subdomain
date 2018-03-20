<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <meta name="description" content="">
      <meta name="keywords" content="">
      <meta name="author" content="">
      <link rel="icon" href="images/title.png">
      <title> Department of Handlooms and Textiles - Home</title>
      <?php include dirname(__FILE__). "/css.php"; ?>
      <style type="text/css">
         .ulhome ul li {
         cursor: pointer;
         }
		 .hidethis {
			 display:none;
			 
		 }
      </style>
   </head>
   <body>
      <?php include dirname(__FILE__). "/menu.php"; ?>
      <div id="white-bg" style="min-height: 500px;">
         <div class="extInlineMenu container-fluid">
            <?php if (isset($_SESSION['username']) and ($_SESSION['username'] != 'COMMISSIONER')) { ?> 
            <div class="col-sm-12">
                  <ul class="">
                  <li id="report1"><a href="progress-report.php">progress report</a>
                  </li>
                  <li id="report2"><a href="training-and-placement.php">training and placement</a>
                  </li>
                  <li id="report3"><a href="number-of-candidates.php">number of candidates</a>
                  </li>
                  <li id="report4"><a href="batchwise-training.php">batchwise training</a>
                  </li>
                  <li id="report5"><a href="year-skill-development-program.php">year skill development program</a>
                  </li>
                  <li id="formsmen"><a href="home.php">back to forms<i class="fa fa-undo" aria-hidden="true"></i></a></li>
                  </ul>
            </div>
            <?php } ?>
      </div>
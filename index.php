<?php
session_start();

if (isset($_SESSION['user_id']) and intval($_SESSION['user_id']) > 0) {
    if (isset($_SESSION['username']) and ($_SESSION['username'] == 'COMMISSIONER')) {
        header("Location: centers.php");
    } else {
        header("Location: home.php");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {
    require dirname(__FILE__) . '/dbconnect.php';
    $user = $db->where('username', trim($_POST['username']))->where('password', trim($_POST['password']))->getOne('users');
    
    if ($db->count > 0) {
        $_SESSION['userid']   = $user["id"];
        $_SESSION['username'] = $user["username"];

        if ($user["username"] == 'COMMISSIONER') {
            header("Location: centers.php");        
        } else {
            header("Location: home.php");
        }     
        exit;
    } else {
        $message = 'Wrong username or password';
    }
}

?>

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
      <link rel="stylesheet" type="text/css" href="dist/css/style-custom.css">
      <title> Department of Handlooms and Textiles - Home</title>
      <?php include dirname(__FILE__) . '/css.php'; ?>
   </head>
   <body>
     <?php include dirname(__FILE__) . '/menu.php'; ?>
      <div id="white-bg">
         <div class="container">
            <div class="row">
             <div class="col-sm-offset-4 col-sm-4">
                 <div class="wrapper extFormWrapper">
                  <?php if (isset($message)) { ?>
                  <div class="alert alert-danger"><?php echo $message; ?></div>     
                  <?php } ?>     
                  <form class="extFormSignin" action ="index.php" method = "post">
                     <h2 class="extFormSigninHeading">Please login</h2>
                     <input type="text" class="extFormControl" name="username" placeholder="Username" required="" autofocus="" />
                     <input type="password" class="extFormControl" name="password" placeholder="Password" required=""/>      
                     <!-- <label class="extCheckbox">
                     <input type="checkbox"  id="rememberMe" name="rememberMe"> Remember me
                     </label> -->
                     <input type="submit" name="submitForm" class="btn btn-lg btn-primary btn-block" value="Login">  
                  </form>
               </div>
                 
                </div>
             </div>
         </div>
      </div>
      <?php include dirname(__FILE__) . '/footer.php'; ?>
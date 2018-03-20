<div class="">
    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="">
                <div class="sectionStart">
    <div class="clearfix toper">	
        <div class="headText">Welcome </div>
        <div class="buttSec" id="extLogout"><a title="Logout" href="logout.php"><img src="images/Logout-512.png" alt="logout" class="img-responsive"></a></div>
    </div>    
    <ul class="extList">
        <?php if (isset($_SESSION['username']) and $_SESSION['username'] != 'COMMISSIONER') { ?>    
        <li id="form1"><a href="home.php">Training Centre<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <li id="form2"><a href="physical-financial-target.php">Physical & Financial target<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <li id="form3"><a href="physical-financial-achievement.php">Physical & Financial achievement<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <li id="form4"><a href="employment-details.php">Employment Details<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <li id="form4"><a href="centre-details.php">Centre Details<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if (isset($_SESSION['username']) and in_array($_SESSION['username'], array('COMMISSIONER', 'DD_HO', 'JD_HO'))) { ?>
        <li id="form5"><a href="centers.php">Training Centres List<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <li id="form6"><a href="financial-year.php">Financial Years List<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <?php } ?>
    </ul>
</div>
<div class="clearfix">&nbsp;</div>
        
            </div>
        </div>
</div>
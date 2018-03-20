<?php $page = basename($_SERVER['SCRIPT_NAME']); ?> 
<header>
<div id="logobg">
	<div class="container">
    	<div class="row">
        	
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin:10px 0 5px 10px;">  
            	<a href="index.php"><img src="images/logo.png" class="img-responsive"/></a>  
                      
			</div>
            <div class="clearfix visible-xs">&nbsp;</div>
			
			<div class="col-lg-6 col-md-6 col-sm-7 pull-right hidden-xs">
			   <div class="col-md-6 col-sm-6 col-xs-12 pull-left margin-left hidden-xs ">
				   <div style="padding: 7px 0px 0px 0px;" class="hidden-sm hidden-xs">&nbsp;</div>
					<div style="padding:7px 0px 0px 0px;" class="visible-xs"></div>
					<div class="text-center contact-no"> 
                   <span>CONTACT US @ 080 235 61628</span>
					</div>
					
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-2 col-xs-12 pull-left padd-right text-center-sm text-left-xs lang margin-top-5" >
				<div style="padding: 0px 0px 0px 0px;" class="hidden-sm hidden-xs">&nbsp;</div>
				 <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">English
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
					  <li><a href="kannada/index.php">ಕನ್ನಡ</a></li>
					  <li><a href="../index.php">English</a></li>
					</ul>
				</div>
				
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 pull-right margin-top-8 space">
					<img src="images/gov-logo.png" class="img-responsive"/>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-6  visible-xs">
			   
				
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 padd-right text-center-sm text-left-xs" >
				<div style="padding: 0px 0px 0px 0px;" class="hidden-sm hidden-xs">&nbsp;</div>
				 <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">English
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
					  <li><a href="kannada/index.php">ಕನ್ನಡ</a></li>
					  <li><a href="../index.php">English</a></li>
					</ul>
				</div>
				<div class="col-xs-3">&nbsp;</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 text-center-xs space">
					<img src="images/gov-logo.png" class="img-responsive"/>
				</div>
				<div class="clearfix"></div>
			</div>
        </div>
    </div>
</div>

<div id="menubg">
	<div class="container gap">
    	<div class="row gap">
        	
			<div class="col-md-1 col-sm-3 col-xs-12  hidden-xs">
              
            </div>
           
			<div class="col-md-11 col-sm-12 col-xs-12" align="center">
				<div id='cssmenu' >
					<ul>
						<li><a href="index.php" <?php if ($page == 'index.php') { ?>class="current"<?php } ?>> Home </a></li>
						<li><a href="about-us.php" <?php if ($page == 'about-us.php') { ?>class="current"<?php } ?>> About Us </a></li>
						<li><a href="policies.php" <?php if ($page == 'policies.php') { ?>class="current"<?php } ?>> Policies </a></li>
						<li><a href="schemes.php" <?php if ($page == 'schemes.php') { ?>class="current"<?php } ?>> Schemes </a></li>
						<li><a href="notifications-coop-society.php" <?php if ($page == 'notifications.php') { ?>class="current"<?php } ?>> Notification </a></li>
						<li><a href="circular.php" <?php if ($page == 'circular.php') { ?>class="current"<?php } ?>> Circular </a></li>
						<li><a href="njn-acts.php" <?php if ($page == 'circular.php') { ?>class="current"<?php } ?>> ACTS </a></li>
						<li><a href="citizens.php" <?php if ($page == 'citizens.php') { ?>class="current"<?php } ?>> Citizens </a></li>
						<li><a href="handlooms-gallery.php" <?php if ($page == 'faq.php') { ?>class="current"<?php } ?>> Gallery </a></li>
						<li><a href="contact-us.php" <?php if ($page == 'contact-us.php') { ?>class="current"<?php } ?>> Contact Us </a></li>
												
						
					</ul>
				</div>
            </div>
			
			<div class="col-md-1 col-sm-3 col-xs-12  hidden-xs">
              
            </div>
                        
        </div>
    </div>
</div>


</header>
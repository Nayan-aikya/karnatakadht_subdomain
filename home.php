<?php 
require dirname(__FILE__). "/config.php";

if (isset($_SESSION['username']) and ($_SESSION['username'] == 'COMMISSIONER')) {
    header("Location: centers.php");
    exit;
}

$centers = [];

if (!in_array($_SESSION['username'], array('DD_HO', 'JD_HO'))) {
    $db->where('userid', $_SESSION['userid']);
}

$centers_list = $db->get("centers", null, array('id', 'center'));

foreach ($centers_list as $list) {
    $centers[$list['id']] = $list['center'];
}

reset($centers);
$center_id = key($centers); 

if ($_SERVER['REQUEST_METHOD'] == 'POST'
and isset($_POST['center'])
and array_key_exists($_POST['center'], $centers)    
) {
    $center_id = $_POST['center'];
    require dirname(__FILE__). "/class.upload.php";
    foreach (array('uploadpic','pancardimage', 'gstimage', 'adharcardimage') as $file) {
        $handle = new Upload($_FILES[$file]);
        if ($handle->uploaded) {
            $handle->process(dirname(__FILE__).'/uploads/');
            if ($handle->processed) {
                $_POST[$file] = $handle->file_dst_name;
            }
        }
        $handle->clean();
    }
    
    $trainingstart = (new DateTime())->createFromFormat('d-m-Y', $_POST['trainingstart']);
    if (!($trainingstart) or ($trainingstart->format('d-m-Y') != $_POST['trainingstart'])) {
        unset($_POST['trainingstart']);
	}

	if ($db->where("center", $center_id)->has("center_details")) {
        unset($_POST['center']);
        if ($db->where("center", $center_id)->update ('center_details', $_POST, 1)) {
            $success = 'Training center updated';
        } else {
            $error = 'Training center updated failed';
        }
    } else {
        if ($id = $db->insert('center_details', $_POST)) {
			$data = Array (
    "approved" => "'0'",
    "centre_id" => $id,
   
);

$db->insert('centre_approved',$data);
            $success = 'Training center inserted';
        } else {
            $error = 'Training center insert failed';
        }
    }
}

if (isset($_GET['center_id']) and (array_key_exists($_GET['center_id'], $centers))) {
    $center_id = $_GET['center_id'];
} 

$post_url = 'home.php?center_id=' . $center_id;

$result = $db->where('center', $center_id)->getOne('center_details');

?>
<?php include dirname(__FILE__). "/header.php"; ?>
 <div class="container">
	<div class="col-sm-12">
	   <div class="col-sm-4 extMainMenu">
		  <?php include("leftnav.php"); ?>
	   </div>
	   <div class="col-sm-8 extFormPanel" style="">
		  <div class="row padding-bot-01" id="mainform1" >
             <?php if (isset($success)) { ?>
              <div class="alert alert-success">
                <strong>Success!</strong> <?php echo $success; ?>
              </div>
            <?php } ?>
            <?php if (isset($error)) { ?>
              <div class="alert alert-danger">
                <strong>Error!</strong> <?php echo $error; ?>
              </div>
            <?php } ?>  
			 <h5>Training Centre</h5>
			 <div class="col-md-12">
				<form id="tc-form" method="post" enctype="multipart/form-data" action="<?php echo $post_url; ?>">
				   <div class="row form-box padding-bot-02">
					  <div class="col-md-12">
						 <label for="email">Training Center Name</label>
						 <select class="form-control" name="center" id="center" onchange="window.location.href = 'home.php?center_id='+this.options[this.selectedIndex].value;">
							<?php foreach ($centers as $key => $value ) { ?>
                            <?php if ($key == $center_id) { ?>
                            <option	value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                            <?php } else { ?>    
							<option	value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?> 
							<?php } ?>
						 </select>
					  </div>
					  <div class="col-md-6">
						 <label for="oname">Owner Name</label>
						 <input type="text" class="form-control" name="oname" id="oname" value="<?php echo $result ? $result['oname'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="uploadpic">Upload Picture</label>
						 <input type="file" class="form-control" name="uploadpic" id="uploadpic" >
                         <?php if ($result and is_file(dirname(__FILE__).'/uploads/' . $result['uploadpic'])) { ?>
                          <small><a href="uploads/<?php echo $result['uploadpic']; ?>">view picture</a></small>  
                         <?php } ?>  
					  </div>
					  <div class="col-md-6">
						 <label for="address">Address Line 1</label>
						 <input type="text" class="form-control" placeholder="Building  Name and Number" name="buildingname" value="<?php echo $result ? $result['buildingname'] : ''; ?>" id="buildingname" >
					  </div>
					  <div class="col-md-6">
						 <label for="address">Address Line 2</label>
						 <input type="text" class="form-control" placeholder="Road Name" name="roadname" id="roadname" value="<?php echo $result ? $result['roadname'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="address">Address Line 3</label>
						 <input type="text" class="form-control" placeholder="Locality" name="locality" id="locality" value="<?php echo $result ? $result['locality'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="address">Address Line 4</label>
						 <input type="text" class="form-control" placeholder="Pincode" name="pincode" id="pincode" value="<?php echo $result ? $result['pincode'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">Email ID</label>
						 <input type="email" class="form-control" name="email" id="email" value="<?php echo $result ? $result['email'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">Mobile Number</label>
						 <input type="text" class="form-control" name="mobilenum" id="mobilenum" value="<?php echo $result ? $result['mobilenum'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">Landline Number</label>
						 <input type="text" class="form-control" name="landline" id="landline" value="<?php echo $result ? $result['landline'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">Website ID</label>
						 <input type="text" class="form-control" name="websiteid" id="websiteid" value="<?php echo $result ? $result['websiteid'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">PAN Card</label>
						 <input type="text" class="form-control" name="pancard" id="pancard" value="<?php echo $result ? $result['pancard'] : ''; ?>" > 
					  </div>
					  <div class="col-md-6">
						 <label for="email">PAN Card Image Upload</label>
						 <input type="file" class="form-control" name="pancardimage" id="pancardimage" >
                         <?php if ($result and is_file(dirname(__FILE__).'/uploads/' . $result['pancardimage'])) { ?>
						<small><a href="uploads/<?php echo $result['pancardimage']; ?>">view pan card image</a></small>  
                         <?php } ?>  
					  </div>
					  <div class="col-md-6">
						 <label for="email">GST</label>
						 <input type="text" class="form-control" name="gst" id="gst" value="<?php echo $result ? $result['gst'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">GST Image Upload</label>
						 <input type="file" class="form-control" name="gstimage" id="gstimage" >
                         <?php if ($result and is_file(dirname(__FILE__).'/uploads/' . $result['gstimage'])) { ?>
                         <small><a href="uploads/<?php echo $result['gstimage']; ?>">view gst image</a></small>  
                         <?php } ?>  
					  </div>
					  <div class="col-md-6">
						 <label for="email">Training Centre started on </label>
						 <input type="text" class="form-control" name="trainingstart" id="trainingstart" value="<?php echo $result ? $result['trainingstart'] : ''; ?>" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">Aadhar Card </label>
						 <input type="text" class="form-control" name="adharcard" value="<?php echo $result ? $result['adharcard'] : ''; ?>" id="adharcard" >
					  </div>
					  <div class="col-md-6">
						 <label for="email">Aadhar Card Image Upload</label>
						 <input type="file" class="form-control" name="adharcardimage" id="adharcardimage" >
                         <?php if ($result and is_file(dirname(__FILE__).'/uploads/' . $result['adharcardimage'])) { ?>
                         <small><a href="uploads/<?php echo $result['adharcardimage']; ?>">view aadhar card image</a></small>  
                         <?php } ?>  
					  </div>
					  <div class="col-md-6">
						 <label for="email">Type of Centre </label>
						 <select class="form-control" name="centertype" id="centertype">
							<?php foreach(['Govt Training Centre', 'Private Training Centre' ] as $center_type) { ?>
							<?php if (($result) and ($result['centertype'] == $center_type)) { ?>
							<option value="<?php echo $center_type; ?>" selected="selected"><?php echo $center_type; ?></option>	
							<?php } else { ?>
							<option value="<?php echo $center_type; ?>"><?php echo $center_type; ?></option>
							<?php } ?>	
							<?php } ?>	
						</select>
					  </div>
					  <div class="col-md-6">
						 <label for="email">Training Subject </label>
						 <select class="form-control" name="trainingsub" id="trainingsub">
							<?php foreach(['Specialized Sewing Machine Operator', 'Power loom Weaving', 'Hand loom Weaving' ] as $training_sub) { ?>
                            <?php if (($result) and ($result['trainingsub'] == $training_sub)) { ?> 
							<option value="<?php echo $training_sub; ?>" selected="selected"><?php echo $training_sub; ?></option>	
							<?php } else { ?>
							<option value="<?php echo $training_sub; ?>"><?php echo $training_sub; ?></option>
							<?php } ?>	
							<?php } ?>
						 </select>
					  </div><div class="col-md-6">
						 <label for="email">Status </label>
						 <select class="form-control" name="centrestatus" id="centrestatus">
							<?php foreach(['Active', 'Defunct', 'Idle' ] as $training_sub) { ?>
                            <?php if (($result) and ($result['centrestatus'] == $training_sub)) { ?> 
							<option value="<?php echo $training_sub; ?>" selected="selected"><?php echo $training_sub; ?></option>	
							<?php } else { ?>
							<option value="<?php echo $training_sub; ?>"><?php echo $training_sub; ?></option>
							<?php } ?>	
							<?php } ?>
						 </select>
					  </div>
					  					  <div class="col-md-12" style="padding-top: 20px;">
						 <div class="col-md-8"></div>
						 <div class="col-md-4">
							<button id="submitForm1" class="form-control">Submit</button>
						 </div>
					  </div>
				   </div>
				</form>
			 </div>
		  </div>
		  </div>
	   </div>
	</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
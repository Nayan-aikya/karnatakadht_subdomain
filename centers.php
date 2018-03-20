<?php
require dirname(__FILE__). "/config.php";

if (isset($_SESSION['username']) and !(in_array($_SESSION['username'], array('COMMISSIONER', 'DD_HO', 'JD_HO')))) {
    header("Location: home.php");
    exit;
}

$disticts = [];

$districts_list = $db->where("district", null, 'IS NOT')->get('users', null, array('id', 'district'));

foreach ($districts_list as $list) {
    $disticts[$list['id']] = $list['district'];
}

if (isset($_GET['center']) and intval($_GET['center']) > 0) {
    $center_id = $_GET['center'];
}

if (isset($_GET['action'], $center_id) and $_GET['action'] == 'delete') {
    $db->where('id', $center_id);
    if($db->delete('centers')) {
        header('Location:centers.php?success=delete'); 
    } else {
        header('Location:centers.php?error=delete');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'
and !empty($_POST['name'])
and !empty($_POST['district'])
and array_key_exists($_POST['district'], $disticts)
) {
    if (isset($center_id)) {
		print_r($_POST);
		
        $db->where('id', $center_id);
        if ($db->update ('centers', array(
            'center' => $_POST['name'], 
            'userid' => $_POST['district']
        ), 1)) {
			 echo 1;
			 echo 'update centre_approved set approved ="'.$_POST['approved_id'].'" where centre_id ='. $center_id;
			 $db->rawQuery('update centre_approved set approved ="'.$_POST['approved_id'].'" where centre_id = '.$center_id);
			 
            header('Location:centers.php?success=update');        
         
		}else {
            header('Location:centers.php?error=update');
        }
    } else {
        if ($id = $db->insert ('centers', array(
            'center' => $_POST['name'], 
            'userid' => $_POST['district']
        ))) {
            header('Location:centers.php?success=insert');        
        } else {
            header('Location:centers.php?error=insert');
        }
    }
    exit;
}

$db->join("users u", "c.userid=u.id", "LEFT");
$db->join("centre_approved ca","c.id = ca.centre_id","LEFT");
$db->orderBy("c.id","desc");
$centers = $db->get("centers c", null, array('c.id', 'c.center', 'u.id as did', 'u.district','ca.approved'));
//print_r($centers);
include dirname(__FILE__). "/header.php"; ?>
<div class="container">
    <div class="col-sm-12">
        <div class="col-sm-4 extMainMenu">
            <?php include("leftnav.php"); ?>
        </div>
        <div class="col-sm-8 extFormPanel" style="">
            <div class="row padding-bot-01" id="centersf">
                <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                Traing center <?php echo $_GET['success']; ?> success
                </div>  
                <?php } ?>
                <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger">
                Traing center <?php echo $_GET['error']; ?> failed
                </div>
                <?php } ?>
                <h5>TRAINING CENTERS <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#center-model">Add New Center</button></h5>
                <div class="table-responsive"> 
                    <table class="table table-bordered">
                        <tr>
                            <th>SL NO.</th>
                            <th>TRAINING CENTRE NAME</th>
                            <th>DISTRICT</th>
                            <th>APPROVED</th>
                            <th>ACTION</th>
                        </tr>
                        <?php if ($centers) { 
                        foreach ($centers as $key => $value) { ?>
                        <tr>
                        <td><?php echo $key + 1; ?></td>    
                        <td width="50%"><?php echo $value['center']; ?></td>
                        <td><?php echo $value['district']; ?></td>
						<?php $approved = $value['approved'];
						
						if($approved == ''){
							
							$approved = 'No';
							
						}elseif($approved == 1){
							
							$approved = 'Yes';
							
						}else {
							
							$approved = 'No';
						}
						
						?>
						<td><?php echo $approved;?></td>
                        <td style="width:20%">
                        <a href="javascript:;" data-center="<?php echo $value['center']; ?>" data-district="<?php echo $value['did']; ?>" class="tc-edit btn btn-sm" data-id="<?php echo $value['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="centers.php?action=delete&center=<?php echo $value['id']; ?>" class="tc-delete btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                        </tr>
                        <?php } ?>     
                        <?php } ?>     
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="center-model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Training Center</h4>
      </div>
      <div class="modal-body">
        <form method="post" data-action="centers.php" action="centers.php">           
            <div class="form-group">
                <label for="name">Training Center Name</label>
                <input type="text" class="form-control" name="name" id="name" value="" required>
            </div>
            <div class="form-group">
                <label for="district">District</label>
                <select name="district" id="district" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php foreach ($disticts as $key => $value) { ?>   
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>  
                    <?php } ?>  
                </select>
				<label for="approve_district">Approved</label><select name="approved_id" id="approved_id" class="approved_id">
				<option value="1">Yes</option>
				<option value="0">No</option>
				</select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
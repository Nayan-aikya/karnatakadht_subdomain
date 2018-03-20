<?php 
require dirname(__FILE__). "/config.php";

if (isset($_SESSION['username']) and ($_SESSION['username'] == 'COMMISSIONER')) {
    header("Location: centers.php");
    exit;
}

$finyears = [];
$db->orderBy("finyear","Desc");
$finyears_list = $db->get("financial_years", null, array('id', 'finyear'));

foreach ($finyears_list as $list) {
    $finyears[$list['id']] = $list['finyear'];
}

reset($finyears);
$finyear = key($finyears);

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

if (($_SERVER['REQUEST_METHOD'] == 'POST')
and isset($_POST['finyear'], $_POST['center'])    
and array_key_exists($_POST['finyear'], $finyears)
and array_key_exists($_POST['center'], $centers)    
 ) {
    
    $flag = [];
    $center_id = $_POST['center'];
    $finyear = $_POST['finyear'];
    
    for ($i =1; $i <=8; $i++) {
        $data = array(
           'cand' => intval($_POST['cand'][$i]),
           'stipend' => intval($_POST['stipend'][$i]),
           'rawmaterial' => intval($_POST['rawmaterial'][$i]),
           'industrial_expense' => intval($_POST['inex'][$i]),
           'candemp' => intval($_POST['candemp'][$i]),
           'expemp' => intval($_POST['expemp'][$i])
        );
        
        $trainstart = (new DateTime())->createFromFormat('d-m-Y', $_POST['trainstart'][$i]);
        if ($trainstart && $trainstart->format('d-m-Y') === $_POST['trainstart'][$i]) {
            $data['trainstart'] = $_POST['trainstart'][$i];
        }

        $trainend = (new DateTime())->createFromFormat('d-m-Y', $_POST['trainend'][$i]);
        if ($trainend && $trainend->format('d-m-Y') === $_POST['trainend'][$i]) {
            $data['trainend'] = $_POST['trainend'][$i];
        }
        
        if ($db->where("center", $center_id)->where("finyear", $finyear)->where("batch", $i)->has("emp_details")) {
            if ($db->where("center", $center_id)->where("finyear", $finyear)->where("batch", $i)->update('emp_details', $data, 1)) {
                $flag[] = $i;
            } else {
                echo 'insert failed: ' . $db->getLastError();
            }
        } else {
            $data['center'] = $center_id;
            $data['finyear'] = $finyear;
            $data['batch'] = $i;
            if ($id = $db->insert('emp_details', $data)) {
                $flag[] = $i;
            }  else {
                echo 'insert failed: ' . $db->getLastError();
            }
        }
    }
}

if (isset($_GET['center_id']) and array_key_exists($_GET['center_id'], $centers)) {
    $center_id = $_GET['center_id'];
} 

if (isset($_GET['finyear']) and array_key_exists($_GET['finyear'], $finyears)) {
    $finyear = $_GET['finyear'];
}

$post_url = 'employment-details.php?finyear=' . $finyear . '&center_id=' . $center_id;

$ed = [];

$ed_list = $db->where('center', $center_id)->where('finyear ', $finyear)->get("emp_details");

$candtot = $expendtot = $expemptot = $expendituretot = 0;

if ($ed_list) { 
    foreach ($ed_list as $list) {
       $ed[$list['batch']] = array(
           'cand' => $list['cand'],
           'trainstart' => $list['trainstart'],
           'trainend' => $list['trainend'],
           //'expend' => $list['expend'],
           'candemp' => $list['candemp'],
           'expemp' => $list['expemp']
       );

       $candtot = $candtot + $list['cand'];
       $expendtot = $expendtot + $list['expend'];
       $expemptot = $expemptot + $list['candemp'];
       $expendituretot = $expendituretot + $list['expemp'];    
    }
}
$selectedMonth =(isset($_GET['month']))?$_GET['month']:1;
$monthArray=array('1' => 'January',
'2' => 'February',
'3' => 'March',
'4' => 'April',
'5' => 'May',
'6' => 'June',
'7' => 'July',
'8' => 'August',
'9' => 'September',
'10' => 'October',
'11' => 'November',
'12' => 'December',
);

?>
<?php include dirname(__FILE__). "/header.php"; ?>
 <div class="container">
	<div class="col-sm-12">
	   <div class="col-sm-4 extMainMenu">
		  <?php include("leftnav.php"); ?>
	   </div>
	   <div class="col-sm-8 extFormPanel" style="">
		  <div class="row padding-bot-01" id="mainform2" >
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
			<h5>Employment Details</h5>
             <form method="post" enctype="multipart/form-data" id="ed-form" action="<?php echo $post_url; ?>">

                <br>
                <div class="row padding-bot-01 ">
                   <div class="col-md-12">
                      <div class="col-md-6">
                         <label for="email">Financial Year</label>
                         <select name="finyear" id="finyear" class="form-control">
                         <?php foreach ($finyears as $key => $value) { ?>
                         <?php if ($key == $finyear) { ?>
                         <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>     
                         <?php } else { ?>     
                         <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                         <?php } ?>     
                         <?php } ?>     
                         </select>         
                      </div>
                      <div class="col-md-6" style="margin-bottom: 20px;">
                         <label for="email">Training Center Name</label>
                          <select class="form-control" name="center" id="center">
                            <?php foreach ($centers as $key => $value ) { ?>
                            <?php if ($key == $center_id) { ?>
                            <option	value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>  
                            <?php } else { ?>
                            <option	value="<?php echo $key; ?>"><?php echo $value; ?></option>  
                            <?php } ?>  
                            <?php } ?>
                         </select>
                      </div>
					   <div class="col-md-6" style="margin-bottom: 20px;">
                                 <label for="email">Month</label>
								  <select style = "width:30%" class="form-control" name="month" id="month">
									<?php 
									
									foreach ($monthArray as $key => $value ) { ?>
                                    <?php if ($key == $selectedMonth) { ?>
                                    <option	value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>  
                                    <?php } else { ?>
                                    <option	value="<?php echo $key; ?>"><?php echo $value; ?></option>  
                                    <?php } ?>  
									<?php } ?>
                                 </select>
                              </div>
                      <table class="table table-bordered">
                         <thead>
                            <tr>
                               <th>Sl No</th>
                               <th>Batch No</th>
                               <th>No of Canditates trained</th>
                               <th>Training start date</th>
                               <th>Training end date</th>
                               <th colspan="3">Expenditure incurred towards training in Rs. (Stipend, Raw Material and Institutional Expenditures) </th>
                               <th>Number of Candidates employed</th>
                               <th>Expenditure incurred towards providing employment in Rs.</th>
                            </tr>
                         </thead>
                         <tbody>
                            <?php for ($i=1; $i<=8; $i++) { ?>
                             <tr>
                               <td ><?php echo $i; ?></td>
                               <td><?php echo $i; ?></td>
                               <td><input name="cand[<?php echo $i; ?>]" id="cand<?php echo $i; ?>" class="table-fld frmcand"  placeholder="Enter" type="text" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['cand'] : 0; ?>" ></td>
                               <td><input name="trainstart[<?php echo $i; ?>]" id="trainstart<?php echo $i; ?>" class="table-fld frmtrainstart" placeholder="Enter" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['trainstart'] : ''; ?>" type="text" ></td>
                               <td><input name="trainend[<?php echo $i; ?>]" id="trainend<?php echo $i; ?>" class="table-fld frmtrainend" placeholder="Enter" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['trainend'] : ''; ?>" type="text" ></td>
                               <td><input name="stipend[<?php echo $i; ?>]" id="stipend<?php echo $i; ?>" class="table-fld frmstipend" placeholder="Enter" type="text" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['expend'] : 0; ?>" ></td>
                               <td><input name="rawmaterial[<?php echo $i; ?>]" id="rawmaterial<?php echo $i; ?>" class="table-fld frmrawmaterial" placeholder="Enter" type="text" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['expend'] : 0; ?>" ></td>
                               <td><input name="inex[<?php echo $i; ?>]" id="inex<?php echo $i; ?>" class="table-fld frminex" placeholder="Enter" type="text" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['expend'] : 0; ?>" ></td>
                               <td><input name="candemp[<?php echo $i; ?>]" id="candemp<?php echo $i; ?>" class="table-fld frmcandemp" placeholder="Enter" type="text" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['candemp'] : 0; ?>" ></td>
                               <td><input name="expemp[<?php echo $i; ?>]" id="expemp<?php echo $i; ?>" class="table-fld frmexpemp" placeholder="Enter" type="text" value="<?php echo array_key_exists($i, $ed) ? $ed[$i]['expemp'] : 0; ?>" ></td>     
                            </tr>
                            <?php } ?>    
                            <tr>
                               <td colspan="2"><b>Total</b></td>
                               <td><b><input type="text" name="candtot" id="candtot" class="table-fld"  placeholder="" value="<?php echo $candtot; ?>" readonly ></b></td>
                               <td></td>
                               <td></td>
                               <td><b><input type="text" name="stipendtot" id="stipendtot" class="table-fld"  placeholder="" value="<?php echo $expendtot; ?>" readonly></b></td>
                               <td><b><input type="text" name="rawmaterialtot" id="rawmaterialtot" class="table-fld"  placeholder="" value="<?php echo $expemptot; ?>" readonly></b></td>
                               <td><b><input type="text" name="inextot" id="inextot" class="table-fld"  placeholder="" value="<?php echo $expemptot; ?>" readonly></b></td>
                               <td><b><input type="text" name="expemptot" id="expemptot" class="table-fld"  placeholder="" value="<?php echo $expemptot; ?>" readonly></b></td>
                               <td><b><input type="text" name="expendituretot" id="expendituretot" class="table-fld"  placeholder="" value="<?php echo $expendituretot; ?>" readonly></b></td>
                            </tr>
                         </tbody>
                      </table>
                      <div class="col-md-12">
                         <div class="col-md-8"></div>
                         <div class="col-md-4">
                            <button id="submitForm2" class="form-control">Submit</button>
                         </div>
                      </div>
                   </div>
                </div>
             </form>
		  </div>
		  </div>
	   </div>
	</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
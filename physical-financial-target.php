<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require dirname(__FILE__). "/config.php";


if (isset($_SESSION['username']) and ($_SESSION['username'] == 'COMMISSIONER')) {
    header("Location: centers.php");
    exit;
}
$selectedMonth =(isset($_GET['month']))?$_GET['month']:1;
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
    
    $_POST = array_map('intval', $_POST);
    $center_id = $_POST['center'];
    $finyear = $_POST['finyear'];
    
    if ($db->where("center", $center_id)->where("finyear", $finyear)->has("form2tab")) {
        unset($_POST['center'], $_POST['finyear']);
        if ($db->where("center", $center_id)->where("finyear", $finyear)->update ('form2tab', $_POST, 1)) {
            $success = 'Physical financial target updated';
        } else {
            $error = 'Physical financial target updated failed';
        }
    } else {
        if ($id = $db->insert('form2tab', $_POST)) {
            $success = 'Physical financial target inserted';
        } else {
            $error = 'Physical financial target insert failed';
        }
    }
}

if (isset($_GET['center_id']) and array_key_exists($_GET['center_id'], $centers)) {
    $center_id = $_GET['center_id'];
} 

if (isset($_GET['finyear']) and array_key_exists($_GET['finyear'], $finyears)) {
    $finyear = $_GET['finyear'];
}

$post_url = 'physical-financial-target.php?finyear=' . $finyear . '&center_id=' . $center_id. '&month=' . $selectedMonth;

$pft = $db->where('center', $center_id)->where('finyear ', $finyear)->getOne("form2tab");


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
			<h5>Physical & Financial target</h5>
             <form method="post" enctype="multipart/form-data" id="pft-form" action="<?php echo $post_url; ?>">

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
					  <div class="col-md-6" style="margin-bottom: 20px;display:none">
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
                      <div class="col-md-12">
                                <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th rowspan="2">Sl No</th>
                                       <th rowspan="2">Category type</th>
                                       <th colspan="3">Physical Target in Numbers</th>
                                       <th colspan="3">Financial Target in Rs.</th>
                                    </tr>
                                    <tr>
                                       <th>Male</th>
                                       <th>Female</th>
									   <th>Total</th>
                                       <th>Male</th>
                                       <th>Female</th>
									   <th>Total</th>
									   
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>1</td>
                                       <td>General</td>
                                       <td><input name="genphymale1" id="genphymale1" class="table-fld frm4m" placeholder="Enter" value="<?php echo $pft ? $pft['genphymale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genphyfmale1" id="genphyfmale1" class="table-fld frm4f" placeholder="Enter" value="<?php echo $pft ? $pft['genphyfmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genphyfmale1total" id="genphyfmale1total" class="table-fld" placeholder="0" value="<?php echo $pft ? $pft['genphyfmale1total'] : 0; ?>" type="text"></td>
                                       <td><input name="genfinmale1" id="genfinmale1" class="table-fld frm5m" placeholder="Enter" value="<?php echo $pft ? $pft['genfinmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genfinfmale1" id="genfinfmale1" class="table-fld frm5f" placeholder="Enter" value="<?php echo $pft ? $pft['genfinfmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genfinfmale1Total" id="genfinfmale1Total" class="table-fld"  placeholder="Enter" value="<?php echo $pft ? $pft['genfinfmale1Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="genfinffemale1Total" id="genfinffemale1Total" class="table-fld hidethis"  placeholder="Enter" value="<?php echo $pft ? $pft['genfinffemale1Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>2</td>
                                       <td>SCP-Special Component Plan</td>
                                       <td><input name="scpphymale2" id="scpphymale2" class="table-fld frm4m" placeholder="Enter" value="<?php echo $pft ? $pft['scpphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpphyfmale2" id="scpphyfmale2" class="table-fld frm4f" placeholder="Enter" value="<?php echo $pft ? $pft['scpphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpphyfmale2total" id="scpphyfmale2total" class="table-fld " placeholder="0" value="<?php echo $pft ? $pft['scpphyfmale2total'] : 0; ?>" type="text"></td>
                                       <td><input name="scpfinmale2" id="scpfinmale2" class="table-fld frm5m" placeholder="Enter" value="<?php echo $pft ? $pft['scpfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpfinfmale2" id="scpfinfmale2" class="table-fld frm5f" placeholder="Enter" value="<?php echo $pft ? $pft['scpfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpfinfmale2Total" id="scpfinfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pft ? $pft['scpfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="scpfinffemale2Total" id="scpfinffemale2Total" class="table-fld hidethis" placeholder="Enter" value="<?php echo $pft ? $pft['scpfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>3</td>
                                       <td>TSP – Tribal Sub Plan</td>
                                       <td><input name="tspphymale2" id="tspphymale2" class="table-fld frm4m" placeholder="Enter" value="<?php echo $pft ? $pft['tspphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspphyfmale2" id="tspphyfmale2" class="table-fld frm4f" placeholder="Enter" value="<?php echo $pft ? $pft['tspphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspphyfmale2total" id="tspphyfmale2total" class="table-fld " placeholder="0" value="<?php echo $pft ? $pft['tspphyfmale2total'] : 0; ?>" type="text"></td>
                                       <td><input name="tspfinmale2" id="tspfinmale2" class="table-fld frm5m" placeholder="Enter" value="<?php echo $pft ? $pft['tspfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspfinfmale2" id="tspfinfmale2" class="table-fld frm5f" placeholder="Enter" value="<?php echo $pft ? $pft['tspfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspfinfmale2Total" id="tspfinfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pft ? $pft['tspfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="tspfinffemale2Total" id="tspfinffemale2Total" class="table-fld hidethis" placeholder="Enter" value="<?php echo $pft ? $pft['tspfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><b>Total</b></td>
                                       <td><b><input name="phytotmale2" id="phytotmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pft ? $pft['phytotmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="phytotfmale2" id="phytotfmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pft ? $pft['phytotfmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="phytotfmale2Total" id="phytotfmale2Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pft ? $pft['phytotfmale2Total'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotmale2" id="fintotmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pft ? $pft['fintotmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotfmale2" id="fintotfmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pft ? $pft['fintotfmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotfmale2Total" id="fintotfmale2Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pft ? $pft['fintotfmale2Total'] : 0; ?>" type="text"></b></td>
                                       <td class="hidethis"><b><input name="fintotffemale2Total" id="fintotffemale2Total" class="table-fld hidethis" placeholder="" readonly="" value="<?php echo $pft ? $pft['fintotffemale2Total'] : 0; ?>" type="text"></b></td>
                                    </tr>
                                 </tbody>
                              </table>
                               </div>
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
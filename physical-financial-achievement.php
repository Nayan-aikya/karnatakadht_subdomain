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
    
    $_POST = array_map('intval', $_POST);
    
    $center_id = $_POST['center'];
    $finyear = $_POST['finyear'];
    
    $_POST['phytotmale2'] =  ($_POST['genphymale1'] + $_POST['scpphymale2'] + $_POST['tspphymale2']);
    $_POST['phytotfmale2'] =  ($_POST['genphyfmale1'] + $_POST['scpphyfmale2'] + $_POST['tspphyfmale2']);
    $_POST['fintotmale2'] =  ($_POST['genfinmale1'] + $_POST['scpfinmale2'] + $_POST['tspfinmale2']);
    $_POST['fintotfmale2'] =  ($_POST['genfinfmale1'] + $_POST['scpfinfmale2'] + $_POST['tspfinfmale2']);
    
    $_POST['phytotmale3'] =  ($_POST['indusphymale1'] + $_POST['ownphymale2'] + $_POST['grpphymale2'] + $_POST['othphymale2']);
    $_POST['phytotfmale3'] =  ($_POST['indusphyfmale1'] + $_POST['ownphyfmale2'] + $_POST['grpphyfmale2'] + $_POST['othphyfmale2']);
    $_POST['fintotmale3'] =  ($_POST['indusfinmale1'] + $_POST['ownfinmale2'] + $_POST['grpfinmale2'] + $_POST['othfinmale2']);
    $_POST['fintotfmale3'] =  ($_POST['indusfinfmale1'] + $_POST['ownfinfmale2'] + $_POST['grpfinfmale2'] + $_POST['othfinfmale2']);
    
    if ($db->where("center", $center_id)->where("finyear", $finyear)->has("form3tab")) {
        unset($_POST['center'], $_POST['finyear']);
        if ($db->where("center", $center_id)->where("finyear", $finyear)->update ('form3tab', $_POST, 1)) {
            $success = 'Physical financial achievement updated';
        } else {
            $error = 'Physical financial achievement updated failed';
        }
    } else {
        if ($id = $db->insert('form3tab', $_POST)) {
            $success = 'Physical financial achievement inserted';
        } else {
            $error = 'Physical financial achievement insert failed';
        }
    }
}



if (isset($_GET['center_id']) and array_key_exists($_GET['center_id'], $centers)) {
    $center_id = $_GET['center_id'];
} 

if (isset($_GET['finyear']) and array_key_exists($_GET['finyear'], $finyears)) {
    $finyear = $_GET['finyear'];
}
$selectedMonth =(isset($_GET['month']))?$_GET['month']:1;

$post_url = 'physical-financial-achievement.php?finyear=' . $finyear . '&center_id=' . $center_id . '&month=' . $selectedMonth;

$pfa = $db->where('center', $center_id)->where('finyear ', $finyear)->getOne("form3tab");

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
		  <div class="row padding-bot-01" id="mainform3" >
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
			<h5>Physical &amp; Financial achievement</h5>
                     <form method="post" enctype="multipart/form-data" id="pfa-form" action="<?php echo $post_url; ?>">
                        
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
									   <th>Total </th>
									   <th class="hidethis">Total FeMale</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>1</td>
                                       <td>General</td>
                                       <td><input name="genphymale1" id="genphymale1" class="table-fld frm4m" placeholder="Enter" value="<?php echo $pfa ? $pfa['genphymale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genphyfmale1" id="genphyfmale1" class="table-fld frm4f" placeholder="Enter" value="<?php echo $pfa ? $pfa['genphyfmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genphyfmale1total" id="genphyfmale1total" class="table-fld" placeholder="0" value="<?php echo $pfa ? $pfa['genphyfmale1total'] : 0; ?>" type="text"></td>
                                       <td><input name="genfinmale1" id="genfinmale1" class="table-fld frm5m" placeholder="Enter" value="<?php echo $pfa ? $pfa['genfinmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genfinfmale1" id="genfinfmale1" class="table-fld frm5f" placeholder="Enter" value="<?php echo $pfa ? $pfa['genfinfmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="genfinfmale1Total" id="genfinfmale1Total" class="table-fld"  placeholder="Enter" value="<?php echo $pfa ? $pfa['genfinfmale1Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="genfinffemale1Total" id="genfinffemale1Total" class="table-fld"  placeholder="Enter" value="<?php echo $pfa ? $pfa['genfinffemale1Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>2</td>
                                       <td>SCP-Special Component Plan</td>
                                       <td><input name="scpphymale2" id="scpphymale2" class="table-fld frm4m" placeholder="Enter" value="<?php echo $pfa ? $pfa['scpphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpphyfmale2" id="scpphyfmale2" class="table-fld frm4f" placeholder="Enter" value="<?php echo $pfa ? $pfa['scpphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpphyfmale2total" id="scpphyfmale2total" class="table-fld " placeholder="0" value="<?php echo $pfa ? $pfa['scpphyfmale2total'] : 0; ?>" type="text"></td>
                                       <td><input name="scpfinmale2" id="scpfinmale2" class="table-fld frm5m" placeholder="Enter" value="<?php echo $pfa ? $pfa['scpfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpfinfmale2" id="scpfinfmale2" class="table-fld frm5f" placeholder="Enter" value="<?php echo $pfa ? $pfa['scpfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="scpfinfmale2Total" id="scpfinfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['scpfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="scpfinffemale2Total" id="scpfinffemale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['scpfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>3</td>
                                       <td>TSP – Tribal Sub Plan</td>
                                       <td><input name="tspphymale2" id="tspphymale2" class="table-fld frm4m" placeholder="Enter" value="<?php echo $pfa ? $pfa['tspphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspphyfmale2" id="tspphyfmale2" class="table-fld frm4f" placeholder="Enter" value="<?php echo $pfa ? $pfa['tspphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspphyfmale2total" id="tspphyfmale2total" class="table-fld " placeholder="0" value="<?php echo $pfa ? $pfa['tspphyfmale2total'] : 0; ?>" type="text"></td>
                                       <td><input name="tspfinmale2" id="tspfinmale2" class="table-fld frm5m" placeholder="Enter" value="<?php echo $pfa ? $pfa['tspfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspfinfmale2" id="tspfinfmale2" class="table-fld frm5f" placeholder="Enter" value="<?php echo $pfa ? $pfa['tspfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="tspfinfmale2Total" id="tspfinfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['tspfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="tspfinffemale2Total" id="tspfinffemale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['tspfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><b>Total</b></td>
                                       <td><b><input name="phytotmale2" id="phytotmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['phytotmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="phytotfmale2" id="phytotfmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['phytotfmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="phytotfmale2Total" id="phytotfmale2Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['phytotfmale2Total'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotmale2" id="fintotmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotfmale2" id="fintotfmale2" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotfmale2'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotfmale2Total" id="fintotfmale2Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotfmale2Total'] : 0; ?>" type="text"></b></td>
                                       <td class="hidethis"><b><input name="fintotffemale2Total" id="fintotffemale2Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotffemale2Total'] : 0; ?>" type="text"></b></td>
                                    </tr>
                                 </tbody>
                              </table>
                               </div>
                                <div class="col-md-12">
                               <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th rowspan="2">Sl No</th>
                                       <th rowspan="2">Category type</th>
                                       <th colspan="3">Physical Target in Numbers</th>
                                       <th colspan="3">Financial Target in Lakhs</th>
                                    </tr>
                                    <tr>
                                       <th>Male</th>
                                       <th>Female</th>
									   <th>Total</th>
                                       <th>Male</th>
                                       <th>Female</th>
                                       <th>Total</th>
                                       <th class="hidethis">Total Female</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>1</td>
                                       <td>Industries</td>
                                       <td><input name="indusphymale1" id="indusphymale1" class="table-fld frm6m " placeholder="Enter" value="<?php echo $pfa ? $pfa['indusphymale1'] : 0; ?>" type="text"></td>
                                       <td><input name="indusphyfmale1" id="indusphyfmale1" class="table-fld frm6f" placeholder="Enter" value="<?php echo $pfa ? $pfa['indusphyfmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="indusphyfmale1Total" id="indusphyfmale1Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['indusphyfmale1Total'] : 0; ?>" type="text"></td>
                                       <td><input name="indusfinmale1" id="indusfinmale1" class="table-fld frm7m" placeholder="Enter" value="<?php echo $pfa ? $pfa['indusfinmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="indusfinfmale1" value="<?php echo $pfa ? $pfa['indusfinfmale1'] : 0; ?>" id="indusfinfmale1" class="table-fld frm7f" placeholder="Enter" value="<?php echo $pfa ? $pfa['indusfinfmale1'] : 0; ?>" type="text"></td>
                                       <td><input name="indusfinfmale1Total" value="<?php echo $pfa ? $pfa['indusfinfmale1Total'] : 0; ?>" id="indusfinfmale1Total" class="table-fld " placeholder="Enter" value="<?php echo $pfa ? $pfa['indusfinfmale1'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="indusfinffemale1Total" value="<?php echo $pfa ? $pfa['indusfinffemale1Total'] : 0; ?>" id="indusfinffemale1Total" class="table-fld " placeholder="Enter" value="<?php echo $pfa ? $pfa['indusfinfmale1'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>2</td>
                                       <td>Own</td>
                                       <td><input name="ownphymale2" id="ownphymale2" class="table-fld frm6m" placeholder="Enter" value="<?php echo $pfa ? $pfa['ownphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="ownphyfmale2" id="ownphyfmale2" class="table-fld frm6f" placeholder="Enter" value="<?php echo $pfa ? $pfa['ownphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="ownphyfmale2Total" id="ownphyfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['ownphyfmale2Total'] : 0; ?>" type="text"></td>
                                       <td><input name="ownfinmale2" id="ownfinmale2" class="table-fld frm7m" placeholder="Enter" value="<?php echo $pfa ? $pfa['ownfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="ownfinfmale2" id="ownfinfmale2" class="table-fld frm7f" placeholder="Enter" value="<?php echo $pfa ? $pfa['ownfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="ownfinfmale2Total" id="ownfinfmale2Total" class="table-fld " placeholder="Enter" value="<?php echo $pfa ? $pfa['ownfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="ownfinffemale2Total" id="ownfinffemale2Total" class="table-fld " placeholder="Enter" value="<?php echo $pfa ? $pfa['ownfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>3</td>
                                       <td>Group Activity</td>
                                       <td><input name="grpphymale2" id="grpphymale2" class="table-fld frm6m" placeholder="Enter" value="<?php echo $pfa ? $pfa['grpphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="grpphyfmale2" id="grpphyfmale2" class="table-fld frm6f" placeholder="Enter" value="<?php echo $pfa ? $pfa['grpphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="grpphyfmale2Total" id="grpphyfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['grpphyfmale2Total'] : 0; ?>" type="text"></td>
                                       <td><input name="grpfinmale2" id="grpfinmale2" class="table-fld frm7m" placeholder="Enter" value="<?php echo $pfa ? $pfa['grpfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="grpfinfmale2" id="grpfinfmale2" class="table-fld frm7f" placeholder="Enter" value="<?php echo $pfa ? $pfa['grpfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="grpfinfmale2Total" id="grpfinfmale2Total" class="table-fld " placeholder="Enter" value="<?php echo $pfa ? $pfa['grpfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="grpfinffemale2Total" id="grpfinffemale2Total" class="table-fld " placeholder="Enter" value="<?php echo $pfa ? $pfa['grpfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td>4</td>
                                       <td>Others</td>
                                       <td><input name="othphymale2" id="othphymale2" class="table-fld frm6m" placeholder="Enter" value="<?php echo $pfa ? $pfa['othphymale2'] : 0; ?>" type="text"></td>
                                       <td><input name="othphyfmale2" id="othphyfmale2" class="table-fld frm6f" placeholder="Enter" value="<?php echo $pfa ? $pfa['othphyfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="othphyfmale2Total" id="othphyfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['othphyfmale2Total'] : 0; ?>" type="text"></td>
                                       <td><input name="othfinmale2" id="othfinmale2" class="table-fld frm7m" placeholder="Enter" value="<?php echo $pfa ? $pfa['othfinmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="othfinfmale2" id="othfinfmale2" class="table-fld frm7f" placeholder="Enter" value="<?php echo $pfa ? $pfa['othfinfmale2'] : 0; ?>" type="text"></td>
                                       <td><input name="othfinfmale2Total" id="othfinfmale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['othfinfmale2Total'] : 0; ?>" type="text"></td>
                                       <td class="hidethis"><input name="othfinffemale2Total" id="othfinffemale2Total" class="table-fld" placeholder="Enter" value="<?php echo $pfa ? $pfa['othfinffemale2Total'] : 0; ?>" type="text"></td>
                                    </tr>
                                    <tr>
                                       <td colspan="2"><b>Total</b></td>
                                       <td><b><input name="phytotmale3" id="phytotmale3" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['phytotmale3'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="phytotfmale3" id="phytotfmale3" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['phytotfmale3'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="phytotfmale3Total" id="phytotfmale3Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['phytotfmale3Total'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotmale3" id="fintotmale3" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotmale3'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotfmale3" id="fintotfmale3" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotfmale3'] : 0; ?>" type="text"></b></td>
                                       <td><b><input name="fintotfmale3Total" id="fintotfmale3Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotfmale3Total'] : 0; ?>" type="text"></b></td>
                                       <td class="hidethis"><b><input name="fintotffemale3Total" id="fintotffemale3Total" class="table-fld" placeholder="" readonly="" value="<?php echo $pfa ? $pfa['fintotffemale3Total'] : 0; ?>" type="text"></b></td>
                                    </tr>
                                 </tbody>
                              </table>
                               </div>        
                              <div class="col-md-12">
                                 <div class="col-md-8"></div>
                                 <div class="col-md-4">
                                    <button id="submitForm3" class="form-control">Submit</button>
                                 </div>
                              </div>
                              <div class="col-sm-12" style="padding-top: 20px;">
                                 <div class="extOpResult3 alert alert-success" style="display: none;"></div>
                              </div>
                           </div>
                        </div>

                     </form>
		  </div>
		  </div>
	   </div>
	</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
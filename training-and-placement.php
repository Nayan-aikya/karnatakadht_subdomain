<?php
require dirname(__FILE__). "/config.php";

if (isset($_SESSION['username']) and ($_SESSION['username'] == 'COMMISSIONER')) {
    header("Location: centers.php");
    exit;
}

$admin_flag = false;
if (in_array($_SESSION['username'], array('DD_HO', 'JD_HO'))) {
    $admin_flag = true;
}  

$districts = [];

if ($admin_flag) {
    $db->where("district", null, 'IS NOT');
} else {
    $db->where("id", $_SESSION['userid']);
}
$selectedMonth =(isset($_GET['month']))?$_GET['month']:1;
$districts_list = $db->get('users', null, array('id', 'district'));
foreach ($districts_list as $list) {
    $districts[$list['id']] = $list['district'];
}

if (!$admin_flag) {
    reset($districts);
    $district = key($districts);  
}

if (isset($_GET['district']) and array_key_exists($_GET['district'], $districts)) {
    $district = $_GET['district'];
}

$centers = [];

if (isset($district)) $db->where('userid', $district);
$centers_list = $db->get("centers", null, array('id', 'center'));
foreach ($centers_list as $list) {
    $centers[$list['id']] = $list['center'];
}

if (isset($_GET['center_id']) and array_key_exists($_GET['center_id'], $centers)) {
    $center_id = $_GET['center_id'];
} 

$finyears = [];
$db->orderBy("finyear","Desc");
$finyears_list = $db->get("financial_years", null, array('id', 'finyear'));

foreach ($finyears_list as $list) {
    $finyears[$list['id']] = $list['finyear'];
}

reset($finyears);
$finyear = key($finyears);

if (isset($_GET['finyear']) and array_key_exists($_GET['finyear'], $finyears)) {
    $finyear = $_GET['finyear'];
}

$db->where("pfa.finyear", $finyear);
if (isset($center_id)) $db->where("pfa.center", $center_id);
if (isset($district)) $db->where("c.userid", $district);
$db->join("centers c", "c.id=pfa.center", "LEFT");
$pfa_list = $db->get("form3tab pfa", null, array(
    'c.center as center_name',
    'pfa.*'
));

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
    <div id="reporttable2" style="">
        <h2><?php echo $finyears[$finyear]; ?> TRAINING AND PLACEMENT PROVIDED FOR CANDIDATES</h2>
        <div class="row padding-bot-01" id="trainplc">
        <div class="col-md-4">
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
            <div class="col-md-4" style="margin-bottom: 20px;">
                <label for="email">Districts</label>
                <select class="form-control" name="district" id="district">
                    <option value="0">All Districts</option>
                    <?php foreach ($districts as $key => $value ) { ?>
                    <?php if ($key == $district) { ?>
                    <option	value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>  
                    <?php } else { ?>
                    <option	value="<?php echo $key; ?>"><?php echo $value; ?></option>  
                    <?php } ?>  
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4" style="margin-bottom: 20px;">
                <label for="email">Training Center Name</label>
                <select class="form-control" name="center" id="center">
                    <option value="0">All Training Centers</option>
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
              <div class="table-responsive">  
              <table class="table table-bordered">
                 <tbody><tr>
                    <th rowspan="3" width="4%">SL NO</th>
                    <th rowspan="3" width="10%">TRAINING CENTRE NAME</th>
                    <th colspan="8">PLACEMENT PROVIDED TO  CANDIADTES</th>
                    <th colspan="16">PLACEMENT DETAILS</th>
                 </tr>
                 <tr>
                    <th colspan="2">GENERAL</th>
                    <th colspan="2">SCP</th>
                    <th colspan="2">TSP</th>
                    <th colspan="2">TOTAL</th>
                    <th colspan="3">INDUSTRIES</th>
                    <th colspan="3">SELF EMP</th>
                    <th colspan="3">GROUP ACT</th>
                    <th colspan="3">OTHERS</th>
                    <th colspan="3">TOTAL</th>
                    <th rowspan="2">%</th>
                 </tr>
                 <tr>
                    <th>M</th>
                    <th>F</th>
                    <th>M</th>
                    <th>F</th>
                    <th>M</th>
                    <th>F</th>
                    <th>M</th>
                    <th>F</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                 </tr>
                 <?php if ($pfa_list) { 
                 $sl_no = 1; 
                 foreach ($pfa_list as $list) { ?>     
                 <tr>
                    <td><?php echo $sl_no; ?></td>
                    <td><?php echo $list['center_name']; ?></td>
                    <td><?php echo $list['genphymale1']; ?></td>
                    <td><?php echo $list['genphyfmale1']; ?></td>
                    <td><?php echo $list['scpphymale2']; ?></td>
                    <td><?php echo $list['scpphyfmale2']; ?></td>
                    <td><?php echo $list['tspphymale2']; ?></td>
                    <td><?php echo $list['tspphyfmale2']; ?></td>
                    <td><?php echo $list['phytotmale2']; ?></td>
                    <td><?php echo $list['phytotfmale2']; ?></td>
                    <td><?php echo $list['indusphymale1']; ?></td>
                    <td><?php echo $list['indusphyfmale1']; ?></td>
                    <td><?php echo $list['indusphymale1'] + $list['indusphyfmale1']; ?></td>
                    <td><?php echo $list['ownphymale2']; ?></td>
                    <td><?php echo $list['ownphyfmale2']; ?></td>
                    <td><?php echo $list['ownphymale2'] + $list['ownphyfmale2']; ?></td>
                    <td><?php echo $list['grpphymale2']; ?></td>
                    <td><?php echo $list['grpphyfmale2']; ?></td>
                    <td><?php echo $list['grpphymale2'] + $list['grpphyfmale2']; ?></td>
                    <td><?php echo $list['othphymale2']; ?></td>
                    <td><?php echo $list['othphyfmale2']; ?></td>
                    <td><?php echo $list['othphymale2'] + $list['othphyfmale2']; ?></td>
                    <td><?php echo $list['phytotmale3']; ?></td>
                    <td><?php echo $list['phytotfmale3']; ?></td>
                    <td><?php echo $list['phytotmale3'] + $list['phytotfmale3']; ?></td>
                    <td>100%</td>
                 </tr>
                 <?php $sl_no++; } ?>
                 <?php } ?>     
              </tbody></table></div>
           </div>
        </div>
  </div>
</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
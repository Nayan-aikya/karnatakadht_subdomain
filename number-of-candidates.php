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
$finyears_list = $db->get("financial_years", null, array('id', 'finyear'));
foreach ($finyears_list as $list) {
    $finyears[$list['id']] = $list['finyear'];
}

reset($finyears);
$finyear = key($finyears);

if (isset($_GET['finyear']) and array_key_exists($_GET['finyear'], $finyears)) {
    $finyear = $_GET['finyear'];
}

$reports = [];

$db->where("ed.finyear", $finyear);
if (isset($center_id)) $db->where("ed.center", $center_id);
if (isset($district)) $db->where("c.userid", $district);
$db->where("ed2.id", NULL, 'IS');
$db->join("emp_details ed2", "ed.center=ed2.center", "LEFT");
$db->joinWhere("emp_details ed2", "ed.id < ed2.id");
$db->join("centers c", "c.id=ed.center", "LEFT");
$db->groupBy('ed.center');
$reports = $db->get("emp_details ed", null, array(
    'c.center as center_name',
    'ed.*',
));

include dirname(__FILE__). "/header.php"; ?>
 <div class="container">
    <div id="reporttable3" style="">
        <h2>NUMBER OF CANDIDATES</h2>
        <div class="row padding-bot-01" id="noc">
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
           <div class="col-md-12">
              <div class="table-responsive"> 
              <table class="table table-bordered">
                 <tbody><tr>
                    <th rowspan="2">SL NO</th>
                    <th rowspan="2">TRAINING CENTRE NAME</th>
                    <th colspan="3"><?php echo $finyears[$finyear]; ?> YEAR NUMBER OF CANDIDATES    PROVIDED TRAINING</th>
                    <th colspan="2">BALANCE TO BE ACHIEVED (Target -    achived)</th>
                 </tr>
                 <tr>
                    <th>NUMBER OF CANDIADTES</th>
                    <th>STARTING DATE</th>
                    <th>ENDING DATE</th>
                    <th>NUMBER OF CANDIDATES</th>
                    <th>EXPENDITURE INCURRED</th>
                 </tr>
                 <?php if ($reports) { 
                    $sl_no = 1;
                    foreach ($reports as $report) { ?>
                 <tr>
                    <td><?php echo $sl_no; ?></td>
                    <td><?php echo $report['center_name']; ?></td>
                    <td><?php echo $report['cand']; ?></td>
                    <td><?php echo $report['trainstart']; ?></td>
                    <td><?php echo $report['trainend']; ?></td>
                    <td><?php echo $report['candemp']; ?></td>
                    <td><?php echo $report['expemp']; ?></td>
                 </tr>
                 <?php $sl_no++; } ?>     
                 <?php } ?>     
              </tbody></table></div>
           </div>
        </div>
  </div>
</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
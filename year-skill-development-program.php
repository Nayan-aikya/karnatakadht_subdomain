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
$districts_list = $db->where("district", null, 'IS NOT')->get('users', null, array('id', 'district'));
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

$reports = [];

$db->where("finyear", $finyear);
if (isset($center_id)) $db->where("ed.center", $center_id);
if (isset($district)) $db->where("c.userid", $district);
$db->join("centers c", "c.id=ed.center", "LEFT");
$db->groupBy ('center, batch');

$reports = array();

$ed_list = $db->get("emp_details ed", null, array(
    'c.center as center',
    'ed.center as center_id', 
    'ed.batch', 
    'SUM(ed.candemp) as tcandemp', 
    'SUM(ed.expemp) as texpemp'
));

if ($ed_list) {
    foreach ($ed_list as $list) {
        if (!array_key_exists($list['center_id'], $reports)) {
            $reports[$list['center_id']] = array();
            $reports[$list['center_id']]['center'] = $list['center'];
            $reports[$list['center_id']]['ttcandemp'] = $list['tcandemp'];
            $reports[$list['center_id']]['ttexpemp'] = $list['texpemp'];
            $reports[$list['center_id']]['batch'][$list['batch']]['tcandemp'] = $list['tcandemp'];
            $reports[$list['center_id']]['batch'][$list['batch']]['texpemp'] = $list['texpemp'];
        } else {
            $reports[$list['center_id']]['center'] = $list['center'];
            $reports[$list['center_id']]['ttcandemp'] = $reports[$list['center_id']]['ttcandemp'] + $list['tcandemp'];
            $reports[$list['center_id']]['ttexpemp'] = $reports[$list['center_id']]['ttexpemp'] + $list['texpemp'];
            $reports[$list['center_id']]['batch'][$list['batch']]['tcandemp'] = $list['tcandemp'];
            $reports[$list['center_id']]['batch'][$list['batch']]['texpemp'] = $list['texpemp'];
        }
    }
}
include dirname(__FILE__). "/header.php";
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
 <div class="container">
     <div id="reporttable5" style="">
        <h2 style="text-align: center;"><?php echo $finyears[$finyear]; ?> YEAR SKILL DEVELOPMENT PROGRAM TRAINING CENTRE WISE AND BATCH WISE EMPLOYMENT PROVIDED DETAILS</h2>
        <div class="row padding-bot-01" id="ysdp">
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
                    <th rowspan="3">SL NO</th>
                    <th rowspan="3">TRAINING CENTRE NAME</th>
                    <th colspan="18">TRAINED CANDIDATES FOR WHOM  PLACEMENT PROVIDED</th>
                 </tr>
                 <tr>
                    <th colspan="2">1ST BATCH (H)</th>
                    <th colspan="2">2ND BATCH -H</th>
                    <th colspan="2">3RD BATCH-H</th>
                    <th colspan="2">4TH BATCH - H</th>
                    <th colspan="2">5TH BATCH - H</th>
                    <th colspan="2">6TH BATCH - H</th>
                    <th colspan="2">7TH BATCH - H</th>
                    <th colspan="2">8TH BATCH - H</th>
                    <th colspan="2">TOTAL</th>
                 </tr>
                 <tr>
                    <th>NO OF CANDIDATES -A</th>
                    <th>EXPENDITURE INCURRED - B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                    <th>A</th>
                    <th>B</th>
                 </tr>
                 <?php $sl_no = 1; foreach ($reports as $center => $report) { ?>     
                 <tr>
                    <td><?php echo $sl_no; ?></td>
                    <td><?php echo $report['center']; ?></td>
                    <?php for ($i = 1; $i <= 8; $i++) { ?>
                    <?php if (array_key_exists($i, $report['batch'])) { ?>  
                    <td><?php echo $report['batch'][$i]['tcandemp']; ?></td>
                    <td><?php echo $report['batch'][$i]['texpemp']; ?></td>
                    <?php } else { ?>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php } ?>
                    <?php } ?>  
                    <td><?php echo $report['ttcandemp']; ?></td>
                    <td><?php echo $report['ttexpemp']; ?></td>
                 </tr>
                 <?php $sl_no++; } ?>     
              </tbody></table></div>
           </div>
        </div>
  </div>
</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
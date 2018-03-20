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

$reports = [];

$db->where("pft.finyear", $finyear);
if (isset($center_id)) $db->where("pft.center", $center_id);
if (isset($district)) $db->where("c.userid", $district);
$db->join("form3tab pfa", "pfa.center=pft.center", "LEFT");
$db->joinWhere("form3tab pfa", "pfa.finyear=pft.finyear");
$db->join("centers c", "c.id=pft.center", "LEFT");
$pf_list = $db->get("form2tab pft", null, array(
    'pft.*',
    'pfa.*',
    'c.center as center_name'
));

include dirname(__FILE__). "/header.php"; ?>
 <div class="container">
     <div id="reporttable1" style="">
        <h2>NUTANA JAWALI NEETHI – <?php echo $finyears[$finyear]; ?> - PROGRESS REPORT</h2>
        <div class="row padding-bot-01" id="prorepo">
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
			<div class="col-md-4" style="margin-bottom: 20px; width: 11%;">
                                 <label for="email">Month</label>
								  <select style = "" class="form-control" name="month" id="month">
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
                    <th rowspan="4">SL NO </th>
                    <th rowspan="4">TRAINING CENTRE NAME</th>
                    <th colspan="8"><?php echo $finyears[$finyear]; ?> TARGET</th>
                    <th colspan="24">ACHIEVMENT REPORT <?php echo $finyears[$finyear]; ?></th>
                 </tr>
                 <tr>
                    <th colspan="2">GENERAL</th>
                    <th colspan="2">SCP</th>
                    <th colspan="2">TSP</th>
                    <th colspan="2">TOTAL</th>
                    <th colspan="6">GENERAL</th>
                    <th colspan="6">SCP</th>
                    <th colspan="6">TSP</th>
                    <th colspan="6">TOTAL</th>
                 </tr>
                 <tr>
                    <th rowspan="2">PHY</th>
                    <th rowspan="2">FIN</th>
                    <th rowspan="2">P</th>
                    <th rowspan="2">F</th>
                    <th rowspan="2">P</th>
                    <th rowspan="2">F</th>
                    <th rowspan="2">P</th>
                    <th rowspan="2">F</th>
                    <th colspan="2">PHY</th>
                    <th colspan="2">FIN</th>
                    <th colspan="2">T</th>
                    <th colspan="2">PHY</th>
                    <th colspan="2">FIN</th>
                    <th colspan="2">T</th>
                    <th colspan="2">PHY</th>
                    <th colspan="2">FIN</th>
                    <th colspan="2">T</th>
                    <th colspan="3">P</th>
                    <th colspan="3">F</th>
                 </tr>
                 <tr>
                    <th>Male</th>
                    <th>Fe</th>
                    <th>Male</th>
                    <th>Fe</th>
                    <th>Ph</th>
                    <th>Fi</th>
                    <th>Male</th>
                    <th>Fe</th>
                    <th>Male</th>
                    <th>Fe</th>
                    <th>Ph</th>
                    <th>Fi</th>
                    <th>Male</th>
                    <th>Fe</th>
                    <th>Male</th>
                    <th>Fe</th>
                    <th>Ph</th>
                    <th>Fi</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                    <th>M</th>
                    <th>F</th>
                    <th>T</th>
                 </tr>
                <?php $sl_no = 1; 
                foreach ($pf_list as $report) { ?>
                <tr>
                    <td><?php echo $sl_no; ?></td>
                    <td><?php echo $report['center_name']; ?></td>
                    <td><?php echo $report['genphy']; ?></td>
                    <td><?php echo $report['genfin']; ?></td>
                    <td><?php echo $report['scpphy']; ?></td>
                    <td><?php echo $report['scpfin']; ?></td>
                    <td><?php echo $report['tspphy']; ?></td>
                    <td><?php echo $report['tspfin']; ?></td>
                    <td><?php echo $report['phytot']; ?></td>
                    <td><?php echo $report['fintot']; ?></td>
                    <td><?php echo $report['genphymale1']; ?></td>
                    <th><?php echo $report['genphyfmale1']; ?></th>
                    <td><?php echo $report['genfinmale1']; ?></td>
                    <td><?php echo $report['genfinfmale1']; ?></td>
                    <td><?php echo $report['genphymale1'] + $report['genphyfmale1']; ?></td>
                    <td><?php echo $report['genfinmale1'] + $report['genfinfmale1']; ?></td>
                    <td><?php echo $report['scpphymale2']; ?></td>
                    <td><?php echo $report['scpphyfmale2']; ?></td>
                    <td><?php echo $report['scpfinmale2']; ?></td>
                    <td><?php echo $report['scpfinfmale2']; ?></td>
                    <td><?php echo $report['scpphymale2'] + $report['scpphyfmale2']; ?></td>
                    <td><?php echo $report['scpfinmale2'] + $report['scpfinfmale2']; ?></td>
                    <td><?php echo $report['tspphymale2']; ?></td>
                    <td><?php echo $report['tspphyfmale2']; ?></td>
                    <td><?php echo $report['tspfinmale2']; ?></td>
                    <td><?php echo $report['tspfinfmale2']; ?></td>
                    <td><?php echo $report['tspphymale2'] + $report['tspphyfmale2']; ?></td>
                    <td><?php echo $report['tspfinmale2'] + $report['tspfinfmale2']; ?></td>
                    <td><?php echo $report['phytotmale2']; ?></td>
                    <td><?php echo $report['phytotfmale2']; ?></td>
                    <td><?php echo $report['phytotmale2'] + $report['phytotfmale2']; ?></td>
                    <td><?php echo $report['fintotmale2']; ?></td>
                    <td><?php echo $report['fintotfmale2']; ?></td>
                    <td><?php echo $report['fintotmale2'] + $report['fintotfmale2']; ?></td>
                    <td></td>
                 </tr>
                 <?php $sl_no++; } ?>     
              </tbody></table></div>
           </div>
        </div>
      </div>
</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
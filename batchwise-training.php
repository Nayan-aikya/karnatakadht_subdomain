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

if (isset($center_id))
    $db->where("ed.center", $center_id);

$db->where("ed.finyear", $finyear);
if (isset($center_id)) $db->where("ed.center", $center_id);
if (isset($district)) $db->where("c.userid", $district);
$db->join("centers c", "c.id=ed.center", "LEFT");

$reports = array();

$ed_list = $db->get("emp_details ed", null, array(
    'ed.center as center_id',
    'c.center as center',
    'ed.batch',
    'ed.cand',
    'ed.trainstart',
    'ed.trainend',
    'ed.expend',
    'ed.candemp',
    'ed.expemp'
));
if ($ed_list) {
    foreach ($ed_list as $list) {
        if (!array_key_exists($list['center'], $reports)) {
            $reports[$list['center_id']] = array();
            $reports[$list['center_id']]['center'] = $list['center'];
            $reports[$list['center_id']][$list['batch']]['cand'] = $list['cand'];
            $reports[$list['center_id']][$list['batch']]['trainstart'] = $list['trainstart'];
            $reports[$list['center_id']][$list['batch']]['trainend'] = $list['trainend'];
            $reports[$list['center_id']]['candtot'] = $list['cand'];
            $reports[$list['center_id']]['expendtot'] = $list['expend'];
        } else {
            $reports[$list['center_id']][$list['batch']] = [];
            $reports[$list['center_id']]['center'] = $list['center'];
            $reports[$list['center_id']][$list['batch']]['cand'] = $list['cand'];
            $reports[$list['center_id']][$list['batch']]['trainstart'] = $list['trainstart'];
            $reports[$list['center_id']][$list['batch']]['trainend'] = $list['trainend'];
            $reports[$list['center_id']]['candtot'] = $reports[$list['center_id']]['candtot'] + $list['cand'];
            $reports[$list['center_id']]['expendtot'] = $reports[$list['center_id']]['expendtot'] + $list['expend'];
        }   
    }
}

?>
<?php include dirname(__FILE__). "/header.php"; ?>
 <div class="container">
    <div id="reporttable4" style="">
        <h2 style="text-align: center;">BATCH WISE TRAINING</h2>
        <div class="row padding-bot-01" id="bwtrain">
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
                     <tbody>
                     <tr>
                        <th rowspan="3">SL NO </th>
                        <th rowspan="3">
                           <p align="center">TRAINING CENTRE NAME
                        </p></th>
                        <th colspan="26" valign="top">
                           <p>DETAILS OF BATCH WISE TRAINING PROVIDED (REGULAR + SPILL OVER) <?php echo $finyears[$finyear]; ?>
                        </p></th>
                     </tr>
                     <tr>
                        <th colspan="3">1ST BATCH</th>
                        <th colspan="3">2ND BATCH</th>
                        <th colspan="3">3RD BATCH</th>
                        <th colspan="3">4TH BATCH</th>
                        <th colspan="3">5TH BATCH</th>
                        <th colspan="3">6TH BATCH</th>
                        <th colspan="3">7TH BATCH</th>
                        <th colspan="3">8TH BATCH</th>
                        <th colspan="2" width="10%">TOTAL</th>
                     </tr>
                     <tr>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>H</th>
                        <th>A</th>
                        <th>B</th>
                        <th>NO OF    CANDIDATES TRAINED  (H)</th>
                        <th>TOTAL EXPS    INCURRED</th>
                     </tr>
                     <?php $sl_no = 1; foreach ($reports as $center => $report) { ?>             
                     <tr>
                        <td><?php echo $sl_no; ?></td>
                        <td><?php echo $report['center']; ?></td>
                        <?php for ($i = 1; $i <= 8; $i++) { ?>
                        <?php if (array_key_exists($i, $report)) { ?>
                        <td><?php echo $report[$i]['cand']; ?></td>
                        <td><?php echo $report[$i]['trainstart']; ?></td>
                        <td><?php echo $report[$i]['trainend']; ?></td>  
                        <?php } else { ?>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td> 
                        <?php } ?>
                        <?php } ?>  
                        <td><?php echo $report['candtot']; ?></td>
                        <td><?php echo $report['expendtot']; ?></td>
                     </tr>
                     <?php $sl_no++; } ?>     
                  </tbody></table></div>
                </div>
           </div>
        </div>
  </div>
<?php include dirname(__FILE__). "/footer.php"; ?>
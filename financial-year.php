<?php
require dirname(__FILE__). "/config.php";

if (isset($_SESSION['username']) and !(in_array($_SESSION['username'], array('COMMISSIONER', 'DD_HO', 'JD_HO')))) {
    header("Location: home.php");
    exit;
}

if (isset($_GET['id']) and intval($_GET['id']) > 0) {
    $finyear_id = $_GET['id'];
}

if (isset($_GET['action'], $finyear_id) and $_GET['action'] == 'delete') {
    $db->where('id', $finyear_id);
    if($db->delete('financial_years')) {
        header('Location:financial-year.php?success=delete'); 
    } else {
        header('Location:financial-year.php?error=delete');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'
and !empty($_POST['finyear'])
) {
    if (isset($finyear_id)) {
        $db->where('id', $finyear_id);
        if ($db->update ('financial_years', array(
            'finyear' => $_POST['finyear'] 
        ), 1)) {
            header('Location:financial-year.php?success=update');        
        } else {
            header('Location:financial-year.php?error=update');
        }
    } else {
        if ($id = $db->insert ('financial_years', array(
            'finyear' => $_POST['finyear'], 
        ))) {
            header('Location:financial-year.php?success=insert');        
        } else {
            header('Location:financial-year.php?error=insert');
        }
    }
    exit;
}
$db->orderBy("finyear","Desc");
$finyears = $db->get("financial_years", null, array('id', 'finyear'));

include dirname(__FILE__). "/header.php"; ?>
<div class="container">
    <div class="col-sm-12">
        <div class="col-sm-4 extMainMenu">
            <?php include("leftnav.php"); ?>
        </div>
        <div class="col-sm-8 extFormPanel" style="">
            <div class="row padding-bot-01" id="fin-years-form">
                <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                Financial year <?php echo $_GET['success']; ?> success
                </div>  
                <?php } ?>
                <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger">
                Financial year <?php echo $_GET['error']; ?> failed
                </div>
                <?php } ?>
                <h5>FINANCIAL YEARS <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#finyear-model">Add New Financial Year</button></h5>
                <div class="table-responsive"> 
                    <table class="table table-bordered">
                    <tr>
                    <th>SL NO.</th>
                    <th>FINANCIAL YEAR</th>
                    <th>ACTION</th>
                    </tr>
                    <?php if ($finyears) { 
                    foreach ($finyears as $key => $value) { ?>
                    <tr>
                    <td><?php echo $key + 1; ?></td>    
                    <td><?php echo $value['finyear']; ?></td>
                    <td>
                    <a href="javascript:;" data-finyear="<?php echo $value['finyear']; ?>" class="fy-edit btn btn-sm" data-id="<?php echo $value['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a href="financial-year.php?action=delete&id=<?php echo $value['id']; ?>" class="fy-delete btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<div id="finyear-model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Fiancial Year</h4>
      </div>
      <div class="modal-body">
        <form method="post" data-action="financial-year.php" action="financial-year.php">           
            <div class="form-group">
                <label for="name">Year</label>
                <input type="text" class="form-control" name="finyear" id="finyear" value="" required>
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
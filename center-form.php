<?php
require dirname(__FILE__). "/config.php";

$post_url = 'center-form.php';

if (isset($_GET['center']) and intval($_GET['center']) > 0) {
    $db->join("users u", "c.userid=u.id", "LEFT");
    $db->where('c.id', $_GET['center']);
    $center = $db->getOne("centers c", array('c.id', 'c.center', 'c.userid'));
    if ($center) {
        $post_url = 'center-form.php?center=' . $center['id'];
    }
    echo '<pre>'; print_r($center); echo '</pre>';
}

$districts = $db->where("district", null, 'IS NOT')->get('users', null, array('id', 'district'));

include dirname(__FILE__). "/header.php"; ?>
 <div class="container">
    <div id="reporttable3" style="">
        <h2>TRAINING CENTER FORM</h2>
        <div class="row padding-bot-01" id="noc">
           <div class="col-md-12">
           <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input">
      Check me out
    </label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="panel panel-default">
  <div class="panel-body">
    Basic panel example
  </div>
</div>
            </div>
        </div>
  </div>
</div>
<?php include dirname(__FILE__). "/footer.php"; ?>
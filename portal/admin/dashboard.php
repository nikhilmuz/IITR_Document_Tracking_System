<?php
require_once(dirname(__FILE__).'/theme/theme.php');
include_once ('../includes/autoload.php');
get_admin_header();
$userstatus=true;
if(isset($_GET['id'])&&$_GET['id']!="") {
    $user = new Users($_GET['id']);
    $userstatus=$user->isValid;
}
?>
    <script>
        $("#tab1").addClass("active");
        $("title").html("Admin Dashboard | <?php echo TITLE; ?>");
    </script>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }
    </style>
<?php
if(isset($_GET['id'])&&$_GET['id']!=''&&$userstatus){
    ?>
    <style>
        body {
    font-family: "Helvetica Neue", Helvetica, Arial;
    font-size: 14px;
    line-height: 20px;
    font-weight: 400;
    color: #3b3b3b;
    -webkit-font-smoothing: antialiased;
    font-smoothing: antialiased;
    }
    @media screen and (max-width: 580px) {
    body {
    font-size: 16px;
    line-height: 22px;
    }
    }

    .wrapper {
    margin: 0 auto;
    padding: 40px;
    max-width: 800px;
    }

    .table {
    margin: 0 0 40px 0;
    width: 100%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    display: table;
    }
    @media screen and (max-width: 580px) {
    .table {
    display: block;
    }
    }

    .row {
    display: table-row;
    background: #f6f6f6;
    }
    .row:nth-of-type(odd) {
    background: #e9e9e9;
    }
    .row.header {
    font-weight: 900;
    color: #ffffff;
    background: #ea6153;
    }
    .row.green {
    background: #27ae60;
    }
    .row.blue {
    background: #2980b9;
    }
    @media screen and (max-width: 580px) {
    .row {
    padding: 14px 0 7px;
    display: block;
    }
    .row.header {
    padding: 0;
    height: 6px;
    }
    .row.header .cell {
    display: none;
    }
    .row .cell {
    margin-bottom: 10px;
    }
    .row .cell:before {
    margin-bottom: 3px;
    content: attr(data-title);
    min-width: 98px;
    font-size: 10px;
    line-height: 10px;
    font-weight: bold;
    text-transform: uppercase;
    color: #969696;
    display: block;
    }
    }

    .cell {
    padding: 6px 12px;
    display: table-cell;
    }
    @media screen and (max-width: 580px) {
    .cell {
    padding: 2px 16px;
    display: block;
    }
    }
</style>
    <div class="table">

        <div class="row header">
            <div class="cell">
                User ID
            </div>
            <div class="cell">
                Username
            </div>
            <div class="cell">
                Full Name
            </div>
            <div class="cell">
                DOB
            </div>
            <div class="cell">
                Phone No.
            </div>
            <div class="cell">
                Email
            </div>
            <div class="cell">
                Office
            </div>
        </div>

        <div class="row">
            <div class="cell" data-title="Shipment No.">
                <?php echo $user->enrlid; ?>
            </div>
            <div class="cell" data-title="Created On">
                <?php echo $user->id; ?>
            </div>
            <div class="cell" data-title="Created By">
                <?php echo $user->fn." ".$user->ln; ?>
            </div>
            <div class="cell" data-title="Origin">
                <?php echo $user->dob; ?>
            </div>
            <div class="cell" data-title="Destination">
                <?php echo $user->ph; ?>
            </div>
            <div class="cell" data-title="Expected Delivery">
                <?php echo $user->email; ?>
            </div>
            <div class="cell" data-title="Delivered On">
                <?php echo ((new Office($user->office))->name); ?>
            </div>
        </div>
</div>
    <br>
       <p align="center"><button onClick="window.location='reset_password.php?id=<?php echo $user->enrlid;?>'" class="btn btn-info">Reset Password</button> <button onClick="window.location='delete_user.php?id=<?php echo $user->enrlid;?>'" class="btn btn-danger">Delete User</button></p>
    <?php
}
else {
    ?>
    <div id="msgdiv"></div>
    <div style="padding-top: 10%" class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form onsubmit="if ($('#awb').val()==''){generate_message('msgdiv','info','Please Enter Shipment Number First!','msgid','','clear'); event.preventDefault();}" id="awbform" method="get">
                <div class="input-group">
                    <input class="form-control" name="id" id="id" placeholder="User ID" type="number">
                    <span onclick="if ($('#id').val()==''){generate_message('msgdiv','info','Please Enter User ID First!','msgid','','clear');} else document.getElementById('awbform').submit();"
                          class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </form>
        </div>
    </div>
    <script src="<?php echo DOMAIN . PATH; ?>/js/ajax.js"></script>
    <script src="<?php echo DOMAIN . PATH; ?>/js/msg.js"></script>
    <script>
        if (<?php echo !$userstatus; ?>) {
            generate_message('msgdiv', 'danger', 'Incorrect User ID! Try Again', 'msgid', '', 'clear');
        }
    </script>
    <?php
}
get_admin_footer();
?>
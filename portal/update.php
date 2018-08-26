<?php
require_once( dirname( __FILE__ ) . '/theme/theme.php' );
include_once ('includes/autoload.php');
get_header();
$awbstatus=true;
if(isset($_GET['awb'])&&$_GET['awb']!="") {
    $awb = new AWB($_GET['awb']);
    $awbstatus=$awb->isValid;
}
?>
    <script>
        $("#tab2").addClass("active");
        $("title").html("Update Shipment | <?php echo TITLE; ?>");
    </script>
    <script src="<?php echo DOMAIN . PATH; ?>/js/ajax.js"></script>
    <script src="<?php echo DOMAIN . PATH; ?>/js/msg.js"></script>
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
if(isset($_GET['awb'])&&$_GET['awb']!=''&&$awbstatus){
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
            max-width: 400px;
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
                Shipment No.
            </div>
            <div class="cell">
                Created On
            </div>
            <div class="cell">
                Created By
            </div>
            <div class="cell">
                Origin
            </div>
            <div class="cell">
                Destination
            </div>
            <div class="cell">
                Expected Delivery
            </div>
            <div class="cell">
                Delivered On
            </div>
            <div class="cell">
                Delivered By
            </div>
            <div class="cell">
                Status
            </div>
        </div>

        <div class="row">
            <div class="cell" data-title="Shipment No.">
                <?php echo $awb->awb; ?>
            </div>
            <div class="cell" data-title="Created On">
                <?php echo Functions::get_date_from_stamp($awb->created); ?>
            </div>
            <div class="cell" data-title="Created By">
                <?php echo (new Users($awb->created_by))->fn; ?>
            </div>
            <div class="cell" data-title="Origin">
                <?php echo $awb->origin; ?>
            </div>
            <div class="cell" data-title="Destination">
                <?php echo $awb->destination; ?>
            </div>
            <div class="cell" data-title="Expected Delivery">
                <?php if($awb->status==0){echo Functions::get_date_from_stamp($awb->completed);} ?>
            </div>
            <div class="cell" data-title="Delivered On">
                <?php if($awb->status==1){echo Functions::get_date_from_stamp($awb->completed);} ?>
            </div>
            <div class="cell" data-title="Delivered By">
                <?php echo (new Users($awb->completed_by))->fn; ?>
            </div>
            <div class="cell" data-title="Status">
                <?php if($awb->status==0) echo "In Transit"; else if($awb->status==1) echo "Delivered"; ?>
            </div>
        </div>
    </div>
    <div id="msgdiv"></div>
    <div class="wrapper well" align="center">
        <div>
            <div style="display: inline;"><span class="input-group-addon field"><strong>Privacy</strong></span></div>
            <br><br>
            <div class="radio" style="display: inline;">
                <label><input type="radio" value="1" name="privacy" checked>Public</label>
            </div>
            <div class="radio" style="display: inline;">
                <label><input type="radio" value="0" name="privacy">Private</label>
            </div>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon field"><strong>Remarks</strong></span>
            <select class="form-control" name="remarks" id="remarks">
                <option selected="selected" value="">Choose One</option>
                <option value="Received">Received</option>
                <option value="Processing">Processing</option>
                <option value="Dispatched">Dispatched</option>
                <option value="Delivered">Delivered</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <br>
        <div class="input-group" id="others">
            <input id="oth" name="others" type="text" class="form-control" placeholder="Please Specify" >
        </div>
    </div>
    <br>
    <p align="center"><button id="proceed" onClick="submit();" class="btn btn-info">Proceed</button> <button onClick="window.location='update.php';" class="btn btn-warning">Cancel</button></p>
    <script>
        function submit(){
            if($('select').val()==""||($('select').val()=="Others"&&$('#oth').val()=="")){
        generate_message('msgdiv', 'info', 'Fill the details completely!', 'msgid', '', 'clear');
            }
            else{
                var remarks=$('select').val();
                if(remarks=="Others"){remarks=$('#oth').val();}
                $("#proceed").html("Submitting...");
                document.getElementById("proceed").disabled = "true";
                send_ajax('api/update.php',"privacy="+$('input[name=privacy]:checked').val()+"&remarks="+remarks+"&awb=<?php echo $awb->awb; ?>",'ajax_callback1');
            }
            }
        function ajax_callback1(text,status,state){
            if(status==200&&state==4){
                if(text=="1"){
                    $("#proceed").html("Proceed");
                    document.getElementById("proceed").disabled = false;
                    generate_message('msgdiv', 'success', 'Sucessfully Updated!', 'msgid', '', 'clear');
                    window.location="update.php";
                }
                else if(text=="0"){
                    $("#proceed").html("Proceed");
                    document.getElementById("proceed").disabled = false;
                    generate_message('msgdiv', 'warning', 'Unauthorized!', 'msgid', '', 'clear');
                }
            }
            if(status!=200&&state==4){
                $("#proceed").html("Proceed");
                document.getElementById("proceed").disabled = false;
                generate_message('msgdiv', 'warning', 'Critical Server Error! Try Again Later!', 'msgid', '', 'clear');
            }
        };
        $("#others").css("visibility","hidden");
        $('select').on('change', function() {
            if( this.value=="Others"){
                $("#others").css("visibility","visible");
            }
            else{
                $("#others").css("visibility","hidden");
            }
        });
    </script>
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
                    <input class="form-control" name="awb" id="awb" placeholder="Shipment Number" type="number">
                    <span onclick="if ($('#awb').val()==''){generate_message('msgdiv','info','Please Enter Shipment Number First!','msgid','','clear');} else document.getElementById('awbform').submit();"
                          class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                </div>
            </form>
        </div>
    </div>
    <script>
        if (<?php echo !$awbstatus; ?>) {
            generate_message('msgdiv', 'danger', 'Incorrect Shipment Number! Try Again', 'msgid', '', 'clear');
        }
    </script>
    <?php
}
get_footer();
?>
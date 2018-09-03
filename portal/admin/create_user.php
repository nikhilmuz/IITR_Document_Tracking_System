<?php
require_once(dirname(__FILE__).'/theme/theme.php');
include_once ('../includes/autoload.php');
get_admin_header();
?>
    <script>
        $("#tab3").addClass("active");
        $("title").html("Create User | <?php echo TITLE; ?>");
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }
    </style>
    <div id="msgdiv"></div>
    <div style="max-width: 100%;" class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon field"><strong>First Name</strong></span>
                    <input id="fn" class="form-control" name="fn" type="text" placeholder="e.g. John" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon field"><strong>Last Name</strong></span>
                    <input id="ln" class="form-control" name="ln" type="text" placeholder="e.g. Smith">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon field"><strong>Username</strong></span>
                    <input id="un" onkeyup="" class="form-control" name="id" type="text" placeholder="e.g. jsmith123" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon field"><strong>Password</strong></span>
                    <input id="pwd" onkeyup="" class="form-control" name="pwd" type="password" placeholder="Password" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon field"><strong>Date of Birth</strong></span>
                    <input id="dob" class="form-control hasDatepicker" name="dob" placeholder="yyyy-mm-dd" type="date">
                </div>
                <br>
                <div id="phdiv" class="input-group">
                    <span class="input-group-addon field"><strong>Mobile No.</strong></span>
                    <span class="input-group-addon"><strong>+91</strong></span>
                    <input class="form-control" id="ph" name="ph" type="text" placeholder="e.g. 9934099340" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon field"><strong>Email</strong></span>
                    <input class="form-control" id="email" name="email" type="email" placeholder="e.g. jsmith@example.com" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon field"><strong>Office</strong></span>
                    <select class="form-control" name="office" id="office">
                        <option selected="selected" value="">Choose One</option>
                        <?php
                        foreach (Office::getOffices() as $office){
                        ?>
                        <option value="<?php echo $office['officeid']; ?>"><?php echo $office['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <p align="center"><button id="create" onClick="createUser($('#fn').val(),$('#ln').val(),$('#un').val(),$('#dob').val(),$('#ph').val(),$('#email').val(),$('#office').val(),$('#pwd').val()); event.preventDefault();" class="btn btn-success">Create User</button></p>
        </div>
    </div>
    <script src="<?php echo DOMAIN . PATH; ?>/js/ajax.js"></script>
    <script src="<?php echo DOMAIN . PATH; ?>/js/msg.js"></script>
    <script>
        $(function() {
            $('#office').select2({
                placeholder: 'Choose One',
                width: '100%',
                tags: true
            });;
            $( "#dob" ).datepicker().datepicker( "option", "dateFormat", "yy-mm-dd" ).datepicker( "option", "changeMonth", "true" ).datepicker( "option", "changeYear", "true" ).datepicker("option","yearRange", "1980:-15");
        });
        function createUser(fn,ln,un,dob,ph,email,office,pwd){
            if(fn==""||un==""||ph==""||email==""||office==""||pwd==""){
                generate_message('msgdiv', 'info', 'Please fill details completely first!', 'msgid', '', 'clear');
            }
            else {
                $("#create").attr("value","Creating...");
                document.getElementById("create").disabled = "true";
                send_ajax("../api/create_user.php","fn="+fn+"&ln="+ln+"&un="+un+"&dob="+dob+"&ph="+ph+"&email="+email+"&office="+office+"&pwd="+pwd,"ajax_callback1");
            }
        }
        function ajax_callback1(text,status,state){
            if(status==200&&state==4){
                if(text=="0"){generate_message('msgdiv','danger','Unauthorized!','msgid','','clear');}
                else if (text=="2"){
                    generate_message('msgdiv','danger','Username Already Taken!','msgid','','clear');
                }
                else {
                    generate_message('msgdiv','success','User Created Successfully!','msgid','','clear');
                    window.location="dashboard.php";
                }
            }
            else if(status!=200&&state==4){
                generate_message('msgdiv', 'danger', 'Critical Server Error! Try Again Later', 'msgid', '', 'clear');
            }
            if(state==4){
                $("#create").attr("value","Create User");
                $("#create").removeAttr("disabled");
            }
        };
    </script>
    <?php
get_admin_footer();
?>
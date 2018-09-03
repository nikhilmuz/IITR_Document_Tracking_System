<?php
require_once( dirname( __FILE__ ) . '/theme/theme.php' );
include_once ('includes/autoload.php');
get_header();
?>
    <script>
        $("#tab3").addClass("active");
        $("title").html("Manage Shipment | <?php echo TITLE; ?>");
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
            width: 100%;
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
<div class="wrapper">
    <div class="table">

        <div class="row header">
            <div class="cell">
                Shipment No.
            </div>
            <div class="cell">
                SAP ID
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
                Remarks
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
        <?php
        foreach (Shipment::getShipments((new Sessions())->getID()) as $shipment){
        ?>
        <div class="row">
            <div class="cell" data-title="Shipment No.">
                <?php echo $shipment['awb']; ?>
            </div>
            <div class="cell" data-title="SAP ID">
                <?php echo $shipment['docid']; ?>
            </div>
            <div class="cell" data-title="Created On">
                <?php echo Functions::get_date_from_stamp($shipment['created']); ?>
            </div>
            <div class="cell" data-title="Created By">
                <?php echo (new Users($shipment['created_by']))->fn; ?>
            </div>
            <div class="cell" data-title="Origin">
                <?php echo $shipment['origin']; ?>
            </div>
            <div class="cell" data-title="Destination">
                <?php echo $shipment['destination']; ?>
            </div>
            <div class="cell" data-title="Remarks">
                <?php echo $shipment['remarks']; ?>
            </div>
            <div class="cell" data-title="Expected Delivery">
                <?php if($shipment['status']==0){echo Functions::get_date_from_stamp($shipment['completed']);} ?>
            </div>
            <div class="cell" data-title="Delivered On">
                <?php if($shipment['status']==1){echo Functions::get_date_from_stamp($shipment['completed']);} ?>
            </div>
            <div class="cell" data-title="Delivered By">
                <?php echo (new Users($shipment['completed_by']))->fn; ?>
            </div>
            <div class="cell" data-title="Status">
                <?php if($shipment['status']==0) echo "In Transit"; else if($shipment['status']==1) echo "Delivered"; ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
    <br>
    <p align="center"><button onClick="window.location='create.php'" class="btn btn-info">Create New</button></p>
    <?php
get_footer();
?>
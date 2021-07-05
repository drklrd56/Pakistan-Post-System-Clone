<!DOCTYPE HTML>
<html>
    <head>
        <title>PPOST CUSTOMER TRANSACTIONS</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php"><img src="./logo.jpg" height=100 alt=""></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../Track.php">Track Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Customer.php">Customer Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Funds.php">FundsHistory</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            DataBase Control
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="Create.php">CreateSQLSchema</a>
                        <a class="dropdown-item" href="Delete.php">DeleteSQLSchema</a>
                        <a class="dropdown-item" href="Insert.php">InsertRecords</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <?php 
            include("DataBaseConnection.php");
            $TrackingID=$_POST["trackingID"];
            $Length_Tracking=0;
            // Get ParcelID, Invoice
            $Query="SELECT ParcelID,InvoiceID FROM Parcel WHERE ParcelID=$TrackingID";
            $parse=oci_parse($con,$Query);
            $Execute=oci_execute($parse);
            $row_Basic = oci_fetch_array($parse, OCI_BOTH+OCI_RETURN_NULLS);
            if($row_Basic!=0)
            {
                // Get Empno,CustomerID
                $Query2="SELECT Empno,CustomerID FROM INVOICE WHERE InvoiceID=$row_Basic[1]";
                $parse2 = oci_parse($con, $Query2);
                $Execute2 = oci_execute($parse2);
                $row_Members = oci_fetch_array($parse2, OCI_BOTH+OCI_RETURN_NULLS);
                if($row_Members!=0)
                {
                    //Get Customer Information
                    $Query3="SELECT FName,LName FROM CUSTOMER WHERE CustomerID=".$row_Members['1'];
                    $parse3 = oci_parse($con, $Query3);
                    $Execute3 = oci_execute($parse3);
                    $row_Customer = oci_fetch_array($parse3, OCI_BOTH+OCI_RETURN_NULLS);
                    // Get Recipient Information
                    $Query4="SELECT FName,LName,SignedBy FROM RECIPIENT WHERE ParcelID=$row_Basic[0]";
                    $parse4 = oci_parse($con, $Query4);
                    $Execute4 = oci_execute($parse4);
                    $row_Recipient = oci_fetch_array($parse4, OCI_BOTH+OCI_RETURN_NULLS);
                    // Get Tracking_details
                    $Query5="SELECT to_char(DateANDTime,'MM/DD/YYYY hh24:mi'),Status,Location FROM TRACKING_DETAILS WHERE ParcelID=$row_Basic[0]";
                    $parse5 = oci_parse($con, $Query5);
                    $Execute5 = oci_execute($parse5);
                    $row_Tracking=array();
                    while($row= oci_fetch_array($parse5, OCI_BOTH+OCI_RETURN_NULLS)) {
                        array_push($row_Tracking,$row);
                        $Length_Tracking++;
                    }
        ?>

        <div class="form-group" style="margin:50px 20px 0px 30px;">
            <label style="color:Red;" >Tracking Number : </label>
            <span > <?php echo $TrackingID; ?></span>

        </div>
        <div style="width:400px;float:right;margin-right:40px;margin-top:60px;">
        <div class="Form_Container" style="max-width: 800px; margin-left:30px;" >
                <div class="form-group">
                    <div><label class="labl" > Shipment Tracking Summary </label></div>
                </div>
                <div class="form-group">
                    <div><label class="labl" > Current Status </label></div>
                    <div class="form-control form-control"> <?php echo $row_Tracking[4][1]; ?> </div>
                </div>

                <div class="form-group">
                    <div><label class="labl" >  Delivered On </label></div>
                    <div class="form-control form-control"> <?php echo $row_Tracking[0][0]?> </div>
                </div>

                <div class="form-group">
                    <div><label class="labl" > SignedBy </label></div>
                    <div class="form-control form-control"> <?php echo $row_Recipient[2]; ?> </div>
                </div>
            </div>
        </div>
        <div style="width: 700px">
            <div class="Form_Container" style="max-width: 600px; margin-left:30px;" >
                <div class="form-group">
                    <div><label class="labl" >Shipment Details</label></div>
                </div>
                <div class="form-group">
                    <div><label class="labl" > Agent Reference Number </label></div>
                    <div class="form-control form-control"> <?php echo $row_Members[1]; ?> </div>
                </div>

                <div class="form-group">
                    <div><label class="labl" >  Origin </label></div>
                    <div class="form-control form-control"> <?php echo $row_Tracking[0][2]?> </div>
                </div>

                <div class="form-group">
                    <div><label class="labl" >Booking Date </label></div>
                    <div class="form-control form-control"> <?php  echo $row_Tracking[0][0]; ?> </div>
                </div>
                <div class="form-group">
                    <div><label class="labl" > Shipper </label></div>
                    <div class="form-control form-control"> <?php 
                        echo $row_Customer[0].' ',$row_Customer[1] ?> </div>
                </div>

                <div class="form-group" >
                    <div><label class="labl" >ConSignee </label></div>
                    <div class="form-control form-control"> <?php
                        echo  $row_Recipient[0]." ",$row_Recipient[1]; ?> </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <table class="table" style="margin-top:20px;">
            <thead class="thead-dark table-striped">
                <tr>
                    <th scope="col">DateAndTime</th>
                    <th scope="col">Status</th>
                    <th scope="col">Location</th>
                </tr>
            </thead>
            <tbody>
                <tr scope="row">
                <?php
                    for($var=0;$var<$Length_Tracking;$var++) {
                        echo "<td>".$row_Tracking[$var][0]."</td>";
                        echo "<td>".$row_Tracking[$var][1]."</td>";
                        echo "<td>".$row_Tracking[$var][2]."</td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        <?php
                }
            }
            else {?>
                <div class="form-group" style="margin:50px 20px 0px 30px;">
                <label style="color:Red;" >NO Records Found Against Tracking Number </label>
                </div>
           <?php } ?>
</body>
</html>

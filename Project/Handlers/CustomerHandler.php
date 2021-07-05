<!DOCTYPE HTML>
<html>
    <head>
        <title>PPOST CUSTOMER TRANSACTIONS</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            $CustomerID=$_POST["CustomerID"];
            $query="SELECT CustomerID,FName,LName,Street,City,Province,PhoneNumber,
            CNIC FROM Customer WHERE CustomerID=".$CustomerID;
            $parse=oci_parse($con,$query);
            $execte=oci_execute($parse);
            $row = oci_fetch_array($parse, OCI_BOTH+OCI_RETURN_NULLS); 
            if($row!=0) {
        ?>
        <div class="Form_Container" style="max-width: 1200px;" >
            <div class="form-group">
                <div><label class="labl" >CustomerName </label></div>
                <div class="form-control"> <?php echo $row[1]." ".$row[2]; ?></div>
            </div>
            <div class="form-group">
                <div><label class="labl" >CustomerID </label></div>
                <div class="form-control"> <?php echo $row[0]; ?> </div>
            </div>

            <div class="form-group">
                <div><label class="labl" >Address </label></div>
                <div class="form-control"> <?php echo $row[3].", ".$row[4].", ".$row[5]; ?> </div>
            </div>

            <div class="form-group">
                <div><label class="labl" >City </label></div>
                <div class="form-control"> <?php echo $row[4]; ?> </div>
            </div>
            <div class="form-group">
                <div><label class="labl" >PhoneNumber </label></div>
                <div class="form-control"> <?php 
                    $row[6]=substr_replace( $row[6], '-', 3, 0 );
                    echo "0".$row[6]; ?> </div>
            </div>

            <div class="form-group" >
                <div><label class="labl" >CNIC </label></div>
                <div class="form-control"> <?php
                    $row[7]=substr_replace( $row[7], '-', 5, 0 );
                    $row[7]=substr_replace( $row[7], '-', 13, 0 );
                    echo  $row[7]; ?> </div>
            </div>
        <table class="table" style="magin-top:20px;">
            <thead class="thead-dark table-striped">
                <tr>
                    <th scope="col">Parcel NO.</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Recipient Name</th>
                    <th scope="col">Recipient Address</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query1="SELECT InvoiceID,InDate FROM INVOICE WHERE CustomerID=$CustomerID";
                    $parse1=oci_parse($con,$query1);
                    $execte1=oci_execute($parse1);
                    while($row1 = oci_fetch_array($parse1, OCI_BOTH+OCI_RETURN_NULLS)) {
                        $query2="SELECT parcelID, Description, Quantity FROM parcel WHERE InvoiceID = ".$row1[0];
                        $parse2=oci_parse($con,$query2);
                        $execte2=oci_execute($parse2);
                        while($row_parcel = oci_fetch_array($parse2, OCI_BOTH+OCI_RETURN_NULLS)) {
                            $query3="SELECT FName,LName,Street,City,Province
                            FROM RECIPIENT WHERE ParcelID=$row_parcel[0]";                
                            $parse3 = oci_parse($con, $query3);
                            $execute3 = oci_execute($parse3);
                            while($row_recipient = oci_fetch_array($parse3, OCI_BOTH+OCI_RETURN_NULLS)) {
                                $query4="SELECT Status FROM TRACKING_DETAILS 
                                WHERE ParcelID=$row_parcel[0] AND TrackingID >= ALL
                                (SELECT TrackingID FROM TRACKING_DETAILS
                                WHERE ParcelID=$row_parcel[0])";
                                $parse4 = oci_parse($con, $query4);
                                $execute4 = oci_execute($parse4);
                                $row_tracking = oci_fetch_array($parse4, OCI_BOTH+OCI_RETURN_NULLS);
                                ?>
                                <tr scope="row">
                                <?php
                                echo "<td>$row_parcel[0]</td>";
                                echo "<td>$row_parcel[1]</td>";
                                echo "<td>$row_parcel[2]</td>";
                                echo "<td>".$row_recipient[0]." ".$row_recipient[1]."</td>";
                                echo "<td>".$row_recipient[2].",".$row_recipient[3].",".$row_recipient[4]."</td>";
                                echo "<td>$row_tracking[0]</td>";
                                echo "<td>".date('d M Y', strtotime($row1[1]))."</td>";
                                echo "</tr>";
                            }
                        }
                    }?>
                </tbody>
            </table>
        </div>
                <?php } else { ?>
                    <div class="form-group">
                <div><label class="labl" >No Customer Found By Given Parameters.</label></div>
                <?php } ?>
</body>
</html>

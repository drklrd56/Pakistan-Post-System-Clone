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
            function searchArray($Array,$Value){
                foreach($Array as $i){
                    if($i[1]==$Value)
                        return $i[2];
                }
                return 0;
            }
            $BranchID=$_POST["PostalCode"];
            $Year=$_POST["Year"];

            $query="SELECT Name,Head FROM POST_OFFICE WHERE POSTALCODE=".$BranchID;
            $parse=oci_parse($con,$query);
            $execte=oci_execute($parse);
            $row = oci_fetch_array($parse, OCI_BOTH+OCI_RETURN_NULLS); 
            if($row!=0)
            {
                $query_Emp="SELECT FName,LName FROM Employee WHERE Empno=".$row[1];
                $parse_Emp=oci_parse($con,$query_Emp);
                $execte_Emp=oci_execute($parse_Emp);
                $Year[0]='0';
                $row_Emp = oci_fetch_array($parse_Emp, OCI_BOTH+OCI_RETURN_NULLS); 
            ?>
            <div class="Form_Container" style="max-width: 1200px;" >
                <div class="form-group">
                    <div><label class="labl" > Year </label></div>
                    <div class="form-control"> <?php $Year[0]='2'; echo $Year; $Year[0]='0'; ?></div>
                </div>
                <div class="form-group">
                    <div><label class="labl" >Branch# </label></div>
                    <div class="form-control"> <?php echo $BranchID; ?> </div>
                </div>

                <div class="form-group">
                    <div><label class="labl" > Name </label></div>
                    <div class="form-control"> <?php echo $row[0] ?> </div>
                </div>

                <div class="form-group">
                    <div><label class="labl" >Manager Name </label></div>
                    <div class="form-control"> <?php echo $row_Emp[0]." ".$row_Emp[1]; ?> </div>
                </div>
            <table class="table" style="magin-top:20px;">
                <thead class="thead-dark table-striped">
                    <tr>
                        <th scope="col">NO. of Collections</th>
                        <th scope="col">Month</th>
                        <th scope="col">Amount Collected</th>
                        <th scope="col">Amount Returnend</th>
                        <th scope="col">Net Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query1="select count(p.parcelid),TO_CHAR( TRUNC(i.InDate, 'month'),'MM' ),sum(s.Rate)
                        from parcel p, invoice i,tracking_details t,service s
                        where i.invoiceid = p.invoiceid
                        and p.parcelid = t.parcelid
                        and p.serviceid = s.serviceid
                        and (t.status='Delivered' OR t.status='Bounced')
                        and i.postalcode = ".$BranchID."
                        and to_char(trunc(i.Indate,'year'),'YYYY')=".$Year." 
                        group by TO_CHAR( TRUNC(i.InDate, 'month'),'MM' )
                        order by TO_CHAR( TRUNC(i.INDate, 'month'),'MM' )";

                        $query2="select count(p.parcelid),TO_CHAR( TRUNC(i.InDate, 'month'),'MM' ),sum(s.Rate)
                        from parcel p, invoice i,tracking_details t,service s
                        where i.invoiceid = p.invoiceid
                        and p.parcelid = t.parcelid
                        and p.serviceid = s.serviceid
                        and t.status = 'Bounced'
                        and i.postalcode = ".$BranchID."
                        and to_char(trunc(i.Indate,'year'),'YYYY')=".$Year." 
                        group by TO_CHAR( TRUNC(i.InDate, 'month'),'MM' )
                        order by TO_CHAR( TRUNC(i.INDate, 'month'),'MM' )";
                        $parse2=oci_parse($con,$query2);
                        $execte2=oci_execute($parse2);
                        $bounced=array();
                        while($row_Return = oci_fetch_array($parse2, OCI_BOTH+OCI_RETURN_NULLS)){
                            array_push($bounced,$row_Return);
                        }
                        $parse1=oci_parse($con,$query1);
                        $execte1=oci_execute($parse1);
                        while($row_Collection = oci_fetch_array($parse1, OCI_BOTH+OCI_RETURN_NULLS)) { ?>
                            <tr scope="row">
                            <?php
                            echo "<td>$row_Collection[0]</td>";
                            echo "<td>$row_Collection[1]</td>";
                            echo "<td>$row_Collection[2]</td>";  
                            $value=searchArray($bounced,$row_Collection[1]);
                            if($value!=0) {
                                echo "<td>$value</td>";
                                $value=(int)$row_Collection[2]-(int)$value;
                                echo "<td>$value</td>";
                            }
                            else {
                                echo "<td>0</td>";
                                echo "<td>$row_Collection[2]</td>";
                            }
                            echo "</tr>";  
                        }
                        ?>
                    </tbody>
                </table>
            </div>
                    <?php } 
                    else { ?>
                        <div class="form-group">
                            <div><label class="labl" > Branch Not Found</label></div>
                        </div>
                <?php } ?>
</body>
</html>

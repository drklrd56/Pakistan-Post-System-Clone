<!DOCTYPE HTML>
<html>
    <head>
        <title>PPOST CUSTOMER TRANSACTIONS</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="Handlers/style.css">
    </head>
    <body>
        <table style="width:100%">
        <tr>
                <th>CustomerID</th>
                <th>NAme</th>
                <th>Address</th>
                <th>City</th>
                <th>PhoneNumber</th>
                <th>CNIC</th>
            </tr>
        <?php 
        include("DataBaseConnection.php");
        $CustomerID=$_POST["CustomerID"];
        echo $CustomerID;
        echo "<br>";
        $query="SELECT CustomerID,FName,LName,Street,City,Province,PhoneNumber,
        CNIC FROM Customer";
        $parse=oci_parse($con,$query);
        $execte=oci_execute($parse);
        while($row = oci_fetch_array($parse, OCI_BOTH+OCI_RETURN_NULLS)) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]"." $row[2]</td>";
            echo "<td>$row[3],"."$row[4],"."$row[5]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[6]</td>";
            echo "<td>$row[7]</td>";
            echo "</tr>";
        } ?>
        </table>
</body>
</html>

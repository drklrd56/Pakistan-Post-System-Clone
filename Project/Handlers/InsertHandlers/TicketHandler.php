<?php 
 // Handle Tickets
 $skip=0;
 $datapath="";
 $values="";
 //TicketID,IssuanceDate,ExpiryDate,Price
 if (($h = fopen('InsertHandlers\DataSet\TicketPayment.csv', "r") )!== FALSE) {
    echo "<h1>Ticket Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO TICKET_PAYMENT(TicketID".",".$data[1].",".$data[2].",".$data[3].")";
            $skip=$skip+1;        
        }
        else {
            $daat="to_date("."'".$data[1]."','DD-MM-YYYY')";
            $daat2="to_date("."'".$data[2]."','DD-MM-YYYY')";
            $values="Values(".(int)$data[0].",".$daat.",".$daat.",".$data[3].")";
            $query=$dataPath.$values;
            echo $dataPath;
                echo "<br>";
                echo $values;
                echo ";";
                echo "<br>";
                echo "<br>";
            $parse=oci_parse($con,$query);
            $execute=oci_execute($parse);
        }
    }
}
    fclose($h);
?>
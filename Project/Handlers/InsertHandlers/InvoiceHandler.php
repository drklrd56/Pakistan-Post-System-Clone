<?php 
 // Handle Invoice
 $skip=0;
 $datapath="";
 $datapath2="";
 $values="";
 //InvoiceID,CustomerID,Type,InDate,Empno,PostalCode
 if (($h = fopen('InsertHandlers\DataSet\Invoice.csv', "r") )!== FALSE) {
    echo "<h1>Invoice Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        
        if($skip==0) {   
            $dataPath="INSERT INTO INVOICE(InvoiceID".",".$data[1].",".$data[2].",".$data[3].",".$data[4].",".$data[5].")";
            $dataPath2="INSERT INTO INVOICE(InvoiceID".",".$data[2].",".$data[3].",".$data[4].",".$data[5].")";
            $skip=$skip+1;        
        }
        else {
            if($data[1]==0) {
                $daat="to_date("."'".$data[3]."','DD-MM-YYYY')";
                $values="Values(".(int)$data[0].",".(int)$data[2].",".$daat.",".(int)$data[4].",".(int)$data[5].")";
                $query=$dataPath2.$values;
                echo $dataPath2;
                echo "<br>";
                echo $values;
                echo ";";
                echo "<br>";
                echo "<br>";
            }
            else {
                $daat="to_date("."'".$data[3]."','DD-MM-YYYY')";
                $values="Values(".(int)$data[0].",".(int)$data[1].",".(int)$data[2].",".$daat.",".(int)$data[4].",".(int)$data[5].")";
                $query=$dataPath.$values;
                echo $dataPath;
                echo "<br>";
                echo $values;
                echo ";";
                echo "<br>";
                echo "<br>";
            }
            $parse=oci_parse($con,$query);
            $execute=oci_execute($parse);
        }
    }
}
    fclose($h);
?>
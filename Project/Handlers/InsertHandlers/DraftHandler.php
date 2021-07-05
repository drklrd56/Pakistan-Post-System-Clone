<?php 
 // Handle Draft
 $skip=0;
 $datapath="";
 $values="";
 //TicketID,Description
 if (($h = fopen('InsertHandlers\DataSet\Draft.csv', "r") )!== FALSE) {
    echo "<h1>Draft Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO Draft(TicketID".",".$data[1].")";
            $skip=$skip+1;        
        }
        else {
            $values="Values(".(int)$data[0].",".(int)$data[1].")";
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
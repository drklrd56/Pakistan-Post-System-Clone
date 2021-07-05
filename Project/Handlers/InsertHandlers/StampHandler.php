<?php 
 // Handle Stamp
 $skip=0;
 $datapath="";
 $values="";
 //TicketID,Description
 if (($h = fopen('InsertHandlers\DataSet\Stamp.csv', "r") )!== FALSE) {
    echo "<h1>Stamp Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO Stamp(TicketID".",".$data[1].",".$data[2].",".$data[3].",".$data[4].")";
            $skip=$skip+1;        
        }
        else {
            $values="Values(".(int)$data[0].",'".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."')";
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
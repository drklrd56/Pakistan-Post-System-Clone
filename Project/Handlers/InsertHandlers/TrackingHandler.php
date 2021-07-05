<?php 
 // Handle Tracking
 $skip=0;
 $datapath="";
 $values="";
 //ParcelID,TrackingID,Empno,Date,Status,Location
 if (($h = fopen('InsertHandlers\DataSet\TrackingDetail.csv', "r") )!== FALSE) {
    echo "<h1>Tracking_Details Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO TRACKING_DETAILS(ParcelID".",".$data[1].",".$data[2].",".$data[3].",".$data[4].
            ",".$data[5].")";
            $skip=$skip+1;        
        }
        else {
            $daat="to_date('".$data[3]."','"."MM/DD/YYYY HH24:MI:SS')";
            $values="Values(".(int)$data[0].",".(int)$data[1].",".(int)$data[2].",".$daat.",'".$data[4]."','".$data[5]."')";
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
<?php 
 // Handle Service
 $skip=0;
 $datapath="";
 $values="";
 //ServiceID,Name,MaxWeight,Rate
 if (($h = fopen('InsertHandlers\DataSet\Service.csv', "r") )!== FALSE) {
    echo "<h1>Service Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO Service(ServiceID".",".$data[1].",".$data[2].",".$data[3].")";
            $skip=$skip+1;        
        }
        else {
            $values="Values(".(int)$data[0].",'".$data[1]."',".(int)$data[2].",".(int)$data[3].")";
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

<?php 
 // Handle Parcel
 $skip=0;
 $datapath="";
 $values="";
 //ParcelID,Description,Weight,IsInsured,Value,Quantity,ServiceID,InvoiceID
 if (($h = fopen('InsertHandlers\DataSet\Parcel.csv', "r") )!== FALSE) {
    echo "<h1>Parcel Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO Parcel(ParcelID".",".$data[1].",".$data[2].",".$data[3].",".$data[4].
            ",".$data[5].",".$data[6].",".$data[7].")";
            $skip=$skip+1;        
        }
        else {
            $values="Values(".(int)$data[0].",'".$data[1]."',".(int)$data[2].",".(int)$data[3].",".(int)$data[4].
            ",".(int)$data[5].",".(int)$data[6].",".$data[7].")";
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
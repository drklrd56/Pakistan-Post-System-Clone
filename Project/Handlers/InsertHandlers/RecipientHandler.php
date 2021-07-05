<?php 
 // Handle Recipient
 $skip=0;
 $datapath="";
 $values="";
 //ParcelID,Fname,Lname,PhoneNumber,Street,City,Province,Signed By
 if (($h = fopen('InsertHandlers\DataSet\Recipient.csv', "r") )!== FALSE) {
    echo "<h1>Recipient Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO Recipient(ParcelID".",".$data[1].",".$data[2].",".$data[3].",".$data[4].
            ",".$data[5].",".$data[6].",".$data[7].")";
            $skip=$skip+1;        
        }
        else {
            $data[3]=preg_replace("/-/", "", $data[3]);
            $values="Values(".(int)$data[0].",'".$data[1]."','".$data[2]."',".(int)$data[3].",'".$data[4].
            "','".$data[5]."','".$data[6]."','".$data[7]."')";
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

<?php 
 // Handle BrachOffice
 $skip=0;
 $datapath="";
 $datapath2="";
 $values="";
 //PostalCode,Name,OfficeType,Head,ContactNumber,Street,City,Province,GPO
 if (($h = fopen('InsertHandlers\DataSet\PostOffice.csv', "r") )!== FALSE) {
    echo "<h1>POST_OFFICE Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO POST_OFFICE(POSTALCODE".",".$data[1].",".$data[2].",".$data[3].",".$data[4].
            ",".$data[5].",".$data[6].",".$data[7].",".$data[8].")";
            $dataPath2="INSERT INTO POST_OFFICE(POSTALCODE".",".$data[1].",".$data[2].",".$data[3].",".$data[4].
            ",".$data[5].",".$data[6].",".$data[7].")";
            $skip=$skip+1;        
        }
        else {
            $data[4]=preg_replace("/-/", "", $data[4]);
            if($data[8]=='NULL') {
                $values="Values(".(int)$data[0].",'".$data[1]."','".$data[2]."',".(int)$data[3].",".(int)$data[4].
                ",'".$data[5]."','".$data[6]."','".$data[7]."')";
                $query=$dataPath2.$values;
                echo $dataPath2;
                echo "<br>";
                echo $values;
                echo ";";
                echo "<br>";
                echo "<br>";
            }
            else {
                $values="Values(".(int)$data[0].",'".$data[1]."','".$data[2]."',".(int)$data[3].",".(int)$data[4].
                ",'".$data[5]."','".$data[6]."','".$data[7]."',".(int)$data[8].")";
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

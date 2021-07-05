<?php 
 // Handle Employee
 $skip=0;
 $datapath="";
 $values="";
 if (($h = fopen('InsertHandlers\DataSet\Employee.csv', "r") )!== FALSE) {
    echo "<h1>Employee Update</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $skip=$skip+1;        
        }
        else {
            $dataPath="UPDATE EMPLOYEE SET BranchID=".$data[10]." WHERE Empno=".(int)$data[0];
            $query=$dataPath;
            echo $dataPath;
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
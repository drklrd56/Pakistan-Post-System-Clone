<?php 
 // Handle Employee
 $skip=0;
 $datapath="";
 $values="";
 //Empno,FName,LName,CNIC,Job,Salary,PhoneNumber,Street,City,Province,BranchID
 if (($h = fopen('InsertHandlers\DataSet\Employee.csv', "r") )!== FALSE) {
    echo "<h1>Employee Records</h1>";
    while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
        if($skip==0) {   
            $dataPath="INSERT INTO EMPLOYEE(Empno".",".$data[1].",".$data[2].",".$data[3].",".$data[4].
            ",".$data[5].",".$data[6].",".$data[7].",".$data[8].",".$data[9].")";
            $skip=$skip+1;        
        }
        else {
            $data[3]=preg_replace("/-/", "", $data[3]);
            $data[5]=preg_replace("/,/", "", $data[5]);
            $data[6]=preg_replace("/-/", "", $data[6]);
            $values="Values(".(int)$data[0].",'".$data[1]."','".$data[2]."',".(int)$data[3].",'".$data[4].
            "',".(int)$data[5].",".(int)$data[6].",'".$data[7]."','".$data[8]."','".$data[9]."')";
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
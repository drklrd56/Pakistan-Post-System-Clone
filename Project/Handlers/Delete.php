<?php
    include('DataBaseConnection.php');
    $queries=array("DROP TABLE PAYMENT","DROP TABLE RECIPIENT",
    "DROP TABLE TRACKING_DETAILS","DROP TABLE PARCEL","DROP TABLE SERVICE",
    "DROP TABLE INVOICE","DROP TABLE CUSTOMER",
    "ALTER TABLE POST_OFFICE DROP CONSTRAINT fk_Head","DROP TABLE EMPLOYEE","DROP TABLE POST_OFFICE",
    "DROP TABLE STAMP","DROP TABLE DRAFT","DROP TABLE TICKET_PAYMENT");
    foreach($queries as $query) {
        $parse=oci_parse($con,$query);
        $execute=oci_execute($parse);
    }

?>
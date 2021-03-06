<?php
    include('DataBaseConnection.php');
    $queries=array("CREATE TABLE CUSTOMER (
        CustomerID  NUMBER   NOT NULL,
        CNIC        NUMBER(14)   NOT NULL,
        FName       VARCHAR2(25) NOT NULL,
        LName       VARCHAR2(25) NOT NULL,
        Province    VARCHAR(25)  NOT NULL,
        City        VARCHAR2(25) NOT NULL,
        Street      VARCHAR2(50) NOT NULL,
        PhoneNumber NUMBER(11)   NOT NULL,
        PRIMARY KEY(CustomerID) )",
    
    "CREATE TABLE POST_OFFICE (
        POSTALCODE    NUMBER        NOT NULL,
        Name          VARCHAR2(40)  NOT NULL,
        Province      VARCHAR(25)   NOT NULL,
        City          VARCHAR2(25)  NOT NULL,
        Street        VARCHAR2(50)  NOT NULL,
        ContactNumber NUMBER(11)    NOT NULL,
        OfficeType    VARCHAR2(15)  NOT NULL,
        Head          NUMBER                ,
        GPO           NUMBER                ,
        PRIMARY KEY(POSTALCODE),
        FOREIGN KEY(GPO) REFERENCES    POST_OFFICE(POSTALCODE) )",
    
    "CREATE TABLE EMPLOYEE (
        Empno       NUMBER       NOT NULL,
        CNIC        NUMBER(14)   NOT NULL,
        FName       VARCHAR2(25) NOT NULL,
        LName       VARCHAR2(25) NOT NULL,
        Province    VARCHAR(25)  NOT NULL,
        City        VARCHAR2(25) NOT NULL,
        Street      VARCHAR2(50) NOT NULL,
        PhoneNumber NUMBER(11)   NOT NULL,
        Salary      NUMBER       NOT NULL,
        Job         VARCHAR2(20) NOT NULL,
        BranchID    NUMBER               ,
        FOREIGN KEY(BranchID) REFERENCES POST_OFFICE(POSTALCODE),       
        PRIMARY KEY(Empno) )",
    
    "ALTER TABLE POST_OFFICE ADD CONSTRAINT fk_Head FOREIGN KEY (Head) REFERENCES EMPLOYEE(Empno)",
    
    "CREATE TABLE TICKET_PAYMENT (
        TICKETID        NUMBER          NOT NULL,
        IssuanceDate    Date            NOT NULL,
        ExpiryDate      Date            NOT NULL,
        Price           NUMBER          NOT NULL,
        PRIMARY KEY(TICKETID))",
    
    "CREATE TABLE STAMP (
        TICKETID        NUMBER          NOT NULL,
        Description     VARCHAR2(40)    NOT NULL,
        COLOR           VARCHAR2(10)            ,
        HEIGHT          NUMBER(2)               ,
        WIDTH           NUMBER(2)               ,
        PRIMARY KEY(TICKETID),
        FOREIGN KEY(TICKETID) REFERENCES TICKET_PAYMENT(TICKETID) )",
    
    "CREATE TABLE DRAFT (
        TICKETID        NUMBER          NOT NULL,
        Commission      NUMBER          NOT NULL,
        PRIMARY KEY(TICKETID),
        FOREIGN KEY(TICKETID) REFERENCES TICKET_PAYMENT(TICKETID) )",
    
    "CREATE TABLE SERVICE (
        ServiceID   NUMBER          NOT NULL,
        Name        VARCHAR2(20)    NOT NULL,
        Rate        NUMBER          NOT NULL,
        MaxWeight   NUMBER          NOT NULL,
        PRIMARY KEY(ServiceID) )",
    
    "CREATE TABLE INVOICE ( 
        InvoiceID   NUMBER  NOT NULL,
        CustomerID  NUMBER          ,
        Empno       NUMBER  NOT NULL,
        Type        NUMBER  NOT NULL,
        InDate      Date    NOT NULL,
        POSTALCODE  NUMBER  NOT NULL,
        PRIMARY KEY(InvoiceID),
        FOREIGN KEY(Empno)      REFERENCES  EMPLOYEE(Empno),
        FOREIGN KEY(CustomerID) REFERENCES  CUSTOMER(CustomerID),
        FOREIGN KEY(POSTALCODE) REFERENCES  POST_OFFICE(POSTALCODE) )",
    
    "CREATE TABLE PARCEL (
        ParcelID      NUMBER          NOT NULL,
        Quantity        NUMBER          NOT NULL,
        Weight          NUMBER          NOT NULL,
        Description     VARCHAR2(50)    NOT NULL,
        isInsured       NUMBER          NOT NULL,
        Value           NUMBER                  ,
        ServiceID       NUMBER                  ,
        InvoiceID       NUMBER          NOT NULL,
        FOREIGN KEY(ServiceID)  REFERENCES SERVICE(ServiceID),
        FOREIGN KEY(InvoiceID)  REFERENCES INVOICE(InvoiceID),
        PRIMARY KEY(ParcelID) )",
    
    "CREATE TABLE RECIPIENT (
        ParcelID  NUMBER       NOT NULL,
        FName       VARCHAR2(25) NOT NULL,
        LName       VARCHAR2(25) NOT NULL,
        Province    VARCHAR2(25) NOT NULL,
        City        VARCHAR2(25) NOT NULL,
        Street      VARCHAR2(50) NOT NULL,
        PhoneNumber NUMBER(11)   NOT NULL,
        SignedBy   VARCHAR2(30) NOT NULL,  
        FOREIGN KEY(ParcelID) REFERENCES  PARCEL(ParcelID) )",
    
    "CREATE TABLE TRACKING_DETAILS (
        ParcelID    NUMBER        NOT NULL,
        TrackingID  NUMBER        NOT NULL,
        Empno       NUMBER        NOT NULL,
        Location    VARCHAR2(40)          ,  
        Status      VARCHAR2(100) NOT NULL,
        DateANDTime Date                 ,
        PRIMARY KEY(ParcelID,TrackingID),
        FOREIGN KEY(ParcelID) REFERENCES  PARCEL(ParcelID),
        FOREIGN KEY(Empno)    REFERENCES  EMPLOYEE(Empno) )",
    "CREATE TABLE PAYMENT (
        InvoiceID       NUMBER      NOT NULL,
        TICKETID        NUMBER      NOT NULL,
        Quantity        NUMBER      NOT NULL,
        Total           NUMBER      NOT NULL,
        PRIMARY KEY(InvoiceID,TICKETID),
        FOREIGN KEY(InvoiceID) REFERENCES  INVOICE(InvoiceID),
        FOREIGN KEY(TICKETID)  REFERENCES  TICKET_PAYMENT(TICKETID) )");

    foreach($queries as $query) {
        $parse=oci_parse($con,$query);
        $execute=oci_execute($parse);
    }
?>
    

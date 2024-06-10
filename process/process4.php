<?php
    session_start();

    $dbserver = "localhost";
    $dblocation = "root";
    $dbpassword = "Dilshan@1234";
    $dbname = "waterbills";
    
    $dbms = new mysqli($dbserver,$dblocation,$dbpassword,$dbname,"3306");

    $billuse = $_POST["billuse"];
    $billfinalvalue = filter_var(trim($_POST["billfinalvalue"]), FILTER_SANITIZE_STRING);
    $year = $_POST["year"];
    $month = $_POST["month"];
    $tariffid = 2;

    $dateStr =  $_POST["yearname"]." ".$_POST["monthname"]." 01";
    $date = DateTime::createFromFormat('Y F d', $dateStr);
    $formattedDate = $date->format('Y-m-d');

    $query ="SELECT * FROM bill_tariff WHERE upfrom <= '".$formattedDate."' AND (tilfor >= '".$formattedDate."' OR tilfor IS NULL);";
    $resultset = $dbms -> query($query);
    $data = $resultset->fetch_assoc();
    $tariffid = $data["id"];

    $intbilluse = intval($billuse);
    $str = str_replace(',', '', $billfinalvalue);
    $doublefinalvalue = (double) $str;

    $query ="INSERT INTO bill(`customer_id`,`year_id`,`month_id`,`tariff_id`,`units`,`total`) VALUES('".$_SESSION["myuser"]["id"]."','".$year."','".$month."','".$tariffid."','".$intbilluse."','".$doublefinalvalue."');";
    $dbms -> query($query);
    echo "Success";
?>
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

    $intbilluse = intval($billuse);
    $str = str_replace(',', '', $billfinalvalue);
    $doublefinalvalue = (double) $str;

    $query ="INSERT INTO bill(`customer_id`,`year_id`,`month_id`,`units`,`total`) VALUES('".$_SESSION["user"]["id"]."','".$year."','".$month."','".$intbilluse."','".$doublefinalvalue."');";
    $dbms -> query($query);
    echo "Success";
?>
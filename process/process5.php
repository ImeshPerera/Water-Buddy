<?php
    session_start();

    $dbserver = "localhost";
    $dblocation = "root";
    $dbpassword = "Dilshan@1234";
    $dbname = "waterbills";
    
    $dbms = new mysqli($dbserver,$dblocation,$dbpassword,$dbname,"3306");

    $yearid = $_POST["yearid"];

    $query ="SELECT * FROM months WHERE id NOT IN (SELECT DISTINCT months.id FROM years INNER JOIN months LEFT JOIN bill ON months.id = bill.month_id AND years.id = bill.year_id WHERE bill.customer_id = '".$_SESSION["myuser"]["id"]."' AND bill.year_id = '".$yearid."');";
    $result = $dbms -> query($query);
    $in = $result->num_rows;
    for($i=1; $i<=$in; $i++){
        $data = $result->fetch_assoc();
        ?><option value="<?php echo $data["id"] ?>"><?php echo $data["name"]; ?></option><?php
    }
?>
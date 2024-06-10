<?php

session_start();
if(isset($_SESSION["myadmin"])){

$dbserver = "localhost";
$dblocation = "root";
$dbpassword = "Dilshan@1234";
$dbname = "waterbills";
$currenttariffid;

$dbms = new mysqli($dbserver, $dblocation, $dbpassword, $dbname, "3306");

function formatNumber($number) {
    $formattedNumber = number_format((float)$number, 2, '.', '');
    if (strpos($formattedNumber, '.') !== false) {
        list($whole, $decimal) = explode('.', $formattedNumber);
        $whole = number_format((int)$whole);
        $formattedNumber = $whole . '.' . $decimal;
    } else {
        $formattedNumber = number_format((int)$formattedNumber);
    }    
    return $formattedNumber;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>WaterBuddy</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body class="main-background">
    <!-- Alert Boxes Start -->
    <?php require "alert.php"; ?>
    <!-- Alert Boxes End -->
    <div class="container-fluid min-vh-100 d-flex align-content-center pt-5">
        <div class="row align-content-sm-center">
            <!-- header -->
            <div class="col-12">
                <button class="btn btn-outline-secondary w-auto position-absolute ms-2 ms-md-5" onclick="SignOut();"> Logout </button>
                <div class="row">
                    <div class="col-12 logo">
                    </div>
                    <div class="col-12">
                        <p class="text-center title1">Hi, Welcome <?php echo $_SESSION["myadmin"]["name"]; ?></p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <!-- Content Start-->
            <div class="col-12 px-3">
                <div class="row px-2 px-md-5 g-3">
                    <div class="col-12 text-center">
                        <label class="form-lable title2 text-center text-bold">View & Change Current Thariff</label>
                        <p class="text-danger" id="msg1"></p>
                    </div>
                    <form action="admin.php" method="POST">
                        <div class="col-6 col-md-4 offset-3 offset-md-4">
                            <label class="form-lable">Change From</label>
                            <?php
                                $currentDate = new DateTime();
                                $nextMonth = $currentDate->modify('first day of next month');
                                $nextMonthString = $nextMonth->format('Y-m');
                            ?>
                            <input name="nextmonth" type="month" class="form-control" min="<?php echo $nextMonthString; ?>" />
                        </div>
                        <div class="col-12" id="bill_box">
                            <div class="row" id="bill_preview">
                                <div class="col-12 mt-4">
                                    <div class="row justify-content-center">
                                        <table class="table w-75">
                                            <tr class="table-secondary">
                                                <th class="text-center" colspan="2">Consumption per month (kWh)</th>
                                                <th class="text-end">Energy Charge (LKR/kWh)</th>
                                                <th class="text-end">Fixed Charge(LKR/month)</th>
                                            </tr>
                                            <?php
                                                $today = date("Y-m-d");
                                                $querya ="SELECT * FROM bill_tariff RIGHT JOIN water_bill_units ON bill_tariff.id = water_bill_units.tariff_id WHERE bill_tariff.upfrom <= '".$today."' AND (bill_tariff.tilfor >= '".$today."' OR bill_tariff.tilfor IS NULL);";
                                                $resulta = $dbms -> query($querya);
                                                $nr = $resulta->num_rows;
                                                for($j=1; $j<=$nr; $j++){
                                                    $dataa = $resulta->fetch_assoc();
                                                    $currenttariffid = $dataa["tariff_id"];
                                                ?>
                                                    <tr class="table-light">
                                                        <td><input type="number" disabled class="text-end w-fill" value="<?php echo $dataa['minvalue']; ?>" />
                                                        <input type="number" hidden name="<?php echo "min".$j; ?>" value="<?php echo $dataa['minvalue']; ?>" /></td>
                                                        <td><input type="number" disabled class="w-fill" value="<?php if($j == $nr){echo "++"; }else{echo $dataa['maxvalue'];} ?>" />
                                                        <input type="number" hidden name="<?php echo "max".$j; ?>" value="<?php if($j == $nr){echo "++"; }else{echo $dataa['maxvalue'];} ?>" /></td>
                                                        <td><input type="number" name="<?php echo "energycharge".$j; ?>" class="form-control" value="<?php echo $dataa['energycharge']; ?>"/></td>
                                                        <td><input type="number" name="<?php echo "fixcharge".$j; ?>" class="text-end form-control" value="<?php echo $dataa['fixcharge']; ?>"/></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-6 offset-3">
                                        <button class="btn btn-success w-50" type="submit">Submit Your Tariff as Final</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if(isset($_POST["nextmonth"]) && !empty($_POST["nextmonth"]) && is_numeric($currenttariffid)){
                        $selectedMonth = $_POST['nextmonth'];
                        $firstDayOfMonth = $selectedMonth . '-01';
                        $date = DateTime::createFromFormat('Y-m-d', $firstDayOfMonth);
                        $formattedDate = $date->format('Y-m-d');
                        $date->modify('last day of previous month');
                        $previousMonthEndDate = $date->format('Y-m-d');

                        $i = 1;

                        $inquery ="INSERT INTO bill_tariff(`upfrom`) VALUES('".$formattedDate."');";
                        if ($dbms->query($inquery) === TRUE) {
                            $newInquaryId = $dbms->insert_id;
                            $upquery ="UPDATE bill_tariff SET tilfor = '".$previousMonthEndDate."' WHERE id = '".$currenttariffid."';";
                            $dbms -> query($upquery);
                            for($i=1; $i<= $nr; $i++){
                                if(!is_numeric($_POST["max".$i])){
                                    $indataquery ="INSERT INTO water_bill_units(`tariff_id`,`minvalue`,`energycharge`,`fixcharge`) VALUES('".$newInquaryId."','".$_POST["min".$i]."','".$_POST["energycharge".$i]."','".$_POST["fixcharge".$i]."');";
                                }else{
                                    $indataquery ="INSERT INTO water_bill_units(`tariff_id`,`minvalue`,`maxvalue`,`energycharge`,`fixcharge`) VALUES('".$newInquaryId."','".$_POST["min".$i]."','".$_POST["max".$i]."','".$_POST["energycharge".$i]."','".$_POST["fixcharge".$i]."');";
                                }
                                $dbms -> query($indataquery);
                            }
                        }                       
                    }
                    ?>


                    <div class="col-12 mt-3">
                        <label class="form-lable text-bold mb-3">View next to come bill tariffs</label>
                    </div>
                    <?php
                        $queryx ="SELECT bill_tariff.id, bill_tariff.upfrom, bill_tariff.tilfor FROM bill_tariff RIGHT JOIN water_bill_units ON bill_tariff.id = water_bill_units.tariff_id WHERE bill_tariff.upfrom > '".$today ."' GROUP BY bill_tariff.id;";
                        $resultx = $dbms -> query($queryx);
                        $nr4 = $resultx->num_rows;
                        for($q=1; $q<=$nr4; $q++){
                            $datax = $resultx->fetch_assoc();
                    ?>
                        <div class="col-6 col-md-3 offset-md-3">
                            <label class="form-lable">From</label>
                            <div class="form-control"><?php echo $datax["upfrom"]; ?></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-lable">To</label>
                            <div class="form-control"><?php if(empty($datax["tilfor"])){echo "++";}else{echo $datax["tilfor"];} ?></div>
                        </div>
                        <div class="row" id="bill_preview">
                            <div class="col-12 mt-4">
                                <div class="row justify-content-center">
                                    <table class="table w-75">
                                        <tr class="table-secondary">
                                            <th class="text-center" colspan="2">Consumption per month (kWh)</th>
                                            <th class="text-end">Energy Charge (LKR/kWh)</th>
                                            <th class="text-end">Fixed Charge(LKR/month)</th>
                                        </tr>
                                        <?php
                                            $queryy ="SELECT * FROM bill_tariff RIGHT JOIN water_bill_units ON bill_tariff.id = water_bill_units.tariff_id WHERE bill_tariff.id = '".$datax["id"]."';";
                                            $resulty = $dbms -> query($queryy);
                                            $nr5 = $resulty->num_rows;
                                            for($j=1; $j<=$nr5; $j++){
                                                $datay = $resulty->fetch_assoc();
                                            ?>
                                                <tr class="table-light">
                                                    <td>
                                                        <div>
                                                            <label class="text-end w-fill"><?php echo $datay['minvalue']; ?> </label>                                                  
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <label class="w-fill"><?php if($j == $nr5){echo "++"; }else{echo $datay['maxvalue'];} ?></label>                                                  
                                                        </div>
                                                    </td>
                                                    <td><label type="number" class="text-end form-control"><?php echo formatNumber($datay['energycharge']); ?></label></td>
                                                    <td><label type="number" class="text-end form-control" ><?php echo formatNumber($datay['fixcharge']); ?></label></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>


                    <div class="col-12 mt-3">
                        <label class="form-lable text-bold mb-3">View past bill tariffs</label>
                    </div>
                    <?php
                        $queryb ="SELECT bill_tariff.id, bill_tariff.upfrom, bill_tariff.tilfor FROM bill_tariff RIGHT JOIN water_bill_units ON bill_tariff.id = water_bill_units.tariff_id WHERE bill_tariff.tilfor < '".$today ."' GROUP BY bill_tariff.id;";
                        $resultb = $dbms -> query($queryb);
                        $nr2 = $resultb->num_rows;
                        for($q=1; $q<=$nr2; $q++){
                            $datab = $resultb->fetch_assoc();
                    ?>
                        <div class="col-6 col-md-3 offset-md-3">
                            <label class="form-lable">From</label>
                            <div class="form-control"><?php echo $datab["upfrom"]; ?></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-lable">To</label>
                            <div class="form-control"><?php echo $datab["tilfor"]; ?></div>
                        </div>
                        <div class="row" id="bill_preview">
                            <div class="col-12 mt-4">
                                <div class="row justify-content-center">
                                    <table class="table w-75">
                                        <tr class="table-secondary">
                                            <th class="text-center" colspan="2">Consumption per month (kWh)</th>
                                            <th class="text-end">Energy Charge (LKR/kWh)</th>
                                            <th class="text-end">Fixed Charge(LKR/month)</th>
                                        </tr>
                                        <?php
                                            $queryc ="SELECT * FROM bill_tariff RIGHT JOIN water_bill_units ON bill_tariff.id = water_bill_units.tariff_id WHERE bill_tariff.id = '".$datab["id"]."';";
                                            $resultc = $dbms -> query($queryc);
                                            $nr3 = $resultc->num_rows;
                                            for($j=1; $j<=$nr3; $j++){
                                                $datac = $resultc->fetch_assoc();
                                            ?>
                                                <tr class="table-light">
                                                    <td>
                                                        <div>
                                                            <label class="text-end w-fill"><?php echo $datac['minvalue']; ?> </label>                                                  
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <label class="w-fill"><?php if($j == $nr3){echo "++"; }else{echo $datac['maxvalue'];} ?></label>                                                  
                                                        </div>
                                                    </td>
                                                    <td><label type="number" class="text-end form-control"><?php echo formatNumber($datac['energycharge']); ?></label></td>
                                                    <td><label type="number" class="text-end form-control" ><?php echo formatNumber($datac['fixcharge']); ?></label></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    <div class="col-12 mt-3 mt-lg-5">
                        <p class="text-center"><a href="https://www.imeshperera.com"
                                class="text-decoration-none text-dark">&copy; 2024 imeshperera.com All Rights
                                Reserved</a></p>
                    </div>
                </div>
                <!-- Content End -->
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.bundle.js"></script>
</body>

</html>

<?php
}else{
?>
<script>window.location = "index.php";</script>
<?php
}
?>
<?php

session_start();

$dbserver = "localhost";
$dblocation = "root";
$dbpassword = "Dilshan@1234";
$dbname = "waterbills";

$dbms = new mysqli($dbserver, $dblocation, $dbpassword, $dbname, "3306");

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
    <div class="container-fluid min-vh-100 d-flex align-content-center">
        <div class="row align-content-sm-center">
            <!-- header -->
            <div class="col-12">
                <div class="row">
                    <div class="col-12 logo">
                    </div>
                    <div class="col-12">
                        <p class="text-center title1">Hi, Welcome <?php echo $_SESSION["user"]["name"]; ?></p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <!-- Content Start-->
            <div class="col-12 px-3">
                <div class="row px-2 px-md-5 g-3">
                    <div class="col-12 text-center">
                        <label class="form-lable title2 text-center text-bold">Calculate your monthly usage</label>
                        <p class="text-danger" id="msg1"></p>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-lable">Year</label>
                        <select id="year" class="form-control">
                            <?php
                            $query ="SELECT `name` FROM years ;";
                            $result = $dbms -> query($query);
                            $in = $result->num_rows;
                            for($i=1; $i<=$in; $i++){
                                $data = $result->fetch_assoc();
                                ?><option value="<?php echo $i; ?>"><?php echo $data["name"]; ?></option><?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-lable">Month</label>
                        <select id="month" class="form-control">
                            <?php
                            $query ="SELECT `name` FROM months ;";
                            $result = $dbms -> query($query);
                            $in = $result->num_rows;
                            for($i=1; $i<=$in; $i++){
                                $data = $result->fetch_assoc();
                                ?><option value="<?php echo $i; ?>"><?php echo $data["name"]; ?></option><?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-lable">Usage</label>
                        <input id="usage" class="form-control" type="number" min="0" />
                    </div>

                    <div class="col-12 mt-2">
                        <div class="row justify-content-center">
                            <div class="col-6 offset-3">
                                <button class="btn btn-dark w-50" onclick="BillCalculate();">Calculate Your Bill</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none" id="bill_box">
                        <div class="row" id="bill_preview">
                            <div class="col-12 mt-4">
                                <div class="row justify-content-center">
                                    <table class="table w-75">
                                        <tr class="table-secondary">
                                            <th>Consumption per month (kWh)</th>
                                            <th class="text-end">Energy Charge (LKR/kWh)</th>
                                            <th class="text-center">Consumption of the customer (kWh)</th>
                                            <th>Charge (Rs.)</th>
                                        </tr>
                                        <tr class="table-light">
                                            <td>0-60</td>
                                            <td class="text-end">25.00</td>
                                            <td class="text-center">60</td>
                                            <td class="text-end">1500</td>
                                        </tr>
                                        <tr class="table-light">
                                            <td>61-90</td>
                                            <td class="text-end">30.00</td>
                                            <td class="text-center">30</td>
                                            <td class="text-end">900</td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="3" class="colspan">The monthly charge for 90 units</td>
                                            <td class="text-end">8775.00</td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="3" class="colspan">The monthly charge for 90 units with Fixed
                                                Charge</td>
                                            <td class="text-end">10775.00</td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="3" class="colspan">VAT (18%)</td>
                                            <td class="text-end">1939.50</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td colspan="3" class="colspan">Final Bill</td>
                                            <td class="text-end text-bold">12714.50</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row justify-content-center">
                                <div class="col-6 offset-3">
                                    <button class="btn btn-success w-50" onclick="submitbill();">Submit Your Bill as Final</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="form-lable text-bold">View your bill history</label>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="row justify-content-center">
                            <table class="table w-75">
                                <tr class="table-secondary">
                                    <th class="text-center">Year & Month</th>
                                    <th class="text-center">Consumption of the month (kWh)</th>
                                    <th class="text-end pe-3 pe-md-5">Charge (Rs.)</th>
                                    <th class="text-center">Detail Bill</th>
                                </tr>
                                <tr class="table-light">
                                    <td class="text-center align-middle">2024-06</td>
                                    <td class="text-center align-middle">205</td>
                                    <td class="text-end align-middle pe-3 pe-md-5">1500.00</td>
                                    <td><button class="btn btn-dark w-100" onclick="">Your Bill</button></td>
                                </tr>
                                <tr class="table-light">
                                    <td class="text-center align-middle">2024-07</td>
                                    <td class="text-center align-middle">408</td>
                                    <td class="text-end align-middle pe-3 pe-md-5">2200.00</td>
                                    <td><button class="btn btn-dark w-100" onclick="">Your Bill</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 mt-3 mt-lg-5">
                        <p class="text-center"><a href="https://www.imeshperera.com"
                                class="text-decoration-none text-dark">&copy; 2024 imeshperera.com All Rights
                                Reserved</a></p>
                    </div>
                </div>
                <!-- Content End -->
            </div>
        </div>
        <script src="script.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>
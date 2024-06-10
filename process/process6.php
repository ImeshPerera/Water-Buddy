<?php
    session_start();

    $dbserver = "localhost";
    $dblocation = "root";
    $dbpassword = "Dilshan@1234";
    $dbname = "waterbills";
    
    $dbms = new mysqli($dbserver,$dblocation,$dbpassword,$dbname,"3306");

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

<tr class="table-secondary">
    <th class="text-center">Year & Month</th>
    <th class="text-center">Consumption of the month (kWh)</th>
    <th class="text-end pe-3 pe-md-5">Charge (Rs.)</th>
    <th class="text-center">Detail Bill</th>
</tr>
<?php
    $querya ="SELECT bill.id, years.name AS `yearname`, months.name AS `monthname`, bill.tariff_id, bill_tariff.upfrom, bill_tariff.tilfor, bill.units, bill.total FROM years INNER JOIN months LEFT JOIN bill ON months.id = bill.month_id AND years.id = bill.year_id LEFT JOIN bill_tariff ON bill.tariff_id = bill_tariff.id WHERE bill.customer_id = '".$_SESSION["myuser"]["id"]."' ORDER BY year_id, month_id;";
    $resulta = $dbms -> query($querya);
    $nr = $resulta->num_rows;
    for($j=1; $j<=$nr; $j++){
        $dataa = $resulta->fetch_assoc();
    ?>
    <tr class="table-light">
        <td class="text-start align-middle" id="<?php echo "exdate".$j ;?>"><?php echo $dataa['yearname'].'-'.$dataa['monthname'] ;?></td>
        <input type="hidden" id="<?php echo "extariff".$j ;?>" value="<?php echo $dataa["tariff_id"];?>">
        <td class="text-center align-middle" id="<?php echo "exuse".$j ;?>"><?php echo $dataa["units"];?></td>
        <td class="text-end align-middle pe-3 pe-md-5"><?php echo formatNumber($dataa["total"]);?></td>
        <td><button class="btn btn-dark w-100" onclick="ExBillCalculate(<?php echo $j ;?>);" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Your Bill</button></td>
    </tr>
<?php
}
?>
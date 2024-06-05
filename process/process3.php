<?php

$dbserver = "localhost";
$dblocation = "root";
$dbpassword = "Dilshan@1234";
$dbname = "waterbills";

$dbms = new mysqli($dbserver,$dblocation,$dbpassword,$dbname,"3306");

$query ="SELECT * FROM bill_tariff RIGHT JOIN water_bill_units ON bill_tariff.id = water_bill_units.tariff_id WHERE bill_tariff.upfrom <= '2024-04-01' AND (bill_tariff.tilfor >= '2024-04-01' OR bill_tariff.tilfor IS NULL);";
$resultset = $dbms -> query($query);
$n = $resultset->num_rows;

$ranges = [];
$fixedCharge = 0;
$totalValue = filter_var(trim($_POST["usage"]), FILTER_SANITIZE_STRING);

if(empty($totalValue)){
    $totalValue = 0;
}

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

for ($i = 0; $i < $n; $i++) {
    $data = $resultset->fetch_assoc();
    $ranges[] = [
        'min' => $data['minvalue'], 
        'max' => $data['maxvalue'],  
        'price' => $data['energycharge'],
        'fixed_charge' => $data['fixcharge']
    ];
}

$consumption = $totalValue;
$totalCharge = 0;
$tableRows = [];

foreach ($ranges as $range) {
    if ($consumption > 0) {
        
        // Determine the consumption for the current range
        if (isset($range['max'])) {
            $rangeConsumption = min($consumption, $range['max'] - $range['min'] + 1);
        } else {
            $rangeConsumption = $consumption;
        }

        // Calculateing the current range charge
        $rangeCharge = $rangeConsumption * $range['price'];

        // Adding the current range charge to the total charge
        $totalCharge += $rangeCharge;

        // Determine current range fixed charge to globle variable
        $fixedCharge = $range['fixed_charge'];

        // Add the row data to the table (New Range affected to table)
        $tableRows[] = [
            'range' => (isset($range['max']) ? $range['min'] . '-' . $range['max'] : 'Over ' . $range['min'] - 1),
            'price' => $range['price'],
            'consumption' => $rangeConsumption,
            'charge' => $rangeCharge
        ];

        // Decrease the remaining consumption
        $consumption -= $rangeConsumption;
    }
}
$totalwithfix = $totalCharge + $fixedCharge;
$taxcharge = ($totalwithfix/100)*18;
$monthfinalbill = $totalwithfix + $taxcharge;
?>
<div class="col-12 mt-4">
    <div class="row justify-content-center">
        <table class="table w-75">
            <tr class="table-secondary">
                <th>Consumption per month (kWh)</th>
                <th class="text-end">Energy Charge (LKR/kWh)</th>
                <th class="text-center">Consumption of the customer (kWh)</th>
                <th>Charge (Rs.)</th>
            </tr>
        <?php foreach ($tableRows as $row) { ?>
            <tr class="table-light">
                <td><?php echo $row['range']; ?></td>
                <td class="text-end"><?php echo formatNumber($row['price']); ?></td>
                <td class="text-center"><?php echo $row['consumption']; ?></td>
                <td class="text-end"><?php echo formatNumber($row['charge']); ?></td>
            </tr>
        <?php } ?>
            <tr class="table-light">
                <td colspan="3" class="colspan">The monthly charge for <span id="billuse"><?php echo $totalValue; ?></span> units</td>
                <td class="text-end"><?php echo formatNumber($totalCharge); ?></td>
            </tr>
            <tr class="table-light">
                <td colspan="3" class="colspan">The monthly charge for <?php echo $totalValue; ?> units with Fixed Charge</td>
                <td class="text-end"><?php echo formatNumber($totalwithfix); ?></td>
            </tr>
            <tr class="table-light">
                <td colspan="3" class="colspan">VAT (18%)</td>
                <td class="text-end"><?php echo formatNumber($taxcharge); ?></td>
            </tr>
            <tr class="table-secondary">
                <td colspan="3" class="colspan">Final Bill</td>
                <td id="billfinalvalue" class="text-end text-bold"><?php echo formatNumber($monthfinalbill); ?></td>
            </tr>
        </table>
    </div>
</div>
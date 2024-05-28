<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Statistics</title>
</head>
<body>
<h1 align="center"> Site Statistics </h1>
<?php
$link = new mysqli("localhost", "root", "", "StolenCarsDB");
if($link->connect_error){
    die("Error: " . $link->connect_error);
}

$sql1 = "SELECT COUNT(*) as count FROM StolenCar";
$result1 = $link->query($sql1);
$count1 = $result1->fetch_assoc()['count'];

$sql2 = "SELECT COUNT(*) as count FROM Model";
$result2 = $link->query($sql2);
$count2 = $result2->fetch_assoc()['count'];

$sql3 = "SELECT COUNT(*) as count FROM StolenCar WHERE DATE(CreationDate) > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$result3 = $link->query($sql3);
$count3 = $result3->fetch_assoc()['count'];

$sql4 = "SELECT * FROM StolenCar ORDER BY CreationDate DESC LIMIT 1";
$result4 = $link->query($sql4);
$last_record = $result4->fetch_assoc();

$sql5 = "SELECT Status.ID, Status.StatusName, COUNT(StolenCar.ID) as related_count FROM Status LEFT JOIN StolenCar ON StolenCar.StatusID = Status.ID GROUP BY Status.ID ORDER BY related_count DESC LIMIT 1";
$result5 = $link->query($sql5);
$most_related_record = $result5->fetch_assoc();

echo "Count of records in StolenCar: $count1<br>";
echo "Count of records in Model: $count2<br>";
echo "Count of records for the last month in StolenCars: $count3<br>";
echo "Last record: " . json_encode($last_record) . "<br>";
echo "Record with the biggest number of related records: " . json_encode($most_related_record) . "<br>";

$link->close();
?>
<h4 align="left"><a href="index.php">Back</a></h4></body>
</body>
</html>
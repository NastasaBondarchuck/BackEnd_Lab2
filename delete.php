<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Car</title>
</head>
<body>
<h1 align="center"> Delete Car </h1>

<?php
$id = $_GET['car'];
$link = new mysqli("localhost", "root", "", "StolenCarsDB");
if ($link->connect_error) {
    die("Error: " . $link->connect_error);
}

$sql = "DELETE FROM StolenCar WHERE ID=$id";

if ($link->query($sql) === TRUE) {
    echo "Car deleted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
}
$link->close();
?>
<h4 align="left"><a href="index.php">Back</a></h4></body>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Car</title>
</head>
<body>
<h1 align="center"> Search Car </h1>
<form method="post">
    Key word: <input type="text" name="keyword"><br>
    <input type="submit" value="Search">
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $link = new mysqli("localhost", "root", "", "StolenCarsDB");
    if ($link->connect_error) {
        die("Error: " . $link->connect_error);
    }
    $sql = "select StolenCar.ID, StolenCar.CarNumber, StolenCar.CreationDate, Model.ModelName, Status.StatusName, StolenCar.OwnerSurname 
from StolenCar, Model, Status where StolenCar.ModelID=Model.ID 
and StolenCar.StatusID=Status.ID and StolenCar.CarNumber LIKE '%$keyword%' OR Model.ModelName LIKE '%$keyword%' 
OR StolenCar.OwnerSurname LIKE '%$keyword%' or Status.StatusName LIKE '%$keyword%'";
    $result = $link->query($sql);

    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["ID"]. "<br> - CarNumber: " . $row["CarNumber"]. "<br> - Model: " . $row["ModelName"]. "<br> - Status: " . $row["StatusName"]. "<br> - OwnerSurname: " . $row["OwnerSurname"]. "<br> - CreationDate: " . $row["CreationDate"]. "<br>";
    }

    $link->close();
}
?>
<h4 align="left"><a href="index.php">Back</a></h4></body>
</body>
</html><?php

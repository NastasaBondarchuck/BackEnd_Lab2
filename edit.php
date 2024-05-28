<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"/>
    <title>Edit Car</title>
</head>
<body>
<h1 align="center"> Edit Car </h1>
<div align="center">
    <form class="form" method="post">
        Car number: <input type="text" name="Number"><br>
        Model:
        <select name="Model">
            <?php
            $link = new mysqli("localhost", "root", "", "StolenCarsDB");
            if ($link->connect_error) {
                die("Error: " . $link->connect_error);
            }

            $models = "select ID, ModelName from Model";

            if ($result = $link->query($models)) {
                $rowsCount = $result->num_rows;
                foreach ($result as $row) {
                    echo "<option value=' " . $row['ID'] . " '> " . $row['ModelName'] . "</option>";
                }
            }
            $link->close();
            ?>
        </select><br>
        Status:
        <select name="Status">
            <option value="Stolen">Stolen</option>
            <option value="Found">Found</option>
        </select><br>
        Owner surname: <input type="text" name="OwnerSurname"><br>
        <input type="submit" value="Edit">
    </form>
</div>


<?php
$link = new mysqli("localhost", "root", "", "StolenCarsDB");
if ($link->connect_error) {
    die("Error: " . $link->connect_error);
}
$id = $_GET['car'];
$sql = "select StolenCar.ID, StolenCar.CreationDate, StolenCar.CarNumber, Model.ModelName, Status.StatusName, StolenCar.OwnerSurname from StolenCar, Model, Status where StolenCar.ID=$id and StolenCar.ModelID=Model.ID and StolenCar.StatusID=Status.ID";
if ($result = $link->query($sql)) {
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "
<br><table align='center' border='1 solid black'>
    <tr><th>CarNumber</th> 
        <th>Model</th>
        <th>Status</th>
        <th>OwnerSurname</th>
        <th>CreationDate</th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["CarNumber"] . "</td>";
        echo "<td>" . $row["ModelName"] . "</td>";
        echo "<td>" . $row["StatusName"] . "</td>";
        echo "<td>" . $row["OwnerSurname"] . "</td>";
        echo "<td>" . $row["CreationDate"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else {
    echo "Error: " . $link->error;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = $_POST['Number'];
    $modelID = $_POST['Model'];
    $status = $_POST['Status'];
    $ownerSurname = $_POST['OwnerSurname'];
    $statusID = 1;

    if ($status == 'Stolen') $statusID = 1;
    else if ($status == 'Found') $statusID = 2;

    $sql_2 = "UPDATE StolenCar SET CarNumber='$number', ModelID='$modelID', StatusID='$statusID', OwnerSurname='$ownerSurname' WHERE id='$id'";

    if ($link->query($sql_2) === TRUE) {
        echo "Car updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }


}
$link->close();
?>
<h4 align="left"><a href="index.php">Back</a></h4></body>
</body>
</html>
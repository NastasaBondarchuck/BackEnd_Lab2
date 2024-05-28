<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"/>
    <title>Add Car</title>
</head>
<body>
<h1 align="center"> Add Car </h1>
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
        <input type="submit" value="Add">
    </form>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = $_POST['Number'];
    $modelID = $_POST['Model'];
    $status = $_POST['Status'];
    $ownerSurname = $_POST['OwnerSurname'];
    $statusID = 1;

    if ($status == 'Stolen') $statusID = 1;
    else if ($status == 'Found') $statusID = 2;

    $link = new mysqli("localhost", "root", "", "StolenCarsDB");
    if ($link->connect_error) {
        die("Error: " . $link->connect_error);
    }
    $sql = "INSERT INTO StolenCar (CarNumber, ModelID, StatusID, OwnerSurname) VALUES ('$number', '$modelID', '$statusID', '$ownerSurname')";
    if ($link->query($sql) === TRUE) {
        echo "New car is added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    $link->close();
}
?>
<h4 align="left"><a href="index.php">Back</a></h4></body>
</body>
</html>
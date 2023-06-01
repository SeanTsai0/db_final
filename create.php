<?php
    require_once "connect.php";

    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $engine = $_POST['engine'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $fuel = $_POST['fuel'];
    $gearbox = $_POST['gearbox'];
    $location = $_POST['location'];

    mysqli_begin_transaction($connect, MYSQLI_TRANS_START_READ_WRITE);
    if (mysqli_num_rows((mysqli_query($connect, "SELECT * FROM brand_table WHERE brand_name = '$brand'"))) > 0) {
        // echo "\nexists brand";
    }
    else {
        mysqli_query($connect, "INSERT INTO brand_table (brand_name) VALUES('$brand')");
    }
    if (mysqli_num_rows((mysqli_query($connect, "SELECT * FROM fuel_table WHERE fuel_name = '$fuel'"))) > 0) {
        // echo "\nexists fuel";
    }
    else {
        mysqli_query($connect, "INSERT INTO fuel_table (fuel_name) VALUES('$fuel')");
    }
    if (mysqli_num_rows((mysqli_query($connect, "SELECT * FROM location_table WHERE location_name = '$location'"))) > 0) {
        // echo "\nexists location";
    }
    else {
        mysqli_query($connect, "INSERT INTO location_table (location_name) VALUES('$location')");
    }

    $sql = "INSERT INTO info_table (brand_id, model, price, engine, year, mileage, fuel_id, gearbox_id, location_id)
                 VALUES ((SELECT brand_id FROM brand_table WHERE brand_name = '$brand'), 
                         '$model',
                         '$price',
                         '$engine',
                         '$year',
                         '$mileage',
                         (SELECT fuel_id FROM fuel_table WHERE fuel_name = '$fuel'),
                         '$gearbox',
                         (SELECT location_id FROM location_table WHERE location_name = '$location')
                        )";

    mysqli_query($connect, $sql);
   
    $commit = mysqli_commit($connect);
    if ($commit) 
        $result = "Successful Create!";
    else 
        $result = "Create Fail...";

    $url = "http://localhost:8080/DB_final/index.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="refresh" content="1;url=<?php echo $url; ?>">
    </head>
    <body>
        <center>
            <h1>
                <p><?php echo $result?></p>
            </h1>
        </center>
    </body>
</html>
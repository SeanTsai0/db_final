<?php
    require_once "connect.php";

    $id = $_POST['id'];
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
    if (mysqli_num_rows((mysqli_query($connect, "SELECT * FROM brand_table WHERE brand_name = \"".$_POST['brand']."\""))) > 0) {
        // echo "\nexists brand";
    }
    else {
        mysqli_query($connect, "INSERT INTO brand_table (brand_name) VALUES(\"".$_POST['brand']."\")");
    }
    if (mysqli_num_rows((mysqli_query($connect, "SELECT * FROM fuel_table WHERE fuel_name = \"".$_POST['fuel']."\""))) > 0) {
        // echo "\nexists fuel";
    }
    else {
        mysqli_query($connect, "INSERT INTO fuel_table (fuel_name) VALUES(\"".$_POST['fuel']."\")");
    }
    if (mysqli_num_rows((mysqli_query($connect, "SELECT * FROM location_table WHERE location_name = \"".$_POST['location']."\""))) > 0) {
        // echo "\nexists location";
    }
    else {
        mysqli_query($connect, "INSERT INTO location_table (location_name) VALUES(\"".$_POST['location']."\")");
    }

    $sql = "UPDATE info_table SET brand_id = (SELECT brand_id FROM brand_table WHERE brand_name = '$brand'),
                                     model = '$model',
                                     price = '$price',
                                    engine = '$engine',
                                      year = '$year',
                                   mileage = '$mileage',
                                   fuel_id = (SELECT fuel_id FROM fuel_table WHERE fuel_name = '$fuel'),
                                gearbox_id = (SELECT gearbox_id FROM gearbox_table WHERE gearbox_name = '$gearbox'),
                               location_id = (SELECT location_id FROM location_table WHERE location_name = '$location')
                             WHERE id = '$id'";

    mysqli_query($connect, $sql);
   
    $commit = mysqli_commit($connect);
    if ($commit) 
        $result = "Successful Modified!";
    else 
        $result = "Modified Fail...";

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
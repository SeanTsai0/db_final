<?php
    require_once "connect.php";

    $id = $_POST['id'];

    $sql = "SELECT id,
                brand_table.brand_name AS brand,
                model,
                price,
                engine,
                year,
                mileage,
                fuel_table.fuel_name AS fuel,
                gearbox_table.gearbox_name AS gearbox,
                location_table.location_name AS location
                FROM ((
                    (info_table 
                    INNER JOIN brand_table ON info_table.brand_id = brand_table.brand_id)
                )INNER JOIN fuel_table ON info_table.fuel_id = fuel_table.fuel_id
                )INNER JOIN gearbox_table ON info_table.gearbox_id = gearbox_table.gearbox_id
                INNER JOIN location_table ON info_table.location_id = location_table.location_id
                WHERE info_table.id = '$id'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    
?>
<!DOCTYPE html>
<html>
    <header></header>
    <body>
        <center>
        <form action="execute_update.php" method="post">
            <table border="1" width="400">
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Engine</th>
                    <th>Year</th>
                    <th>Mileage(km)</th>
                    <th>Fuel</th>
                    <th>Gearbox</th>
                    <th>Location</th>
                </tr>
                <tr>
                    <input type="hidden" value="<?php echo $id?>" name="id">
                    <td><input type="text" value="<?php echo $row['brand']?>" name="brand" size="10"></td>
                    <td><input type="text" value="<?php echo $row['model']?>" name="model" size="10"></td>
                    <td><input type="text" value="<?php echo $row['price']?>" name="price" size="10"></td>
                    <td><input type="text" value="<?php echo $row['engine']?>" name="engine" size="10"></td>
                    <td><input type="text" value="<?php echo $row['year']?>" name="year" size="10"></td>
                    <td><input type="text" value="<?php echo $row['mileage']?>" name="mileage" size="10"></td>
                    <td><input type="text" value="<?php echo $row['fuel']?>" name="fuel" size="10"></td>
                    <td><select name="gearbox" id="gearbox">
                    <?php
                        $option = mysqli_query($connect, "SELECT gearbox_name    FROM gearbox_table GROUP BY gearbox_name");
                        while($target = mysqli_fetch_array($option)):
                            if ($target['gearbox_name'] == $row['gearbox']) {
                    ?>
                    <option value="<?php echo $row['gearbox']?>" selected><?php echo $row['gearbox']?></option>
                    <?php
                            } else {
                    ?>
                    <option value="<?php echo $target['gearbox_name']?>"><?php echo $target['gearbox_name']?></option>
                    <?php
                            }
                            endwhile
                    ?>
                </select></td>
                    <td><input type="text" value="<?php echo $row['location']?>" name="location" size="10"></td>
                </tr>
            </table>
            <input type="submit" value="Confirm">
            <button><a href="index.php">Cancel</a></button>
        </form>
        </center>
    </body>
</html>
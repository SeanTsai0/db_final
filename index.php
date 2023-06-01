<?php
    require_once "connect.php";

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
                INNER JOIN location_table ON info_table.location_id = location_table.location_id";

    if (isset($_GET['brand_id']) && $_GET['brand_id'] != null) {
        if (str_contains($sql, "WHERE")) {
            $sql .= " AND brand_id = ".$_GET['brand_id']."";
        } else {
            $sql .= " WHERE info_table.brand_id = ".$_GET['brand_id']."";
        }
    }
    if (isset($_GET['model']) && $_GET['model'] != null) {
        if (str_contains($sql, "WHERE")) {
            $sql .= " AND info_table.model = \"".$_GET['model']."\"";
        } else {
            $sql .= " WHERE info_table.model = \"".$_GET['model']."\"";
        }
    }
    if (isset($_GET['year']) && $_GET['year'] != null) {
        if (str_contains($sql, "WHERE")) {
            $sql .= " AND info_table.year = \"".$_GET['year']."\"";
        } else {
            $sql .= " WHERE info_table.year = \"".$_GET['year']."\"";
        }
    }
    if (isset($_GET['fuel']) && $_GET['fuel'] != null) {
        if (str_contains($sql, "WHERE")) {
            $sql .= " AND info_table.fuel_id = \"".$_GET['fuel']."\"";
        } else {
            $sql .= " WHERE info_table.fuel_id = \"".$_GET['fuel']."\"";
        }
    }
    if (isset($_GET['gearbox']) && $_GET['gearbox'] != null) {
        if (str_contains($sql, "WHERE")) {
            $sql .= " AND info_table.gearbox_id = \"".$_GET['gearbox']."\"";
        } else {
            $sql .= " WHERE info_table.gearbox_id = \"".$_GET['gearbox']."\"";
        }
    }
    if (isset($_GET['location']) && $_GET['location'] != null) {
        if (str_contains($sql, "WHERE")) {
            $sql .= " AND info_table.location_id = \"".$_GET['location']."\"";
        } else {
            $sql .= " WHERE info_table.location_id = \"".$_GET['location']."\"";
        }
    }


    if (isset($_GET['order']) && $_GET['order'] != null) {
        $sql .= " ORDER BY ".$_GET['order']."";
    }
    // echo $sql;

    $result = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <h1 id="title">Second Used Car Website</h1>
        <form action="create.php" method="post">
            <label for="brand">Brand : </label>
            <input type="text" id="brand" name="brand" size="5">
            <label for="model">Model : </label>
            <input type="text" id="model" name="model">
            <label for="price">Price : </label>
            <input type="text" id="price" name="price" size="5">
            <label for="engine">Engine : </label>
            <input type="text" id="engine" name="engine">
            <label for="year">Year : </label>
            <input type="text" id="year" name="year" size="3">
            <label for="mileage">Mileage</label>
            <input type="text" id="mileage" name="mileage" size="5">
            <label for="fuel">Fuel</label>
            <input type="text" id="fuel" name="fuel" size="5">
            <label for="gearbox">Gearbox</label>
            <select name="gearbox" id="gearbox">
                <option value="1">Automatica</option>
                <option value="2">Manual</option>
            </select>
            <label for="location">Location</label>
            <input type="text" id="location" name="location" size="10">
            <input type="submit" name="submit" value="Create Data" id="btn">
        </form>
        <hr class="solid">
        <center>
        <div>
            <form action="<?php $PHP_SELF; ?>" method="get">
                <h4>
                <label>Brand : </label>
                <select name="brand_id"  onchange="window.location='<?php $PHP_SELF?>?brand_id='+this.value">
                    <option value="" selected>-----Select-----</option>
                    <?php
                        $option = mysqli_query($connect, "SELECT * FROM brand_table WHERE brand_id");
                        while($row = mysqli_fetch_array($option)):
                            if (isset($_GET['brand_id']) && $_GET['brand_id'] == $row['brand_id']):
                    ?>
                    <option value="<?php echo $row['brand_id']?>" selected><?php echo $row['brand_name']?></option>
                    <?php else:?>
                    <option value="<?php echo $row['brand_id']?>"><?php echo $row['brand_name']?></option>
                    <?php endif;?>
                    <?php 
                        endwhile;
                    ?>
                </select>
                <label>Model : </label>
                <select name="model">
                    <option value="">---------------Selece--------------</option>
                    <?php
                        if(isset($_GET['brand_id']) && $_GET['brand_id'] != null){
                            $option = mysqli_query($connect, "SELECT model FROM info_table WHERE brand_id = ".$_GET['brand_id']." GROUP BY model");
                        }
                        else {
                            $option = mysqli_query($connect, "SELECT model FROM info_table GROUP BY model");
                        }
                        while($row = mysqli_fetch_array($option)):
                    ?>
                    <option value="<?php echo $row['model']?>"><?php echo $row['model']?></option>
                    <?php endwhile;?>
                </select>               
                <label>Year : </label>
                <select name="year">
                    <option value="">-Select-</option>
                    <?php
                        if(isset($_GET['brand_id']) && $_GET['brand_id'] != null){
                            $option = mysqli_query($connect, "SELECT year FROM info_table WHERE brand_id = ".$_GET['brand_id']." GROUP BY year");
                        }
                        else {
                            $option = mysqli_query($connect, "SELECT year FROM info_table GROUP BY year");
                        }
                        while($row = mysqli_fetch_array($option)):
                    ?>
                    <option value="<?php echo $row['year']?>"><?php echo $row['year']?></option>
                    <?php endwhile?>
                </select>
                <label for="fuel">Fuel : </label>
                <select name="fuel" id="fuel">
                    <option value="">----Select----</option>
                    <?php
                        $option = mysqli_query($connect, "SELECT * FROM fuel_table GROUP BY fuel_name");
                        while($row = mysqli_fetch_array($option)):
                    ?>
                    <option value="<?php echo $row['fuel_id']?>"><?php echo $row['fuel_name']?></option>
                    <?php endwhile?>
                </select>
                <label>Gearbox</label>
                <select name="gearbox" id="gearbox">
                    <option value="">----Selete----</option>
                    <?php
                        $option = mysqli_query($connect, "SELECT * FROM gearbox_table GROUP BY gearbox_name");
                        while($row = mysqli_fetch_array($option)):
                    ?>
                    <option value="<?php echo $row['gearbox_id']?>"><?php echo $row['gearbox_name']?></option>
                    <?php endwhile?>
                </select>
                <label>Location</label>
                <select name="location" id="location">
                    <option value="">----Selete----</option>
                    <?php
                        $option = mysqli_query($connect, "SELECT * FROM location_table GROUP BY location_name");
                        while($row = mysqli_fetch_array($option)):
                    ?>
                    <option value="<?php echo $row['location_id']?>"><?php echo $row['location_name']?></option>
                    <?php endwhile?>
                </select>
                <label for="order">Order by</label>
                <select name="order" >
                    <option value="">----Whatever----</option> 
                    <option value="id">Id</option>
                    <option value="brand">Brand</option>
                    <option value="model">Model</option>
                    <option value="price">Price</option>
                    <option value="engine">Engine</option>
                    <option value="year">Year</option>
                    <option value="mileage">Mileage</option>
                    <option value="fuel">Fuel</option>
                    <option value="gearbox">Gearbox</option>
                    <option value="location">Location</option>
                </select>
                <input type="submit" value="Search">
                </h4>
            </form>
        <div>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price</th>
                <th>Engine</th>
                <th>Year</th>
                <th>Mileage(km)</th>
                <th>Fuel</th>
                <th>Gearbox</th>
                <th>Location</th>
                <th></th>
                <th></th>
            </tr>
            <?php
                if (mysqli_num_rows($result) > 0):
                    foreach($result as $row):
            ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['brand']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td>Є<?php echo $row['price']; ?></td>
                        <td><?php echo $row['engine']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['mileage']; ?></td>
                        <td><?php echo $row['fuel']; ?></td>
                        <td><?php echo $row['gearbox']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <form action="update.php" method="post">
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                            <input type="submit" value="Modify">
                        </td>
                        </form>
                        <form action="delete.php" method="post">
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                            <input type="submit" value="Delete" id='del_btn'>
                        </td>
                        </form>
                    </tr>
            <?php
                    endforeach;
                else:
            ?>
        </table>
                    <p>NULL</p>
            <?php        
                endif;
            ?>
        </center>       
    </body>
</html>
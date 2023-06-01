<?php
    require_once "connect.php";

    $id = $_POST['id'];

    $sql = "DELETE FROM info_table WHERE id = '$id'";
    mysqli_query($connect, $sql);


    $url = "http://localhost:8080/DB_final/index.php";

?>
<!DOCTYPE html>
<html>   
    <head>   
        <meta http-equiv="refresh" content="1;url=<?php echo $url; ?>">   
    </head>   
<body> 
    <center>
        <head>Successful Delete!</head>
    </center>
</body>
</html>
<?php
session_start();
if(isset($_SESSION['products'])){
    unset($_SESSION['products']);
    session_destroy();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Amazon Product listing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form action="product.php" method="post" enctype="multipart/form-data" >
            <div class="form-group">
                <label>Chooe file :</label>
                <input type="file" name="product">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
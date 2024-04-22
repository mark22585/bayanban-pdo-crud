<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "../db/config.php";
    $sql = "SELECT * FROM products WHERE product_id = :id"; 
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":id", $param_id);
        $param_id = trim($_GET["id"]);
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
              
                $name = $row["product_name"]; 
                $description = $row["product_description"]; 
                $price = $row["product_retail_price"]; 
            } else{
                header("location: public/error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    unset($stmt);
    
    unset($pdo);
} else{ 
    header("location: public/error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $name; ?></b></p> 
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p><b><?php echo $description; ?></b></p> 
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <p><b><?php echo $price; ?></b></p> 
                    </div>
                    <p><a href="../index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

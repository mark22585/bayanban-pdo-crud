<?php
// Include config file
require_once "../db/config.php";
 
// Define variables and initialize with empty values
$id = $link = $name = $description = $price = $added = $updated = "";
$id_err = $link_err = $name_err = $description_err = $price_err = $added_err = $updated_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["product_id"]) && !empty($_POST["product_id"])){
    // Get hidden input value
    $id = $_POST["product_id"];
    // Validate product ID
$input_id = trim($_POST["product_id"]);
if(empty($input_id)){
    $id_err = "Please enter a product ID.";
} elseif(!ctype_digit($input_id)){
    $id_err = "Product ID must be a positive integer value.";
} else{
    $id = $input_id;
}

// Validate product link
$input_link = trim($_POST["product_link"]);
if(empty($input_link)){
    $link_err = "Please enter a product link.";
} elseif(!filter_var($input_link, FILTER_VALIDATE_URL)){
    $link_err = "Please enter a valid URL for the product link.";
} else{
    $link = $input_link;
}
    // Validate name
    $input_name = trim($_POST["product_name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate product details
    $input_description = trim($_POST["product_description"]);
    if(empty($input_description)){
        $description_err = "Please enter product details.";     
    } else{
        $details = $input_description;
    }
    
    // Validate product retail price
    $input_price = trim($_POST["product_retail_price"]);
    if(empty($input_price)){
        $price_err = "Please enter the retail price amount.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "Please enter a positive integer value.";
    } else{
        $price = $input_price;
    }

    // Validate date added
$input_added = trim($_POST["product_date_added"]);
if(empty($input_added)){
    $added_err = "Please enter the date the product was added.";
} else {
    // Assuming the date format is YYYY-MM-DD, you can further validate it if needed
    $added = $input_added;
}

// Validate update date
$input_updated = trim($_POST["product_updated_date"]);
if(empty($input_updated)){
    $updated_err = "Please enter the update date for the product.";
} else {
    // Assuming the date format is YYYY-MM-DD, you can further validate it if needed
    $updated = $input_updated;
}
    
    // Check input errors before inserting in database
    if (empty($id_err) && empty($link_err) && empty($name_err) && empty($description_err) && empty($price_err) && empty($added_err) && empty($updated_err)) {
        // Prepare an update statement
        $sql = "UPDATE products SET product_id=:product_id, product_thumbnail_link=:product_thumbnail_link, product_name=:product_name, product_description=:product_description, product_retail_price=:product_retail_price, product_date_added=:product_date_added, product_updated_date=:product_updated_date WHERE product_id=:product_id";
        
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":link", $link);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":description", $description);
                $stmt->bindParam(":price", $price);
                $stmt->bindParam(":added", $added);
                $stmt->bindParam(":updated", $updated);

                $param_product_id = $id;
                $param_product_thumbnail_link = $link;
                $param_product_name = $name;
                $param_product_description = $description;
                $param_product_retail_price = $price;
                $param_product_date_added = $added;
                $param_pproduct_updated_date = $date;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["product_id"]) && !empty(trim($_GET["product_id"]))){
        // Get URL parameter
        $product_id =  trim($_GET["product_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM products WHERE product_id = :product_id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":product_id", $param_product_id);
            
            // Set parameters
            $param_product_id = $product_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $id = $row["product_id"];
                    $link = $row["product_thumbnail_link"];
                    $name = $row["product_name"];
                    $description = $row["product_description"];
                    $price = $row["product_retail_price"];
                    $added = $row["product_date_added"];
                    $updated = $row["product_updated_date"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: ../public/error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../public/error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add a product record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" name="id" class="form-control <?php echo (!empty($id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id; ?>">
                            <span class="invalid-feedback"><?php echo $id_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" class="form-control <?php echo (!empty($link_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $link; ?>">
                            <span class="invalid-feedback"><?php echo $link_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Added</label>
                            <input type="date" name="added" class="form-control <?php echo (!empty($added_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $added; ?>">
                            <span class="invalid-feedback"><?php echo $added_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Updated Date</label>
                            <input type="date" name="updated" class="form-control <?php echo (!empty($updated_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $updated; ?>">
                            <span class="invalid-feedback"><?php echo $updated_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
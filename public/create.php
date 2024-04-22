<?php
require_once "../db/config.php";
$id = $link = $name = $description = $price = $added = $updated = "";
$id_err = $link_err = $name_err = $description_err = $price_err = $added_err = $updated_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        
        $input_id = trim($_POST["id"]);
        if (empty($input_id)) {
            $id_err = "Please enter the id";
        } elseif (!ctype_digit($input_id)) {
            $id_err = "Please enter a positive integer value.";
        } else {
            $id = $input_id;
        }
    } else {
        $id_err = "ID is required";
    }

    if (isset($_POST["link"])) {
        $input_link = trim($_POST["link"]);
        if (empty($input_link)) {
            $link_err = "Please enter a link.";
        } elseif (!filter_var($input_link, FILTER_VALIDATE_URL)) {
            $link_err = "Please enter a valid URL.";
        } else {
            $link = $input_link;
        }
    } else {
        $link_err = "Link is required";
    }

    if (isset($_POST["name"])) {
        $input_name = trim($_POST["name"]);
        if (empty($input_name)) {
            $name_err = "Please enter a name.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $input_name)) {
            $name_err = "Please enter a valid name.";
        } else {
            $name = $input_name;
        }
    } else {
        $name_err = "Name is required";
    }

    if (isset($_POST["description"])) {
        $input_description = trim($_POST["description"]);
        if (empty($input_description)) {
            $description_err = "Please enter a description.";
        } else {
            $description = $input_description;
        }
    } else {
        $description_err = "Description is required";
    }

    if (isset($_POST["price"])) {
        $input_price = trim($_POST["price"]);
        if (empty($input_price)) {
            $price_err = "Please enter a price.";
        } elseif (!preg_match("/^\d+(\.\d+)?$/", $input_price)) {
            $price_err = "Please enter a valid price.";
        } else {
            $price = $input_price;
        }
    } else {
        $price_err = "Price is required";
    }

    if (isset($_POST["added"])) {
        $input_added = trim($_POST["added"]);
        if (empty($input_added)) {
            $added_err = "Please enter a date-added.";
        } else {
            $added = $input_added;
        }
    } else {
        $added_err = "Date added is required";
    }

    if (isset($_POST["updated"])) {
        $input_updated = trim($_POST["updated"]);
        if (empty($input_updated)) {
            $updated_err = "Please enter an updated date.";
        } else {
            $updated = $input_updated;
        }
    } else {
        $updated_err = "Updated date is required";
    }

    if (empty($id_err) && empty($link_err) && empty($name_err) && empty($description_err) && empty($price_err) && empty($added_err) && empty($updated_err)) {
        $sql = "INSERT INTO products (product_id, product_thumbnail_link, product_name, product_description, product_retail_price, product_date_added, product_updated_date) VALUES (:id, :link, :name, :description, :price, :added, :updated)";

        echo "SQL Query: $sql<br>";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":link", $link);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":added", $added);
            $stmt->bindParam(":updated", $updated);

            if ($stmt->execute()) {
                header("location: ../index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                print_r($stmt->errorInfo());
            }
        } else {
            echo "Failed to prepare the SQL statement.";
        }

        unset($stmt);
    }

    unset($pdo);
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

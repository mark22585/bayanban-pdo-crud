<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Products Details</h2>
                        <a href="public/create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New products</a>
                    </div>
                    <?php
                    require_once "db/config.php";
                    
                    $sql = "SELECT * FROM products";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>id</th>";
                                        echo "<th>Link</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Price</th>";
                                        echo "<th>Date added</th>";
                                        echo "<th>updated Date</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['product_id'] . "</td>";
                                        echo "<td>" . $row['product_thumbnail_link'] . "</td>";
                                        echo "<td>" . $row['product_name'] . "</td>";
                                        echo "<td>" . $row['product_description'] . "</td>";
                                        echo "<td>" . $row['product_retail_price'] . "</td>";
                                        echo "<td>" . $row['product_date_added'] . "</td>";
                                        echo "<td>" . $row['product_updated_date'] . "</td>";
                                        echo "<td>";
                                        echo '<a href="public/read.php?id='. $row['product_id'] .'" class="mr-3" title="View Record"><span class="fa fa-eye"></span></a>';
                                        echo '<a href="public/update.php?product_id='. $row['product_id'] .'" class="mr-3" title="Update Record"><span class="fa fa-pencil"></span></a>';
                                        echo '<a href="public/delete.php?product_id=' . $row['product_id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';                                       
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
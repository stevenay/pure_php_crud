<?php require_once 'database.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Customers</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <h3>PHP CRUD Grid</h3>
        </div>

        <div class="row">
            <p>
                <a href="create.php" class="btn btn-success">Create</a>
            </p>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Mobile Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $pdo  = Database::connect();
                        $sql  = 'Select * From customers ';
                        $sql .= 'Order By id Desc';
                        foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['mobile'] . '</td>';
                            echo '<td width="250">';
                            echo '<a class="btn btn-info" href="read.php?id=' . $row['id'] . '">Read</a>';
                            echo '&nbsp;';
                            echo '<a class="btn btn-success" href="update.php?id=' . $row['id'] . '">Update</a>';
                            echo '&nbsp;';
                            echo '<a class="btn btn-danger" href="delete.php?id=' . $row['id'] . '">Delete</a>';
                            echo '&nbsp;';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php Database::disconnect(); ?>
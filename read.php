<?php
require_once 'database.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ($id == null) {
    header('Location: index.php');
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "Select * From customers where id = ? limit 1";
    $q   = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <title>Read Customer</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>Read a Customer</h3>

            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <label>
                        <?php echo $data['name']; ?>
                    </label>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <label>
                        <?php echo $data['email']; ?>
                    </label>
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile No:</label>
                    <label>
                        <?php echo $data['mobile']; ?>
                    </label>
                </div>
                
                <div class="form-group">
                    <a href="index.php" class="btn">Back</a>
                </div>
            </div>
        </div>
    </div>

    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</div>
</body>
</html>

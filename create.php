<?php
require_once 'database.php';

if (!empty($_POST)) {
    // keep track validation errors
    $nameError = null;
    $emailError = null;
    $mobileError = null;

    // keep track post values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // validate input
    $valid = true;
    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }

    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO customers (name, email, mobile) Values(?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $email, $mobile));
        Database::disconnect();
        header("Location: index.php");
    }
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
    <title>Create new Customer</title>
</head>
<body>
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <h3>Create a Customer</h3>
        </div>

        <form method="post" action="create.php" class="form-horizontal">
            <div class="form-group <?php echo !empty($nameError) ? 'has-error' : ''; ?>">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Name"
                       class="form-control"
                       value="<?php echo !empty($name) ? $name : ''; ?>">
                <?php
                if (!empty($nameError)):
                    echo "<span class='help-block'>$nameError</span>";
                endif
                ?>
            </div>

            <div class="form-group <?php echo !empty($emailError) ? 'has-error' : ''; ?>">
                <label for="email">Email Address</label>
                <input type="text" name="email" placeholder="Email"
                       class="form-control"
                       value="<?php echo !empty($email) ? $email : ''; ?>">
                <?php
                if (!empty($emailError)):
                    echo "<span class='help-block'>$emailError</span>";
                endif
                ?>
            </div>

            <div class="form-group <?php echo !empty($mobileError) ? 'has-error' : ''; ?>">
                <label for="mobile">Mobile Number</label>
                <input type="text" name="mobile" placeholder="Mobile Number"
                       class="form-control"
                       value="<?php echo !empty($mobile) ? $mobile : ''; ?>">
                <?php
                if (!empty($mobileError)):
                    echo "<span class='help-block'>$mobileError</span>";
                endif
                ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn btn-default" href="index.php">Back</a>
            </div>
        </form>
    </div>
</div>

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
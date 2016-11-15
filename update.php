<?php
require_once 'database.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ($id == null) {
    header("Location: index.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $nameError   = null;
    $emailError  = null;
    $mobileError = null;

    // keep track post values
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];

    // validate input
    $valid = true;
    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid     = false;
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid      = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Please enter a valid email address';
        $valid      = false;
    }

    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number';
        $valid       = false;
    }

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "Update customers set name = ?, email = ?, mobile = ? Where id = ?";
        $q   = $pdo->prepare($sql);
        $q->execute(array($name, $email, $mobile, $id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "Select * From customers Where id = ?";
    $q   = $pdo->prepare($sql);
    $q->execute([$id]);
    $data = $q->fetch(PDO::FETCH_ASSOC);

    $name   = $data['name'];
    $email  = $data['email'];
    $mobile = $data['mobile'];
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
    <title>Update Customer</title>
</head>
<body>
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <h3>Update a Customer</h3>

        <form method="post" class="form-horizontal" action="update.php?id=<?php echo $id; ?>">
            <div class="form-group <?php echo !empty($nameError) ? 'has-error' : ''; ?>">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Name"
                       class="form-control"
                       value="<?php echo !empty($name) ? $name : '';  ?>">
                <?php if (!empty($nameError)): ?>
                    <span class="help-block"><?php echo $nameError; ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group <?php echo !empty($emailError) ? 'has-error' : ''; ?>">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Email"
                       class="form-control"
                       value="<?php echo !empty($email) ? $email : '';  ?>">
                <?php if (!empty($emailError)): ?>
                    <span class="help-block"><?php echo $emailError; ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group <?php echo !empty($mobileError) ? 'has-error' : ''; ?>">
                <label for="mobile">Mobile</label>
                <input type="text" name="mobile"  placeholder="Mobile"
                       class="form-control"
                       value="<?php echo !empty($mobile) ? $mobile : '';  ?>">
                <?php if (!empty($mobileError)): ?>
                    <span class="help-block"><?php echo $mobileError; ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="index.php" class="btn btn-default">Back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
include 'database.php';
$errorsArray = array();

if (isset($_POST['login_btn'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = md5($_POST['password']);
    if (!$email) {
        array_push($errorsArray, "Email format is not valid");
    } else if ($email) {
        $query = "SELECT email FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row == 0) {
            array_push($errorsArray, "Email is not valid");
        } else if ($row == 1) {
            $query = "SELECT email FROM users WHERE email = :email AND password = :password";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->execute();
            $row = $stmt->rowCount();
            if ($row == 0) {
                array_push($errorsArray, "password incorrect");
            } else if ($row == 1) {
                array_push($errorsArray, "welcome to your account");
                header('Location:admin.php');
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <H2>Login </H2>
    <?php if (!empty($errorsArray)) {
        foreach ($errorsArray as $error) {
            echo "<h4> $error </h4>";
        }
    } ?>
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">First name : </label>
            <input type="email" class="form-control" name='email' id="exampleInputEmail1" aria-describedby="emailHelp">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Last name :</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary" name="login_btn">Submit</button>
            Not Registered ? <a href="register.php" class="btn btn-primary">Register now!</a>
    </form>
</body>

</html>
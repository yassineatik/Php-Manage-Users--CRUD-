<?php
require 'database.php';

$errorsArray = array();

if (isset($_POST['register_btn'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = md5($_POST['password']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $query = "SELECT email from users WHERE email = '$email' ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->rowCount();
    if ($row == 1) {
        array_push($errorsArray, "Email Already Exists");
    } elseif ($row == 0) {
        $query = "INSERT INTO users (nom,prenom,email,password) VALUES (:nom,:prenom,:email,:password) ";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        array_push($errorsArray, "Account Registered Successfully");
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
    <H2>Register</H2>
    <?php if (!empty($errorsArray)) {
        foreach ($errorsArray as $error) {
            echo "<h4> $error </h4>";
        }
    } ?>
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">First name : </label>
            <input type="text" class="form-control" name='prenom' id="exampleInputEmail1" aria-describedby="emailHelp">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Last name :</label>
                <input type="text" class="form-control" name="nom" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Email : </label>
                <input type="email" class="form-control" name="email" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password : </label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary" name="register_btn">Submit</button>
            Already registered ? <a href="login.php" class="btn btn-primary">Login now !</a> <br>
    </form>
</body>

</html>
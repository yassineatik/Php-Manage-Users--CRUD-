<?php

include 'database.php';
include 'header.php';

?>



<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
        $oldFirstName = $data->prenom;
        $oldLastName = $data->nom;
        $oldEmail = $data->email;
        $oldPassword = $data->password;
    }
}
if ($_GET['update'] == 'infos') {
    $errorsArray = array();

    if (isset($_POST['change'])) {
        $changes = array();
        $newFirstName = $_POST['prenom'];
        $newLastName = $_POST['nom'];
        $newEmail = $_POST['email'];
        if ($newFirstName !== $oldFirstName) {
            $changes['prenom'] = $newFirstName;
        }

        if ($newLastName !== $oldLastName) {
            $changes['nom'] = $newLastName;
        }
        if ($newEmail !== $oldEmail) {
            $changes['email'] = $newEmail;
        }
        if (count($changes) > 0) {
            $query = "UPDATE users SET ";
            // var_dump($changes);
            $i = 0;
            $count = count($changes);
            foreach ($changes as $key => $value) {
                $i++;
                if ($i == $count) {
                    $query = $query . "$key = '$value' ";
                } else {
                    $query = $query . "$key = '$value' , ";
                }
            }
            $query = $query . "WHERE id = $id";
            $conn->exec($query);
            array_push($errorsArray, "Changes have been saved successfully :) ");
        } else {
            array_push($errorsArray, "You have not made any changes ");
        }
    }

?>

    <head>
        <link rel="stylesheet" href="includes/style.css">
    </head>

    <body>

        <H2>Editing infos of user id : <?php echo $id ?></H2>
        <H5>NOTE : SET ONLY THE FIELDS YOU WANT TO UPDATE</H5>
        <div class="message">
            <?php if (!empty($errorsArray)) {
                foreach ($errorsArray as $error) {
                    echo "<h4> $error </h4>";
                }
            } ?>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">New first name : </label>
                <input type="text" class="form-control" name='prenom' id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= $oldFirstName ?>">
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">New last name :</label>
                    <input type="text" class="form-control" name="nom" id="exampleInputPassword1" value="<?= $oldLastName ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">New email : </label>
                    <input type="email" class="form-control" name="email" id="exampleInputPassword1" value="<?= $oldEmail ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="change">Submit</button>
        </form>
    </body>

<?php
} else if ($_GET['update'] == 'password') {
    $errorsArray = array();
    if (isset($_POST['changePassword'])) {
        $currentPassword = md5($_POST['currentPassword']);
        $newPassword = md5($_POST['newPassword']);
        if ($currentPassword !== $oldPassword) {
            array_push($errorsArray, "Current password is incorrect");
        }
        if ($newPassword == $oldPassword) {
            array_push($errorsArray, "You can't use the same password");
        } else if ($currentPassword == $oldPassword && $newPassword !== $oldPassword) {
            $query = "UPDATE users SET password = '$newPassword' WHERE id = $id";
            $conn->exec($query);
            array_push($errorsArray, "Password has been changed successfully :)");
        }
    }
?>

    <body>

        <H2>Editing password of user id : <?php echo $id; ?></H2>

        <?php if (!empty($errorsArray)) {
            foreach ($errorsArray as $error) {
                echo "<h4> $error </h4>";
            }
        } ?>
        <div id="form">

            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Current Password : </label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="currentPassword" required>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">New Password : </label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="newPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="changePassword">Change Password</button>
            </form>

        </div>
    </body>


<?php


}

?>
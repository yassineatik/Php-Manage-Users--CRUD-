<head>
    <link rel="stylesheet" href="includes/admin_style.css">
</head>

<?php

include 'database.php';

$query = "SELECT * FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
$text = "<table> <tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th></tr>";
foreach ($users as $user) {
    $text = $text . "<tr><td>$user->nom</td><td> $user->prenom </td><td> $user->email </td><td><a class='btn btn-primary' href='delete.php?id=$user->id' > Delete user </a> <a class='btn btn-primary' href = 'updateForm.php?id=$user->id&update=infos'>Update user infos</a> <a class='btn btn-primary' href = 'updateForm.php?id=$user->id&update=password'>Update user's password</a></td></tr>";
}
$text = $text . "<table>";
echo $text;
echo "<a class='btn btn-primary' href='register.php'>Add user </a>";

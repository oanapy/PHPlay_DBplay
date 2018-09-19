<!-- To get started run the following SQL commands:

CREATE DATABASE misc;
GRANT ALL ON misc.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';

USE misc; (Or select misc in phpMyAdmin)

CREATE TABLE users (
   user_id INTEGER NOT NULL
     AUTO_INCREMENT KEY,
   name VARCHAR(128),
   email VARCHAR(128),
   password VARCHAR(128),
   INDEX(email)
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO users (name,email,password) VALUES ('Chuck','csev@umich.edu','123');
INSERT INTO users (name,email,password) VALUES ('Glenn','gg@umich.edu','456'); -->

<?php
error_reporting(E_ALL);

echo "<pre>\n";
require_once "pdo.php";

if (isset($_POST['name']) && isset($_POST['email'])
     && isset($_POST['password'])) {
    $sql = "INSERT INTO users (name, email, password) 
              VALUES (:name, :email, :password)";
    echo("<pre>\n".$sql."\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password']));
}
if (isset($_POST['delete']) && isset($_POST['user_id'])) {
    $sql = "DELETE FROM users WHERE user_id = :zip";
    echo "<pre>\n$sql\n</pre>\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['user_id']));
}
?>
<html>
<head></head>
<body>
    <table border = "1">
        <?php
        $stmt = $pdo -> query("SELECT user_id, name, email, password FROM users");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>"; //aseaza frumos datele intr-un tabel ca output
            echo($row['name']);
            echo("</td><td>");
            echo($row['email']);
            echo("</td><td>");
            echo($row['password']);
            echo("</td><td>");
            echo('<form method = "post"><input type = "hidden"');
            echo('name = "user_id" value=" '.$row['user_id'].'">'."\n");
            echo('<input type = "submit" value = "Delete" name = "delete">');
            echo("\n</form>\n");
            echo("</td></tr>\n");
        }
        ?>
    </table>
    <p>Add A New User</p>
     <form method="post">
        <p>Name:
            <input type="text" name="name" size="40">
        </p>
        <p>Email:
            <input type="text" name="email">
        </p>
        <p>Password:
            <input type="password" name="password">
        </p>
        <p>
            <input type="submit" value="Add New"/>
        </p>
    </form>
</body>

<?php
 require_once "pdo.php";

var_dump(isset($_POST));
if (isset($_POST['email']) && isset($_POST['password'])) {
    $sql = "SELECT name FROM users WHERE email = :em AND password = :pw";

    echo "<p>$sql</p>\n";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $_POST['email'],
        ':pw' => $_POST['password']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($row);
    if ($row === false) {
        echo "<h1>Login incorrect.</h1>\n";
    } else {
        echo "<p>Login success.</p>\n";
    }
}
?>
<p>Please Login</p>
<form method="post">
    <p>Email:
        <input type="text" size="40" name="email">
    </p>
    <p>Password:
        <input type="text" size="40" name="password">
    </p>
    <p><input type="submit" value="Login"/>
        <a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a>
    </p>
</form>

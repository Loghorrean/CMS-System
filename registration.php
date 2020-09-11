<?php
require_once("includes/db.php");
require_once("includes/header.php");
if (isset($_POST["submitReg"])) {
    if (!checkPassword($_POST["password"])) {
        header("Location: registration.php");
        exit();
    }
    $query = $pdo->prepare("SELECT * from users where username = :name");
    $query->bindParam(":name", $_POST["username"]);
    $query->execute();
    $checkuser = $query->fetch(PDO::FETCH_LAZY);
    if ($checkuser) {
        $_SESSION["error"] = "Username already taken, try another!";
        header("Location: registration.php");
        exit();
    }
}
?>
    <!-- Navigation -->
    <?php
    require_once("includes/navigation.php");
    ?>
    <!-- Page Content -->
    <div class="container">
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <?php
                            showSuccess();
                            showError();
                            ?>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                </div>
                                <input onclick="return doRegisterValidate();" type="submit" name="submitReg" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                            <p></p>
                            <a href="./"><button class = "btn btn-custom btn-lg btn-block">Already have an account? - Sign In!</button></a>
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <hr>
<?php
require_once("includes/footer.php");
?>

<?php
$categories = $pdo->prepare("SELECT * from category");
$categories->execute();
$showAdminButton = false;
$showEditButton = false;
if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "admin") {
    $showAdminButton = true;
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    while($cat = $categories->fetch(PDO::FETCH_LAZY)) {
                        echo "<li><a href = 'categories.php?cat={$cat["cat_id"]}'>{$cat["cat_title"]}</a></li>";
                    }
                    ?>
                    <?php
                    if ($showAdminButton) {
                        echo '<li><a href="admin" style = "font-weight: bold;">Admin</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
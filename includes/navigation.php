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
                    $stmt = $pdo->prepare("SELECT * from category");
                    $stmt->execute();
                    while($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                        echo "<li><a href = 'categories.php?cat={$row["cat_id"]}'>{$row["cat_title"]}</a></li>";
                    }
                    ?>
                    <?php
                    if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "admin") {
                        echo '<li><a href="admin" style = "font-weight: bold;">Admin</a></li>';
                    }
                    ?>
                    <?php
                    if (isset($_SESSION["user_id"]) && isset($_GET["p_id"])) {
                        $stmt = $pdo->prepare("SELECT post_author from posts where post_id = :id");
                        $stmt->bindParam(":id", $_GET["p_id"]);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_LAZY);
                        if ($_SESSION["name"] == $row["post_author"] || $_SESSION["user_role"] == "admin") {
                            echo '<li><a href="admin/posts.php?source=edit_post&p_id=' . $_GET["p_id"] . '">Edit Post</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
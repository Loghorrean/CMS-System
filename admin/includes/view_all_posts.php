<form action="" method = "POST">
<table class = "table table-bordered table-hover">
    <div id = "bulkOptionsContainer" class = "col-xs-4">
        <select class = "form-control" name="bulkOptions" id="">
            <option value="none" disabled>Select Option</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
        </select>
    </div>
    <div class = "col-xs-4">
        <input type="submit" name="submitBulk" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"</th>
            <th>Post ID</th>
            <th>Category Title</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date</th>
            <th>Image</th>
            <th>Content</th>
            <th>Tags</th>
            <th>Comment Count</th>
            <th>Status</th>
            <th>Delete field</th>
            <th>Edit field</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $select_all->fetch(PDO::FETCH_LAZY)) {
            $cat_title = $row["cat_title"] ?? "Non existent";
            ?>
            <tr>
                <td><input class="checkBoxes" type="checkbox" name = "checkBoxArray[]" value = <?=$row["post_id"]?>></td>
                <td><?=htmlspecialchars($row["post_id"])?></td>
                <td><?=htmlspecialchars($cat_title)?></td>
                <td><?=htmlspecialchars($row["post_title"])?></td>
                <td><?=htmlspecialchars($row["post_author"])?></td>
                <td><?=htmlspecialchars($row["post_date"])?></td>
                <td><img width = "150" src="../images/<?=$row["post_image"]?>" alt = "Image"></td>
                <td><?=htmlspecialchars($row["post_content"])?></td>
                <td><?=$row["post_tags"]?></td>
                <td><?=$row["post_comment_count"]?></td>
                <td><?=$row["post_status"]?></td>
                <td><a href="posts.php?delete=<?=$row["post_id"]?>">Delete</a></td>
                <td><a href="posts.php?source=edit_post&p_id=<?=$row["post_id"]?>">Edit</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
    <?php
    if (isset($_GET["delete"])) {
        showDeletePostForm($_GET["delete"], $pdo);
    }
    ?>
<table class = "table table-bordered table-hover">
    <thead>
    <tr>
        <th>Comment ID</th>
        <th>Post ID</th>
        <th>Email</th>
        <th>Author</th>
        <th>Content</th>
        <th>In Response To</th>
        <th>Status</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete field</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = $select_all->fetch(PDO::FETCH_LAZY)) {
        ?>
        <tr>
            <td><?=htmlspecialchars($row["comment_id"])?></td>
            <td><?=htmlspecialchars($row["comment_post_id"])?></td>
            <td><?=htmlspecialchars($row["comment_email"])?></td>
            <td><?=htmlspecialchars($row["comment_author"])?></td>
            <td><?=htmlspecialchars($row["comment_content"])?></td>
            <td><a href="../post.php?p_id=<?=$row["comment_post_id"]?>"><?=htmlspecialchars($row["post_title"])?></a></td>
            <td><?=htmlspecialchars($row["comment_status"])?></td>
            <td><?=htmlspecialchars($row["comment_date"])?></td>
            <td><a href="comments.php?approve=<?=$row["comment_id"]?>">Approve</a></td>
            <td><a href="comments.php?unapprove=<?=$row["comment_id"]?>">Unapprove</a></td>
            <td><a href="comments.php?delete=<?=$row["comment_id"]?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
if (isset($_GET["unapprove"])) {
    showUnapproveForm($_GET["unapprove"], $pdo);
}
if (isset($_GET["approve"])) {
    showApproveForm($_GET["approve"], $pdo);
}
if (isset($_GET["delete"])) {
    showDeleteCommentForm($_GET["delete"], $pdo);
}
?>
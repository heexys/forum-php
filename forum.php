<?php 
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'add_topic' && isset($_SESSION['user_id']) ) {
    $userId = $_SESSION['user_id'];
    $dateCreate = time();

    $result = mysqli_query($connect, "
        INSERT INTO f_topic (name, countMessages, userId, dateCreate)
        VALUES ('{$_REQUEST['topic']}', '1', '$userId', '$dateCreate')
    ");

    $topicId = $connect->insert_id;

    $result = mysqli_query($connect, "
        INSERT INTO f_post (topicId, userId, message, dateCreate)
            VALUES('{$topicId}', '{$_SESSION['user_id']}', '{$_REQUEST['message']}', '$dateCreate')
    ");

    die(header('location: /pt/?page=topic&topicId='.$topicId));
} else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add_topic' && empty($_SESSION['user_id'])) {
    die(header('location: /pt/?page=auth'));
}

$topicList = [];
$res = $connect->prepare("
    SELECT t.*, 
           u.login AS authorName,
           ru.login AS replyName
    FROM f_topic t
    LEFT JOIN f_user u ON t.userId = u.id
    LEFT JOIN f_user ru ON t.replyUserId = ru.id
");
$res->execute();
$result = $res->get_result();
$topicList = $result->fetch_all(MYSQLI_ASSOC);


include PATH.'/header.php';
?>

<h1>Forum - Topics</h1>

<table>
    <thead>
        <tr>
            <th>Topic Name</th>
            <th>Count. messages</th>
            <th>Author</th>
            <th>Date Created</th>
            <th>Last. reply</th>
            <th>Reply date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($topicList as $topic):?>
            <tr>
                <td><a href="/pt/?page=topic&topicId=<?=$topic['id']?>"><?=$topic['name']?></a></td>
                <td><?=$topic['countMessages']?></td>
                <td><?=$topic['authorName']?></td>
                <td><?=date('d-m-Y H:i:s', $topic['dateCreate'])?></td>
                <td><?=$topic['replyName']?></td>
                <td><?=$topic['dateReply'] ? date('d-m-Y H:i:s', $topic['dateReply']) : '-'?></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>

<?php if(isset($_SESSION['user_id'])): ?>
    <table class="reply_form">
        <thead>
        <tr>
            <th>Create New Topic</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <form class="message_form" action="/pt/?action=add_topic" method="post">
                    <input type="text" name="topic" placeholder="Topic name">
                    <textarea name="message" placeholder="Write message"></textarea>
                    <input type="submit" name="create" value="Create">
                </form>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif ?>

<?php include PATH.'/footer.php' ?>
<?php
    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'add_post' && isset($_SESSION['user_id'])) {
        $dateCreate = time();
        $result = mysqli_query($connect, "
            INSERT INTO f_post (topicId, userId, message, dateCreate)
                VALUES('{$_REQUEST['topicId']}', '{$_SESSION['user_id']}', '{$_REQUEST['message']}', '$dateCreate')
        ");

        $result = mysqli_query($connect, "
            UPDATE f_topic
                SET dateReply = '".time()."',
                    replyUserId = '{$_SESSION['user_id']}'
                WHERE id = '{$_REQUEST['topicId']}';
        ");

        $updateCount = $connect->prepare("
        UPDATE f_topic 
        SET countMessages = (
            SELECT COUNT(*) FROM f_post WHERE topicId = ?
        ), 
        dateReply = (SELECT MAX(dateCreate) FROM f_post WHERE topicId = ?),
        replyUserId = (SELECT userId FROM f_post WHERE topicId = ? ORDER BY dateCreate DESC LIMIT 1)
        WHERE id = ?
        ");

        $topicId = (int)$_REQUEST['topicId'];
        $updateCount->bind_param("iiii", $topicId, $topicId, $topicId, $topicId);
        $updateCount->execute();


        die(header('location: /pt/?page=topic&topicId='.$_REQUEST['topicId']));
    }

    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit_post' && isset($_SESSION['user_id'])) {
        if($_REQUEST['editSave']) {
            $result = mysqli_query($connect, "
                UPDATE f_post
                    SET message = '{$_REQUEST['message']}'
                WHERE id = '{$_REQUEST['postId']}';
            ");
        }
       
        die(header('location: /pt/?page=topic&topicId='.$_REQUEST['topicId']));
    }

    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete_post' && isset($_SESSION['user_id'])) {
        $postId = (int)$_REQUEST['postId'];
    
        $res = $connect->prepare("SELECT userId FROM f_post WHERE id = ?");
        $res->bind_param("i", $postId);
        $res->execute();
        $resData = $res->get_result()->fetch_assoc();
    
        if ($resData && $resData['userId'] == $_SESSION['user_id']) {
            $stmt = $connect->prepare("DELETE FROM f_post WHERE id = ?");
            $stmt->bind_param("i", $postId);
            $stmt->execute();

            $updateCount = $connect->prepare("
            UPDATE f_topic 
            SET countMessages = (
                SELECT COUNT(*) FROM f_post WHERE topicId = ?
            ), 
            dateReply = (SELECT MAX(dateCreate) FROM f_post WHERE topicId = ?),
            replyUserId = (SELECT userId FROM f_post WHERE topicId = ? ORDER BY dateCreate DESC LIMIT 1)
            WHERE id = ?
            ");

            $topicId = (int)$_REQUEST['topicId'];
            $updateCount->bind_param("iiii", $topicId, $topicId, $topicId, $topicId);
            $updateCount->execute();

        }
    
        die(header('Location: /pt/?page=topic&topicId=' . $_REQUEST['topicId']));
    }

    $res = $connect->prepare("
        SELECT p.*, 
            u.login AS authorName,
            t.name AS topicName
        FROM f_post p
        LEFT JOIN f_user u ON p.userId = u.id
        LEFT JOIN f_topic t ON p.topicId = t.id
        WHERE p.topicId = ?
    ");

    if ($res === false) {
        die('MySQL prepare error: ' . $connect->error);
    }

    $res->bind_param('i', $_REQUEST['topicId']);
    $res->execute();
    $result = $res->get_result();
    $postList = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php include PATH.'/header.php' ?>

<h1><a href="/pt/">Forum</a> - <?= isset($postList[0]['topicName']) ? htmlspecialchars($postList[0]['topicName']) : 'Topic not found' ?></h1>

<table class="messages">
    <thead>
        <tr>
            <th>Author</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($postList as $post): ?>
            <tr>
                <td>
                    <h3><?=$post['authorName']?></h3>
                    <span><?=date('d-m-Y H:i:s', $post['dateCreate'] )?></span>
                    <?php if(isset($_SESSION['user_id']) && $post['userId'] === $_SESSION['user_id'] ): ?>
                        <div class="">
                        <a href="/pt/?page=topic&topicId=<?=$_REQUEST['topicId']?>&action=delete_post&postId=<?=$post['id']?>">Delete</a>
                        <a href="/pt/?page=topic&topicId=<?=$_REQUEST['topicId']?>&mode=edit&postId=<?=$post['id']?>">Edit</a>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post['userId'] && isset($_REQUEST['mode']) && $_REQUEST['mode'] === 'edit' && (int)$post['id'] === (int)$_REQUEST['postId']): ?>
                        <form class="message_form" action="/pt/?page=topic&topicId=<?=$_REQUEST['topicId']?>&action=edit_post&postId=<?=$post['id']?>" method="post">
                            <input type="hidden" name="postId" value='<?=$post['id']?>'>
                            <textarea name="message"><?=$post['message']?></textarea>
                            <input type="submit" name="editSave" value="Save">
                            <input type="submit" value="Cancel">
                        </form>
                    <?php else: ?>
                        <?=$post['message']?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php if(isset($_SESSION['user_id'])): ?>
<table class="reply_form">
    <thead>
        <tr>
            <th>Reply to topic</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <form class="message_form" action="/pt/?page=topic&action=add_post" method="post">
                    <input type="hidden" name="topicId" value="<?=$_REQUEST['topicId']?>" />
                    <textarea name="message" placeholder="Write Reply"></textarea>
                    <input type="submit" name="reply" value="Send">
                </form>
            </td>
        </tr>
    </tbody>
</table>
<?php endif ?>

<?php include PATH.'/footer.php' ?>

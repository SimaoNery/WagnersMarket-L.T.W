<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/image.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/condition.class.php');
require_once(__DIR__ . '/../database/category.class.php');
?>

<?php function drawMessages(array $lastMessages, array $messages, PDO $db, int $userId, int $otherUserId) { ?>

    <section id="messages-container">
        <h3 id="contacts-header">Contacts</h3>
        <section id="contacts">
            <?php if (empty($lastMessages)) { ?>
                    <h3 id="no-open-conversations">You have no open conversations!</h3>
            <?php } ?>
            <?php foreach ($lastMessages as $message) {
                $user = $message->receiverId === $userId ? User::getUser($db, $message->authorId) : User::getUser($db, $message->receiverId); ?>
                <a href="../../pages/messages.php?otherUserId=<?= $user->userId ?>">
                    <section class="contact">
                        <?php
                        $timestamp = strtotime($message->timestamp);
                        $displayDate = date('Y-m-d') === date('Y-m-d', $timestamp) ? date('H:i', $timestamp) : date('Y-m-d', $timestamp);
                        ?>
                        <span><?= $user->username ?></span>
                        <img src="<?= $user->profilePic ?>">
                        <p><?= $message->content ?></p>
                        <time datetime="<?= $message->timestamp ?>"><?= $displayDate ?></time>
                    </section>
                </a>
            <?php } ?>
        </section>



     
            <?php {
                if ($otherUserId !== -1) { ?>
                <section id="conversation-header">
                    <?php $otherUser = User::getUser($db, $otherUserId) ?>
                    <img src="<?= $otherUser->profilePic ?>">
                    <h3><?= $otherUser->username ?></h3>
                </section>
                <section id="messages">
                    <?php
                        if (!empty($messages)) {
                            $messages = array_reverse($messages);
                            $currentDate = date('Y-m-d',strtotime($messages[0]->timestamp)); ?>
                            <time id="last-date" class="message-date" datetime="<?= $messages[0]->timestamp ?>"><?= $currentDate ?></time>
                        <?php } else { ?>
                            <h3 id="no-messages-sent">Send <?= $otherUser->username ?> a message!</h3>
                    <?php } ?>

                    <?php foreach ($messages as $message) {?>
                        <?php $class = $message->receiverId === $userId ? "left" : "right"?>
                        <?php
                        $timestamp = strtotime($message->timestamp);
                        $date = date('Y-m-d', $timestamp);
                        if ($date !== $currentDate) {
                            $currentDate = $date; ?>
                            <time class="message-date" datetime="<?= $message->timestamp ?>"><?= $date ?></time>
                        <?php }
                            $displayTime = date('H:i', $timestamp)
                        ?>
                        <section class=" message <?= $class ?>">
                            <p><?= $message->content ?></p>
                            <time class="message-time" datetime="<?= $messages[0]->timestamp ?>"><?= $displayTime ?></time>
                        </section>
                    <?php } ?>
                </section>
                    <form id="send-message" action="../../public/actions/action_send_message.php" method="post" enctype="multipart/form-data">
                        <input id="other-user" type="hidden" name="other-user-id" value="<?= $otherUserId ?>">
                        <textarea id="content" name="message" placeholder="Write a message" maxlength="9000" rows="1" required="required"></textarea>
                        <input class= "button" type="submit" value="Send">
                    </form>
                <?php }
                else { ?>
                    <h3 id="never-sent-a-message">You have no new messages!</h3>
                <?php }
            } ?>
        </section>



<?php } ?>

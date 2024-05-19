<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/image.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/condition.class.php');
require_once(__DIR__ . '/../database/category.class.php');
?>

<?php function drawMessages(array $lastMessages, array $messages, PDO $db, int $userId, int $otherUserId) { ?>

    <section id="messages_container">
        <section id="contacts_container">
            <h3 id="contacts_header">Contacts</h3>
            <section id="contacts">
                <?php if (empty($lastMessages)) { ?>
                        <h3 id="noOpenConversations">You have no open conversations!</h3>
                <?php } ?>
                <?php foreach ($lastMessages as $message) {
                    $user = $message->receiverId === $userId ? User::getUser($db, $message->authorId) : User::getUser($db, $message->receiverId); ?>
                    <a id="<?= $user->userId ?>" href="../pages/messages.php?otherUserId=<?= $user->userId ?>">
                        <section class="contact">
                            <?php
                            $timestamp = strtotime($message->timestamp);
                            $displayDate = date('Y-m-d') === date('Y-m-d', $timestamp) ? date('H:i', $timestamp) : date('Y-m-d', $timestamp);
                            ?>
                            <span><?= $user->username ?></span>
                            <img class="little" src="<?= $user->profilePic ?>" alt="../profile_pictures/profile_pic1.png">
                            <p><?= $message->content ?></p>
                            <time datetime="<?= $message->timestamp ?>"><?= $displayDate ?></time>
                        </section>
                    </a>
                <?php } ?>
            </section>
        </section>


        <section id="conversation_container">
            <?php {
                if ($otherUserId !== -1) { ?>
                <section id="conversation_header">
                    <?php $otherUser = User::getUser($db, $otherUserId) ?>
                    <img class="little" src="<?= $otherUser->profilePic ?>" alt="../profile_pictures/profile_pic1.png">
                    <h3><?= $otherUser->username ?></h3>
                </section>
                <section id="messages">
                    <?php
                        if (!empty($messages)) {
                            $messages = array_reverse($messages);
                            $currentDate = date('Y-m-d',strtotime($messages[0]->timestamp)); ?>
                            <time id="lastDate" class="messageDate" datetime="<?= $messages[0]->timestamp ?>"><?= $currentDate ?></time>
                        <?php } else { ?>
                            <h3 id="noMessagesSent">Send <?= $otherUser->username ?> a message!</h3>
                    <?php } ?>

                    <?php foreach ($messages as $message) {?>
                        <?php $class = $message->receiverId === $userId ? "left" : "right"?>
                        <?php
                        $timestamp = strtotime($message->timestamp);
                        $date = date('Y-m-d', $timestamp);
                        if ($date !== $currentDate) {
                            $currentDate = $date; ?>
                            <time class="messageDate" datetime="<?= $message->timestamp ?>"><?= $date ?></time>
                        <?php }
                            $displayTime = date('H:i', $timestamp)
                        ?>
                        <section class=" message <?= $class ?>">
                            <p><?= $message->content ?></p>
                            <time class="messageTime" datetime="<?= $messages[0]->timestamp ?>"><?= $displayTime ?></time>
                        </section>
                    <?php } ?>
                </section>
                    <form id="send_message" action="../../public/actions/action_send_message.php" method="post" enctype="multipart/form-data">
                        <input id="otherUser" type="hidden" name="otherUserId" value="<?= $otherUserId ?>">
                        <textarea id="content" name="message" placeholder="Write a message" maxlength="9000" rows="1" required="required"></textarea>
                        <input type="submit" value="Send">
                    </form>
                <?php }
                else { ?>
                    <h3 id="neverSentAMessage">You have no new messages!</h3>
                <?php }
            } ?>
        </section>
    </section>


<?php } ?>

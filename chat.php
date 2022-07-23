<?php
    include "template/__header.php";
    if (!isset($_SESSION['id'])){
        header("Location: index.php");
        exit();
    }
?>
<body class="bg-light">
    <div class="container">
        <div class="wrapper chat bg-light shadow-lg col-md-4 p-0 offset-md-4">
            <div class="chat-header bg-white py-2 px-3 d-flex align-items-center">
                <a href="user.php" class="exit-chat text-dark mr-2 d-block">
                    <i class="fa fa-arrow-left mt-3" id="exit-chat"></i>
                </a>
                <div class="profile d-flex">
                    <?php
                        $sqlSender = "SELECT * FROM users WHERE id={$_SESSION['id']}";
                        $resultSender = mysqli_query($dbh->conn, $sqlSender);
                        $checkSender = mysqli_num_rows($resultSender);

                        if ($checkSender > 0) {
                            if($senderData = mysqli_fetch_array($resultSender, MYSQLI_ASSOC)){
                                $fileLocation = "upload/profile".$_SESSION['id']."*";
                                $checkFile = glob($fileLocation);

                                if (count($checkFile) > 0) {
                                    $fileExt = explode(".", $checkFile[0]);
                                    $fileActualExt = strtolower(end($fileExt));
                                }
                                echo '<div class="user-image mr-3" id="user-image">
                                    <img src="upload/profile'.$_SESSION['id'].'.'.$fileActualExt.'" id="userimage" alt="profile-image">
                                </div>
                                
                                <div class="user-details">
                                    <div class="username">
                                        <h6 class="m-0">'.$senderData['firstname'] ." ". $senderData['lastname'].'</h6>
                                    </div>
                                    <div class="userstatus mt-1">
                                        <p class="m-0">'.$senderData['status'].'</p>
                                    </div>
                                </div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="chat-body p-2">
                <div class="messages">
                    <?php
                        $user_id = mysqli_real_escape_string($dbh->conn, $_GET['id']);
                        $sql = "SELECT messages.sender_id, messages.receiver_id, messages.message, messages.id FROM messages INNER JOIN users ON messages.receiver_id=users.id WHERE sender_id={$_SESSION['id']} AND receiver_id={$user_id} OR sender_id={$user_id} AND receiver_id={$_SESSION['id']} ORDER BY messages.id ASC";
                        $result = mysqli_query($dbh->conn, $sql);
                        $checkForMessages = mysqli_num_rows($result);

                        if ($checkForMessages > 0) {
                            $fileLocation = "upload/profile".$user_id."*";
                            $checkFile = glob($fileLocation);

                            if (count($checkFile) > 0) {
                                $fileExt = explode(".", $checkFile[0]);
                                $fileActualExt = strtolower(end($fileExt));
                            }
                            
                            while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                if ($data['sender_id'] == $_SESSION['id']) {
                                    echo '<div class="outgoing mt-3 d-flex justify-content-end">
                                            <div class="user-message bg-dark text-white shadow-lg">
                                                <p class="m-0">'.$data['message'].'</p>
                                            </div>
                                        </div>';
                                }else{
                                    
                                }
                                
                                if ($data['receiver_id'] == $_SESSION['id']){
                                    echo '<div class="incoming mt-3 d-flex">
                                            <div class="user-image mr-3" id="user-image">
                                                <img src="upload/profile'.$user_id.'.'.$fileActualExt.'" alt="">
                                            </div>
                                            <div class="user-message bg-white shadow-lg">
                                                <p class="m-0">'.$data['message'].'</p>
                                            </div>
                                        </div>';
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="chat-footer bg-white">
                <form class="d-flex" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" name="sender_id" value="<?php echo $_SESSION['id']; ?>">
                    <input type="hidden" name="receiver_id" value="<?php echo mysqli_real_escape_string($dbh->conn, $_GET['id']); ?>">
                    <input type="text" class="form-control" name="message" id="send-messages" placeholder="Type a message here............" required>
                    <button type="submit" name="sendMessageBtn" class="m-0"><i class="fa fa-telegram"></i></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
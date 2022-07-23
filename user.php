<?php
    include "template/__header.php";
    if (!isset($_SESSION['id'])){
        header("Location: index.php");
        exit();
    }
?>
<body class="bg-light">
    <div class="container">
        <div class="wrapper user rounded shadow-lg col-md-6 p-4 offset-md-3">
            <div class="user-profile d-flex py-2 border-bottom mb-3 justify-content-between">
                <?php
                    $sqlUser = "SELECT * FROM users WHERE id={$_SESSION['id']}";
                    $resultUser = mysqli_query($dbh->conn, $sqlUser);
                    if ($resultUser){
                        $dataUser = mysqli_fetch_array($resultUser, MYSQLI_ASSOC);
                    }
                ?>
                <div class="profile d-flex">
                    <div class="user-image mr-3" id="user-image">
                        <?php
                            $fileLocation = "upload/profile".$_SESSION['id']."*";
                            $checkFile = glob($fileLocation);

                            if (count($checkFile) > 0) {
                                $fileExt = explode(".", $checkFile[0]);
                                $fileActualExt = strtolower(end($fileExt));
                            }
                        ?>

                        <img src="upload/profile<?php echo $_SESSION['id'];?>.<?php echo $fileActualExt; ?>" id="userimage" alt="profile-image">
                    </div>
                    <div class="user-details">
                        <div class="username">
                            <h6><?php echo $dataUser['firstname']." ".$dataUser['lastname'] ?></h6>
                        </div>
                        <div class="userstatus">
                            <p><?php echo $dataUser['status']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="logout">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <button type="submit" name="logoutBtn" class="btn font-weight-bold btn-dark btn-white">LOGOUT</button>
                    </form>
                </div>
            </div>
            <div class="user-search">
                <div class="search d-flex">
                    <input type="text" name="search" class="form-control" id="searchInput" placeholder="Search for friends.....">
                    <button type="button" id="searchBtn" class="btn btn-dark btn-white"><i class="fa fa-search" id="search"></i></button>
                </div>
            </div>
            <div class="user-connection">
                <?php
                    $sqlFriends = "SELECT * FROM users WHERE NOT id = {$_SESSION['id']}";
                    $resultFriends = mysqli_query($dbh->conn, $sqlFriends);
                    $checkForFriends = mysqli_num_rows($resultFriends);

                    $userArray = [];

                    if ($checkForFriends > 0){
                        while($dataFriends = mysqli_fetch_array($resultFriends, MYSQLI_ASSOC)){
                            $userArray[] = $dataFriends;
                        }
                    }else{
                        echo '<p>No other user registered yet!</p>';
                    }
                ?>

                <?php foreach($userArray as $user): ?>
                    <?php
                        $fileLocation = "upload/profile".$user['id']."*";
                        $checkFile = glob($fileLocation);
                        
                        if (count($checkFile) > 0) {
                            $fileExt = explode(".", $checkFile[0]);
                            $friendFileActualExt = strtolower(end($fileExt));
                        }

                        $sql = "SELECT * FROM messages WHERE sender_id={$_SESSION['id']} AND receiver_id={$user['id']} OR sender_id={$user['id']} AND receiver_id={$_SESSION['id']} ORDER BY id DESC LIMIT 1";
                        $result = mysqli_query($dbh->conn, $sql);
                        $check = mysqli_num_rows($result);

                        $output = "";

                        if ($check > 0){
                            if ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                if ($data['sender_id'] == $_SESSION['id']) {
                                    if (strlen($data['message']) > 35) {
                                        $output .= '<p>You: '.substr($data['message'], 0, 35).'...............'.'</p>'; 
                                    }else{
                                        $output .= '<p>You: '.$data['message'].'</p>';
                                    }
                                }
                                if ($data['sender_id'] == $user['id']){
                                    $output .= '<p>'.$data['message'].'</p>';
                                }
                            }
                        }else{
                            $output .= 'No message available yet!';
                        }    
                    ?>

                    <a href="chat.php?id=<?php echo $user['id']; ?>" class="profile text-decoration-none text-dark" style="display: grid;grid-template-columns: 15% 70% 10%;">
                        <div class="user-image mr-3" id="user-image">
                            <img src="upload/profile<?php echo $user['id']; ?>.<?php echo $friendFileActualExt; ?>" id="userimage" alt="profile-image">
                        </div>
                        
                        <div class="user-details">
                            <div class="username">
                                <h6 class="m-0 mb-2 name"><?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?></h6>
                            </div>
                            <div class="userstatus">
                                <p class="m-0 font-weight-bold"><?php echo $output; ?></p>
                            </div>
                        </div>
                        <?php
                            $sqlStatus = "SELECT status FROM users WHERE id={$user['id']} LIMIT 1";
                            $resultStatus = mysqli_query($dbh->conn, $sqlStatus);
                            
                            if ($resultStatus) {
                                if ($status = mysqli_fetch_array($resultStatus, MYSQLI_ASSOC)) {
                                    echo (strtolower($status['status']) == "active") ? '<div class="status bg-success"></div>' : '<div class="status bg-dark"></div>';
                                }
                            }
                        ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="js/user.js"></script>
    <script src="chatapp.js"></script>
</body>
</html>
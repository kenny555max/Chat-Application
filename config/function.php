<?php

$dbh = new DBH();

$error = "";
$fname = "";
$lname = "";
$email = "";

$signup = new SIGNUP($dbh);

if (isset($_POST['signupBtn'])) {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        $fileName = $file['name'];
        $fileTmpLocation = $file['tmp_name'];
        $fileType = $file['type'];
        $fileError = $file['error'];
        $fileSize = $file['size'];
        
        // image ext
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $array = array("jpg", "jpeg", "png");

        if (in_array($fileActualExt, $array)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fname = mysqli_real_escape_string($dbh->conn, $_POST['fname']);
                    $lname = mysqli_real_escape_string($dbh->conn, $_POST['lname']);
                    $email = mysqli_real_escape_string($dbh->conn, $_POST['email']);
                    $password = mysqli_real_escape_string($dbh->conn, $_POST['password']);

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error = "Invalid email address";
                    }

                    if ($signup->checkIfUserAlreadyExist($email) > 0) {
                        $error = "Email already exist in our database!";
                    }

                    if ($error === "") {
                        $status = "Active";
                        $encryptpassword = password_hash($password, PASSWORD_BCRYPT);
                        $param = array(
                            "firstname" => $fname,
                            "lastname" => $lname,
                            "email" => $email,
                            "password" => $encryptpassword,
                            "status" => $status
                        );

                        if ($signup->insertUserData($param)){
                            // check to see if the uploaded image already exist in our folder
                            $fileLocation = "upload/profile".$_SESSION['id']."*";
                            $checkFileLocation = glob($fileLocation);
                            
                            if ($checkFileLocation) {
                                unlink($checkFileLocation[0]);
                            }

                            $fileNewLocation = "upload/profile".$_SESSION['id'].".".$fileActualExt;
                            
                            if (move_uploaded_file($fileTmpLocation, $fileNewLocation)) {
                                header("Location: user.php");
                                exit();
                            }
                        }
                    }
                }else{
                    $error = "File size is too big!. Please try uploading another file with size below 100000";
                }
            }else{
                $error = "Something went wrong while uploading the file!. Try uploading again!";
            }
        }else{
            $error = "This file type is not supported!. Please enter a file type like jped, jpg, png";
        }
    }
}

$login = new LOGIN();

if (isset($_POST['loginBtn'])){
    $email = mysqli_real_escape_string($dbh->conn, $_POST['email']);
    $password = mysqli_real_escape_string($dbh->conn, $_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address!";
    }else{
        if($login->checkUserExistence($email, $table = "users") !== null){
            $data = $login->checkUserExistence($email, $table = "users");
            $hash = $data['password'];
    
            if(password_verify($password, $hash)){
                $_SESSION['id'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['firstname'] = $data['firstname'];
                $_SESSION['lastname'] = $data['lastname'];
    
                $sqlUpdate = "UPDATE `users` SET status='Active' WHERE id={$_SESSION['id']} LIMIT 1";
                $resultUpdate = mysqli_query($dbh->conn, $sqlUpdate);
    
                if ($resultUpdate) {
                    $_SESSION['status'] = $data['status'];
                }
    
                header("Location: user.php");
                exit();
            }else{
                $error = "Incorrect password!";
            }
        }else{
            $error = "User info does not exist in our database!. Please enter a valid email address!";
        }
    }

}

if (isset($_POST['logoutBtn'])){
    $sql = "UPDATE `users` SET status='Offline' WHERE id={$_SESSION['id']} LIMIT 1";
    $result = mysqli_query($dbh->conn, $sql);

    unset($_SESSION['id']);
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_POST['sendMessageBtn'])){
    $sender_id = mysqli_real_escape_string($dbh->conn, $_POST['sender_id']);
    $receiver_id = mysqli_real_escape_string($dbh->conn, $_POST['receiver_id']);
    $message = mysqli_real_escape_string($dbh->conn, $_POST['message']);

    $sql = "INSERT INTO messages(`message`, `sender_id`, `receiver_id`) VALUES('{$message}', '{$sender_id}', '{$receiver_id}')";
    $result = mysqli_query($dbh->conn, $sql);

    if ($result){
        header("Location: chat.php?id=".$receiver_id);
        exit();
    }
}
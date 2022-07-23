<?php
    include "template/__header.php";
?>
<body class="bg-light">
    <div class="container">
        <div class="wrapper signup col-md-6 bg-light shadow-lg rounded p-4 offset-md-3">
            <h2 class="text-center">Realtime Chat App</h2>
            <?php if ($error !== ""): ?>
                    <li class="bg-danger list-unstyled text-white text-center font-weight-bold p-2"> <?php echo $error; ?> </li>
            <?php endif; ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12 p-0 d-flex">
                    <div class="col-lg-6 p-0 mr-2">
                        <div class="form-group">
                            <label for="First Name">First Name</label>
                            <input type="text" class="form-control" value="<?php echo $fname; ?>" name="fname" placeholder="First name......" required>
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="form-group">
                            <label for="Last Name">Last Name</label>
                            <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>" placeholder="Last name......" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 p-0">
                    <div class="form-group">
                        <label for="Email address">Email Address</label>
                        <input type="email" value="<?php echo $email; ?>" class="form-control" name="email" placeholder="Enter your email......" required>
                    </div>
                </div>
                <div class="col-lg-12 p-0">
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <i class="fa fa-eye" id="showPassword"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password......" required>
                    </div>
                </div>
                <div class="col-lg-12 p-0">
                    <div class="form-group">
                        <label for="Select image">Select image</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                </div>
                <div class="col-lg-12 p-0">
                    <button type="submit" name="signupBtn" class="btn btn-block font-weight-bold btn-dark text-white">Continue to Chat</button>
                </div>
                <p class="text-center mt-2">Already signed in? <a href="login.php">Login now</a></p>
            </form>
        </div>
    </div>
    
    <script src="js/index.js"></script>
</body>
</html>
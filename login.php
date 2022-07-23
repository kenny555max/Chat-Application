<?php
    include "template/__header.php";
?>
<body class="bg-light">
    <div class="container">
        <div class="wrapper login col-md-6 bg-light shadow-lg rounded p-4 offset-md-3">
        <h2 class="text-center">Realtime Chat App</h2>
        
        <?php if ($error !== ""): ?>
            <li class="bg-danger p-2 text-white font-weight-bold"><?php echo $error; ?></li>
        <?php endif; ?>
        
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="col-lg-12 p-0">
                <div class="form-group">
                    <label for="Email address">Email Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Enter your email......" required>
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
                <button type="submit" class="btn btn-block font-weight-bold btn-dark text-white" name="loginBtn">Continue to Chat</button>
            </div>
            <p class="text-center mt-2">Not yet signed in? <a href="index.php">Signup now</a></p>
        </form>
    </div>

    <script src="js/login.js"></script>
</body>
</html>
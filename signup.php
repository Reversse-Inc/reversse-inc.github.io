<?php require_once 'controllers/authController.php' ?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
   <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 form-div">
                    <form action="signup.php" method="post">
                        <h3 class="text-center">Register</h3>

                        <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" onkeyup="this.value=this.value.replace(/^(\d{3})(?=\d)/,'$1&nbsp;')" value="<?php echo $phone; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <div class="float-left col-md-6">
                            <label for="firstname">First Name</label>
                            <input type="firstname" name="firstname" value="<?php echo $firstname; ?>" class="form-control form-control-lg">
                            </div>
                            <div class="float-right col-md-6">
                            <label for="lastname">last Name</label>
                            <input type="lastname" name="lastname" value="<?php echo $lastname; ?>" class="form-control form-control-lg">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="passwordConf">Confirm Password</label>
                            <input type="password" name="passwordConf" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign Up</button>
                        </div>
                        
                        <p class="text-center">Already a member? <a href="login">Sign In</a></p>


                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
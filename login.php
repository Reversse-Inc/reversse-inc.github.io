<?php require_once 'controllers/authController.php' ?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Connexion</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
   <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 form-div login">
                    <form action="login.php" method="post">
                        <h3 class="text-center">Connexion</h3>

                        <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="username">Nom d'utilisateur, email ou No. de téléphone</label>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de de passe</label>
                            <input type="password" name="password" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Se Connecter</button>
                        </div>
                        <p class="text-center">Pas encore de compte? <a href="signup.php">S'inscrire</a></p>


                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
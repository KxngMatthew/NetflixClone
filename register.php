<?php

    require_once( "includes/config.php"); //Connect to database and start session
    require_once( "includes/classes/FormSanitizer.php");
    require_once( "includes/classes/Account.php");
    require_once( "includes/classes/Constants.php");

    $account = new Account($con);

    if(isset($_POST['submitBttn'])){

        $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
        $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
        $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
        $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
        $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

       $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

       if($success){
        //store session
            $_SESSION["userLoggedIn"]=$username;
            header("Location: index.php");// redirect to index page if user register successfully.
       }
    }

    //Function to remember user input after submission to avoid re-typing all input values for validation.
    function getInputValue($value){
        if(isset($_POST[$value])){
            echo $_POST[$value];
        }

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Nextflik</title>
        <link rel="stylesheet" type = "text/css" href="assets/style/style.css"/>
    </head>
    <body>
    <div class="body-container">
        <div class="basic-header">
        <a href="https://fontmeme.com/netflix-font/"><img class="logo" src="https://fontmeme.com/permalink/220730/23a6eaec9e0ca4a5a13274bf484bef2f.png" title="Logo" alt="netflix-font" border="0"></a>
        </div>
        <div class="sign-in-container">
            <div class="column">

            <div class="header">
                <h3>Sign Up</h3>
                <span>Welcome to NextFlik</span>
            </div>
                <form method="POST">
                    <?php echo $account->getError(Constants::$firstNameCharacters);?>
                    <input type="text" name="firstName" placeholder="First Name" value="<?php getInputValue("firstName")?>" required>

                    <?php echo $account->getError(Constants::$lastNameCharacters);?>
                    <input type="text" name="lastName" placeholder="Last Name" value="<?php getInputValue("lastName")?>" required>

                    <?php echo $account->getError(Constants::$userNameCharacters);?>
                    <?php echo $account->getError(Constants::$userNameTaken);?>
                    <input type="text" name="username" placeholder="Username" value="<?php getInputValue("username")?>" required>

                    <?php echo $account->getError(Constants::$emailNotMatched);?>
                    <?php echo $account->getError(Constants::$emailInvalid);?>
                    <?php echo $account->getError(Constants::$emailTaken);?>
                    <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email")?>" required>
                    <input type="email" name="email2" placeholder="Confirm email" value="<?php getInputValue("email2")?>" required>

                    <?php echo $account->getError(Constants::$passwordNotMatched);?>
                    <?php echo $account->getError(Constants::$passwordCharacters);?>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="password2" placeholder="Confirm password" required>
                    <input type="submit" name="submitBttn" value="Sign Up">
                </form>
                <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
            </div>
        </div>
</div>
    </body>
</html>
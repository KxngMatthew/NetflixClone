<?php

    require_once( "includes/config.php"); //Connect to database
    require_once( "includes/classes/FormSanitizer.php");
    require_once( "includes/classes/Account.php");
    require_once( "includes/classes/Constants.php");

    $account = new Account($con);
    if(isset($_POST['submitBttn'])){

        $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
        $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

       $success = $account->loginUser($username,$password);

       if($success){
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
                <h3>Sign In</h3>
                <span>Welcome to NextFlik</span>
            </div>
                <form method="POST">
                    <?php echo $account->getError(Constants::$loginFailed);?>
                    <input type="text" name="username" placeholder="Username" value="<?php getInputValue("username")?>" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" name="submitBttn" value="Sign In">
                </form>
                <a href="register.php" class="signInMessage">Don't have an account? Sign up here!</a>
            </div>
        </div>
</div>
    </body>
</html>
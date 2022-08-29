<?php

class Account {

private $con;
private $error = [];

public function __construct($con){
    $this->con = $con;
}

public function register($fn, $ln, $un, $em, $em2, $pw, $pw2){
    $this->validateFirstName($fn);
    $this->validateLastName($ln);
    $this->validateUserName($un);
    $this->validateEmails($em,$em2);
    $this->validatePassword($pw,$pw2);

    if(empty($this->error)){
    return $this->acceptUserDetails($fn, $ln, $un, $em, $pw);
    }

    return false;
}

public function loginUser($un,$pw){
    $pw = hash("sha512",$pw);

    $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");

    $query->bindValue(":un", $un);
    $query->bindValue(":pw", $pw);

    $query->execute();

    if($query->rowCount() == 1){
        return true;
    }

    array_push($this->error, Constants::$loginFailed);
    return false;
}

private function acceptUserDetails($fn, $ln, $un, $em, $pw){

    $pw = hash("sha512",$pw); //hash password

    $query = $this->con->prepare("INSERT INTO users (firstName,lastName,email,password,username)
                                    VALUES(:fn, :ln, :em, :pw, :un)");
    $query->bindValue(":fn", $fn);
    $query->bindValue(":ln", $ln);
    $query->bindValue(":em", $em);
    $query->bindValue(":pw", $pw);
    $query->bindValue(":un", $un);

    return $query->execute();// if query execute successfully it will return true or false.
}

private function validateFirstName($fn){
    if(strlen($fn) < 2 || strlen($fn) > 30){
        array_push($this->error,Constants::$firstNameCharacters);
    }
}

private function validateLastName($ln){
    if(strlen($ln) < 2 || strlen($ln) > 30){
        array_push($this->error,Constants::$lastNameCharacters);
    }
}

private function validateUserName($un){
    if(strlen($un) < 2 || strlen($un) > 30){
        array_push($this->error,Constants::$userNameCharacters);
        return;
    }

    $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
    $query->bindValue(":un",$un);
    $query->execute();

    if($query->rowCount() != 0){
        array_push($this->error, Constants::$userNameTaken);
    }
}

private function validateEmails($em,$em2){

    if($em != $em2){
        array_push($this->error,Constants::$emailNotMatched);
        return;
    }

    if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
        array_push($this->error,Constants::$emailInvalid);
        return;
    }

    $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
    $query->bindValue(":em",$em);
    $query->execute();

    if($query->rowCount() != 0){
        array_push($this->error, Constants::$emailTaken);
    }

}

private function validatePassword($pw,$pw2){
    
    if($pw != $pw2){
        array_push($this->error,Constants::$passwordNotMatched);
        return;
    }

    if(strlen($pw) < 8 || strlen($pw) > 30){
        array_push($this->error,Constants::$passwordCharacters);
    }
}


public function getError($error){
    if(in_array($error, $this->error)){
        return "<span class='errorMessage'>$error</span>";
    }
}
}
?>
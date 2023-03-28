<?php

/**
* Register a user
*
* @param string $email
* @param string $username
* @param string $password
* @param bool $is_admin
* @return bool
*/

function register_user(string $email, string $username, string $password, string $activation_code, int $expiry = 1 * 24  * 60 * 60, bool $is_admin = false): bool
{
    $sql = 'INSERT INTO users(username, email, password, is_admin, activation_code, activation_expiry)
            VALUES(:username, :email, :password, :is_admin, :activation_code,:activation_expiry)';

    $statement = db()->prepare($sql);

    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);
    $statement->bindValue(':activation_code', password_hash($activation_code, PASSWORD_DEFAULT));
    $statement->bindValue(':activation_expiry', date('Y-m-d H:i:s',  time() + $expiry));

    return $statement->execute();
}

function find_user_by_username(string $username)
{
    $sql = 'SELECT username, password, active, email
            FROM users
            WHERE username=:username';

    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function is_user_active($user)
{
    return (int)$user['active'] === 1;
}

function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);

    if ($user && is_user_active($user) && password_verify($password, $user['password'])) {
        // prevent session fixation attack
        session_regenerate_id();

        // set username in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        return true;
    }

    return false;
}

function is_user_logged_in(): bool
{
    return isset($_SESSION['username']);
}

function require_login(): void
{
    if (!is_user_logged_in()) {
        redirect_to('login.php');
    }
}

function logout(): void
{
    if (is_user_logged_in()) {
        unset($_SESSION['username'], $_SESSION['user_id']);
        session_destroy();
        redirect_to('login.php');
    }
}

function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['username'];
    }
    return null;
}

function find_user_by_email(string $email)
{
   $sql = 'SELECT username, password, active, email
           FROM users
           WHERE email=:email';


   $statement = db()->prepare($sql);
   $statement->bindValue(':email', $email);
   $statement->execute();


   return $statement->fetch(PDO::FETCH_ASSOC);
}


function validate_token($email, $token) {
   //$pdo = new PDO("mysql:host=localhost:3306; dbname=auth", "root", "");
   $pdo = new PDO("mysql:host=sql311.byethost17.com; dbname=b17_33364802_loginSystem", "b17_33364802","love0220");




   $sql = "SELECT * FROM users WHERE email = :email AND token = :token LIMIT 1";
   $stmt =$pdo->prepare($sql);
   $stmt->execute(['email' => $email, 'token' => $token]);
   $user = $stmt->fetch(PDO::FETCH_ASSOC);


   return $user ? true : false;
}


function login_without_password($email): bool {
   // find the user by email
   $user = find_user_by_email($email);


   // check if the user exists and is active
   if (is_user_active($user)) {
       // prevent session fixation attack
     // prevent session fixation attack
     session_regenerate_id();


     // set username in the session
     $_SESSION['user_id'] = $user['id'];
     $_SESSION['username'] = $user['username'];


     return true;
   }else
   {
       echo('no');
   }


   // return false for unsuccessful login
   return false;
}

function current_email() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        return null;
    }
 
 
    // Get the user's email address from the database
    //$pdo = new PDO("mysql:host=localhost;dbname=auth", "root", "");
    $pdo = new PDO("mysql:host=sql311.byethost17.com; dbname=b17_33364802_loginSystem", "b17_33364802","love0220");
 
 
    $stmt = $pdo->prepare("SELECT email FROM users WHERE username = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
 
    // Return the email address
    return $result['email'];
 }
 
 function update_user_password($username, $new_password) {
    // Create a PDO instance
    //$pdo = new PDO("mysql:host=localhost;dbname=auth", "root", "");
    $pdo = new PDO("mysql:host=sql311.byethost17.com; dbname=b17_33364802_loginSystem", "b17_33364802","love0220");
 
 
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
    // Prepare and execute the SQL statement to update the user's password
    $stmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE username = :username");
    $stmt->bindParam(':new_password', $password_hash);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
 
 
    // Check if the update was successful
    return $stmt->rowCount() > 0;
 }
 

?>
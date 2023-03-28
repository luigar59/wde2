<?php

// Swiftmailer lib
//require_once './plib/vendor/autoload.php';

const APP_URL = 'http://luigar59/byethost10.com/projects/wde2';
const SENDER_EMAIL_ADDRESS = 'luisenriquegarcia1124@gmail.com';

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

function send_activation_email(string $email, string $activation_code): void
{

    // create the activation link
    $activation_link = APP_URL . "/activate.php?email=$email&activation_code=$activation_code";

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
    ->setUsername('luisenriquegarcia1124@gmail.com')
    ->setPassword('Deepbluesea1');

    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Registration Email'))
    ->setFrom(['luisenriquegarcia1124@gmail.com' => 'Activation Link'])
    ->setTo([$email])
    ->setBody('Click here to activate your account with us --> '.$activation_link)
    ;

    // Send the message
    $result = $mailer->send($message);

}

function success_email(string $email): void
{
   // Create the Transport
   $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
   ->setUsername('luisenriquegarcia1124@gmail.com')
   ->setPassword('Deepbluesea1');


   $mailer = new Swift_Mailer($transport);


   // Create a message
   $message = (new Swift_Message('Password Update'))
   ->setFrom(['luisenriquegarcia1124@gmail.com' => 'Password'])
   ->setTo([$email])
   ->setBody('<html>' .
'<head>' .
'<style>' .
'h1 { font-family: Arial, sans-serif; font-size: 16px;  }' .
'</style>' .
'</head>' .
'<body>' .
'<h1>Greetings from Wolf Pack Ltd.<br> You have successfully updated your password!<br></h1>' .
'</body>' .
'</html>',
'text/html');




   // Send the message
   $result = $mailer->send($message);
}


function delete_user_by_id(int $id, int $active = 0)
{
    $sql = 'DELETE FROM users
            WHERE id =:id and active=:active';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':active', $active, PDO::PARAM_INT);

    return $statement->execute();
}

function find_unverified_user(string $activation_code, string $email)
{

    $sql = 'SELECT id, activation_code, activation_expiry < now() as expired
            FROM users
            WHERE active = 0 AND email=:email';

    $statement = db()->prepare($sql);

    $statement->bindValue(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {
            delete_user_by_id($user['id']);
            return null;
        }
        // verify the password
        if (password_verify($activation_code, $user['activation_code'])) {
            return $user;
        }
    }

    return null;
}

function activate_user(int $user_id): bool
{
    $sql = 'UPDATE users
            SET active = 1,
                activated_at = CURRENT_TIMESTAMP
            WHERE id=:id';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}



?>
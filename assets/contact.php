<?php

if (!$_POST) exit;

// Email verification function, do not edit.
function isEmail($email_contact)
{
    return (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email_contact));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$name_contact = $_POST['name_contact'];
$lastname_contact = $_POST['lastname_contact'];
$email_contact = $_POST['email_contact'];
$phone_contact = $_POST['phone_contact'];
$message_contact = $_POST['message_contact'];
$verify_contact = $_POST['verify_contact'];

// Input validation
if (trim($name_contact) == '') {
    echo '<div class="error_message">Sie müssen Ihren Namen Eintragen.</div>';
    exit();
} elseif (trim($lastname_contact) == '') {
    echo '<div class="error_message">Sie müssen Ihren Nachnamen Eintragen.</div>';
    exit();
} elseif (trim($email_contact) == '') {
    echo '<div class="error_message">Bitte geben Sie eine gültige Email adresse an.</div>';
    exit();
} elseif (!isEmail($email_contact)) {
    echo '<div class="error_message">Bitte geben Sie eine gültige Email adresse an.</div>';
    exit();
} elseif (trim($phone_contact) == '') {
    echo '<div class="error_message">Bitte geben Sie eine gültige Telefonnummer an.</div>';
    exit();
} elseif (!is_numeric($phone_contact)) {
    echo '<div class="error_message">Bitte geben Sie eine gültige Telefonnummer an.</div>';
    exit();
} elseif (trim($message_contact) == '') {
    echo '<div class="error_message">Bitte schreiben Sie uns Ihr Anliegen.</div>';
    exit();
} elseif (!isset($verify_contact) || trim($verify_contact) == '') {
    echo '<div class="error_message">Please enter the verification number.</div>';
    exit();
} elseif (trim($verify_contact) != '4') {
    echo '<div class="error_message">The verification number you entered is incorrect.</div>';
    exit();
}

// if (get_magic_quotes_gpc()) {
//     $message_contact = stripslashes($message_contact);
// }

// Email settings
$address = "info@sungate24.com";  // Change to your actual email address

// Subject of the email
$e_subject = 'You\'ve been contacted by ' . $name_contact . '.';

// Email body
$e_body = "You have been contacted by $name_contact $lastname_contact with the following message:" . PHP_EOL . PHP_EOL;
$e_content = "\"$message_contact\"" . PHP_EOL . PHP_EOL;
$e_reply = "You can contact $lastname_contact via email: $email_contact or via phone: $phone_contact";

$msg = wordwrap($e_body . $e_content . $e_reply, 70);

// Email headers
$headers = "From: $email_contact" . PHP_EOL;
$headers .= "Reply-To: $email_contact" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

// User response message
$user = "$email_contact";
$usersubject = "Thank You";
$userheaders = "From: info@sungate24.com\n";
$usermessage = "Thank you for contacting UDEMA. We will reply shortly!";
mail($user, $usersubject, $usermessage, $userheaders);

// Send the email to the admin
if (mail($address, $e_subject, $msg, $headers)) {

    // Success message
    echo "<div id='success_page' style='padding:25px 0'>";
    echo "<strong>Email gesendet.</strong><br>";
    echo "Danke <strong>$name_contact</strong>,<br> Ihre Nachricht wurde uns übermittelt. Wir werden Sie bald kontaktieren.";
    echo "</div>";

} else {
    // Error message
    echo 'ERROR!';
}

?>

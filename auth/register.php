<?php
include "../include_pdo.php";

$email = trim($_GET['email']);
$password = $_GET['password'];

if (empty($email)) {
    http_response_code(422);
    exit(json_encode([
        'status' => 'EMAIL_IS_EMPTY'
    ]));
}
if (empty($password)) {
    http_response_code(422);
    exit(json_encode([
        'status' => 'PASSWORD_IS_EMPTY'
    ]));
}
$isPasswordValid = preg_match('/\d/', $password)
    && preg_match('/[a-zA-Z]/', $password)
    && strlen($password) >= 6;

if (!$isPasswordValid) {
    http_response_code(400);
    exit(json_encode([
        'status' => 'PASSWORD_IS_NOT_VALID'
    ]));
}

$isEmailTaken = (bool)$pdo->query(
    "SELECT email FROM users WHERE email = '$email'"
)->fetchColumn();

if ($isEmailTaken) {
    http_response_code(400);
    exit(json_encode([
        'email' => $email,
        'status' => 'EMAIL_ALREADY_TAKEN'
    ]));
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$emailConfirmToken = bin2hex(random_bytes(16));

$pdo->exec("INSERT INTO users (email, hashed_password, email_confirm_token) VALUES ('$email','$hashedPassword', '$emailConfirmToken')");

$body = generateMailBody('email_confirmed', [
    'confirmUrl' => "https://www.google.com?q=$emailConfirmToken",
]);
sendEmail($email, "Подтверждение электронной почты", $body);

exit(json_encode([
    'status' => 'OK'
]));
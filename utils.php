<?php

use PHPMailer\PHPMailer\PHPMailer;

function sendEmail($email, $subject, $body) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.yandex.ru';
    $mail->SMTPAuth = true;
    $mail->Username = 'natali23160@yandex.ru';
    $mail->Password = 'rqcquoktgglwsgtf';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('natali23160@yandex.ru', 'CoinKeeper');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $body;
    return $mail->send();
}


function generateMailBody($templateName, $variables) {
    ob_start();
    $root = $_SERVER['DOCUMENT_ROOT'];
    include "$root/mails/$templateName.php";
    $text = ob_get_clean();
    foreach ($variables as $key => $variable) {
        $text = str_replace("{{{$key}}}", $variable, $text);
    }
    return $text;
}


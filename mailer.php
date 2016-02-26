<?php

function sendEmail() {
    $to = 'dulaj.r.atapattu@gmail.com'; //$_REQUEST['to'];
    $from = 'noreply@dosstraining.com'; //$_REQUEST['from'];
    $replyto = 'noreply@dosstraining.com'; //$_REQUEST['replyto'];
    $subject = $_REQUEST['subject'] . ' Training request';
    $message = $_REQUEST['msg'];

    $headers = "From: " . $from . "\r\n" .
            'Reply-To: ' . $replyto . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    $mail = mail($to, $subject, $message, $headers);
    if ($mail) {
        echo json_encode(TRUE);
    } else {
        echo json_encode(FALSE);
    }
}

sendEmail();

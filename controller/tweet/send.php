<?php

require_once './TwitterLibrary/twitter.class.php';

// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$twitter = new Twitter('bYbOMaCUhVTCHbC21niWIigGd', 'TTuRx4TelfclbV9qksXhyqhPwC2l5gxZZzaWEtRZZGWNi5QMPT', '3321000236-iLOVolcrKRlDwgxxqexnHEhw5YJxfVvOIJKA4HQ', 'XNFRZIWTgRK0FqtQjJbRNldy8XPKbxiBNHHFbD8p6qVxY');

try {
    $tweet = $twitter->send($_POST['msg']); // you can add $imagePath as second argument
    echo json_encode(TRUE);
} catch (TwitterException $e) {
    echo json_encode(FALSE);
}

<?php

require_once './TwitterLibrary/twitter.class.php';

$twitter = new Twitter('3Nqt8v6x29KhsHQDsVc0n32J8', 'qNAjbk1OFXSVsjNoitnGp6VXvvSpmb3MGRyQ9n6nkMQaFJtH8L', '834600368-5IQevX5iGY319lvVx3k9iVi8oPNUt5FLaTAVsGza', 'UwnY1njIdFnsksRFCkPzFPsmu3N6wa9qp43HUqf8aEA9l');
$message=$_POST['msg'];
try {
	$tweet = $twitter->send("Thsi is fine"); // you can add $imagePath as second argument
        echo json_encode(TRUE);

} catch (TwitterException $e) {
	echo json_encode(FALSE);
}

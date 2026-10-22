<?php
$postData = file_get_contents('php://input');

$data = json_decode($postData, true);

if ($data['action'] == 'accept') {
    setcookie("licprof_consent", true, strtotime("+1 year"), "/");
}

?>
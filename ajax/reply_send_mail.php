<?php
header('Content-Type: application/json');
session_start();
include("../include/connection.php");

$sender_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mailId = $_POST['mailId'];
    $senderEmail = $_POST['senderEmail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $actionType = $_POST['actionType'];

    $attachmentPaths = [];

    if (!empty($_FILES["fileInput"]["name"][0])) { 
        foreach ($_FILES["fileInput"]["name"] as $key => $file_name) {
            $file_tmp = $_FILES["fileInput"]["tmp_name"][$key];
            $file_path = "../assets/img/emaildocument/".time().basename($file_name);

            if (move_uploaded_file($file_tmp, $file_path)) {
                $attachmentPaths[] = $file_path;
            }
        }
    }

    $attachmentString = implode("||", $attachmentPaths);


    $sql = "INSERT INTO reply_mail (mail_id, sender_email, reply_subject, reply_message, actionType, fileInput) VALUES ('$mailId', '$senderEmail', '$subject', '$message','$actionType', '$attachmentString')";

    if ($conn->query($sql) === TRUE) {
        $mail_id = $conn->insert_id;
        echo json_encode(["status" => "success", "message" => "Mail sent successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}

?>

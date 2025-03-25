<?php
header('Content-Type: application/json');
session_start();
include("../include/connection.php");
date_default_timezone_set('Asia/Kolkata');

$sender_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $toEmails = is_array($_POST['tomail']) ? implode(',', $_POST['tomail']) : $_POST['tomail'];
    $ccEmails = isset($_POST['ccmail']) && is_array($_POST['ccmail']) ? implode(',', $_POST['ccmail']) : $_POST['ccmail'];  
    $bccEmails = isset($_POST['bccmail']) && is_array($_POST['bccmail']) ? implode(',', $_POST['bccmail']) : $_POST['bccmail'];

    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // $attachmentPath = '';
    // if (!empty($_FILES["fileInput"]["name"])) { 
    //     $file_name = basename($_FILES["fileInput"]["name"]);
    //     $file_path = "../assets/img/emaildocument/" . $file_name;
    //     if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $file_path)) {
    //         $attachmentPath = $file_path;
    //     }
    // }

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


    $sql = "INSERT INTO mail (sender_id, to_ids, cc_ids, bcc_ids, subject, message, attachments, status) VALUES ('$sender_id', '$toEmails', '$ccEmails', '$bccEmails','$subject', '$message', '$attachmentString', 'pending')";
    if ($conn->query($sql) === TRUE) {
        $mail_id = $conn->insert_id;
        echo json_encode(["status" => "success", "message" => "Email scheduled. You have 5 seconds to undo.", "mail_id" => $mail_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}

?>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../include/connection.php");
    $emp_id = $_SESSION['id'];

    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($message)) {
        $query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES ('$incoming_id', '$emp_id', '$message')";
        if (mysqli_query($conn, $query)) {
            echo "Message sent!";
        } else {
            echo "Failed to send!";
        }
    } else {
        echo "Message cannot be empty!";
    }
}
?>
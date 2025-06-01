<?php
session_start();
include("../include/connection.php");

$emp_id = $_SESSION['id'];
$searchQuery = isset($_POST['searchQuery']) ? mysqli_real_escape_string($conn, $_POST['searchQuery']) : '';

$sql1 = "SELECT * FROM employee WHERE NOT id = '$emp_id' AND (fname LIKE '%$searchQuery%' OR lname LIKE '%$searchQuery%') ORDER BY fname ASC";
$query1 = mysqli_query($conn, $sql1);

$output = "";
if(mysqli_num_rows($query1) == 0){
    $output .= "<p class='text-muted px-3 py-2'>No users found</p>";
} else {
    while ($row1 = mysqli_fetch_assoc($query1)) {
        // Fetch last message
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row1['id']} OR outgoing_msg_id = {$row1['id']}) 
                 AND (outgoing_msg_id = {$emp_id} OR incoming_msg_id = {$emp_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        
        $result = (mysqli_num_rows($query2) > 0) ? $row2['msg'] : "No message available";
        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;
        $you = isset($row2['outgoing_msg_id']) && ($emp_id == $row2['outgoing_msg_id']) ? "You: " : "";

        // Online status check
        $status_class = ($row1['online_status'] == "Online") ? "bg-success" : "bg-danger";

        $output .= '<a href="message.php?user_id='. $row1['id'] .'" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="chat-avtar">
                                <img src="'. $row1['emp_photo'] .'" class="rounded-circle img-fluid wid-40" alt="user image" />
                                <div class="chat-badge '.$status_class.'"></div>
                            </div>
                            <div class="flex-grow-1 mx-2">
                                <h6 class="mb-0">'. $row1['fname'].'</h6>
                                <span class="text-sm text-muted">
                                    '. $you . $msg .'
                                </span>
                            </div>
                        </div>
                    </a>';
    }
}
echo $output;
?>

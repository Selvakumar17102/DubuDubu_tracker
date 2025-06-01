<?php
    while($row1 = mysqli_fetch_assoc($query1)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row1['id']}
                OR outgoing_msg_id = {$row1['id']}) AND (outgoing_msg_id = {$emp_id} 
                OR incoming_msg_id = {$emp_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        if(isset($row2['outgoing_msg_id'])){
            ($emp_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        ($row1['online_status'] == "Offline") ? $offline = "Offline" : $offline = "";
        ($emp_id == $row1['id']) ? $hid_me = "hide" : $hid_me = "";
        
        $file_path = $row1['emp_photo'];
        if (!file_exists($file_path)) {
            $file_path = 'https://i.pinimg.com/736x/13/54/3c/13543c08374378ff080f1d0c8764b613.jpg'; 
        }
        $status_class = ($row1['online_status'] == "Online") ? "bg-success" : "bg-danger";

        $output .= '<a href="message.php?user_id='. $row1['id'] .'" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="chat-avtar">
                                <img src="'. $file_path .'" class="rounded-circle img-fluid wid-40 hei-40" alt="user image"/>
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
?>

                                                            
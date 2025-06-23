<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$dashboard = "active";
$dashboardBoolean = 'true';
$dash_show = 'show';
$mess_apply = 'active';

$emp_id = $_SESSION['id'];

$sql = mysqli_query($conn, "SELECT * FROM employee WHERE id = $emp_id");
if(mysqli_num_rows($sql) > 0){
  $row = mysqli_fetch_assoc($sql);
}

?>


<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->
    <head>
        <title>Chat</title>
        <!-- [Meta] -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
        <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
        <meta name="author" content="Phoenixcoded" />
        <!-- [Favicon] icon -->
        <link href="assets/img/favicon.png" rel="shortcut icon" />
        <!-- [Font] Family -->
        <link rel="stylesheet" href="assets_new/fonts/inter/inter-2.css" id="main-font-link" />
        <!-- [phosphor Icons] https://phosphoricons.com/ -->
        <link rel="stylesheet" href="assets_new/fonts/phosphor/duotone/style-2.css" />
        <!-- [Tabler Icons] https://tablericons.com -->
        <link rel="stylesheet" href="assets_new/fonts/tabler-icons.min-2.css" />
        <!-- [Feather Icons] https://feathericons.com -->
        <link rel="stylesheet" href="assets_new/fonts/feather-2.css" />
        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link rel="stylesheet" href="assets_new/fonts/fontawesome-2.css" />
        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link rel="stylesheet" href="assets_new/fonts/material-2.css" />
        <!-- [Template CSS Files] -->
        <link rel="stylesheet" href="assets_new/css/style-2.css" id="main-style-link" />
        <script src="assets_new/js/tech-stack-2.js"></script>
        <link rel="stylesheet" href="assets_new/css/style-preset-2.css" />
    </head>

    <body >
        <div class="container-fluid">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="chat-wrapper">
                            <div class="offcanvas-xxl offcanvas-start chat-offcanvas" tabindex="-1" id="offcanvas_User_list">
                                <div class="offcanvas-header"><button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_User_list" aria-label="Close"></button></div>
                                <div class="offcanvas-body p-0">
                                    <div id="chat-user_list" class="show collapse collapse-horizontal">
                                        <div class="chat-user_list">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <h5 class="mb-4">Messages <!-- <span class="avtar avtar-xs bg-light-primary rounded-circle">9</span> --></h5>
                                                    <div class="form-search"><i class="ti ti-search"></i> <input type="search" id="searchUser" class="form-control" placeholder="Search Followers" /></div>
                                                </div>
                                                <div class="scroll-block">
                                                    <div class="card-body p-0">
                                                        <div class="list-group list-group-flush" id="list-group">
                                                            <?php
                                                            $sql1 = "SELECT * FROM employee WHERE NOT id = '$emp_id' ORDER BY fname ASC";
                                                            $query1 = mysqli_query($conn, $sql1);

                                                            $output = "";
                                                            if(mysqli_num_rows($query1) == 0){
                                                                $output .= "No users are available to chat";
                                                            }elseif(mysqli_num_rows($query1) > 0){
                                                                include_once "data.php";
                                                            }
                                                            echo $output;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="list-group list-group-flush">
                                                        <div class="list-group-item">
                                                            <div class="d-flex align-items-center">
                                                                <div class="chat-avtar"><img class="rounded-circle img-fluid wid-40" src="<?= $row['emp_photo']?>" alt="User image" /> <i class="chat-badge bg-success"></i></div>
                                                                <div class="flex-grow-1 mx-3"><h6 class="mb-0"><?= $row['fname'].' '.$row['lname'];?></h6></div>
                                                                <div class="dropdown">
                                                                    <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti ti-chevron-right f-16"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#"><i class="chat-badge bg-warning"></i> Go Offline</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="logOut()"><i class="chat-badge bg-danger"></i> Logout</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if($_GET['user_id']){
                            ?>
                            <div class="chat-content">
                                <div class="card mb-0">

                                    <div class="card-header p-3">
                                        <div class="d-flex align-items-center">
                                            <ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom">
                                                    <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_User_list"><i class="ti ti-menu-2 f-18"></i> </a>
                                                    <a href="#" class="d-none d-xxl-inline-flex avtar avtar-s btn-link-secondary" data-bs-toggle="collapse" data-bs-target="#chat-user_list"><i class="ti ti-menu-2 f-18"></i></a>
                                                </li>
                                                <?php 
                                                    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                                                    $sql3 = "SELECT e.*, d.designation_name FROM employee e LEFT JOIN designation d ON e.designation = d.desig_id WHERE e.id = '$user_id'";
                                                    $result3 = $conn->query($sql3);
                                                    if($result3->num_rows > 0){
                                                        $row3 = mysqli_fetch_assoc($result3);
                                                    }
                                                    $status_color = ($row3['online_status'] == "Online") ? "bg-success" : "bg-danger";
                                                ?>
                                                <li class="list-inline-item">
                                                    <div class="d-flex align-items-center">
                                                        <div class="chat-avtar">
                                                            <img class="rounded-circle img-fluid wid-40" src="<?= $row3['emp_photo']; ?>" alt="User image" />
                                                             <i class="chat-badge <?= $status_color; ?>"></i>
                                                        </div>
                                                        <div class="flex-grow-1 mx-3 d-none d-sm-inline-block">
                                                            <h6 class="mb-0"><?= $row3['fname']. " " . $row3['lname'] ?></h6>
                                                            <span class="text-sm text-muted"><?= $row3['designation_name']; ?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="list-inline ms-auto mb-0">
                                                <li class="list-inline-item">
                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-phone-call f-18"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-video f-18"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_User_info"><i class="ti ti-info-circle f-18"></i> </a>
                                                    <a href="#" class="d-none d-xxl-inline-flex avtar avtar-s btn-link-secondary" data-bs-toggle="collapse" data-bs-target="#chat-user_info"><i class="ti ti-info-circle f-18"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="scroll-block chat-message">
                                        <div class="card-body">
                                            <div id="get_chat">
                                                <?php
                                                    $outgoing_id = $_SESSION['id'];
                                                    $incoming_id = $user_id;

                                                    $sql5 = "SELECT * FROM messages LEFT JOIN employee ON employee.id = messages.outgoing_msg_id
                                                    WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                                                    OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
                                                    $query5 = mysqli_query($conn, $sql5);
                                                    if(mysqli_num_rows($query5) > 0){
                                                        while($row5 = mysqli_fetch_assoc($query5)){
                                                            if($row5['outgoing_msg_id'] === $outgoing_id){
                                                            ?>
                                                                <div class="message-out">
                                                                    <div class="d-flex align-items-end flex-column">
                                                                        <p class="mb-1 text-muted"><small>9h ago</small></p>
                                                                        <div class="message d-flex align-items-end flex-column">
                                                                            <div class="d-flex align-items-center mb-1 chat-msg">
                                                                                <div class="flex-shrink-0">
                                                                                    <ul class="list-inline ms-auto mb-0 chat-msg-option">
                                                                                        <li class="list-inline-item">
                                                                                            <div class="dropdown">
                                                                                                <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    <i class="ti ti-dots-vertical f-18"></i>
                                                                                                </a>
                                                                                                <div class="dropdown-menu">
                                                                                                    <a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up"></i> Reply</a>
                                                                                                    <a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up"></i> Forward</a> <a class="dropdown-item" href="#"><i class="ti ti-copy"></i> Copy</a>
                                                                                                    <a class="dropdown-item" href="#"><i class="ti ti-trash"></i> Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-edit-circle f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-3">
                                                                                    <div class="msg-content bg-primary">
                                                                                        <p class="mb-0"><?= $row5['msg'];?></p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }else{
                                                                ?>
                                                                <div class="message-in">
                                                                    <div class="d-flex">
                                                                        <div class="flex-shrink-0">
                                                                            <div class="chat-avtar">
                                                                                <img class="rounded-circle img-fluid wid-40" src="<?= $row5['emp_photo'];?>" alt="User image" /> 
                                                                                <i class="chat-badge bg-success"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 mx-3">
                                                                            <div class="d-flex align-items-start flex-column">
                                                                                <p class="mb-1 text-muted">Agilulf Fuxg <small>11:23 AM</small></p>
                                                                                <div class="message d-flex align-items-start flex-column">
                                                                                    <div class="d-flex align-items-center mb-1 chat-msg">
                                                                                        <div class="flex-grow-1 me-3">
                                                                                            <div class="msg-content card mb-0">
                                                                                                <p class="mb-0"><?= $row5['msg'];?> </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="flex-shrink-0">
                                                                                            <ul class="list-inline ms-auto mb-0 chat-msg-option">
                                                                                                <li class="list-inline-item">
                                                                                                    <div class="dropdown">
                                                                                                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                            <i class="ti ti-dots-vertical f-18"></i>
                                                                                                        </a>
                                                                                                        <div class="dropdown-menu">
                                                                                                            <a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up"></i> Reply</a>
                                                                                                            <a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up"></i> Forward</a>
                                                                                                            <a class="dropdown-item" href="#"><i class="ti ti-copy"></i> Copy</a> <a class="dropdown-item" href="#"><i class="ti ti-trash"></i> Delete</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-edit-circle f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    }else{
                                                        ?>
                                                        <div class="row g-0 justify-content-center align-items-center h-100">
                                                            <div class="col-md-8 col-sm-10 text-center">
                                                                <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                                                <h2><b>There is No Message</b></h2>
                                                                <p class="mb-0 text-muted">When You have message that will Display here</p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer py-2 px-3">
                                        <form method="POST" class="typing-area">
                                            <input type="hidden" class="incoming_id" name="incoming_id" value="<?= $_GET['user_id']; ?>" >
                                            <textarea class="form-control border-0 shadow-none message" name="message"  placeholder="Type a Message" rows="1"></textarea>
                                            <hr class="my-2" />
                                            <div class="d-sm-flex align-items-center">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-photo f-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-mood-smile f-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-volume f-18"></i></a>
                                                    </li>
                                                </ul>
                                                <ul class="list-inline ms-auto mb-0">
                                                    <li class="list-inline-item">
                                                        <button type="submit" class="avtar avtar-s btn-link-primary"><i class="ti ti-send f-18"></i></button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <?php
                            }else{
                                ?>
                                <div class="row g-0 justify-content-center align-items-center h-100">
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                        <h2><b>There is No Message</b></h2>
                                        <p class="mb-0 text-muted">When You have message that will Display here</p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="offcanvas-xxl offcanvas-end chat-offcanvas" tabindex="-1" id="offcanvas_User_info">
                                <div class="offcanvas-header"><button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_User_info" aria-label="Close"></button></div>
                                <div class="offcanvas-body p-0">
                                    <div id="chat-user_info" class="collapse collapse-horizontal">
                                        <div class="chat-user_info">
                                            <div class="card">
                                                <div class="text-center card-body position-relative pb-0">
                                                    <h5 class="text-start">Profile View</h5>
                                                    <div class="position-absolute end-0 top-0 p-3 d-none d-xxl-inline-flex">
                                                        <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="collapse" data-bs-target="#chat-user_info"><i class="ti ti-x f-16"></i></a>
                                                    </div>
                                                    <div class="chat-avtar d-inline-flex mx-auto"><img class="rounded-circle img-fluid wid-100" src="assets_new/images/user/avatar-5-2.jpg" alt="User image" /></div>
                                                    <h5 class="mb-0">Alene</h5>
                                                    <p class="text-muted text-sm">Sr. Customer Manager</p>
                                                    <div class="d-flex align-items-center justify-content-center mb-4"><i class="chat-badge bg-success me-2"></i> <span class="badge bg-light-success">Available</span></div>
                                                    <ul class="list-inline ms-auto mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-phone-call f-18"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-message-circle f-18"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-video f-18"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="scroll-block">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-6">
                                                                <div class="p-3 rounded bg-light-primary">
                                                                    <p class="mb-1">All File</p>
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="ti ti-folder f-22 text-primary"></i>
                                                                        <h4 class="mb-0 ms-2">231</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="p-3 rounded bg-light-secondary">
                                                                    <p class="mb-1">All Link</p>
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="ti ti-link f-22 text-secondary"></i>
                                                                        <h4 class="mb-0 ms-2">231</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch d-flex align-items-center justify-content-between p-0">
                                                            <label class="form-check-label h5 mb-0" for="customSwitchemlnot1">Notification</label>
                                                            <input class="form-check-input h5 m-0 position-relative" type="checkbox" id="customSwitchemlnot1" checked="" />
                                                        </div>
                                                        <hr class="my-3 border border-secondary-subtle" />
                                                        <a class="btn border-0 p-0 text-start w-100" data-bs-toggle="collapse" href="#filtercollapse1">
                                                            <div class="float-end"><i class="ti ti-chevron-down"></i></div>
                                                            <h5 class="mb-0">Information</h5>
                                                        </a>
                                                        <div class="collapse show" id="filtercollapse1">
                                                            <div class="py-3">
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <p class="mb-0">Address</p>
                                                                    <p class="mb-0 text-muted">Port Narcos</p>
                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <p class="mb-0">Email</p>
                                                                    <p class="mb-0 text-muted">
                                                                        <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="dabbb6bfb4bf9ab9b5b7aabbb4a3f4b9b5b7">[email&#160;protected]</a>
                                                                    </p>
                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <p class="mb-0">Phone</p>
                                                                    <p class="mb-0 text-muted">380-293-0177</p>
                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <p class="mb-0">Last visited</p>
                                                                    <p class="mb-0 text-muted">2 hours</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="my-3 border border-secondary-subtle" />
                                                        <a class="btn border-0 p-0 text-start w-100" data-bs-toggle="collapse" href="#filtercollapse2">
                                                            <div class="float-end"><i class="ti ti-chevron-down"></i></div>
                                                            <h5 class="mb-0">File type</h5>
                                                        </a>
                                                        <div class="collapse show" id="filtercollapse2">
                                                            <div class="py-3">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <a href="#" class="avtar avtar-s btn-light-success"><i class="ti ti-file-text f-20"></i></a>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6 class="mb-0">Document</h6>
                                                                        <span class="text-muted text-sm">123 files, 193MB</span>
                                                                    </div>
                                                                    <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-chevron-right f-16"></i></a>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <a href="#" class="avtar avtar-s btn-light-warning"><i class="ti ti-photo f-20"></i></a>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6 class="mb-0">Photos</h6>
                                                                        <span class="text-muted text-sm">53 files, 321MB</span>
                                                                    </div>
                                                                    <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-chevron-right f-16"></i></a>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <a href="#" class="avtar avtar-s btn-light-primary"><i class="ti ti-id f-20"></i></a>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6 class="mb-0">Other</h6>
                                                                        <span class="text-muted text-sm">49 files, 193MB</span>
                                                                    </div>
                                                                    <a href="#" class="avtar avtar-xs btn-link-secondary"><i class="ti ti-chevron-right f-16"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ sample-page ] end -->
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
        <!-- [ Main Content ] footer end -->
       
        <!-- Required Js -->
        <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min-2.js"></script>
        <script src="assets_new/js/plugins/popper.min-2.js"></script>
        <script src="assets_new/js/plugins/simplebar.min-2.js"></script>
        <script src="assets_new/js/plugins/bootstrap.min-2.js"></script>
        <script src="assets_new/js/fonts/custom-font-2.js"></script>
        <script src="assets_new/js/pcoded-2.js"></script>
        <script src="assets_new/js/plugins/feather.min-2.js"></script>
        <script src="assets_new/js/manual.js"></script>
       
        <script>layout_change("light");</script>
        <script>change_box_container("false");</script>
        <script>layout_caption_change("true");</script>
        <script>layout_rtl_change("false");</script>
        <script>preset_change("preset-1");</script>
        <script>main_layout_change("vertical");</script>
        <script>
            var tc = document.querySelectorAll(".scroll-block");
            for (var t = 0; t < tc.length; t++) {
                new SimpleBar(tc[t]);
            }
            setTimeout(function () {
                var element = document.querySelector(".chat-content .scroll-block .simplebar-content-wrapper");
                var elementheight = document.querySelector(".chat-content .scroll-block .simplebar-content");
                var off = elementheight.getBoundingClientRect();
                var h = off.height;
                element.scrollTop += h;
            }, 100);
        </script>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function logOut(){
        $.ajax({
            type: "POST",
            url: "ajax/logoutCheck.php",
            success: function(data){
                if(data == 'success'){
                    localStorage.removeItem('id')
                    localStorage.removeItem('token')
                    location.replace('./')
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $("#searchUser").on("keyup", function() {
            var searchText = $(this).val();
            
            $.ajax({
                url: "ajax/search_users.php",
                type: "POST",
                data: { searchQuery: searchText },
                success: function(response) {
                    $("#list-group").html(response);
                }
            });
        });
    });

</script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
        setInterval(function(){
            console.log("Running setInterval..."); // Check if this logs

            var iframe = document.getElementById("get_chat");
            if (!iframe) {
                console.warn("Iframe not found");
                return;
            }

            if (!iframe.contentWindow) {
                console.warn("Iframe contentWindow is not accessible");
                return;
            }

            iframe.contentWindow.location.reload();
            console.log("demoooooooooooooooo");
        }, 500);
    });

</script>

<script>
    document.querySelector(".typing-area").addEventListener("submit", function(event) {
        event.preventDefault(); 

        let formData = new FormData(this); 

        fetch("ajax/process_message.php", { 
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            this.reset();
        })
        .catch(error => console.error("Error:", error));
    });
</script>

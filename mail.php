<?php
session_start();
ini_set("display_errors",'on');
include("include/connection.php");
$dashboard = "active";
$dashboardBoolean = 'true';
$dash_show = 'show';
$mail_apply = 'active';

$today = date('Y-m-d');
$today1 = date('d-m-Y');

$id = $_SESSION['id'];

$sql = "SELECT COUNT(*) AS mail_count FROM mail 
        WHERE (FIND_IN_SET($id, to_ids) OR FIND_IN_SET($id, cc_ids) OR FIND_IN_SET($id, bcc_ids)) 
        AND status = 'sent' 
        AND (is_read IS NULL OR NOT FIND_IN_SET($id, is_read)) AND (deleted_at IS NULL OR NOT FIND_IN_SET($id, deleted_at))";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$sql1 = "SELECT COUNT(*) AS trashmail_count FROM mail WHERE FIND_IN_SET($id, deleted_at)";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();




?>

<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->
    <head>
        <title>Mail</title>
        <!-- [Meta] -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
        <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
        <meta name="author" content="Phoenixcoded" />
        <!-- [Favicon] icon -->
        <link href="assets/img/favicon.png" rel="shortcut icon" />

        <link rel="stylesheet" href="assets_new/css/plugins/dragula.min.css" />
        <link rel="stylesheet" href="assets_new/css/plugins/quill.core.css" />
        <link rel="stylesheet" href="assets_new/css/plugins/quill.snow.css" />
        <link rel="stylesheet" href="assets_new/css/plugins/quill.bubble.css" />
        <link rel="stylesheet" href="assets_new/fonts/inter/inter-2.css" id="main-font-link" />
        <link rel="stylesheet" href="assets_new/fonts/phosphor/duotone/style-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/tabler-icons.min-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/feather-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/fontawesome-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/material-2.css" />
        <link rel="stylesheet" href="assets_new/css/style-2.css" id="main-style-link" />
        <script src="assets_new/js/tech-stack-2.js"></script>
        <link rel="stylesheet" href="assets_new/css/style-preset-2.css" />

        <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
	    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

        
    </head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tabler-icons@1.39.1/iconfont/tabler-icons.min.css">
    <style>
        .file-icon {
            cursor: pointer;
            font-size: 24px;
        }
    </style>
    <style>
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            border: 1px solid #eeeeee !important;
            width: 100%;
            border-radius: 15px;
        }
    </style>
    <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
       
        <div class="container-fluid">
            
            <div class="content">
                <!-- [ Main Content ] start -->
                <div class="row">
                    <!-- [ sample-page ] start -->
                    <div class="col-sm-12">
                        <div class="mail-wrapper">
                            <div class="offcanvas-xxl offcanvas-start mail-offcanvas" tabindex="-1" id="offcanvas_mail">
                                <div class="offcanvas-header"><button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_mail" aria-label="Close"></button></div>
                                <div class="offcanvas-body p-0">
                                    <div id="mail-menulist" class="show collapse collapse-horizontal">
                                        <div class="mail-menulist">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#compose_mail_modal">
                                                            <i class="ti ti-circle-plus me-2"></i> Compose
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="scroll-block">
                                                    <div class="card-body pt-0">
                                                        <div class="list-group list-group-flush" id="list-tab" role="tablist">
                                                            <a class="list-group-item list-group-item-action active" id="list-mailtab-1" data-bs-toggle="list" href="#list-mail-1" role="tab">
                                                                <span><i class="ti ti-inbox"></i> Inbox </span><span class="avtar avtar-xs"><?= $row['mail_count']; ?></span>
                                                            </a>
                                                            <a class="list-group-item list-group-item-action " id="list-mailtab-3" data-bs-toggle="list" href="#list-mail-3" role="tab">
                                                                <span><i class="ti ti-send"></i> Sent </span>
                                                            </a>
                                                            <a class="list-group-item list-group-item-action" id="list-mailtab-7" data-bs-toggle="list" href="#list-mail-7" role="tab">
                                                                <span><i class="ti ti-star"></i> Starred </span>
                                                            </a>
                                                            <a class="list-group-item list-group-item-action" id="list-mailtab-6" data-bs-toggle="list" href="#list-mail-6" role="tab">
                                                                <span><i class="ti ti-trash"></i> Trash </span><span class="avtar avtar-xs"><?= $row1['trashmail_count']; ?></span>
                                                            </a>
                                                            <hr class="my-3 border border-secondary-subtle" />
                                                                <!-- <a class="list-group-item list-group-item-action d-none" id="list-mailtab-details" data-bs-toggle="list" href="#list-mail-9" role="tab"></a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mail-content">
                                <div class="d-sm-flex align-items-center">
                                    <ul class="list-inline me-auto mb-3">
                                        <li class="list-inline-item align-bottom">
                                            <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_mail"><i class="ti ti-menu-2 f-18"></i> </a>
                                            <a href="#" class="d-none d-xxl-inline-flex avtar avtar-s btn-link-secondary" data-bs-toggle="collapse" data-bs-target="#mail-menulist"><i class="ti ti-menu-2 f-18"></i></a>
                                        </li>
                                        <li class="list-inline-item align-bottom">
                                            <a href="#" class="avtar avtar-s btn-link-secondary" id="toggle-mail-list-height"><i class="ti ti-arrows-vertical f-18"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="dropdown">
                                                <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti ti-dots f-18"></i></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Name</a> <a class="dropdown-item" href="#">Date</a> <a class="dropdown-item" href="#">Ratting</a> <a class="dropdown-item" href="#">Unread</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-inline ms-auto mb-3">
                                        <li class="list-inline-item">
                                            <div class="form-search"><i class="ti ti-search"></i> <input type="search" class="form-control" placeholder="Search Followers" /></div>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-chevron-left f-18"></i></a>
                                        </li>
                                        <li class="list-inline-item">1–10 of 12</li>
                                        <li class="list-inline-item">
                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-chevron-right f-18"></i></a>
                                        </li>
                                    </ul>
                                    <a href="javascript:history.go(-1)" class="btn btn-primary">Back</a>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content" id="nav-tabContent">

                                            <!-- inbox start section -->
                                            <div class="tab-pane fade  show active" id="list-mail-1" role="tabpanel" aria-labelledby="list-mailtab-1">
                                                <div class="card table-card">
                                                    <div class="card-body scroll-block">
                                                        <div class="tab-content">
                                                            <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <?php
                                                                        $inboxSql = "SELECT * FROM mail WHERE (FIND_IN_SET($id, to_ids) OR FIND_IN_SET($id, cc_ids) OR FIND_IN_SET($id, bcc_ids)) AND status = 'sent' AND (deleted_at IS NULL OR NOT FIND_IN_SET($id, deleted_at))";
                                                                        $inboxRes = $conn->query($inboxSql);
                                                                        if($inboxRes->num_rows){
                                                                            while($inboxRow = mysqli_fetch_array($inboxRes)){
                                                                                $to = $inboxRow['to_ids'];
                                                                                $isRead = !empty($inboxRow['is_read']) && in_array($id, explode(',', $inboxRow['is_read']));
                                                                            ?>
                                                                            
                                                                            <tr class="<?= $isRead ? 'read' : 'unread'; ?>">
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                            <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                            <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input star-checkbox" type="checkbox" data-mail-id="<?= $inboxRow['mail_id']; ?>" <?= in_array($id, explode(',', $inboxRow['starred'])) ? 'checked' : ''; ?> />
                                                                                            <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                            <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="mail-row" data-id="<?= $inboxRow['mail_id']; ?>" >
                                                                                    <div class="d-flex align-items-center">
                                                                                    <?php
                                                                                        $namesql = "SELECT * FROM employee WHERE id IN ($to)";
                                                                                        $nameRes = $conn->query($namesql);
                                                                                        $names = [];
                                                                                        while($nameRow = mysqli_fetch_array($nameRes)){
                                                                                            $names[] = $nameRow['fname'];
                                                                                        }
                                                                                        $formattedNames = implode(", ", $names);
                                                                                    ?>
                                                                                        <!-- <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" /> -->
                                                                                        <h6 class="mb-0 ms-2 text-truncate"><strong>To:</strong> <?= $formattedNames; ?></h6>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex w-100 align-items-center">
                                                                                        <div class="flex-grow-1 position-relative">
                                                                                            <p class="mb-0 mail-text text-truncate"><?= $inboxRow['subject']; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $attachments = $inboxRow['attachments'];
                                                                                    $attachmentArray = explode("||", $attachments); 
                                                                                    foreach ($attachmentArray as $file) {
                                                                                        ?>
                                                                                        <a href="<?= "DubuDubu_tracker/".$file; ?>" target="_blank" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td class="mail-option">
                                                                                    <?= date("d M y h:i A", strtotime($inboxRow['created_at'])); ?>
                                                                                    <div class="mail-buttons">
                                                                                        <ul class="list-inline mb-0">
                                                                                            <li class="list-inline-item">
                                                                                                <a href="#" class="avtar avtar-s btn-link-secondary delete-email" data-mail-id="<?= $inboxRow['mail_id']; ?>">
                                                                                                    <i class="ti ti-trash f-18"></i>
                                                                                                </a>
                                                                                            </li>

                                                                                            <li class="list-inline-item">
                                                                                                <a href="#" class="avtar avtar-s btn-link-secondary toggle-read" data-mail-id="<?= $inboxRow['mail_id']; ?>"><i class="ti <?= $isRead ? 'ti-eye' : 'ti-eye-off'; ?> f-18"></i></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>

                                                                            <?php
                                                                            }
                                                                        }else{
                                                                            ?>
                                                                            <div class="row g-0 justify-content-center align-items-center h-100">
                                                                                <div class="col-md-8 col-sm-10 text-center">
                                                                                    <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                                                                    <h2><b>There is No Mail</b></h2>
                                                                                    <p class="mb-0 text-muted">When You have message that will Display here</p>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- inbox end section -->

                                            <!-- sent start section -->
                                            <div class="tab-pane fade" id="list-mail-3" role="tabpanel" aria-labelledby="list-mailtab-3">
                                                <div class="card table-card">
                                                    <div class="card-body scroll-block">
                                                        <table class="table table-borderless mb-0 mail-table">
                                                            <tbody>
                                                                <?php
                                                                $sentsql = "SELECT * FROM mail WHERE sender_id = '$id' AND status = 'sent' AND (deleted_at IS NULL OR NOT FIND_IN_SET($id, deleted_at))";
                                                                $sentRes = $conn->query($sentsql);
                                                                if($sentRes->num_rows){
                                                                    while($sentRow = mysqli_fetch_array($sentRes)){
                                                                        $to = $sentRow['to_ids'];
                                                                        $isRead = !empty($sentRow['is_read']) && in_array($id, explode(',', $sentRow['is_read']));
                                                                    ?>
                                                                    <tr class="<?= $isRead ? 'read' : 'unread'; ?>">
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                    <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                    <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                </div>
                                                                                <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                    <input class="form-check-input star-checkbox" type="checkbox" data-mail-id="<?= $sentRow['mail_id']; ?>" <?= in_array($id, explode(',', $sentRow['starred'])) ? 'checked' : ''; ?> />
                                                                                    <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                    <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td  class="mail-row" data-id="<?= $sentRow['mail_id']; ?>">
                                                                            <div class="d-flex align-items-center">
                                                                                <?php
                                                                                $namesql = "SELECT * FROM employee WHERE id IN ($to)";
                                                                                $nameRes = $conn->query($namesql);
                                                                                $names = [];
                                                                                while($nameRow = mysqli_fetch_array($nameRes)){
                                                                                    $names[] = $nameRow['fname'];
                                                                                }
                                                                                $formattedNames = implode(", ", $names);
                                                                                ?>
                                                                                <!-- <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" /> -->
                                                                                <h6 class="mb-0 mail-text text-truncate"><strong>To:</strong> <?= $formattedNames; ?></h6>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex w-100 align-items-center">
                                                                                <div class="flex-grow-1 position-relative">
                                                                                    <p class="mb-0 mail-text text-truncate"><?= $sentRow['subject']; ?></p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                                $attachments = $sentRow['attachments'];
                                                                                $attachmentArray = explode("||", $attachments); 
                                                                                foreach ($attachmentArray as $file) {
                                                                                    ?>
                                                                                    <a href="<?= "DubuDubu_tracker/".$file; ?>" target="_blank" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </td>
                                                                        <td class="mail-option">
                                                                        <?= date("d M y h:i A", strtotime($sentRow['created_at'])); ?>
                                                                            <div class="mail-buttons">
                                                                                <ul class="list-inline mb-0">
                                                                                    <li class="list-inline-item">
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary delete-email" data-mail-id="<?= $sentRow['mail_id']; ?>">
                                                                                            <i class="ti ti-trash f-18"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary toggle-read" data-mail-id="<?= $sentRow['mail_id']; ?>"><i class="ti <?= $isRead ? 'ti-eye' : 'ti-eye-off'; ?> f-18"></i></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    }
                                                                }else{
                                                                    ?>
                                                                    <div class="row g-0 justify-content-center align-items-center h-100">
                                                                        <div class="col-md-8 col-sm-10 text-center">
                                                                            <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                                                            <h2><b>There is No Mail</b></h2>
                                                                            <p class="mb-0 text-muted">When You have message that will Display here</p>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- sent end section -->

                                            <!-- Star start section -->
                                            <div class="tab-pane fade" id="list-mail-7" role="tabpanel" aria-labelledby="list-mailtab-7">
                                                <div class="card table-card">
                                                    <div class="card-body scroll-block">
                                                        <table class="table table-borderless mb-0 mail-table">
                                                            <tbody>
                                                                <?php
                                                                $starSql = "SELECT * FROM mail WHERE FIND_IN_SET($id, starred) AND (deleted_at IS NULL OR NOT FIND_IN_SET($id, deleted_at))";
                                                                $starRes = $conn->query($starSql);
                                                                if($starRes->num_rows){
                                                                    while($starRow = mysqli_fetch_array($starRes)){
                                                                        $to = $starRow['to_ids'];
                                                                        $isRead = !empty($starRow['is_read']) && in_array($id, explode(',', $starRow['is_read']));
                                                                    ?>
                                                                <tr class="<?= $isRead ? 'read' : 'unread'; ?>">
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                            </div>
                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                <input class="form-check-input star-checkbox" type="checkbox" data-mail-id="<?= $starRow['mail_id']; ?>" <?= in_array($id, explode(',', $starRow['starred'])) ? 'checked' : ''; ?> />
                                                                                <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="mail-row" data-id="<?= $starRow['mail_id']; ?>" >
                                                                        <div class="d-flex align-items-center">
                                                                        <?php
                                                                            $namesql = "SELECT * FROM employee WHERE id IN ($to)";
                                                                            $nameRes = $conn->query($namesql);
                                                                            $names = [];
                                                                            while($nameRow = mysqli_fetch_array($nameRes)){
                                                                                $names[] = $nameRow['fname'];
                                                                            }
                                                                            $formattedNames = implode(", ", $names);
                                                                        ?>
                                                                            <!-- <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" /> -->
                                                                            <h6 class="mb-0 ms-2 text-truncate"><strong>To:</strong> <?= $formattedNames; ?></h6>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex w-100 align-items-center">
                                                                            <div class="flex-grow-1 position-relative">
                                                                                <p class="mb-0 mail-text text-truncate"><?= $starRow['subject']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $attachments = $starRow['attachments'];
                                                                        $attachmentArray = explode("||", $attachments); 
                                                                        foreach ($attachmentArray as $file) {
                                                                            ?>
                                                                            <a href="<?= "DubuDubu_tracker/".$file; ?>" target="_blank" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="mail-option">
                                                                        <?= date("d M y h:i A", strtotime($starRow['created_at'])); ?>
                                                                        <div class="mail-buttons">
                                                                            <ul class="list-inline mb-0">
                                                                                <li class="list-inline-item">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary delete-email" data-mail-id="<?= $starRow['mail_id']; ?>">
                                                                                        <i class="ti ti-trash f-18"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="list-inline-item">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary toggle-read" data-mail-id="<?= $sentRow['mail_id']; ?>"><i class="ti <?= $isRead ? 'ti-eye' : 'ti-eye-off'; ?> f-18"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                                }else{
                                                                ?>
                                                                <div class="row g-0 justify-content-center align-items-center h-100">
                                                                    <div class="col-md-8 col-sm-10 text-center">
                                                                        <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                                                        <h2><b>There is No Mail</b></h2>
                                                                        <p class="mb-0 text-muted">When You have message that will Display here</p>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- star end section -->

                                            <!-- trash start section -->
                                            <div class="tab-pane fade" id="list-mail-6" role="tabpanel" aria-labelledby="list-mailtab-6">
                                                <div class="card table-card">
                                                    <div class="card-body scroll-block">
                                                        <table class="table table-borderless mb-0 mail-table">
                                                            <tbody>
                                                            <?php
                                                                $trashSql = "SELECT * FROM mail WHERE FIND_IN_SET($id, deleted_at)";
                                                                $trashRes = $conn->query($trashSql);
                                                                if($trashRes->num_rows){
                                                                    while($trashRow = mysqli_fetch_array($trashRes)){
                                                                        $to = $trashRow['to_ids'];
                                                                        $isRead = !empty($trashRow['is_read']) && in_array($id, explode(',', $trashRow['is_read']));
                                                                    ?>
                                                                <tr class="<?= $isRead ? 'read' : 'unread'; ?>">
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                            </div>
                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                <input class="form-check-input star-checkbox" type="checkbox" data-mail-id="<?= $trashRow['mail_id']; ?>" <?= in_array($id, explode(',', $trashRow['starred'])) ? 'checked' : ''; ?> />
                                                                                 <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                    <td class="mail-row" data-id="<?= $trashRow['mail_id']; ?>" >
                                                                        <div class="d-flex align-items-center">
                                                                        <?php
                                                                            $namesql = "SELECT * FROM employee WHERE id IN ($to)";
                                                                            $nameRes = $conn->query($namesql);
                                                                            $names = [];
                                                                            while($nameRow = mysqli_fetch_array($nameRes)){
                                                                                $names[] = $nameRow['fname'];
                                                                            }
                                                                            $formattedNames = implode(", ", $names);
                                                                        ?>
                                                                            <!-- <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" /> -->
                                                                            <h6 class="mb-0 ms-2 text-truncate"><strong>To:</strong> <?= $formattedNames; ?></h6>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex w-100 align-items-center">
                                                                            <div class="flex-grow-1 position-relative">
                                                                                <p class="mb-0 mail-text text-truncate"><?= $trashRow['subject']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $attachments = $trashRow['attachments'];
                                                                        $attachmentArray = explode("||", $attachments); 
                                                                        foreach ($attachmentArray as $file) {
                                                                            ?>
                                                                            <a href="<?= "DubuDubu_tracker/".$file; ?>" target="_blank" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="mail-option">
                                                                        <?= date("d M y h:i A", strtotime($trashRow['created_at'])); ?>
                                                                        <div class="mail-buttons">
                                                                            <ul class="list-inline mb-0">
                                                                                <li class="list-inline-item">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                </li>
                                                                                <li class="list-inline-item">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary toggle-read" data-mail-id="<?= $sentRow['mail_id']; ?>"><i class="ti <?= $isRead ? 'ti-eye' : 'ti-eye-off'; ?> f-18"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                                }else{
                                                                ?>
                                                                <div class="row g-0 justify-content-center align-items-center h-100">
                                                                    <div class="col-md-8 col-sm-10 text-center">
                                                                        <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                                                        <h2><b>There is No Mail</b></h2>
                                                                        <p class="mb-0 text-muted">When You have message that will Display here</p>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- trash end section -->

                                            <!-- mail full detail view page start section -->
                                            <div class="tab-pane fade" id="list-mail-9" role="tabpanel" aria-labelledby="list-mailtab-details">
                                            </div>
                                            <!-- mail full details view page end section -->

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


        <div id="compose_mail_modal" class="modal fade compose_mail_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="flex-grow-1"><h5 class="modal-title">New Message</h5></div>
                        <ul class="list-inline me-auto mb-0">
                            <li class="list-inline-item align-bottom">
                                <a href="#" class="avtar avtar-s btn-link-secondary" id="toggle_mail_dialog"><i class="ti ti-arrows-diagonal-2 f-18"></i></a>
                            </li>
                            <li class="list-inline-item align-bottom">
                                <a href="#" class="avtar avtar-s btn-link-danger" data-bs-dismiss="modal"><i class="ti ti-circle-x f-18"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-body">
                        <div class="text-end">
                            <a data-bs-toggle="collapse" href="#collapsecc" role="button" aria-expanded="false">Cc</a> & 
                            <a data-bs-toggle="collapse" href="#collapsebcc" role="button" aria-expanded="false">Bcc</a>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tomail">To</label>
                            <!-- <input type="email" class="form-control" id="tomail" placeholder="Recipients" /> -->
                            <select name="tomail[]" id="tomail" class="selectpicker" multiple data-live-search="true" required>
                                <?php
                                
								$toSql = "SELECT * FROM employee WHERE id != '$id'";
								$toRes = $conn->query($toSql);
								while($toRow = mysqli_fetch_array($toRes)){
									?>
									<option value="<?php echo $toRow['id'];?>"><?php echo $toRow['oemail'];?></option>
									<?php
								}
								?>
							</select>
                        </div>
                        <div class="collapse" id="collapsecc">
                            <div class="mb-3">
                                <label class="form-label" for="ccmail">Cc</label>
                                <!-- <input type="email" class="form-control mb-3" id="ccmail" placeholder="Enter Cc email" /> -->
                                <select name="ccmail[]" id="ccmail" class="selectpicker" multiple data-live-search="true">
                                <?php
								$ccSql = "SELECT * FROM employee WHERE id != '$id'";
								$ccRes = $conn->query($ccSql);
								while($ccRow = mysqli_fetch_array($ccRes)){
									?>
									<option value="<?php echo $ccRow['id'];?>"><?php echo $ccRow['oemail'];?></option>
									<?php
								}
								?>
                                </select>
                            </div>
                        </div>
                        <div class="collapse" id="collapsebcc">
                            <div class="mb-3">
                                <label class="form-label" for="bccmail">Bcc</label> 
                                <!-- <input type="email" class="form-control mb-3" id="bccmail" placeholder="Enter Bcc email" /> -->
                                <select name="bccmail[]" id="bccmail" class="selectpicker" multiple data-live-search="true">
                                <?php
								$bccSql = "SELECT * FROM employee WHERE id != '$id'";
								$bccRes = $conn->query($bccSql);
								while($bccRow = mysqli_fetch_array($bccRes)){
									?>
									<option value="<?php echo $bccRow['id'];?>"><?php echo $bccRow['oemail'];?></option>
									<?php
								}
								?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required />
                        </div>
                        
                        <div id="pc-quil-1" style="height: 150px;">
                            <br>
                            <br>
                            <p>---</p>
                            <br>
                            <?php
                            $sessionql = "SELECT * FROM employee WHERE id = '$id'";
                            $sessionRes = $conn->query($sessionql);
                            $sessionRow = $sessionRes->fetch_assoc();
                            ?>
                            <h6><b><?= $sessionRow['fname'] ?> <?= $sessionRow['lname'] ?></b></h6>
                            <h5><?= $sessionRow['designation'] ?></h5>
                            <a href="https://dubudubutechnologies.com">Dubudubutechnologies.com</a></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <ul class="list-inline me-auto mb-0">
                            <li class="list-inline-item align-bottom">
                                <!-- <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-file-upload f-18"></i></a> -->
                            </li>
                            <li class="list-inline-item align-bottom">
                            <!-- <i class="ti ti-paperclip f-18 file-icon" onclick="document.getElementById('fileInput').click();"></i> -->
                            <input type="file" id="fileInput" name="fileInput[]" multiple>

                                <!-- <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a> -->
                                <!-- <input type="file" id="fileInput" name="fileInput" style="display: none;">
                                <label for="fileInput" style="cursor: pointer;">
                                    <i class="ti ti-paperclip f-18"></i>
                                </label> -->

                            </li>
                        </ul>
                        <div class="flex-grow-1 text-end">
                            <input class="btn btn-primary" data-bs-dismiss="modal" type="submit" value="Send" id="send_mail" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ]footer end -->
        
        <!-- Required Js -->
        <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min-2.js"></script>
        <script src="assets_new/js/plugins/popper.min-2.js"></script>
        <script src="assets_new/js/plugins/simplebar.min-2.js"></script>
        <script src="assets_new/js/plugins/bootstrap.min-2.js"></script>
        <script src="assets_new/js/fonts/custom-font-2.js"></script>
        <script src="assets_new/js/pcoded-2.js"></script>
        <script src="assets_new/js/plugins/feather.min-2.js"></script>
        
        <script src="assets_new/js/plugins/quill.min.js"></script>

        <script>
            (function () {
                var quill = new Quill("#pc-quil-1", {
                    modules: {
                        toolbar: [
                            [
                                {
                                    header: [1, 2, false],
                                },
                            ],
                            ["bold", "italic", "underline"],
                            ["image", "code-block"],
                        ],
                    },
                    placeholder: "Type your text here...",
                    theme: "snow",
                });
            })();
            // scroll-block
            var tc = document.querySelectorAll(".scroll-block");
            for (var t = 0; t < tc.length; t++) {
                new SimpleBar(tc[t]);
            }
            var toggle_mail_list = document.querySelector("#toggle-mail-list-height");
            var toggle_mail_wrapper = document.querySelector(".mail-wrapper");
            if (toggle_mail_list) {
                toggle_mail_list.addEventListener("click", function () {
                    if (toggle_mail_wrapper.classList.contains("mini-mail-list")) {
                        toggle_mail_wrapper.classList.remove("mini-mail-list");
                    } else {
                        toggle_mail_wrapper.classList.add("mini-mail-list");
                    }
                });
            }

            var toggle_mail_dialog = document.querySelector("#toggle_mail_dialog");
            var toggle_mail_modal = document.querySelector(".compose_mail_modal");
            if (toggle_mail_dialog) {
                toggle_mail_dialog.addEventListener("click", function () {
                    if (toggle_mail_modal.classList.contains("modal-pos-down")) {
                        toggle_mail_modal.classList.remove("modal-pos-down");
                    } else {
                        toggle_mail_modal.classList.add("modal-pos-down");
                    }
                });
            }

            // var tc = document.querySelectorAll(".mail-table tr td:nth-child(2), .mail-table tr td:nth-child(3)");
            // for (var t = 0; t < tc.length; t++) {
            //     tc[t].addEventListener("click", function () {
            //         active_details('a[id="list-mailtab-details"]');
            //     });
            // }

            // document.querySelector("#mail-back_inbox").addEventListener("click", function () {
            //     active_details('a[id="list-mailtab-1"]');
            // });
            // function active_details(tab_name) {
            //     var someTabTriggerEl = document.querySelector(tab_name);
            //     var actTab = new bootstrap.Tab(someTabTriggerEl);
            //     actTab.show();
            // }
        </script>
        <!-- [Page Specific JS] end -->

    </body>
</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        function showToast(message, mailId) {
            let toastId = "toast_" + mailId;
            let toastHtml = `
                <div id="${toastId}" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" 
                    style="position: fixed; top: 20px; right: 20px; background: green; color: white; padding: 15px; 
                    border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); margin-bottom: 10px; z-index: 9999;">
                    
                    <strong>${message}</strong>
                    <button type="button" class="btn btn-danger btn-sm undo-btn" data-mailid="${mailId}" data-toastid="${toastId}" 
                        style="margin-left: 10px;">Undo</button>
                </div>
            `;

            $("body").append(toastHtml);

            setTimeout(function() {
                $("#" + toastId).fadeOut(500, function() { $(this).remove(); });
            }, 5000);
        }

        $("#send_mail").click(function() {
            event.preventDefault();
            var formData = new FormData();

            var messageContent = $("#pc-quil-1 .ql-editor").clone(); 
            messageContent.find(".ql-clipboard, .ql-tooltip").remove(); 

            formData.append("tomail", $("#tomail").val());
            formData.append("ccmail", $("#ccmail").val());
            formData.append("bccmail", $("#bccmail").val());
            formData.append("subject", $("#subject").val());
            formData.append("message", messageContent.html()); 

            var fileInput = $("#fileInput")[0];
            if (fileInput.files.length > 0) {
                for (var i = 0; i < fileInput.files.length; i++) {
                    formData.append("fileInput[]", fileInput.files[i]); // Append each file
                }
            }

            $.ajax({
                url: "ajax/send_mail.php",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === "success") {
                        let mailId = response.mail_id;

                        showToast("Email will be sent in 5 seconds.", mailId);

                        setTimeout(function() {
                            $.ajax({
                                url: "ajax/send_scheduled_mail.php",
                                type: "POST",
                                data: { mail_id: mailId },
                                dataType: "json",
                                success: function(res) {
                                    if (res.status === "success") {
                                        // alert(res.message);
                                        location.reload();
                                    }else{
                                        location.reload();
                                    }
                                }
                            });
                        }, 5000);
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        $(document).on("click", ".undo-btn", function() {
            let mailId = $(this).data("mailid");
            let toastId = $(this).data("toastid");

            undoEmail(mailId, toastId);
        });
    });

    function undoEmail(mailId, toastId) {
        $.ajax({
            url: "ajax/delete_mail.php",
            type: "POST",
            data: { mail_id: mailId },
            dataType: "json",
            success: function(res) {
                // alert(res.message);
                $("#" + toastId).remove();
                location.reload();
            }
        });
    }
</script>

<script>
$(document).ready(function(){
    $(".mail-row").click(function(){
        var mailId = $(this).data("id");
        
        $.ajax({
            url: "ajax/fetch_mail_details.php",
            type: "POST",
            data: { id: mailId },
            success: function(response){
                $("#list-mail-9").html(response);
                $(".tab-pane").removeClass("show active");
                $("#list-mail-9").addClass("show active");

            }
        });
    });
});
</script>

<script>
    $(document).ready(function(){
        $(".star-checkbox").on("change", function(){
            let mailId = $(this).data("mail-id");
            let isChecked = $(this).is(":checked") ? 1 : 0;

            $.ajax({
                url: "ajax/update_starred.php",
                type: "POST",
                data: { mail_id: mailId, is_checked: isChecked },
                success: function(response){
                    console.log(response);
                }
            });
        });
    });
</script>

<script>
    $(document).on("click", ".delete-email", function (e) {
        e.preventDefault();
        let mailId = $(this).data("mail-id");

        if (confirm("Are you sure you want to delete this email?")) {
            $.ajax({
                url: "ajax/trash_mail.php",
                type: "POST",
                data: { mail_id: mailId },
                success: function (response) {
                    if (response === "success") {
                        alert("Email moved to trash successfully!");
                        location.reload();
                    } else {
                        alert("Error deleting email.");
                    }
                }
            });
        }
    });

</script>

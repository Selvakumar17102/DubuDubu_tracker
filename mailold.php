<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$dashboard = "active";
$dashboardBoolean = 'true';
$dash_show = 'show';
$mail_apply = 'active';

$today = date('Y-m-d');
$today1 = date('d-m-Y');

$id = $_SESSION['id'];

$sql = "SELECT COUNT(*) AS mail_count 
        FROM mail 
        WHERE (FIND_IN_SET($id, to_ids) OR FIND_IN_SET($id, cc_ids) OR FIND_IN_SET($id, bcc_ids)) 
        AND status = 'sent'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
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
        
        
        <link rel="stylesheet" href="assets_new/css/plugins/quill.snow.css" />
        <link rel="stylesheet" href="assets_new/fonts/tabler-icons.min-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/material-2.css" />
        <link rel="stylesheet" href="assets_new/css/style-2.css" id="main-style-link" />



        <!-- GOOGLE FONTS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

        <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


        <!-- PLUGINS CSS STYLE -->
        <link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

        <!-- Data-Tables -->
        <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
        <link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

        <!-- Ekka CSS -->
        <link id="ekka-css" rel="stylesheet" href="assets/css/ekka.css" />

        
    </head>
    <style>
        .offcanvas-start {
            top: 0;
            left: 0;
            width: 150px;
            border-right: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-transform: translateX(-100%);
            transform: translateX(-100%);
        }

        .pc-container .pc-content {
            padding-left: 0;
            padding-right: 10px;
            padding-top: 0;
        }

        .pc-container {
            position: relative;
            top: 0;
            margin-left: 150px;
            min-height: calc(100vh - 135px);
        }
    </style>
    <!-- [Head] end --><!-- [Body] Start -->
    <body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">

        <div class="wrapper">

            <?php include("include/side-bar.php"); ?>

            <div class="ec-page-wrapper">
                
                <?php include("include/header.php"); ?>

                <div class="pc-container">
                    <div class="pc-content">
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
                                                                        <span><i class="ti ti-inbox"></i> Inbox </span><span class="avtar avtar-xs">4</span>
                                                                    </a>
                                                                    <a class="list-group-item list-group-item-action" id="list-mailtab-3" data-bs-toggle="list" href="#list-mail-3" role="tab">
                                                                        <span><i class="ti ti-send"></i> Sent </span>
                                                                    </a>
                                                                    <a class="list-group-item list-group-item-action" id="list-mailtab-4" data-bs-toggle="list" href="#list-mail-4" role="tab">
                                                                        <span><i class="ti ti-file-text"></i> Draft </span>
                                                                    </a>
                                                                    <a class="list-group-item list-group-item-action" id="list-mailtab-5" data-bs-toggle="list" href="#list-mail-5" role="tab">
                                                                        <span><i class="ti ti-alert-triangle"></i> Spam </span>
                                                                    </a>
                                                                    <a class="list-group-item list-group-item-action" id="list-mailtab-6" data-bs-toggle="list" href="#list-mail-6" role="tab">
                                                                        <span><i class="ti ti-trash"></i> Trash </span><span class="avtar avtar-xs">2</span>
                                                                    </a>
                                                                    <hr class="my-3 border border-secondary-subtle" />
                                                                    <a data-bs-toggle="collapse" href="#mailCollapselist1" role="button" aria-expanded="false" aria-controls="mailCollapselist1"><p class="text-muted ps-3 mb-0">Filters</p></a>
                                                                    <div class="collapse show multi-collapse" id="mailCollapselist1">
                                                                        <a class="list-group-item list-group-item-action mt-3" id="list-mailtab-7" data-bs-toggle="list" href="#list-mail-7" role="tab">
                                                                            <span><i class="ti ti-star"></i> Starred </span>
                                                                        </a>
                                                                        <a class="list-group-item list-group-item-action" id="list-mailtab-8" data-bs-toggle="list" href="#list-mail-8" role="tab">
                                                                            <span><i class="ti ti-flag-3"></i> Important </span><span class="avtar avtar-xs">2</span>
                                                                        </a>
                                                                    </div>
                                                                    <hr class="my-3 border border-secondary-subtle" />
                                                                    <a data-bs-toggle="collapse" href="#mailCollapselist2" role="button" aria-expanded="false" aria-controls="mailCollapselist2"><p class="text-muted ps-3 mb-0">Label</p></a>
                                                                    <div class="collapse show multi-collapse" id="mailCollapselist2">
                                                                        <a class="list-group-item list-group-item-action mt-3" id="list-mailtab-71" data-bs-toggle="list" href="#list-mail-7" role="tab">
                                                                            <span><i class="ti ti-flag-3 text-primary"></i> Promotions </span><span class="avtar avtar-xs">3</span>
                                                                        </a>
                                                                        <a class="list-group-item list-group-item-action" id="list-mailtab-81" data-bs-toggle="list" href="#list-mail-8" role="tab">
                                                                            <span><i class="ti ti-flag-3 text-warning"></i> Forums </span><span class="avtar avtar-xs">1</span>
                                                                        </a>
                                                                        <a class="list-group-item list-group-item-action d-none" id="list-mailtab-details" data-bs-toggle="list" href="#list-mail-9" role="tab"></a>
                                                                    </div>
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
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="list-mail-1" role="tabpanel" aria-labelledby="list-mailtab-1">
                                                        <div class="card table-card">
                                                            <div class="card-body py-0 px-2">
                                                                <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true"><i class="ti ti-user me-2"></i>Primary</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab" aria-selected="true"><i class="ti ti-file-text me-2"></i>Promotions</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab" aria-selected="true"><i class="ti ti-id me-2"></i>Social</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4" role="tab" aria-selected="true"><i class="ti ti-lock me-2"></i>Updates</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="profile-tab-5" data-bs-toggle="tab" href="#profile-5" role="tab" aria-selected="true"><i class="ti ti-users me-2"></i>Announcement</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="card-body scroll-block">
                                                                <div class="tab-content">
                                                                    <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                                                                        <table class="table table-borderless mb-0 mail-table">
                                                                            <tbody>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                                                                        <table class="table table-borderless mb-0 mail-table">
                                                                            <tbody>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                                                                        <table class="table table-borderless mb-0 mail-table">
                                                                            <tbody>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                                                                        <table class="table table-borderless mb-0 mail-table">
                                                                            <tbody>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="tab-pane" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                                                                        <table class="table table-borderless mb-0 mail-table">
                                                                            <tbody>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        12 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge">
                                                                                                <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a>
                                                                                                <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        13 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="unread">
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="mail-option">
                                                                                        14 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                                                                                                    1500s.been the industry's standard dummy text ever since the 1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        15 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                                <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                                <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                                <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                            <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex w-100 align-items-center">
                                                                                            <div class="flex-grow-1 position-relative">
                                                                                                <p class="mb-0 mail-text text-truncate">
                                                                                                    of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the
                                                                                                    1500s.
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                    </td>
                                                                                    <td class="mail-option">
                                                                                        16 Jul 22 08:23 AM
                                                                                        <div class="mail-buttons">
                                                                                            <ul class="list-inline mb-0">
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                                </li>
                                                                                                <li class="list-inline-item">
                                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-2" role="tabpanel" aria-labelledby="list-mailtab-2">
                                                        <div class="card table-card">
                                                            <div class="card-body scroll-block">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <tr class="unread">
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="unread">
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-3" role="tabpanel" aria-labelledby="list-mailtab-3">
                                                        <div class="card table-card">
                                                            <div class="card-body scroll-block">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-4" role="tabpanel" aria-labelledby="list-mailtab-4">
                                                        <div class="card table-card">
                                                            <div class="card-body scroll-block">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-5" role="tabpanel" aria-labelledby="list-mailtab-5">
                                                        <div class="card bg-transparent empty-mail">
                                                            <div class="card-body scroll-block">
                                                                <div class="row g-0 justify-content-center align-items-center h-100">
                                                                    <div class="col-md-8 col-sm-10 text-center">
                                                                        <img src="assets_new/images/application/img-empty-mail.png" alt="img" class="img-fluid mb-4" />
                                                                        <h2><b>There is No Mail</b></h2>
                                                                        <p class="mb-0 text-muted">When You have message that will Display here</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-6" role="tabpanel" aria-labelledby="list-mailtab-6">
                                                        <div class="card table-card">
                                                            <div class="card-body scroll-block">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-7" role="tabpanel" aria-labelledby="list-mailtab-7">
                                                        <div class="card table-card">
                                                            <div class="card-body scroll-block">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-5-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                16 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-8" role="tabpanel" aria-labelledby="list-mailtab-8">
                                                        <div class="card table-card">
                                                            <div class="card-body scroll-block">
                                                                <table class="table table-borderless mb-0 mail-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Barney Thea</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                12 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-2-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Zachary Chambers</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge">
                                                                                        <a href="#" class="badge rounded-pill btn-light-primary py-1 px-2">Promotions</a> <a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                13 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-3-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Mattie Reid</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">simply dummy text the industry's standard dummy text ever since the 1500s.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td class="mail-option">
                                                                                14 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">check_box_outline_blank</i>
                                                                                        <i class="material-icons-two-tone text-primary pc-icon-check">check_box</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline my-0 mx-3 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                        <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                        <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                        <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <img src="assets_new/images/user/avatar-4-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                    <h6 class="mb-0 ms-2 text-truncate">Nathaniel Vasquez</h6>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex w-100 align-items-center">
                                                                                    <div class="flex-grow-1 position-relative">
                                                                                        <p class="mb-0 mail-text text-truncate">
                                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.been
                                                                                            the industry's standard dummy text ever since the 1500s.
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="mail-content-badge"><a href="#" class="badge rounded-pill btn-light-warning py-1 px-2">Forums</a></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                            </td>
                                                                            <td class="mail-option">
                                                                                15 Jul 22 08:23 AM
                                                                                <div class="mail-buttons">
                                                                                    <ul class="list-inline mb-0">
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-archive f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-mail f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-trash f-18"></i></a>
                                                                                        </li>
                                                                                        <li class="list-inline-item">
                                                                                            <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-eye-off f-18"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="list-mail-9" role="tabpanel" aria-labelledby="list-mailtab-details">
                                                        <div class="card">
                                                            <div class="card-body scroll-block">
                                                                <div class="card border mb-3">
                                                                    <div class="card-body p-1">
                                                                        <div class="d-sm-flex align-items-center">
                                                                            <ul class="list-inline me-auto my-2">
                                                                                <li class="list-inline-item align-bottom">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary" id="mail-back_inbox"><i class="ti ti-chevron-left f-18"></i></a>
                                                                                </li>
                                                                                <li class="list-inline-item align-bottom">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <img src="assets_new/images/user/avatar-1-2.jpg" alt="user-image" class="img-user rounded-circle" />
                                                                                        <div class="flex-grow-1 ms-2">
                                                                                            <h5 class="mb-0 text-truncate">Matthew Hawkins</h5>
                                                                                            <p class="mb-0 text-muted text-sm">
                                                                                                From: &lt;
                                                                                                <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="f581948f90949b80b5969a9885949b8cdb969a98">[email&#160;protected]</a>&gt;
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                            <ul class="list-inline ms-sm-auto ms-2 my-2">
                                                                                <li class="list-inline-item text-muted">12 Jul 22 08:23 AM</li>
                                                                                <li class="list-inline-item">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                            <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                                                            <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline m-0 mx-3 pc-icon-checkbox">
                                                                                            <input class="form-check-input" type="checkbox" checked="checked" /> <i class="material-icons-two-tone pc-icon-uncheck">label</i>
                                                                                            <i class="material-icons-two-tone text-secondary pc-icon-check">label</i>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                                                            <input class="form-check-input" type="checkbox" /> <i class="material-icons-two-tone pc-icon-uncheck">new_releases</i>
                                                                                            <i class="material-icons-two-tone text-danger pc-icon-check">new_releases</i>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-inline-item">
                                                                                    <div class="dropdown">
                                                                                        <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <i class="ti ti-dots f-18"></i>
                                                                                        </a>
                                                                                        <div class="dropdown-menu dropdown-end">
                                                                                            <a class="dropdown-item" href="#">Name</a> <a class="dropdown-item" href="#">Date</a> <a class="dropdown-item" href="#">Ratting</a>
                                                                                            <a class="dropdown-item" href="#">Unread</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mail-details">
                                                                    <h4><b>Lorem Ipsum is simply dummy text</b></h4>
                                                                    <h5 class="mt-4 mb-3">Dear Martha Jenkins,</h5>
                                                                    <p class="text-muted indent-text">
                                                                        Lorem Ipsum is simply dummy text of the printing and <b>typesetting industry</b>. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                                        printer took a galley of type and scrambled it to make a type <b>specimen book</b>. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                                        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                                                        software like <abbr title="Aldus PageMaker" class="initialism">Aldus PageMaker</abbr> including versions of Lorem Ipsum.
                                                                    </p>
                                                                    <p class="text-muted indent-text">
                                                                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                                                        more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web
                                                                        page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved
                                                                        over the years, sometimes by accident, sometimes on purpose
                                                                    </p>
                                                                    <p class="mt-5 mb-0">Kind Regards,</p>
                                                                    <h5 class="mb-4">Jean Anderson</h5>
                                                                    <hr class="my-3" />
                                                                    <h5 class="mb-3">
                                                                        <b><i class="ti ti-paperclip me-2"></i> 3 Attachments</b>
                                                                    </h5>
                                                                    <ul class="list-inline">
                                                                        <li class="list-inline-item mb-2">
                                                                            <div class="card bg-body border">
                                                                                <div class="card-body p-3">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="flex-grow-1 me-2"><h5 class="mb-0 text-truncate">table_denar.pdf</h5></div>
                                                                                        <a href="#" class="avtar avtar-xs btn-link-secondary text-secondary"><i class="ti ti-download f-16"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="list-inline-item mb-2">
                                                                            <div class="card bg-body border">
                                                                                <div class="card-body p-3">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="flex-grow-1 me-2"><h5 class="mb-0 text-truncate">handmade.mp2</h5></div>
                                                                                        <a href="#" class="avtar avtar-xs btn-link-secondary text-secondary"><i class="ti ti-download f-16"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <hr class="mb-3 mt-0" />
                                                                    <div class="bg-light rounded p-3 my-3">
                                                                        <div class="d-flex align-items-start mb-3">
                                                                            <img class="rounded-circle img-fluid wid-30" src="assets_new/images/user/avatar-4-2.jpg" alt="User image" />
                                                                            <div class="flex-grow-1 ms-3">
                                                                                <div class="d-flex align-items-center flex-wrap mb-3">
                                                                                    <h5 class="mb-0 me-3">Barney Thea</h5>
                                                                                    <p class="mb-0 text-muted text-sm">
                                                                                        &lt;<a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="285c49524d49465d684b474558494651064b4745">[email&#160;protected]</a>&gt;
                                                                                    </p>
                                                                                </div>
                                                                                <p class="text-primary">
                                                                                    On Tue, Nov 1, 2022 at 12:05 AM Sreekumar Ks &lt;
                                                                                    <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="fa8e9b809f9b948fba9995978a9b9483d4999597">[email&#160;protected]</a>&gt; wrote:
                                                                                </p>
                                                                                <p class="text-header mb-1">It is a long established fact that a reader will be distracted</p>
                                                                                <p class="text-header mb-1">by the readable content</p>
                                                                                <p class="text-header mb-1">of a page when</p>
                                                                                <p class="text-header mb-1">looking at</p>
                                                                                <p class="text-header mb-1">its layout.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#mailreplay"><i class="align-text-bottom me-1 ti ti-arrow-back-up"></i> Reply</button>
                                                                    <button class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#mailreplay"><i class="align-text-bottom me-1 ti ti-arrow-big-right"></i> Forward</button>
                                                                    <div class="collapse" id="mailreplay">
                                                                        <div class="my-3">
                                                                            <div id="pc-quil-2" style="height: 125px;"><p>Put your things hear...</p></div>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <ul class="list-inline me-auto mb-0">
                                                                                <li class="list-inline-item align-bottom">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-file-upload f-18"></i></a>
                                                                                </li>
                                                                                <li class="list-inline-item align-bottom">
                                                                                    <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                            <div class="flex-grow-1 text-end">
                                                                                <button class="btn btn-link-dark" data-bs-toggle="collapse" data-bs-target="#mailreplay">Cancel</button>
                                                                                <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#mailreplay">Reply</button>
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
                                <div class="text-end"><a data-bs-toggle="collapse" href="#collapseccbcc" role="button" aria-expanded="false">Cc & Bcc</a></div>
                                <div class="mb-3"><label class="form-label" for="exampleInputEmail1">To</label> <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Recipients" /></div>
                                <div class="mb-3"><label class="form-label" for="exampleInputEmail4">Subject</label> <input type="email" class="form-control" id="exampleInputEmail4" placeholder="Subject" /></div>
                                <div class="collapse" id="collapseccbcc">
                                    <div class="mb-3"><label class="form-label">Cc</label> <input type="email" class="form-control mb-3" placeholder="Enter Cc email" /></div>
                                    <div class="mb-3"><label class="form-label">Bcc</label> <input type="email" class="form-control mb-3" placeholder="Enter Bcc email" /></div>
                                </div>
                                <div id="pc-quil-1" style="height: 125px;"><p>Put your things hear...</p></div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-file-upload f-18"></i></a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a href="#" class="avtar avtar-s btn-link-secondary"><i class="ti ti-paperclip f-18"></i></a>
                                    </li>
                                </ul>
                                <div class="flex-grow-1 text-end"><button class="btn btn-primary" data-bs-dismiss="modal">Reply</button></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include("include/footer.php"); ?>

            </div>
        </div>
      
        
        <script src="assets_new/js/plugins/popper.min-2.js"></script>
        <script src="assets_new/js/plugins/simplebar.min-2.js"></script>
        <script src="assets_new/js/plugins/bootstrap.min-2.js"></script>
        
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
                var quill = new Quill("#pc-quil-2", {
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

            var tc = document.querySelectorAll(".mail-table tr td:nth-child(2), .mail-table tr td:nth-child(3)");
            for (var t = 0; t < tc.length; t++) {
                tc[t].addEventListener("click", function () {
                    active_details('a[id="list-mailtab-details"]');
                });
            }

            document.querySelector("#mail-back_inbox").addEventListener("click", function () {
                active_details('a[id="list-mailtab-1"]');
            });
            function active_details(tab_name) {
                var someTabTriggerEl = document.querySelector(tab_name);
                var actTab = new bootstrap.Tab(someTabTriggerEl);
                actTab.show();
            }
        </script>
        <!-- [Page Specific JS] end -->
    </body>
</html>

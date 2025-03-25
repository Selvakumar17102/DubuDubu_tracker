<?php
session_start();
ini_set("display_errors",'off');
include("include/connection.php");
$dashboard = "active";
$dashboardBoolean = 'true';
$dash_show = 'show';
$cal_apply = 'active';

$today = date('Y-m-d');
$today1 = date('d-m-Y');

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard HTML Template.">

	<title>Dubu Dubu - calendar</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

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

	<!-- FAVICON -->
	<link href="assets/img/favicon.png" rel="shortcut icon" />

    <link rel="stylesheet" href="assets_new/fonts/inter/inter-2.css" id="main-font-link" />
        <link rel="stylesheet" href="assets_new/fonts/phosphor/duotone/style-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/tabler-icons.min-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/feather-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/fontawesome-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/material-2.css" />
        <!-- <link rel="stylesheet" href="assets_new/css/style-2.css" id="main-style-link" /> -->
        <!-- <script src="assets_new/js/tech-stack-2.js"></script> -->
        <!-- <link rel="stylesheet" href="assets_new/css/style-preset-2.css" /> -->
</head>


<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body">

	<!-- WRAPPER -->
	<div class="wrapper">

		<!-- LEFT MAIN SIDEBAR -->
		<?php include("include/side-bar.php"); ?>

		<!-- PAGE WRAPPER -->
		<div class="ec-page-wrapper">

			<!-- Header -->
			<?php include("include/header.php"); ?>

			<!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
                <div class="pc-container">
                    <div class="pc-content">
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="../dashboard/index-2.html">Home</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="javascript: void(0)">Application</a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">Calendar</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="col-md-11">
                                        <div class="page-header-title">
                                            <h2 class="mb-0">Calendar</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-primary" href="javascript:history.go(-1)">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body position-relative">
                                        <div id="calendar" class="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="calendar-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="calendar-modal-title f-w-600 text-truncate">
                                    Modal title
                                </h3>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="modal"><i class="ti ti-x f-20"></i></a>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-xs bg-light-secondary">
                                            <i class="ti ti-heading f-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1"><b>Title</b></h5>
                                        <p class="pc-event-title text-muted"></p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-xs bg-light-warning">
                                            <i class="ti ti-map-pin f-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1"><b>Venue</b></h5>
                                        <p class="pc-event-venue text-muted"></p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-xs bg-light-danger">
                                            <i class="ti ti-calendar-event f-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1"><b>Date</b></h5>
                                        <p class="pc-event-date text-muted"></p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-xs bg-light-primary">
                                            <i class="ti ti-file-text f-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1"><b>Description</b></h5>
                                        <p class="pc-event-description text-muted"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <a href="#" id="pc_event_remove" class="avtar avtar-s btn-link-danger btn-pc-default w-sm-auto" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash f-18"></i></a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a href="#" id="pc_event_edit" class="avtar avtar-s btn-link-success btn-pc-default" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit-circle f-18"></i></a>
                                    </li>
                                </ul>
                                <div class="flex-grow-1 text-end">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offcanvas offcanvas-end cal-event-offcanvas" tabindex="-1" id="calendar-add_edit_event">
                    <div class="offcanvas-header">
                        <h3 class="f-w-600 text-truncate">Add Events</h3>
                        <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto" data-bs-dismiss="offcanvas"><i class="ti ti-x f-20"></i></a>
                    </div>
                    <div class="offcanvas-body">
                        <form id="pc-form-event" novalidate="">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="email" class="form-control" id="pc-e-title" placeholder="Enter event title" autofocus="" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Venue</label>
                                <input type="email" class="form-control" id="pc-e-venue" placeholder="Enter event venue" />
                            </div>
                            <div>
                                <input type="hidden" class="form-control" id="pc-e-sdate" />
                                <input type="hidden" class="form-control" id="pc-e-edate" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" placeholder="Enter event description" rows="3" id="pc-e-description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="pc-e-type">
                                    <option value="empty" selected="selected">Type</option>
                                    <option value="event-primary">Primary</option>
                                    <option value="event-secondary">Secondary</option>
                                    <option value="event-success">Success</option>
                                    <option value="event-danger">Danger</option>
                                    <option value="event-warning">Warning</option>
                                    <option value="event-info">Info</option>
                                </select>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas"><i class="align-text-bottom me-1 ti ti-circle-x"></i> Close</button>
                                </div>
                                <div class="col-auto">
                                    <button id="pc_event_add" type="button" class="btn btn-secondary" data-pc-action="add">
                                        <span id="pc-e-btn-text"><i class="align-text-bottom me-1 ti ti-calendar-plus"></i> Add</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
			</div>

			<!-- Footer -->
			<?php include("include/footer.php"); ?>

		</div> <!-- End Page Wrapper -->
	</div> <!-- End Wrapper -->

	<!-- Common Javascript -->
	<script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/plugins/simplebar/simplebar.min.js"></script>
	<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
	<script src="assets/plugins/slick/slick.min.js"></script>

	<!-- Datatables -->
	<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<!-- Option Switcher -->
	<script src="assets/plugins/options-sidebar/optionswitcher.js"></script>

	<!-- ekka Custom -->
	<script src="assets/js/ekka.js"></script>
	<script src="assets/js/manual.js"></script>

        <!-- Required Js -->
        <!-- <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min-2.js"></script> -->
        <!-- <script src="assets_new/js/plugins/popper.min-2.js"></script> -->
        <!-- <script src="assets_new/js/plugins/simplebar.min-2.js"></script> -->
        <!-- <script src="assets_new/js/plugins/bootstrap.min-2.js"></script> -->
        <!-- <script src="assets_new/js/fonts/custom-font-2.js"></script> -->
        <!-- <script src="assets_new/js/pcoded-2.js"></script> -->
        <!-- <script src="assets_new/js/plugins/feather.min-2.js"></script> -->
        <script src="assets_new/js/plugins/index.global.min.js"></script>
        <!-- Sweet Alert -->
        <script src="assets_new/js/plugins/sweetalert2.all.min.js"></script>
        <script src="assets_new/js/pages/calendar.js"></script>
        <!-- [Page Specific JS] end -->

</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#pc_event_add").click(function(){
        var title = $("#pc-e-title").val();
        var venue = $("#pc-e-venue").val();
        var sdate = $("#pc-e-sdate").val();
        var edate = $("#pc-e-edate").val();
        var description = $("#pc-e-description").val();
        var event_type = $("#pc-e-type").val();

        $.ajax({
            url: "store_event.php",
            type: "POST",
            data: {
                title: title,
                venue: venue,
                sdate: sdate,
                edate: edate,
                description: description,
                event_type: event_type
            },
            dataType: "json",
            success: function(response) {
                if(response.status == "success") {
                    Swal.fire({ customClass: { confirmButton: "btn btn-light-primary" }, buttonsStyling: !1, icon: "success", title: "Success", text: "Event added successfully" })
                } else {
                    alert("Failed to add event: " + response.message);
                }
            },
            error: function() {
                alert("Error in AJAX request");
            }
        });
    });
});
</script>



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
<html lang="en">
    <!-- [Head] start -->
    <head>
        <title>Calendar | Able Pro Dashboard Template</title>
        <!-- [Meta] -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
        <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
        <meta name="author" content="Phoenixcoded" />
        <!-- [Favicon] icon -->
        <link href="assets/img/favicon.png" rel="shortcut icon" />
        <link rel="stylesheet" href="assets_new/fonts/inter/inter-2.css" id="main-font-link" />
        <link rel="stylesheet" href="assets_new/fonts/phosphor/duotone/style-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/tabler-icons.min-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/feather-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/fontawesome-2.css" />
        <link rel="stylesheet" href="assets_new/fonts/material-2.css" />
        <link rel="stylesheet" href="assets_new/css/style-2.css" id="main-style-link" />
        <script src="assets_new/js/tech-stack-2.js"></script>
        <link rel="stylesheet" href="assets_new/css/style-preset-2.css" />
    </head>
    <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
        <div class="container">
            <div class="content">
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
        <!-- [ Main Content ] footer end -->

        <!-- Required Js -->
        <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min-2.js"></script>
        <script src="assets_new/js/plugins/popper.min-2.js"></script>
        <script src="assets_new/js/plugins/simplebar.min-2.js"></script>
        <script src="assets_new/js/plugins/bootstrap.min-2.js"></script>
        <script src="assets_new/js/fonts/custom-font-2.js"></script>
        <script src="assets_new/js/pcoded-2.js"></script>
        <script src="assets_new/js/plugins/feather.min-2.js"></script>
        <script src="assets_new/js/plugins/index.global.min.js"></script>
        <!-- Sweet Alert -->
        <script src="assets_new/js/plugins/sweetalert2.all.min.js"></script>
        <script src="assets_new/js/pages/calendar.js"></script>
        <!-- [Page Specific JS] end -->
        
    </body>
    <!-- [Body] end -->
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

<script>
        $(document).ready(function () {
            $.ajax({
                url: "fetch_events.php", 
                method: "GET",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    initializeCalendar(response);
                },
                error: function (error) {
                    console.log("Error fetching events:", error);
                },
            });
        });

        function initializeCalendar(response) {
            const l = new bootstrap.Offcanvas("#calendar-add_edit_event"),
                d = new bootstrap.Modal("#calendar-modal");
            var r = "",
                e = new Date(),
                t = (e.getDate(), e.getMonth()),
                e = e.getFullYear(),
                a = new FullCalendar.Calendar(document.getElementById("calendar"), {
                    headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },
                    themeSystem: "bootstrap",
                    initialDate: new Date(e, t, 16),
                    slotDuration: "00:10:00",
                    navLinks: !0,
                    height: "auto",
                    droppable: !0,
                    selectable: !0,
                    selectMirror: !0,
                    editable: !0,
                    dayMaxEvents: !0,
                    handleWindowResize: !0,
                    select: function (e) {
                        var t = new Date(e.start),
                            e = new Date(e.end);
                        (document.getElementById("pc-e-sdate").value = t.getFullYear() + "-" + o(t.getMonth() + 1) + "-" + o(t.getDate())),
                            (document.getElementById("pc-e-edate").value = e.getFullYear() + "-" + o(e.getMonth() + 1) + "-" + o(e.getDate())),
                            (document.getElementById("pc-e-title").value = ""),
                            (document.getElementById("pc-e-venue").value = ""),
                            (document.getElementById("pc-e-description").value = ""),
                            (document.getElementById("pc-e-type").value = ""),
                            (document.getElementById("pc-e-btn-text").innerHTML = '<i class="align-text-bottom me-1 ti ti-calendar-plus"></i> Add'),
                            document.querySelector("#pc_event_add").setAttribute("data-pc-action", "add"),
                            l.show(),
                            a.unselect();
                    },
                    eventClick: function (e) {
                        r = e.event;
                        var e = e.event,
                            t = void 0 === e.title ? "" : e.title,
                            n = void 0 === e.extendedProps.description ? "" : e.extendedProps.description,
                            a = null === e.start ? "" : c(e.start),
                            i = null === e.end ? "" : " <i class='text-sm'>to</i> " + c(e.end),
                            i = null === e.end ? "" : i,
                            e = void 0 === e.extendedProps.description ? "" : e.extendedProps.venue;
                        (document.querySelector(".calendar-modal-title").innerHTML = t),
                            (document.querySelector(".pc-event-title").innerHTML = t),
                            (document.querySelector(".pc-event-description").innerHTML = n),
                            (document.querySelector(".pc-event-date").innerHTML = a + i),
                            (document.querySelector(".pc-event-venue").innerHTML = e),
                            d.show();
                    },
                    events: response, 
                }),
                e =
                    (a.render(),
                    document.addEventListener("DOMContentLoaded", function () {
                        for (var e = document.querySelectorAll(".fc-toolbar-chunk"), t = 0; t < e.length; t++) {
                            var n = e[t];
                            n.children[0].classList.remove("btn-group"), n.children[0].classList.add("d-inline-flex");
                        }
                    }),
                    document.querySelector("#pc_event_remove")),
                i =
                    (e &&
                        e.addEventListener("click", function () {
                            const t = Swal.mixin({ customClass: { confirmButton: "btn btn-light-success", cancelButton: "btn btn-light-danger" }, buttonsStyling: !1 });
                            t.fire({ title: "Are you sure?", text: "you want to delete this event?", icon: "warning", showCancelButton: !0, confirmButtonText: "Yes, delete it!", cancelButtonText: "No, cancel!", reverseButtons: !0 }).then((e) => {
                                e.isConfirmed ? (r.remove(), d.hide(), t.fire("Deleted!", "Your Event has been deleted.", "success")) : e.dismiss === Swal.DismissReason.cancel && t.fire("Cancelled", "Your Event data is safe.", "error");
                            });
                        }),
                    document.querySelector("#pc_event_add")),
                t =
                    (i &&
                        i.addEventListener("click", function () {
                            var e = null,
                                t = null === document.getElementById("pc-e-sdate").value ? "" : document.getElementById("pc-e-sdate").value,
                                n = null === document.getElementById("pc-e-edate").value ? "" : document.getElementById("pc-e-edate").value;
                            "" == !n && (e = new Date(n)),
                                a.addEvent({
                                    title: document.getElementById("pc-e-title").value,
                                    start: new Date(t),
                                    end: e,
                                    allDay: !0,
                                    description: document.getElementById("pc-e-description").value,
                                    venue: document.getElementById("pc-e-venue").value,
                                    className: document.getElementById("pc-e-type").value,
                                }),
                                "add" == i.getAttribute("data-pc-action")
                                    ? Swal.fire({ customClass: { confirmButton: "btn btn-light-primary" }, buttonsStyling: !1, icon: "success", title: "Success", text: "Event added successfully" })
                                    : (r.remove(),
                                      (document.getElementById("pc-e-btn-text").innerHTML = '<i class="align-text-bottom me-1 ti ti-calendar-plus"></i> Add'),
                                      document.querySelector("#pc_event_add").setAttribute("data-pc-action", "add"),
                                      Swal.fire({ customClass: { confirmButton: "btn btn-light-primary" }, buttonsStyling: !1, icon: "success", title: "Success", text: "Event Updated successfully" })),
                                l.hide();
                        }),
                    document.querySelector("#pc_event_edit"));
            function o(e) {
                return e < 10 ? "0" + e : e;
            }
            function c(e) {
                var e = new Date(e),
                    t = "" + ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][e.getMonth()],
                    n = "" + e.getDate(),
                    e = e.getFullYear();
                return t.length < 2 && (t = "0" + t), [(n = n.length < 2 ? "0" + n : n) + " " + t, e].join(",");
            }
            t &&
                t.addEventListener("click", function () {
                    var e = void 0 === r.title ? "" : r.title,
                        t = void 0 === r.extendedProps.description ? "" : r.extendedProps.description,
                        n = null === r.start ? "" : c(r.start),
                        a = null === r.end ? "" : " <i class='text-sm'>to</i> " + c(r.end),
                        a = null === r.end ? "" : a,
                        i = void 0 === r.extendedProps.description ? "" : r.extendedProps.venue,
                        s = void 0 === r.classNames[0] ? "" : r.classNames[0],
                        e =
                            ((document.getElementById("pc-e-title").value = e),
                            (document.getElementById("pc-e-venue").value = i),
                            (document.getElementById("pc-e-description").value = t),
                            (document.getElementById("pc-e-type").value = s),
                            new Date(n)),
                        i = new Date(a);
                    (document.getElementById("pc-e-sdate").value = e.getFullYear() + "-" + o(e.getMonth() + 1) + "-" + o(e.getDate())),
                        (document.getElementById("pc-e-edate").value = i.getFullYear() + "-" + o(i.getMonth() + 1) + "-" + o(i.getDate())),
                        (document.getElementById("pc-e-btn-text").innerHTML = '<i class="align-text-bottom me-1 ti ti-calendar-stats"></i> Update'),
                        document.querySelector("#pc_event_add").setAttribute("data-pc-action", "edit"),
                        d.hide(),
                        l.show();
                });
        }
    </script>

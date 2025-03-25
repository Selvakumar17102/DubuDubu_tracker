<?php
session_start();
include("../include/connection.php");

$sender_id = $_SESSION['id'];

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT is_read FROM mail WHERE mail_id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $isRead = $row['is_read'];

        $readIds = explode(",", $isRead);

        if (!in_array($sender_id, $readIds)) {
            $readIds[] = $sender_id;
            $newIsRead = implode(",", $readIds);

            $updateQuery = "UPDATE mail SET is_read = '$newIsRead' WHERE mail_id = '$id'";
            $conn->query($updateQuery);
        }
    }

    $mailQuery = "SELECT * FROM mail a LEFT JOIN employee b ON a.sender_id = b.id WHERE mail_id = $id";
    $mailResult = $conn->query($mailQuery);

    if($mailResult->num_rows > 0){
        $mailRow = $mailResult->fetch_assoc();

        $attachments = $mailRow['attachments'];

        $attachmentArray = explode("||", $attachments); 
        $attachmentCount = count($attachmentArray);
        
        ?>
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
                                                <h5 class="mb-0 text-truncate"><?= $mailRow['fname'];?>  <?= $mailRow['lname'];?></h5>
                                                <p class="mb-0 text-muted text-sm">
                                                    From: &lt;
                                                    <a href="#" class="__cf_email__"><?= $mailRow['oemail'];?></a>&gt;
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-inline ms-sm-auto ms-2 my-2">
                                    
                                    <li class="list-inline-item text-muted"><?= date("d M y h:i A", strtotime($mailRow['created_at'])); ?></li>
                                    <li class="list-inline-item">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-check-inline m-0 pc-icon-checkbox">
                                                <input class="form-check-input" type="checkbox" <?= in_array($sender_id, explode(',', $mailRow['starred'])) ? 'checked' : ''; ?> /> 
                                                <i class="material-icons-two-tone pc-icon-uncheck">star_outline</i>
                                                <i class="material-icons-two-tone text-warning pc-icon-check">star</i>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ti ti-dots f-18"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-end">
                                                <a class="dropdown-item" href="#">Name</a> 
                                                <a class="dropdown-item" href="#">Date</a> 
                                                <a class="dropdown-item" href="#">Ratting</a>
                                                <a class="dropdown-item" href="#">Unread</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mail-details">
                        <h4><b><?= $mailRow['subject']; ?></b></h4>
                        
                        <?= $mailRow['message']; ?>

                        <hr class="my-3" />
                        <h5 class="mb-3">
                            <b><i class="ti ti-paperclip me-2"></i> <?= $attachmentCount ?>  Attachments</b>
                        </h5>
                        <ul class="list-inline">
                            <?php
                            foreach ($attachmentArray as $file) { 
                            ?>
                                <li class="list-inline-item mb-2">
                                    <div class="card bg-body border">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <h5 class="mb-0 text-truncate">Document</h5>
                                                </div>
                                                <a href="<?= "DubuDubu_tracker/".$file; ?>" target="_blank" class="avtar avtar-xs btn-link-secondary text-secondary">
                                                    <i class="ti ti-download f-16"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                        <hr class="mb-3 mt-0" />
                        <?php
                        $replySql = "SELECT * FROM reply_mail a LEFT JOIN employee b ON a.sender_email = b.id WHERE a.mail_id = $id";
                        $replyRes = $conn->query($replySql);
                        if($replyRes->num_rows){
                            while($replyRow = mysqli_fetch_array($replyRes)){
                                $replyfile = $replyRow['fileInput'];
                                $replyattachmentArray = explode("||", $replyfile); 
                                ?>
                                <div class="bg-light rounded p-3 my-3">
                                    <div class="d-flex align-items-start mb-3">
                                        <img class="rounded-circle img-fluid wid-30" src="assets_new/images/user/avatar-4-2.jpg" alt="User image" />
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-center flex-wrap mb-3">
                                                <h5 class="mb-0 me-3"><?= $replyRow['fname'];?>  <?= $replyRow['lname'];?></h5>
                                                <p class="mb-0 text-muted text-sm">
                                                    From: &lt;
                                                    <a href="#" class="__cf_email__"><?= $replyRow['oemail'];?></a>&gt;
                                                </p>
                                            </div>
                                            <p class="text-primary">
                                                On <?= date("D, M j, Y \\a\\t h:i A", strtotime($replyRow['created_at'])); ?> &lt;
                                                <a href="#" class="__cf_email__"><?= $replyRow['oemail'];?></a>&gt; wrote:
                                            </p>
                                            
                                            <?= $replyRow['reply_message'];?>
                                        </div>
                                    </div>

                                    <hr class="my-3" />
                                    <ul class="list-inline">
                                        <?php
                                        if($replyRow['fileInput']){
                                            foreach ($replyattachmentArray as $file) { 
                                            ?>
                                                <li class="list-inline-item mb-2">
                                                    <div class="card bg-body border">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1 me-2">
                                                                    <h5 class="mb-0 text-truncate">Document</h5>
                                                                </div>
                                                                <a href="<?= "DubuDubu_tracker/".$file; ?>" target="_blank" class="avtar avtar-xs btn-link-secondary text-secondary">
                                                                    <i class="ti ti-download f-16"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php 
                                            }
                                        } ?>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                        ?>

                        

                        <button class="btn btn-light-primary action-btn" data-reply="true" data-bs-toggle="collapse" data-bs-target="#mailreplay">
                            <i class="align-text-bottom me-1 ti ti-arrow-back-up"></i> Reply
                        </button>
                        <!-- <button class="btn btn-light-primary action-btn" data-forward="true" data-bs-toggle="collapse" data-bs-target="#mailreplay">
                            <i class="align-text-bottom me-1 ti ti-arrow-big-right"></i> Forward
                        </button> -->
                        <div class="collapse" id="mailreplay">
                            <div class="my-3">
                                <div id="pc-quil-2" style="height: 125px;"><p>Put your things hear...</p></div>
                            </div>
                            <input type="hidden" id="mailId" value="<?= $mailRow['mail_id']; ?>">
                            <input type="hidden" id="senderEmail" value="<?= $sender_id; ?>">
                            <input type="hidden" id="subject" value="<?= $mailRow['subject']; ?>">
                            <input type="hidden" id="actionType" value=""> 

                            <div class="d-flex">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <input type="file" id="fileInput" name="fileInput[]" multiple>
                                    </li>
                                </ul>
                                <div class="flex-grow-1 text-end">
                                    <button class="btn btn-primary reply-btn" data-bs-toggle="collapse">send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    } else {
        echo "<p>No details found.</p>";
    }
}
?>

        <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min-2.js"></script>
        <script src="assets_new/js/plugins/popper.min-2.js"></script>
        <script src="assets_new/js/plugins/simplebar.min-2.js"></script>
        <script src="assets_new/js/plugins/bootstrap.min-2.js"></script>
        <!-- <script src="assets_new/js/fonts/custom-font-2.js"></script> -->
        <script src="assets_new/js/pcoded-2.js"></script>
        <script src="assets_new/js/plugins/feather.min-2.js"></script>
        <script src="assets_new/js/plugins/quill.min.js"></script>

        <script>
            (function () {
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
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".action-btn").click(function () {
                    var actionType = $(this).data("reply") ? "reply" : "forward";
                    $("#actionType").val(actionType);
                });
                $(".reply-btn").click(function () {

                    event.preventDefault();
                    var formData = new FormData();

                    var messageContent = $("#pc-quil-2 .ql-editor").clone(); 
                    messageContent.find(".ql-clipboard, .ql-tooltip").remove(); 

                    formData.append("mailId", $("#mailId").val());
                    formData.append("senderEmail", $("#senderEmail").val());
                    formData.append("subject", $("#subject").val());
                    formData.append("message", messageContent.html());
                    formData.append("actionType", $("#actionType").val());

                    var fileInput = $("#fileInput")[0];
                    if (fileInput.files.length > 0) {
                        for (var i = 0; i < fileInput.files.length; i++) {
                            formData.append("fileInput[]", fileInput.files[i]); 
                        }
                    }

                    $.ajax({
                        url: "ajax/reply_send_mail.php",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status === "success") {
                                alert(response.message);
                                location.reload();

                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error:", status, error);
                            console.log("Response Text:", xhr.responseText);
                            alert("Error sending mail. Check console for details.");
                        }
                    });
                });
            });
        </script>
     

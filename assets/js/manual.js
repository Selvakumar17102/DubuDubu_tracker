window.addEventListener('load', (event) => {
    const queryString = new URLSearchParams(window.location.search)
    let msg = queryString.get('msg')
    let login_id = queryString.get('id')
    let token_id = queryString.get('token')
    if(login_id != null && token_id != null){
        localStorage.setItem('id', login_id)
        localStorage.setItem('token', token_id)
        $.ajax({
            type: "POST",
            url: "ajax/sessionSet.php",
            data:{
                'login':login_id,
                'token':token_id
            },
            success: function(data){
                alert(data);
                if(data == 'true'){
                    location.replace('profile_dashboard.php')
                    // location.replace('dashboard.php')
                }
                else{
                    location.replace('./')
                    // let thisURl = window.location.href
                    // if(thisURl.charAt(thisURl.length-1) != '/'){
                    //     // console.log(thisURl.charAt(thisURl.length-1))
                    //     location.replace('./')
                    // }
                }
            }
        });
    }
    // if(msg != null){
    //     Snackbar.show({
    //         text: msg,
    //         pos: 'bottom-right',
    //         actionText: 'Success',
    //         actionTextColor: '#8dbf42',
    //         duration: 5000
    //     });
    // }
    let login = localStorage.getItem('id')
    let token = localStorage.getItem('token')
    if(!login || !token || login == null || token == null){
        let thisURl = window.location.href
        if(thisURl.charAt(thisURl.length-1) != '/'){
            console.log(thisURl.charAt(thisURl.length-1))
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
    }
    else if(login != null && token != null){
        $.ajax({
            type: "POST",
            url: "ajax/sessionSet.php",
            data:{
                'login':login,
                'token':token
            },
            success: function(data){
                // alert(data);
                // if(data == 'true'){}
                if(window.location.href.charAt(window.location.href.length-1) == '/'){
                    // window.location.href.charAt(window.location.href.length-1) == '/'
                    if(data == 'true'){
                        location.replace('profile_dashboard.php')
                        // location.replace('dashboard.php')
                    }
                } else{
                    if(data == 'false'){
                        location.replace('./')
                        localStorage.removeItem('id')
                        localStorage.removeItem('token')
                        // location.reload()
                        // let thisURl = window.location.href
                        // if(thisURl.charAt(thisURl.length-1) != '/'){
                        //     // console.log(thisURl.charAt(thisURl.length-1))
                        //     location.replace('./')
                        // }
                    }
                }
            }
        });
    }
});

$('#signin').click(function(){

    

    var name = document.getElementById('name');
    var pass = document.getElementById('pass');

    if(name.value == ''){
        name.style.border = '1px solid red';
    }
    else{
        name.style.border = '1px solid #bfc9d4';
        if(pass.value == ''){
            pass.style.border = '1px solid red';
            return false;
        }
    }

    if(pass.value != ''){
        pass.style.border = '1px solid #bfc9d4';
        
        $.ajax({
            type : 'POST',
            url : 'user-sign-in.php',
            data : {
                name : name.value,
                pass : pass.value,
            },
            success : function(data){
                // alert(data);
                if(data == 'Invalid username or Password'){
                    $('.validform').html('<span style="color:red; text-align:center">Invalid Username or Password <span>');
                    name.value = '';
                    pass.value = '';
                }
                else{
                    var employee = JSON.parse(data);
                    var emp_id = employee.emp_id;
                    var emp_token = employee.emp_token;
                    $.ajax({
                        type: "POST",
                        url: "ajax/sessionSet.php",
                        data:{
                            login : emp_id,
                            token : emp_token
                        },
                        success: function(data){
                            // alert(data);
                            if(data == 'true'){
                                localStorage.setItem('id', emp_id)
                                localStorage.setItem('token', emp_token)
                                localStorage.removeItem('msg');
                                location.replace('profile_dashboard.php');
                                // location.replace('dashboard.php');
                            }
                            else{
                                location.replace('./');
                            }
                        }
                    });
                }
            }
        });
    }
});

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

function clientStatus(i){
    $.ajax({
        type: "POST",
        url: "ajax/clientStatus.php",
        data:{'id':i},
        success: function(data){
            if(data == 'true'){
                $('#alertmeg').html("<div class='alert alert-success'><center>Successfully</center></div>").fadeIn('slow');
                $('#alertmeg').delay(2000).fadeOut('slow');
                return true;
            } else{
                alert("sorry");
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}
function designationStatus(i){
    $.ajax({
        type: "POST",
        url: "ajax/designationStatus.php",
        data:{'id':i},
        success: function(data){
            // alert(data);
            if(data == 'true'){
                $('#alertmeg').html("<div class='alert alert-success'><center>Successfully</center></div>").fadeIn('slow');
                $('#alertmeg').delay(2000).fadeOut('slow');
                return true;
            } else{
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}

function holidayStatus(i){
    $.ajax({
        type: "POST",
        url: "ajax/holidayStatus.php",
        data:{'id':i},
        success: function(data){
            // alert(data);
            if(data == 'true'){
                $('#alertmeg').html("<div class='alert alert-success'><center>Successfully</center></div>").fadeIn('slow');
                $('#alertmeg').delay(2000).fadeOut('slow');
                return true;
            } else{
                if(document.getElementById('S' + id).checked){
                    document.getElementById('S' + id).checked = false
                } else{
                    document.getElementById('S' + id).checked = true
                }
            }
        }
    });
}

// if($('#alert_msg').show()){
    $('#alert_msg').fadeTo(2000, 500).slideUp(500, function() {
        $('#alert_msg').slideUp(500);
    });
// }

function fileDelete(a,b,c,d){
    $.ajax({
        type : 'POST',
        url : 'delete_emp.php',
        data : {
            id : a,
            colomn : b,
            file : c,
            path : d
        },
        success : function(data){
            // alert(data);
            if(data == "True"){
                $('#panId'+b).remove();
            }
        }
    });
}

function attendanceAdd(){
    var date = $('#date');
    var userid = $('#userid');

    if(date.val() == ''){
        $('#date').addClass('check-border');
        return false;
    }
    else{
        $('#date').removeClass('check-border');
    }
    if(userid.val() == ''){
        $('#userid').addClass('check-border');
        return false;
    }
    else{
        $('#date').removeClass('check-border');
    }
}

// leave report page
// function getRequestType(a){
//     // var a = $('#leave_per').val();
//     // alert(a);
//     if(a != ""){
//         $.ajax({
//             url : 'ajax/leaveReport_check.php',
//             type : 'POST',
//             data : {
//                 rValue : a,
//             },
//             success : function(data){
//                 // alert(data);
//                 var values = jQuery.parseJSON(data);
//                 $lp_array =[];
//                 // alert(values.divTitle);
//                 values.divTitle;
//                 document.getElementById('div_title').innerHTML = values.divTitle;
//                 document.getElementById('div_title1').innerHTML = values.divTitle;
//             }
//         });
//     }
// }

var boxes = document.querySelectorAll(".notification-color");
  	var colors = ['#fa6b6b', '#677af5', '#5bbb5b', '#00abab', 'rosybrown', 'tan', 'plum', '#cb6d2a', '#abb56f', '#9b83e7', '#d5a448'];

  	boxes.forEach(function(box) {
    	var randomIndex = Math.floor(Math.random() * colors.length);
    	box.style.backgroundColor = colors[randomIndex];
    	colors.splice(randomIndex, 1); // Remove used color from array
		box.style.color = '#ffffff';

		// Reset colors array when all colors have been used
		if (colors.length === 0) {
    		colors = ['#fa6b6b', '#677af5', '#5bbb5b', '#00abab', 'rosybrown', 'tan', 'plum', '#cb6d2a', '#abb56f', '#9b83e7', '#d5a448'];
  		}
  	});
$( document ).ready(function() {
    const url = $("#valid").val();
    $("#calen").on("click", loadCalendar);
    var d = new Date();
    var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
    let prevUrl = document.referrer;
    if(prevUrl == url || prevUrl == "http://finalproyect.com/main/login"){
        eventClouse();
    }

    function eventClouse(){
        $.ajax({
            type: "POST",
            url: url+'main/ajax_loadEvents',
            responseType: "json",
            success: function(ev){
                toastr.options = {"progressBar": true,  "timeOut": "10000",}
                ev = JSON.parse(ev);
                ev.forEach(element =>{
                    var days = dates(element.start, strDate);
                    switch(days){
                        case 7:
                            toastr["info"]("You have a Event with the name <b>"+element.title+"</b> in a week", "Event Soon");
                        break;
                        case 3:
                            toastr["info"]("You have a Event with the name <b>"+element.title+"</b> in "+days+" days", "Event Soon");
                        break;
                        case 2:
                            toastr["warning"]("You have a Event with the name <b>"+element.title+"</b> in "+days+" days", "Event Soon");
                            break;
                        case 1:
                            toastr["warning"]("You have a Event with the name <b>"+element.title+"</b> in "+days+" day", "Event Soon");                        
                            break;
                        case 0:
                            toastr["success"]("TODAY, You have a Event with the name <b>"+element.title+"</b>", "Event Soon");                        
                        break;
                    }
                })
            },
            error: function(ev){
                console.log("error to get an Events");
            }
        })
    }
    
    function dates(f1,f2){
         var noHours = f1.split(" ");

         var aDate1 = noHours[0].split('-'); 
         var aDate2 = f2.split('-'); 
         var fDate1 = Date.UTC(aDate1[0],aDate1[1]-1,aDate1[2]); 
         var fDate2 = Date.UTC(aDate2[0],aDate2[1]-1,aDate2[2]); 
         var dif = fDate2 - fDate1;
         var days = Math.floor(dif / (1000 * 60 * 60 * 24)); 
         return days;
    }

    function loadCalendar(){
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          businessHours: true, 
          editable: true,
          selectable: true, 
          navLinks: true,
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev next today',
            center: 'title',
            right: 'dayGridMonth timeGridWeek timeGridDay listWeek'
          },
          events: url+'main/ajax_loadEvents',
          selectable: true,
          select: function(event){
              var start = moment(event.startStr).format('YYYY-MM-DDThh:mm:ss.SSS');
              var end =  moment(event.endStr).format('YYYY-MM-DDThh:mm:ss.SSS');
              var allDay = event.allDay;
              $("#crt").show();
              $("#dlt").hide();
              $("#upd").hide();
              $("#update").html("");

              $("#datec").attr("data-end", end);allDay
              $("#datec").attr("data-allday", allDay);
              $("#datec").val(start);
              $("#editCalendar").modal("show"); 
          },
          eventClick: function(info){
              var start = moment(info.event.startStr).format('YYYY-MM-DDThh:mm:ss.SSS');
              var end =  moment(info.event.endStr).format('YYYY-MM-DDThh:mm:ss.SSS');
              var allDay = info.event.allDay;
              $("#datec").attr("data-end", end);allDay
              $("#datec").attr("data-allday", allDay);
              $("#datec").attr("data-val",info.event.id);
              $("#datec").val(start);
              $("#color").val(info.event.backgroundColor);
              $("#eventName").val(info.event.title);
              $("#crt").hide();
              $("#dlt").show();
              $("#upd").show();

                html=  `     <label for="dateEn" class="form-label" >Date End</label>
                             <input type="datetime-local" class="form-control" id="dateEn" name="dateEn" value='${end}'>
                        `;
              if(allDay){
                html +=`<input type="checkbox" class="checkbox" id="alD" name="alD" value='true' checked>`;
              } else {
                html +=`<input type="checkbox" class="form-checkbox mt-2" id="alD" name="alD" >`;
              }
              html += `<label for="dateEn" class="form-label ml-2">All Day</label>`;
              $("#update").html(html);
              $("#editCalendar").modal("show"); 
          }
          
        });
      calendar.render();
    }

    $("#dlt").on("click", function(ev){
        Swal.fire({
          title: 'Delete Event?',
          text: "Do you want to remove this Event from your Calendar",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Acept'
        }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                type:"POST",
                url:url+"main/ajax_delet_event",
                responseType: "json",
                data: {"id":$("#datec").attr("data-val")}
            }).then(res=>{
                console.log(res);
                if(res != true){
                     Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: 'The event couldnot be deleted.',
                      showConfirmButton: false,
                      timer: 1000
                    });
                } else {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'The Even was deleted',
                      showConfirmButton: false,
                      timer: 1000
                    })
                    loadCalendar();
                }
            });
          }
        });    
    });

    $("#upd").on("click", function(ev){
        var name = $("#eventName").val();
        var date = $("#datec").val();
        var color = $("#color").val();
        var dateEnd = $("#dateEn").val();
        var value = $("#datec").attr("data-val");
        var allDay = 0;

        if ($('#alD').is(':checked')) {
            allDay = 1;
        }


        if(date == '' || name == '' || dateEnd == '' || value ==''){
            Swal.fire(
                'Aviso',
                'All of inputs are necesary.',
                'warning'
            );
        } else {
            $.ajax({
                type:"POST",
                url:url+"main/ajax_update",
                responseType: "json",
                data: {"name": name, "dateStart":date, "dateEnd":dateEnd, "allDay":allDay, "color":color, "id": value}
            }).then(res=>{
                console.log(res);
                if(res != true){
                     Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: 'The event couldnot be saved.',
                      showConfirmButton: false,
                      timer: 1000
                    });
                } else {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'New Event was created',
                      showConfirmButton: false,
                      timer: 1000
                    })
                    loadCalendar();
                }
            });
        }
    });

    $("#crt").on("click", function(ev){
        var name = $("#eventName").val();
        var date = $("#datec").val();
        var color = $("#color").val();
        var dateEnd = $("#datec").attr("data-end");
        var allDay = $("#datec").attr("data-allday");

        if(date == '' || name == '' || dateEnd == '' || color ==''){
            Swal.fire(
                'Aviso',
                'All of inputs are necesary.',
                'warning'
                );
        } else {
            $.ajax({
                type:"POST",
                url:url+"main/ajax_newEvent",
                responseType: "json",
                data: {"name": name, "dateStart":date, "dateEnd":dateEnd, "allDay":allDay, "color":color}
            }).then(res=>{
                console.log(res);
                if(res != true){
                     Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: 'The event couldnot be saved.',
                      showConfirmButton: false,
                      timer: 1000
                    });
                } else {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'New Event was created',
                      showConfirmButton: false,
                      timer: 1000
                    })
                    loadCalendar();
                }
            });
        }
 
    })


    //load first time
    updateMsg();

    //recover the password
    $("#forgotP").on("click", function(){
        $.ajax({
            type: "POST",
            url: url+"main/ajax_forgot_pass",
            responseType: "html",
            data: {"email": $("#fmail").val()},
            success:function(re){
                console.log(re);
                if(re == ""){
                    toastr.error("The Email dosn't exist in on teh database.");
                } else {
                    $(".modal-body").html(re);
                }
            }
        })
    });

    $('#loginForm').submit(function (ev) {
        $.ajax({
            type: $('#loginForm').attr('method'), 
            url: url+"main/ajax_login",
            responseType: "json",
            data: {email: $("#email").val(), pass: $("#pass").val()},
            }).then(res=>{
                res = JSON.parse(res);
                if(res.ResultCode == "ERROR"){
                    $("#notify").text(res.message);
                    $("#pass").val("");
                    $("#email").focus(); 
                } else {
                        eventClouse();
                $(location).attr('href',url+"main/dashboard");
                }
            })
            ev.preventDefault();
    });

    //Ajax for Create an User
    $('#create-user').submit(function (ev) {

        var fd = new FormData();
        var files = $('#photo')[0].files;
        ev.preventDefault();   
        fd.append('file',files[0]);
        fd.append('name',$("#name").val());
        fd.append('last_name',$("#last_name").val());
        fd.append('passport',$("#passport").val());
        fd.append('typeUser',$("#typeUser").val());
        fd.append('email',$("#email").val());
        fd.append('pass',$("#pass").val());

        $.ajax({
            type: $('#create-user').attr('method'), 
            url: url+"adminController/ajax_newUser",
            responseType: "json",
            data: fd,
            contentType: false,
            processData: false,
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    toastr.error('An error has occurred the user has not been inserted '+res.message);
                } else {
                    $.ajax({
                        type: $('#create-user').attr('method'), 
                        url: url+"adminController/ajax_newPass",
                        responseType: "json",
                        }).then(res=>{
                            var newPassword = res;
                            $('#create-user')[0].reset();
                            $("#pass").val(newPassword);
                        });
                    toastr.success('New User was created.');
                }
            })
    });

    //Ajax create a Course
    $('#course-form').submit(function (ev) {
        var fd = new FormData();
        var files = $('#course_img')[0].files;
        ev.preventDefault();  

        fd.append('file',files[0]);
        fd.append('course_name',$("#course_name").val());
        fd.append('students',$("#students").val());
        fd.append('course_description',$("#course_description").val());
        $('input[type="submit"]').attr("disabled", "disabled");

        $.ajax({
            type: $('#course-form').attr('method'), 
            url: url+"adminController/ajax_createCourse",
            responseType: "json",
            data: fd,
            contentType: false,
            processData: false,
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    $('input[type="submit"]').removeAttr("disabled");
                    toastr.error('An error has occurred to create a new course '+res.message);
                } else {
                    $('#course-form')[0].reset();
                    $('input[type="submit"]').removeAttr("disabled");
                    toastr.success('New Course was created.');
                }
            })

    });

    //Ajax update a Course
    $('#course-update-form').submit(function (ev) {
        var fd = new FormData();
        var files = $('#course_img')[0].files;
        ev.preventDefault();  
        fd.append('file',files[0]);
        fd.append('course_name',$("#course_name").val());
        fd.append('students',$("#students").val());
        fd.append('course_description',$("#course_description").val());
        fd.append('course_id', $("#td-course_id").attr("data-val"));
        $('input[type="submit"]').attr("disabled", "disabled");

        $.ajax({
            type: $('#course-update-form').attr('method'), 
            url: url+"adminController/ajax_updateCourse",
            responseType: "json",
            data: fd,
            contentType: false,
            processData: false,
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    $('input[type="submit"]').removeAttr("disabled");
                    toastr.error('An error has occurred to update a new course '+res.message);
                } else {
                    $('#course-update-form')[0].reset();
                    $('input[type="submit"]').removeAttr("disabled");
                    toastr.success('Updated Course.');
                    location.reload();  
                }
            });
    });

    //Unsuscribe user.
    $(document).on("click", ".btn-un", function(){
        var id = $(this).attr("data-user-id");
        var course = $(this).attr("data-course-id");
        var userName = $("#td-fullName").text();
        var courseName = $("#td-course-name").text();

        Swal.fire({
          title: 'Unsuscribe User from '+ courseName+"?",
          text: "Do you want to remove user: "+userName+" from "+courseName+"?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Acept'
        }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                type:"POST",
                url:url+"CourseController/ajax_unsuscribe_user",
                responseType: "json",
                data: {"course_id":course, "user_id":id}
            }).then(res=>{
                if(res != true){
                     Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: 'The User couldnot be unsuscribe.',
                      showConfirmButton: false,
                      timer: 1000
                    });
                } else {
                    Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'The User was unsuscribe',
                      showConfirmButton: false,
                      timer: 1000
                    });
                    location.reload();
                }
            });
          }
        }); 
    });

    $(document).on("click", "#yes", function(){
       var url  =  $("#deleteUser").attr("data-url");
        $.ajax({
            type: "POST", 
            url: url+"adminController/ajax_deleteUser",
            responseType: "json",
            data: {user_id: id},
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    toastr.error(res.message);
                } else {                        
                   $(location).attr('href',url+"adminController/showUsers");
                }
            })
    });


    //Create Datatable
    $('#dataTable').DataTable();
    $('#file-table').DataTable();
    $('#usr-table').DataTable();

    //Check if the pass and confirm pass are same
    $("#c_pass").keyup(function(){
        if($("#c_pass").val() != $("#pass").val() || $("#c_pass").val() == ""){
            $("#pp-diferent").removeClass("d-none");
            $("#pp-true").addClass("d-none");

        } else {
            $("#pp-diferent").addClass("d-none");
            $("#pp-true").removeClass("d-none");
        }
    });

    $('#update-user').submit(function (ev) {
        var fd = new FormData();
        var files = $('#photo')[0].files;
        ev.preventDefault();   
        fd.append('file',files[0]);
        fd.append('name',$("#name").val());
        fd.append('last_name',$("#last_name").val());
        fd.append('passport',$("#passport").val());
        fd.append('typeUser',$("#typeUser").val());
        fd.append('email',$("#email").val());
        fd.append('pass',$("#pass").val());
        fd.append('hash',$('#update-user').attr('action'));

        // Check file selected or not
        if($("#c_pass").val() == $("#pass").val() && $("#c_pass").val() != ""){
            $.ajax({
                type: $('#update-user').attr('method'), 
                url: url+"main/ajax_updateUser",
                responseType: "json",
                data: fd,
                contentType: false,
                processData: false,
                }).then(res=>{
                    res = JSON.parse(res);
                    if(res.status == "ERROR"){
                        toastr.error('An error has occurred the user has not been inserted because: '+res.message);
                    } else {                        
                        toastr.success('New User was created.');
                       $(location).attr('href',url+"main/dashboard");
                    }
                })
                ev.preventDefault();   
        }
    });

    var id; 
    $(document).on("click", ".btn-del", function(){
        id = $(this).attr("data-id");
    });
    $(document).on("click", "#yes", function(){
       var url  =  $("#deleteUser").attr("data-url");
        $.ajax({
            type: "POST", 
            url: url+"adminController/ajax_deleteUser",
            responseType: "json",
            data: {user_id: id},
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    toastr.error(res.message);
                } else {                        
                   $(location).attr('href',url+"adminController/showUsers");
                }
            })
    });

    //Ajax Send a Message
    $('#msg-form').submit(function (ev) {
        ev.preventDefault();  
        $('input[type="submit"]').attr("disabled", "disabled");

        $.ajax({
            type: $('#msg-form').attr('method'), 
            url: url+"main/ajax_sendMsg",
            responseType: "json",
            data:{subject: $('#subject').val(), receptors: $('#receptor').val(), message:  $('#msg').val()},

            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    $('input[type="submit"]').removeAttr("disabled");
                    toastr.error('An error has occurred to send a message '+res.message);
                } else {
                    $('#msg-form')[0].reset();
                    $('input[type="submit"]').removeAttr("disabled");
                    toastr.success('Message Sended.');
                }
            })
    });


    //Update New MSG
    updateMsg();
    function updateMsg(){
        $.ajax({
            type: $('#msg-form').attr('method'), 
            url: url+"main/ajax_updateMsg",
            responseType: "json",
            }).then(res=>{
                res = JSON.parse(res);
                var count = 0;
                if(res != null){
                    res.forEach(element => {
                        if(element.view == 0){
                            count++;
                        }
                    })
                    if(count == 0){
                        $("#msgNew").text("");
                    }else {
                        $("#msgNew").text(count);
                    }

                    $(".here").html(pintMSG(res));   
                }
                window.setTimeout(updateMsg, 30000);
        });
     }

     //Update status relation view  
     $(document).on("click", ".chat", function(ev){
         var url = $(this).attr("data-url")+"main/ajax_updateRelation";
         ev.preventDefault();   
         $.ajax({
             type: $('#msg-form').attr('method'), 
             url: url,
             responseType: "json",
             data:{relation_id: $(this).attr("data-relation-id")},
             }).then(res=>{
                 res = JSON.parse(res);
                 $("#usr-img").attr("src", res[0].site_url+res[0].creator_img);
                 $("#UserName").text(res[0].user_create +" · " +res[0].date);
                 $("#signature").text(res[0].subject);
                 $("#msgText").text(res[0].msg_text);
                updateMsg();
             })
     });

     //PRINT MESSAGES
     function pintMSG(msg){
         html = "";
         msg.forEach(element => {

            html += `                               
                <button type='submit' class="dropdown-item d-flex align-items-center chat" data-url='${element.site_url}' data-bs-toggle="modal" data-relation-id='${element.relation_id}' data-bs-target="#view-msg" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="${url+element.creator_img}"
                            alt="Picture Profile">
                    </div>`;
                    if(element.view == 0){
                        html +="<div class='font-weight-bold'>" ;
                    } else {
                        html +="<div>";
                    }
                    html +=`
                        <div class="text-truncate">${element.subject}.</div>
                        <div class="text-truncate small">${element.msg_text}.</div>
                        <div class="small text-gray-500">${element.user_create}</div>
                        <div class="small text-gray-500">${element.date}</div>

                    </div>
                </button>`;
         });
         return html;
     }

     //Show File on HTML
     $(".sh").on("click", function(){
        var url = $(this).attr("data-url-file");
        var file = $(this).attr("data-file");
        var site = $("#val").attr("data-site");
        $.ajax({
            type: "POST",
            data: {"path": url, "file": file},
            url: site+"CourseController/ajax_PrintHTML",
            responseType: "html",
                success: function(res){
                    $("#showf").html(res);
                }
        });
     });

    
    //Upload FILE
    $('#file-form').submit(function (ev) {
        var fd = new FormData();
        var files = $('#newFile')[0].files;
        var site = $("#valid").attr("data-site");
        var url = $(this).attr("data-url-file");

        ev.preventDefault();   
        fd.append('file',files[0]);
        fd.append('path',url);

    // Check file selected or not
        $.ajax({
            type: $('#file-form').attr('method'), 
            url: site+"CourseController/ajaxUploadFile",
            responseType: "json",
            data: fd,
            contentType: false,
            processData: false,
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    toastr.error('An error has occurred the user has not been inserted because: '+res.message);
                } else {                        
                    toastr.success('New User was created.');
                    location.reload();
                }
        })
        ev.preventDefault();   
    });
     //DELETE FILE 
     $(".dr").on("click", function(){
        var url = $(this).attr("data-url-file");
        var file = $(this).attr("data-file");
        var site = $("#valid").attr("data-site");
        
        $.ajax({
            type: "POST",
            data: {"path": url, "file": file},
            url: site+"CourseController/ajax_delete",
            responseType: "json",
                success: function(res){
                    if(res.status == "ERROR"){
                        toastr.error('An error has occurred to send a message '+res.message);
                    } else {
                        toastr.success("The file has been deleted");
                        location.reload();

                    }
                }
        });
     });

     $("#btn-o").on("click", function(){
        openCloseCourse(1);
     });

      $("#btn-c").on("click", function(){
        openCloseCourse(0);
     });

     function openCloseCourse(status){
        var course_id = $("#td-course_id").attr("data-val");
        $.ajax({
            type: "POST", 
            url: url+"CourseController/ajax_openClose_Course",
            responseType: "json",
            data: {"status": status, "course_id": course_id},
            }).then(res=>{
                res = JSON.parse(res);
                if(res.status == "ERROR"){
                    toastr.error(res.message);
                } else {                        
                    toastr.success(res.message);
                    if(status == 1){
                        $("#btn-c").removeClass("d-none");
                        $("#btn-o").addClass("d-none");
                    } else {
                        $("#btn-o").removeClass("d-none");
                        $("#btn-c").addClass("d-none");
                    }
                }
            });
     }

});

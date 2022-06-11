$( document ).ready(function() {
    const url = $("#valid").val();
    $("#calen").on("click", loadCalendar);
    var d = new Date();
    var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
    let prevUrl = document.referrer;
    if(prevUrl == url || prevUrl == "https://finalproyect.com/main/login"){
        eventClouse();
    }
    if($("#count-questions").attr("data-value") == "false"){
        toastr.warning("You have exams with unassigned questions.")
    }

    // Get Calendary Events
    function eventClouse(){
        $.ajax({
            type: "POST",
            url: url+'main/ajax_loadEvents',
            responseType: "json",
            success: function(ev){
                toastr.options = {"progressBar": true,  "timeOut": "10000",}
                if(ev !== ""){
                    ev = JSON.parse(ev);
                    ev.forEach(element =>{
                        var days = dates(element.start, strDate);
                        switch(days){
                            case -7:
                                toastr["info"]("You have a Event with the name <b>"+element.title+"</b> in a week", "Event Soon");
                                break;
                            case -3:
                                toastr["info"]("You have a Event with the name <b>"+element.title+"</b> in "+days+" days", "Event Soon");
                                break;
                            case -2:
                                toastr["warning"]("You have a Event with the name <b>"+element.title+"</b> in "+days+" days", "Event Soon");
                                break;
                            case -1:
                                toastr["warning"]("You have a Event with the name <b>"+element.title+"</b> in "+days+" day", "Event Soon");
                                break;
                            case 0:
                                toastr["success"]("TODAY, You have a Event with the name <b>"+element.title+"</b>", "Event Soon");
                                break;
                        }
                    })
                }

            },
            error: function(ev){
                console.log("error to get an Events" + ev);
            }
        })
    }
    
    function dates(f1,f2){
         var noHours = f1.split(" ");

         let aDate1 = noHours[0].split('-');
         let aDate2 = f2.split('-');
         let fDate1 = Date.UTC(aDate1[0],aDate1[1]-1,aDate1[2]);
         let fDate2 = Date.UTC(aDate2[0],aDate2[1]-1,aDate2[2]);
         let dif = fDate2 - fDate1;
         let days = Math.floor(dif / (1000 * 60 * 60 * 24));
         return days;
    }

    //load Calendar
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

    //Delete Calendar Event
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

    //Update Calendar Events
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

    //Create a new Calendar Event
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

    //LOGIN USER
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

    function nif(dni) {
        var numero
        var letr
        var letra
        var expresion_regular_dni

        expresion_regular_dni = /^\d{8}[a-zA-Z]$/;

        if(expresion_regular_dni.test (dni) == true){
            numero = dni.substr(0,dni.length-1);
            letr = dni.substr(dni.length-1,1);
            numero = numero % 23;
            letra='TRWAGMYFPDXBNJZSQVHLCKET';
            letra=letra.substring(numero,numero+1);
            if (letra!=letr.toUpperCase()) {
                toastr.error('Wrong DNI, the letter of NIF is not valit');
                return false;
            }
        }else{
            toastr.error('Wrong DNI, invalid format');
            return false;
        }
        return true;
    }

    //Ajax for Create a New User
    $('#create-user').submit(function (ev) {
        var fd = new FormData();
        var files = $('#photo')[0].files;
        ev.preventDefault();

        if(!nif($("#passport").val())){
            $("#passport").focus();
            return false;
        }

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

    //Update Users
    $('#update-user').submit(function (ev) {
        var fd = new FormData();
        var files = $('#photo')[0].files;
        var url = $("#valido").val();
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
        } else {
            toastr.warning("Password fields are not the same")
        }
    });

    $(document).on("click", ".btn-op", function(ev){
        var url  =  $("#deleteUser").attr("data-url");
        var id =  $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: url+"adminController/ajax_openAccount",
            responseType: "json",
            data: {"user_id": id},
        }).then(res=>{
            console.log(res)
            res = JSON.parse(res);
            if(res.status == "true"){
                toastr.success(res.message);
                $(location).attr('href',url+"adminController/showUsers");
            } else {
                toastr.error("An error occurred, the account couldn't status chance");
                $(location).attr('href',url+"adminController/showUsers");
            }
        })
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
                toastr.success(res.message);
                $(location).attr('href',url+"adminController/showUsers");
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

    //Create Datatable
    $('#dataTable').DataTable();
    $('#file-table').DataTable();
    $('#usr-table').DataTable();
    $('#question-test-table').DataTable();
    $('#question-bank').DataTable();
    $("#table-user-review").DataTable();


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
        var path = $(this).attr("data-url-file");
        var file = $(this).attr("data-file");
        $.ajax({
            type: "POST",
            data: {"path": path, "file": file},
            url: url+"CourseController/ajax_PrintHTML",
            responseType: "html",
                success: function(res){
                    $("#showf").html(res);
                }
        });
     });

    
    //Upload FILE
    $('#file-form').submit(function (ev) {
        ev.preventDefault();   
        var fd = new FormData();
        var files = $('#newFile')[0].files;
        var path = $(this).attr("data-url-file");
        fd.append('file',files[0]);
        fd.append('path',path);

    // Check file selected or not
        $.ajax({
            type: $('#file-form').attr('method'), 
            url: url+"CourseController/ajaxUploadFile",
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
        var path = $(this).attr("data-url-file");
        var file = $(this).attr("data-file");
        
        $.ajax({
            type: "POST",
            data: {"path": path, "file": file},
            url: url+"CourseController/ajax_delete",
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
        location.reload();
     });

      $("#btn-c").on("click", function(){
        openCloseCourse(0);
        location.reload();
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


     //REPLY A POST
     $('.reply-post').submit(function (ev) {
        ev.preventDefault(); 
        var replay = $(this).attr("data-r");
        var msg = $("#write-replay-"+replay).val();
        var course =$("#courseVista").attr("data-id-course");

        if(msg == "" || msg.length < 5){
            toastr.error('You cannot send an empty message or sort post.');
            $("#btn-replay").removeAttr("disabled");
            return false;
        }

        $.ajax({
            type: $('.reply-post').attr('method'), 
            url: url+"CourseController/ajax_write",
            responseType: "html",
            data: {"msg": msg, "course_id": course, "replay": replay},
            }).then(res=>{
                if(res.status == "ERROR"){
                    toastr.error('An error has occurred you did not create a post because: '+res.message);
                } else {                        
                    toastr.success('New post was created.');
                    //$("#foroHere").html(res);
                    $("#write-replay-"+replay).val("");
                    $("#btn-replay").removeAttr("disabled");
                    location.reload();// It's necesary to fix problem with the news textarea.
                }
        })
        ev.preventDefault();   
    });

         //WRITE A POST
         $('#new-post').submit(function (ev) {
            $("#btn-new-post").attr("disabled", "disabled");
            ev.preventDefault();   
            var msg = $("#write-new-post").val();
            var course =$("#courseVista").attr("data-id-course");

            if(msg == "" || msg.length < 5){
                toastr.error('You cannot send an empty message or sort post.');
                $("#btn-new-post").removeAttr("disabled");
                return false;
            }

            $.ajax({
                type: "POST", 
                url: url+"CourseController/ajax_write",
                responseType: "html",
                data: {"msg": msg, "course_id": course},
                }).then(res=>{
                    if(res.status == "ERROR"){
                        toastr.error('An error has occurred you did not create a post because: '+res.message);
                    } else {                        
                        toastr.success('New post was created.');
                        //$("#foroHere").html(res);
                        $("#write-new-post").val("");
                        $("#btn-new-post").removeAttr("disabled");
                        location.reload();// It's necesary to fix problem with the news textarea.
                    }
            })
        });


         //SHOW OR HIDE THE BUTTONS IF YOU ARE OR YOU AREN'T LOGGIN ON ZOOM
         if(prevUrl == "https://zoom.us/"){
            $("#lz").hide();
             printMeetings();
            $("#cm").show();
         } else {
            $("#cm").hide();
            $("#lz").show();
         }


         //Create A Meeting
         $('#newMeeting').submit(function (ev) {
            $("#btn-meet-c").attr("disabled", "disabled");
            ev.preventDefault(); 
            var meetP = $("#meetP").val();
            var dateM = $("#dateM").val();
            var meetTitle = $("#meetTitle").val();
            var meetTime = $("#meetTime").val();

            $.ajax({
                type: "POST", 
                url: url+"ZoomController/ajax_create_meeting",
                responseType: "json",
                data: {"date": dateM, "title": meetTitle, "time": meetTime, "pass":meetP},
                }).then(res=>{
                    console.log(res);
                    if(res == "undefined" ||  res == undefined || res == ""){
                        toastr.error('An error has occurred to create a meeting. The result are undefined');
                        $("#createMeet").modal("hide");
                        $("#btn-meet-c").removeAttr("disabled");
                        return;
                    }
                    res = JSON.parse(res);

                    if(!res.status){
                        toastr.error('An error has occurred to create a meeting: '+res.message);
                    } else {                        
                        toastr.success('New Meeting was created.');
                        printMeetings();
                        $("#write-new-post").val("");
                        $("#btn-meet-c").removeAttr("disabled");
                        $("#createMeet").modal("hide");
                        $('#newMeeting')[0].reset();
                         var course =$("#td-course_id").attr("data-val");
                         var msg = "<p>Hi everyone,</p><p>The class meeting from today is available on Zoom at: "+dateM+". Please be <b>Punctual</b></p><p>Meeting URL: <a href='"+res.url+"' target='_blank'>"+res.url+"</a></p><p>Passcode: <b>"+res.pass+"</b></p>";
                          $.ajax({
                                //send the new meeting to the course forum
                                type: "POST", 
                                url: url+"CourseController/ajax_write",
                                responseType: "html",
                                data: {"msg": msg, "course_id": course},
                            }).then(res=>{
                                if(res.status == "ERROR"){
                                    toastr.error('An error has occurred you did not create a post because: '+res.message);
                                }
                            })
                            //new password
                            $.ajax({
                                type: "POST", 
                                url: url+"adminController/ajax_newPass",
                                responseType: "json",
                            }).then(res=>{
                                var newPassword = res;
                                $("#meetP").val(newPassword);
                            });
                    } //else
            })//then
        });

         //PRINT MEETINGSTABLES
         function printMeetings(){
            $.ajax({
                type: "POST", 
                url: url+"ZoomController/ajax_table_meetings",
                responseType: "html",
                success: function(ev){
                    $("#meetingsHere").html(ev);
                },
                error: function(ev){
                    toastr.error("You got an error. "+ev);
                }
            })
         }

         //DELETE MEETINS
         $(document).on("click", ".btn-dmeet", function(ev){
            let meet_id = $(this).attr("data-meet-id");
            Swal.fire({
                  title: 'Delete Meeting?',
                  text: "Do you want to remove this Meeting?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Acept'
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            type: "POST", 
                            url: url+"ZoomController/ajax_deleteMeet",
                            responseType: "json",
                            data: {"meet_id": meet_id},
                            }).then(res=>{
                                res = JSON.parse(res);
                                if(res.status != "true"){
                                    toastr.error('An error has occurred you could not deleted the Meeting: '+res.message);
                                } else {                        
                                    toastr.success(res.message);
                                    printMeetings();
                                }
                        })//then
                    }

                });
        });//function

         $(document).on("click", ".btn-umeet", function(ev){
            var topic = $(this).attr("data-topic");
            var duration = $(this).attr("data-duration");
            var date = $(this).attr("data-date");
            date = date.substring(0, date.length - 1);

            var meet_id = $(this).attr("data-meet-id");
            $("#upTopic").val(topic);
            $("#dateMUp").val(date);
            $("#meetTimeUp").val(duration);
            $("#mup").val(meet_id);
                      //new password
            $.ajax({
                type: "POST", 
                url: url+"adminController/ajax_newPass",
                responseType: "json",
            }).then(res=>{
                var newPassword = res;
                $("#passUp").val(newPassword);
            });

            $("#m-title-up").text("Update Meeting with name: "+ topic);
            $("#updateMeet-m").modal("show");
         })//function

         $("#btn-meet-upd").on("click", function(ev){
            ev.preventDefault();  
            $.ajax({
                type: "POST", 
                url: url+"ZoomController/ajax_update_meeting",
                responseType: "json",
                data: {"meet_id": $("#mup").val(), "title": $("#upTopic").val(), "date": $("#dateMUp").val(), "time":$("#meetTimeUp").val(), "newPass": $("#nuevaPass")[0].checked, "password": $("#passUp").val()},
                }).then(res=>{
                    res = JSON.parse(res);
                    if(res.status != "true"){
                        toastr.error('An error has occurred you could not update this Meeting: '+res.message);
                    } else {                        
                        toastr.success(res.message);
                        printMeetings();
                        $("#updateMeet-m").modal("hide");
                    }
            })//then
         });//function

    //ANSWERS AND EDIT TEST

    //this function remove test
    $(document).on("click", ".btn-test-delete", function(){
        let test_id =  $(this).attr("data-test-id");
        $.ajax({
            type: "POST",
            url:url+"TestController/ajax_deleteTest",
            data: {"test_id": test_id},
            success: function(result){
                result = JSON.parse(result);
                if(result.status == "true"){
                    toastr.success("Test Removed");
                    location.reload();
                } else {
                    toastr.error(result.message);
                }
            }
        })
    });

    //This function you can permit chance the correct answer
    $(document).on("click", ".btn-true-value", function(ev){
        if($("#question_type").val() == "simple"){
            for(var i = 0; i < $(".btn-true-value").length; i++){
                var sp = $(".btn-true-value")[i];
                $(sp).next("input").attr("data-type", 0);
                $(sp).text("X");
                $(sp).removeClass("bg-success");
                $(sp).addClass("bg-danger");
                $(this).next("input").attr("data-type", 1);
                $(this).removeClass("bg-danger");
                $(this).text("✓");
                $(this).addClass("bg-success");
            }
        } else if($("#question_type").val() == "multiple"){
            if($(this).next("input").attr("data-type") == "1"){
                $(this).next("input").attr("data-type", 0);
                $(this).text("X");
                $(this).removeClass("bg-success");
                $(this).addClass("bg-danger");
            } else {
                $(this).next("input").attr("data-type", 1);
                $(this).removeClass("bg-danger");
                $(this).text("✓");
                $(this).addClass("bg-success");
            }
        }

    });

    //Add new answer
    $(document).on("click", "#btn-new-answer", function(ev){
        ev.preventDefault();
        html = "    <div class='row mb-2'>\n" +
            "           <div class='input-group col-md-10 m-auto'>\n" +
            "                <span class='input-group-text bg-danger btn-true-value'>X</span>\n" +
            "                <input type='text' class='form-control answer-t' placeholder='Answer text...' data-type='0' aria-describedby='basic-addon1' required/>\n" +
            "               <button class='btn btn-danger m-auto btn-group-sm btn-del-answer' title='Remove Answer'><span class=''>-</span></button>"+
            "           </div>\n" +
            "        </div>";
        $("#content-answer").append(html);
    });

    //Remove a new answer and if the answer is the true change the true at first one option
    $(document).on("click", ".btn-del-answer", function(ev){
        ev.preventDefault();
        if($(this).prev().attr("data-type") == 1){
            var sp = $(".btn-true-value")[0];
            $(sp).next("input").attr("data-type", 1);
            $(sp).text("✓");
            $(sp).removeClass("bg-danger");
            $(sp).addClass("bg-success");
        }
        $(this).parent().parent().remove();
    })

    $("#question_type").on("change", function(ev){
        switch ($(this).val()){
            case "simple":
                $(".basicAnswer").removeClass("d-none");
                $("#contentNewAnswer").remove();
                $("#content-answer").html(printSimple());
                $("#content-answer").after(buttonNewAnswer());

                break;
            case "multiple":
                $(".basicAnswer").removeClass("d-none");
                $("#content-answer").html(printSimple());
                $("#contentNewAnswer").remove();
                $("#content-answer").after(buttonNewAnswer());
                break;
            case "written":
                $(".basicAnswer").removeClass("d-none");
                $("#content-answer").html(writtenAnswer());
                $("#contentNewAnswer").remove();
                break;
        }
    });


    function printSimple(){
      let  html = `
                    <div class='row mb-2'>
                        <div class='input-group col-md-10 m-auto'>
                            <span class='input-group-text bg-success btn-true-value'>&#10003;</span>
                            <input type='text' class='form-control answer-t' placeholder='Answer text...' data-type='1' aria-describedby='basic-addon1' required/>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <div class='input-group col-md-10 m-auto'>
                            <span class='input-group-text bg-danger btn-true-value'>X</span>
                            <input type='text' class='form-control answer-t' placeholder='Answer text...' data-type='0' aria-describedby='basic-addon1' required/>
                        </div>
                    </div>
                </div>`;

        return html;
    }

    function writtenAnswer(){
        let html = ` 
                    <div class='row mb-5'>
                        <div class='input-group col-md-10 m-auto'>
                            <span class='input-group-text'>Answer Description *</span>
                            <input type='text'  name='question_d' id='question_d' class='form-control input-group-lg' placeholder='Separate the possible results by commas' data-type='0' aria-describedby='basic-addon1' required/>
                        </div>
                    </div>`;

        return html;
    }

    function buttonNewAnswer(){
        let html = `<div class='row mb-2' id='contentNewAnswer'>
                    <div class='input-group col-md-10 m-auto'>
                        <button class='btn btn-primary m-auto btn-group-sm' id='btn-new-answer' title='New Answer'>
                            <span class='fa fa-plus'></span>
                        </button>
                    </div>
                </div>`;
        return html;
    }

    $("#createQuestion").on("click", function(ev){
        ev.preventDefault();

        var nicE = new nicEditors.findEditor('question_des');
        question = nicE.getContent();
        let question_d = $("#question_d").val();
        let title = $("#title").val();
        let question_type = $("#question_type").val();
        let description = question;
        let answerTrue = [];
        let answerFalse = [];

        for(var i = 0; i < $(".answer-t").length; i++){
            var at = $(".answer-t")[i];
            if($(at).attr("data-type") == 1){
                answerTrue.push($(at).val());
            } else {
                answerFalse.push($(at).val());
            }
        }

        if((question_d == "" || question_d == undefined) && question_type == "written"){
            toastr.warning("The answer cannot be empty")
            return false;
        }

        if(title == ""){
            toastr.warning("Title cannot be empty.")
            $("#title").focus()
            return false;
        }

        if(description == "" || description == "<br>"){
            toastr.warning("Description cannot be empty")
            $(description).focus();

            return false;
        }

        for (var i = 0; i < answerTrue.length; i++){
            if(answerTrue[i] == ""){
                toastr.warning("There can be no empty true answers.")
                return false;
            }
        }

        for (var i = 0; i < answerFalse.length; i++){
            if(answerFalse[i] == ""){
                toastr.warning("There can be no empty false answers.")
                return false;
            }
        }

       $.ajax({
           type: "POST",
           url:url+"TestController/ajax_createQuestion",
           data: {"title": title, "question_type": question_type, "description": description, "question_d": question_d, "answerTrue":answerTrue, "answerFalse": answerFalse },
           success: function(result){
               result = JSON.parse(result);
               if(result){
                   toastr.success("New Answer was created!.");
                   location.reload();
               } else {
                   toastr.error(result.message);
               }

           }
       });//ajax
    });

    $(document).on("click", "#add-question-test", function () {
        $.ajax({
            type: "POST",
            url:url+"TestController/ajax_addQuestionTest",
            data: {"question_id": $(this).attr("data-id"), "test_id": $(this).attr("data-test")},
            success: function(result){
                result = JSON.parse(result);
                if(result.status == "true"){
                    toastr.success("Test updated");
                    location.reload();
                } else {
                    toastr.error(result.message);
                }
            }
        })
    });

    //this function remove question from test
    $(document).on("click", ".btn-remove-test", function(){
        let test_id =  $(this).attr("data-test-id");
        let question_id = $(this).attr("data-id");
        Swal.fire({
            title: 'Delete Question from Test?',
            text: "Are you sure that you want delete this question on this Test?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Acept'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url:url+"TestController/ajax_removeQuestionTest",
                    data: {"test_id": test_id, "question_id": question_id},
                    success: function(result){
                        result = JSON.parse(result);
                        if(result.status == "true"){
                            toastr.success("Question Removed");
                            location.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            }
        });
    });

    $(document).on("click", ".btn-del-question", function(){
        let question_id = $(this).attr("data-id");
        Swal.fire({
            title: 'Delete Question?',
            text: "Are you sure that you want delete this Question?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Acept'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url:url+"TestController/ajax_removeQuestion",
                    data: {"question_id": question_id},
                    success: function(result){
                        result = JSON.parse(result);
                        if(result.status == "true"){
                            toastr.success("Question Removed");
                            location.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    }
                })
            }
        });
    });

    $(document).on("click", ".btn-view-qest", function(){
        let question_id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url:url+"TestController/ajax_questionView",
            data: {"question_id": question_id},
            resultType: "html",
            success: function(result){
                $("#modal-view-question").html(result);
                $("#viewQuestion").modal("show");
            }
        })
    });

    $("#startTest").on("click", function(ev){
        ev.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to come back once you have started the test.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: 'red',
            confirmButtonText: 'Yes, start it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = this.href;
            }
        })
    });

    $(document).on("click", ".btn-open-test", function (){
       testId = $(this).attr("data-test-id");
       btn_status = $(this).attr("data-test-status");
        $.ajax({
            type: "POST",
            url: url+"TestController/openTest",
            data: {test_id:testId, status: btn_status},
            responseType: "json",
            success: function(resp){
                resp = JSON.parse(resp);
                if(resp.status == "true"){
                    toastr.success(resp.message);
                    location.reload();
                } else {
                    toastr.error("You got an error."+resp.message);
                }

            }
        })
    });


    //MIGUEL ---------------------------------------------------------------------------
    $("#createTeacherWithCode").on("click", function(ev){
        ev.preventDefault();
        $.ajax({
            type: "POST",
            url: url+"AdminController/ajax_teacherCreate",
            responseType: "json",
            success: function(data){
                data = JSON.parse(data);
                console.log(data);
                if(data.status == "200"){
                    $("#showTeacherCode").text(data.message);
                    $("#teacherCodeModal").modal('show');
                } else {
                    toastr.error(data.message);
                }
            }
        });
    });

    $('#btn-newTeacher').on("click", function (ev) {
        ev.preventDefault();
        let url = $("#url").val();
        if(!nif($("#passport").val())){
            $("#passport").focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: url+"adminController/ajax_newTeacher",
            responseType: "json",
            data: {"name": $("#name").val(), "last_name": $("#last_name").val(), "passport": $("#passport").val(),"typeUser": 3, "email": $("#email").val(), "pass": $("#pass").val(), "code": $("#code").val() },
        }).then(res=>{
            res = JSON.parse(res);
            if(res.status == "ERROR"){
                toastr.error('An error has occurred the user has not been inserted '+res.message);
            } else {
                toastr.success('New User was created.');
                $(location).attr('href',url);
            }
        })
    });

});//Document Read

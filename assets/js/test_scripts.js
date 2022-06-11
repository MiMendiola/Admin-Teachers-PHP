$('#helperShow').hide();
$("#tempo").fadeOut();
$('#helperShow').fadeOut();
$("#hideTem").hide();

$(document).ready( function (){
    $('#helperShow').show();

    $(document).on("click", ".check", function (){
        $(this).prop("checked", true);
        $(this).removeClass("check");
        $(this).addClass("unCheck");

    });

    $(document).on("click", ".unCheck", function (){
        $(this).prop("checked", false);
        $(this).removeClass("unCheck");
        $(this).addClass("check");

    });

    //This function will create an event for check the time. at 5 min less than finish the time send
    //an alert. And when the time is over send the test.
    $("#tempo").TimeCircles({
        count_past_zero: false,
        time:{Days:{show: false}}
    }).addListener(function(unit, value, total) {
        if(total === 300) toastr.warning("5 minutes left to finish the exam.");
        if(total === 0) {
            $("#sent-test-form").submit();
        }
    });

    $("#tempoo").TimeCircles({
        count_past_zero: false,
        time:{Days:{show: false}}
    });

    $("#hideTem").on("click",function(){
        $("#tempo").fadeOut();
        $("#hideTem").hide();
        $("#showTem").show();
    });

    $("#showTem").on("click",function(){
        $("#tempo").fadeIn();
        $("#showTem").hide();
        $("#hideTem").show();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $('#helperShow:hidden').stop(true, true).fadeIn();
        } else {
            $('#helperShow').stop(true, true).fadeOut();
        }
    });

    //Si salimos de la web
    var count = 0;
    $(window).focus(function() {
        var thisUrl = $("#val").attr("data-site");
        var userHash = $("#sent-test-form").attr("data-userHash");
        var testHash = $("#sent-test-form").attr("data-test-hash");
        count++;
        var text = "The user changed tabs or opened another document: "+count+" times.";
        //Si el usuario sale fuera de la pagina se avisa.
        $.ajax({
            type: "POST",
            dataType: "json",
            url: thisUrl+"TestController/cheats",
            data: {user_hash: userHash, test_hash:testHash, user_cheat: text}
        })
    });

    //No copiar No pegar
    $(document).on('paste', function(e){
        e.preventDefault();
        toastr.error("You can't use 'Paste' option in this test.")
    })

    $(document).on('copy', function(e){
        e.preventDefault();
        toastr.error("You can't use 'Copy' option in this test.")
    })

    $("#btn-send-test").on("click", function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Do you want to send the test?',
            text: "If you press cancel you can continue in the test. But if you press Send Test, you will no longer be able to return to the test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: 'red',
            confirmButtonText: 'Send Test'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#sent-test-form").submit();
            }
        });

    });
}) // Document Ready
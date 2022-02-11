
 $(document).ready(function(){

dlt_post_icon_tooltip();
email_tooltip();
hover_dlt_post_icon();
delete_post();
delete_profile();
deletePhoto();
check_photos_count();
makeTitlePhoto();
seen();
open_chat();
delete_visitors();
block_member();
unblock_member();
unblock_member1();
reload_msg();
setInterval(messages_notification, 2000);
setInterval(visitors_notification, 2000);


$("#info :button").click(function(){
  user_update_info();
});

$("#info_login :button").click(function(){
  update_settings();
});

 $("#reg-form :button").click(function(){
   regvalidation();
 });

 $("#email_forget :button").click(function(){
   remind_email();
 });

 $("#new_post_btn").click(function(){
   postvalidation();
 });

 $("#new_chat_btn").click(function(){
   chatvalidation();
 });

 $("#new_msg_btn1").click(function(){
   msgvalidation1();
 });

 $("#login-form :button").click(function(){
   loginvalidation();
 });

 $("#upload_file_btn").click(function(){
    Upload_photo();
 });



 $("#new_srch_btn").click(function(){
   searchvalidation();
 });
 accord();
 accord_hide();
 checkNameValidation();
 checkEmailValidation();
 commentvalidation();
 appenda();
 smiles();
 size();
 resize();
 hover_opacity();
 modal();
 slider();
 is_msg();
 is_visitor();
 set_filter();
 checked_checkin();
 });

function w3_open() {
    document.getElementById("mySidenav").style.display = "block";
    $("#post-reader_header,#content").css("margin-left","200px");
    $("#content .post p").css("padding-right","0px");
    $("#content_header img").css("margin-right","210px");
    $("#content #block_list").css("margin-right","210px");
    $("#content #about_page p").css("margin-right","210px");
}
function w3_close() {
    document.getElementById("mySidenav").style.display = "none";
    $("#post-reader_header,#content").css("margin-left","0px");
    $("#content .post p").css("padding-right","200px");
    $("#content_header img").css("margin-right","10px");
    $("#content #block_list").css("margin-right","10px");
    $("#content #about_page p").css("margin-right","10px");
}



function resize(){
  $(window).resize(function(){
        var x = $(window).width();
        if (x<992) {
          $("#post-reader_header,#content").css("margin-left","0px");
          $("#content .post p").css("padding-right","0px");
          $("#content #photos").css("width","100%");
          $("#content .photo-slider").css({"width":"100%","margin":"20px 0 20px 0"});
          $("#content_header img").css("margin-right","10px");
          $("#content #about").css("width","90%");
          $("#content #block_list").css("margin-right","10px");
          $("#content #about_page p").css("margin-right","10px");
        }else {
          $("#post-reader_header,#content").css("margin-left","200px");
          $("#content .post p").css("padding-right","200px");
          $("#content #photos").css("width","87%");
          $("#content .photo-slider").css({"width":"600px","margin":"20px"});
          $("#content_header img").css("margin-right","210px");
          $("#content #about").css("width","600px");
          $("#content #block_list").css("margin-right","210px");
          $("#content #about_page p").css("margin-right","210px");
        }
    });
}
function size(){
        var x = $(window).width();
        if (x<992) {
          $("#post-reader_header,#content").css("margin-left","0px");
          $("#content .post p").css("padding-right","0px");
          $("#content #photos").css("width","100%");
          $("#content .photo-slider").css({"width":"100%","margin":"20px 0 20px 0"});
          $("#content_header img").css("margin-right","10px");
          $("#content #about").css("width","90%");
          $("#content #block_list").css("margin-right","10px");
          $("#content #about_page p").css("margin-right","10px");
        }else {
          $("#post-reader_header,#content").css("margin-left","200px");
          $("#content .post p").css("padding-right","200px");
          $("#content #photos").css("width","87%");
          $("#content .photo-slider").css({"width":"600px","margin":"20px"});
          $("#content_header img").css("margin-right","210px");
          $("#content #about").css("width","600px");
          $("#content #block_list").css("margin-right","210px");
          $("#content #about_page p").css("margin-right","210px");
        }
}


function hover_opacity(){
  var photo = $("#content #photos-member div, #content #visitors div,#content #photos .w3-third");
  photo.hover(function(){
    $(this).children(".opacity-photo").css("display","block");
  },function(){
    $(this).children(".opacity-photo").css("display","none");
  });
}

function modal(){
  $("#upload_button").click(function(){
    $("#modal").css("display","block");
  });
  $("#profile_btn").click(function(){
    $("#modal_upgrate").css("display","block");
  });
  $("#profile_dlt").click(function(){
    $("#modal_delete").css("display","block");
  });
  $("#go_remember").click(function(){
    $("#email_forget").css("display","block");
  });
  $("#send_msg_btn").click(function(){
    $("#modal_send_msg").css("display","block");
  });
}

function slider(){
  maxim = $("#max").html();
  min = $("#min").html();
  $( "#slider-age" ).slider({
  range: true,
  min: 18,
  max: 99,
  values: [min, maxim ],
  slide: function( event, ui ) {
    $( "#amount1" ).val(ui.values[ 0 ] + "m.");
    $( "#amount2" ).val(ui.values[ 1 ] + "m.");
  }
});
$( "#amount1" ).val($( "#slider-age" ).slider( "values", 0 )+"m.");
$( "#amount2" ).val($( "#slider-age" ).slider( "values", 1 )+"m.");
}

  var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
    showDivs(slideIndex += n);
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length} ;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[slideIndex-1].style.display = "block";
}
openForm(event,"info");
function openForm(evt,formName) {
    var i;
    var x = document.getElementsByClassName("form");
    var selectyv = $( "#modal_upgrate .w3-navbar li a" );
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
       selectyv.css("font-weight","normal");
    }
    document.getElementById(formName).style.display = "block";
    evt.currentTarget.style.fontWeight ="bold";
}


function regvalidation(){
  var name = $("#reg-form input[name='name']");
  var email = $("#reg-form input[name='email']");
  var password = $("#reg-form input[name='password']");
  var diena = $("#reg-form select[name='diena']");
  var menuo = $("#reg-form select[name='menuo']");
  var metai = $("#reg-form select[name='metai']");
  var sex = $("#reg-form input[name='sex']:checked").val();
  var birth = metai.val()+"-"+menuo.val()+"-"+diena.val();
  var a,b,c,d;

  if (diena.val()=="Diena" || menuo.val()=="Mėnuo" || metai.val()=="Metai") {
    $("#reg-error-date").show().html("Neįrašėt gimimo datos").css("color","red");
    a=false;
  }
  else {
    $("#reg-error-date").hide().html("");
    a=true;
  }

  if (name.val().trim().length<=3) {
    $("#reg-error-name").show().html("Neįrašėt slapyvardžio arba jis trumpesnis nei 4 simboliai").css("color","red");
    b=false;
  }else {
      $("#reg-error-name").hide().html("");
      b=true;
  }

  if (password.val().trim().length<=3) {
    $("#reg-error-password").show().html("Neįrašėt slaptažodžio arba jis trumpesnis nei 4 simboliai").css("color","red");
    c=false;
  }else {
    $("#reg-error-password").hide().html("");
    c=true;
  }

  if (email.val().trim().length<=5 || email.val().indexOf("@")<=0 || email.val().indexOf("@")>=email.val().length-4 || email.val().lastIndexOf(".")>=email.val().length-2
    || email.val().lastIndexOf(".")<=email.val().indexOf("@") || email.val().indexOf(" ")>=0) {
     $("#reg-error-email").show().html("Elektroninio pašto klaida").css("color","red");
     d=false;
    }
  else {
    $("#reg-error-email").hide().html("");
    d=true;
  }

  if (a==true && b==true && c==true && d==true) {
    $.post(
      "validation/validation.php",
      {
        name:name.val(),
        email:email.val(),
        password:password.val(),
        sex:sex,
        birth:birth
      },function(data,status){
        if (data==1) {
          window.location.replace("pasiskelbk.php");
        }else {
          $("#reg-error-form").show().html(data);
        }
      });
  }
}

function postvalidation(){
  var post = $("form textarea[name='new_post']");

  if (post.val().trim().length<=0) {
    $("#post_error").show().html("Nieko neįrašėt!!!");
  }
  else {
    $.post(
      "validation/post_validation.php",
      {text:post.val()},
      function(data){
        if (data==1) {
          location.reload();
          $("#post_error").hide().html("");
        }else {
          $("#post_error").show().html(data);
        }
      }
    )
  }
}


function chatvalidation(){
  var post = $("form textarea[name='new_chat']");

  if (post.val().trim().length<=0) {
    $("#chat_error").show().html("Nieko neįrašėt!!!");
  }
  else {
    $.post(
      "validation/chat_validation.php",
      {text:post.val()},
      function(data){
        if (data==1) {
          location.reload();
          $("#chat_error").hide().html("");
        }else {
          $("#chat_error").show().html(data);
        }
      }
    )
  }
}


function checkNameValidation(){
  var name = $("form input[name='name']");
  name.keyup(function(){
    var text = $(this).val();
    if (text.length>0) {
      $.post(
        "validation/checkName.php",
        {text:text},
        function(data){
          if (data==1) {
            $("#reg-error-name").show().html("Vartotojo vardas laisvas").css("color","#E5CB22");
          }else {
            $("#reg-error-name").show().html("Vartotojo vardas užimtas").css("color","red");
          }
        }
      )
    }else {
      $("#reg-error-name").hide().html("");
    }
  });
}

function checkEmailValidation(){
  var email = $("form input[name='email']");
  email.keyup(function(){
    var text = $(this).val();
    if (text.length>0) {
      $.post(
        "validation/checkEmail.php",
        {text:text},
        function(data){
          if (data==1) {
            $("#reg-error-email").show().html("Elektroninio pašto vardas laisvas").css("color","#E5CB22");
          }else {
            $("#reg-error-email").show().html("Elektroninio pašto vardas užimtas").css("color","red");
          }
        }
      )
    }else {
      $("#reg-error-email").hide().html("");
    }

  });
}

function searchvalidation(){
  var srch = $("form input[name='new_srch']");

  if (srch.val().trim().length<=0) {
    $("#search_error").show().html("Nieko neįrašėt");
  }
  else {
    $("#search_error").hide().html("");
    $.post(
      "validation/search_member.php",
      {
        member:srch.val().trim()
      },
      function(data){
        $("#photos-member").html(data);
      }
    )
  }
}


function msgvalidation1(){
  var msg = $("form textarea[name='new_msg']");
  var href = window.location.href;
  var href_lng = href.length;
  var symbol = href.indexOf("=")+1;
  var id= href.slice(symbol,href_lng);

  if (msg.val().trim().length<=0) {
    $("#msg_error").css("display","block");
  }
  else {
    $("#msg_error").css("display","none");
    $.post(
      "validation/msg.php",
      {
        text:msg.val().trim(),
        id:id
      },
      function(data){
        if (data==1) {
          $("#modal_send_msg").css("display","none");
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  }
}

function commentvalidation(){
  $(".post_comment_btn").click(function(){
    var comment = $(this).parent("form").children(".post_comment");
    var comment_error_field = $(this).parent("form").children(".comment_error");
    var post_id = $(this).parent("form").parent(".post").attr("id");
    if (comment.val().trim().length<=0) {
      comment_error_field.show().html("Nieko neįrašėt!!!");
    }
    else {
        $.post(
        "validation/comments.php",
        {
          text:comment.val().trim(),
          post_id:post_id
        },
        function(data){
          if (data==1) {
             $.post(
               "validation/comments_show.php",
               {
                 id:post_id
               },
               function(data){
                 $("#inbox #"+post_id+" .comments_fields .comments_in,#sent_box #"+post_id+" .comments_fields .comments_in").html(data);
                 accord_hide();
               }
             )
            //location.reload();
            comment_error_field.hide().html("");
          }else {
            comment_error_field.show().html(data);
          }
        }
      )
       //$("#"+post_id+"").html("OK");
    }
  });
}

function smiles(){
  $("#smiles_btn").click(function(){
    $("#smiles").css("display","block");

  });
}

function appenda(){
  $("#smiles img").click(function(){
    var alt = $(this).attr("alt");
    var textbox = $("form textarea[name='new_msg'],form textarea[name='new_post'],form textarea[name='new_chat']");
    textbox.val(textbox.val()+alt);
    $("#smiles").css("display","none");
  });
}

function loginvalidation(){
  var nick = $("#login-form :text");
  var password = $("#login-form :password");
  var a,b;

  if (nick.val().trim().length<=0) {
    $("#log-error-nick").show().html("Neįrašėte slapyvardžio").css("color","red");
    a=false;
  }
  else {
    $("#log-error-nick").hide().html("");
    a=true;
  }

  if (password.val().trim().length<=0) {
    $("#log-error-password").show().html("Neįrašėte slaptažodžio").css("color","red");
    b=false;
  }
  else {
    $("#log-error-password").hide().html("");
    b=true;
  }

  if (a==true && b==true) {
    $.post(
      "validation/login.php",
      {
      nick:nick.val(),
      password:password.val()
      },
      function(data){
        if (data==1) {
          window.location.replace("pasiskelbk.php");
        }else {
          $("#log-error").show().html(data).css("color","red");
        }
      }
    )
  }
}


function Upload_photo(){
  var count_img = $("#photos .w3-third").size();
  var count = 10 - count_img;
  var files = document.getElementById("upload_file").files;
  var form = document.getElementById("upload_form"); // You need to use standart javascript object here
  var formData = new FormData(form);
  formData.append('upload_file', $('input[type=file]')[0].files[0]);

  if (files.length==0) {
    $("#post_upload_photo").show().html("Neįkėlėt nuotraukų");
  }
  else if (files[0].type!="image/jpg" && files[0].type!="image/jpeg" && files[0].type!="image/png") {
    $("#post_upload_photo").show().html("Kitoks formatas");
  }
  else if (files[0].size>20000000) {
    $("#post_upload_photo").show().html("Per didelis dydis");
  }
  else {
    $("#post_upload_photo").hide().html("");

    $.ajax({
    url: 'validation/upload_file.php',
    data: formData,
    type: 'POST',
    // THIS MUST BE DONE FOR FILE UPLOADING
    contentType: false,
    processData: false,
    success: function(result){
      if (result==1) {
        location.reload();
      }else {
        $("#post_upload_photo").show().html(result);
      }
    }
    // ... Other options like success and etc
})
  }
}

function check_photos_count(){
    var count = $("#photos .w3-third").size();
    if (count>=10) {
      $("#upload_button").css("display","none");
    }else {
      $("#upload_button").css("display","block");
    }
}


function makeTitlePhoto(){
  var accept = $("#content #photos .w3-third .opacity-photo .makeTitlePhoto");
  $(accept).click(function(){
    var photo_first = $("#content #photos .w3-third:first-of-type .user_photos");
    var photo = $(this).parent(".opacity-photo").parent(".w3-third").children(".user_photos");
    var photo_first_name = photo_first.attr("src");
    var photo_name = photo.attr("src");
    $.post(
      "validation/change_photo.php",
      {
        first:photo_first_name,
        last:photo_name
      },function(data){
        if (data==1) {
          photo.attr("src",photo_first_name);
          photo_first.attr("src",photo_name);
        }else {
          alert(data);
        }
      }
    )

  });
}


function deletePhoto(){
  var count = $("#photos .w3-third").size();
  var deletebutton = $("#content #photos .w3-third .opacity-photo .deletePhoto");

  $(deletebutton).click(function(){
    var photo = $(this).parent(".opacity-photo").parent(".w3-third").children(".user_photos");
    var w3 = $(this).parent(".opacity-photo").parent(".w3-third");
    var photo_name = photo.attr("src");
    $.post(
      "validation/delete_photo.php",
      {photo:photo_name}
      ,function(data){
        if (data==1) {
          location.reload();
        }else {
          alert(data);
        }
      }
    )
  });
}

function messages_notification(){
  var count = $(".w3-sidenav ul:first-of-type li:first-of-type .w3-tag");
  $.post(
    "validation/messages_count.php",
    function(data){
      if (data>0) {
        count.html(data);
        $("title").html("*"+data+" Žinutės*");
      }else {
        count.html("");
        $("title").html("Neatrašau");
      }
    }
  )
}

function seen(){
  var msg = $("#content .NEW");
  $(msg).bind("click", function(){
    var id = $(this).attr("id");
    $(this).css("background-color","#e6f1fc");
    $(this).children("p").css("color","#000000");
    $(this).children(".message-author").children("p").css("color","#3D84DD");
    $(this).children(".message-author").children(".date").css("color","#929E9E");
    $.post(
      "validation/seen.php",
      {id:id},
      function(data){
      }
    )
  });
}

function open_chat(){
  $(".message-from").click(function(){
    $("#msg").css("display","block");
    var id = $(this).attr("id");
      setInterval(function(){$.post(
          "validation/chat.php",
          {id:id},
          function(data){
            $("#msg #chat").html(data);
          }
        );},1000);
        scrollBottom();
      send_chat(id);

  });
}

function interVall(id){
  $.post(
      "validation/chat.php",
      {id:id},
      function(data){
        $("#msg #chat").html(data);

      }
    );
}



function send_chat(id){
  var msg = $("form textarea[name='new_msg']");
    $("#new_msg_btn").click(function(){
      scrollBottom();
      if (msg.val().trim().length<=0) {
        $("#msg_error").css("display","block");
      }
      else {
        $("#msg_error").css("display","none");
        $.post(
          "validation/msg.php",
          {
            text:msg.val().trim(),
            id:id
          },function(data){
            if (data==1) {
              $.post(
                "validation/chat.php",
                {id:id},
                function(data){
                  $("#msg #chat").html(data);
                }
              );
            }else {
              $("#msg_error").css("display","block");
              $("#msg_error .w3-modal-content .w3-container p").html(data);
            }
          }
        )
      }
    });
}

function new_member(){
  $.post(
    "validation/new_member.php",
    function(data){
      $("##mySidenav #new_member_list").html(data);
    }
  );
}

function user_update_info(){
  var town = $("#info #place");
  var about = $("#info textarea[name='about']");
  var diena = $("#info form  select[name='diena']");
  var menuo = $("#info form  select[name='menuo']");
  var metai = $("#info form  select[name='metai']");
  var birth = metai.val()+"-"+menuo.val()+"-"+diena.val();
  var height = $("#info form  select[name='tall']").val();
  var status = $("#info form  select[name='statusas']").val();
  var smoke = $("#info form  select[name='smoke']").val();
  var alcohol = $("#info form  select[name='alcohol']").val();
  var body = $("#info form  select[name='body']").val();
  var reason = $("#info form  select[name='reason']").val();

  if (diena.val()=="Diena" || menuo.val()=="Mėnuo" || metai.val()=="Metai") {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Neįrašėt gimimo datos");
  }
  else if (town.val().trim().length<=0) {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Neįrašėt gyv. vietos");
  }
  else if (about.val().trim().length<=5) {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Neįrašėt nieko apie save");
  }else {
    $.post(
      "validation/update.php",
      {
        town:town.val().trim(),
        about:about.val().trim(),
        birth:birth,
        height:height,
        status:status,
        smoke:smoke,
        alcohol:alcohol,
        body:body,
        reason:reason
      },
      function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    );
  }
}

function update_settings(){
  var name = $("#info_login #name");
  var pass = $("#info_login #password");
  var new_pass = $("#info_login #new-password");
  var email = $("#info_login #email");
  if (name.val().trim().length<=3) {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Vardui Būtini mažiausiai 4 simboliai");
  }else if (pass.val().trim().length<=3) {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Slaptažodžiui būtini mažiausiai 4 simboliai");
  }else if (new_pass.val().trim().length<=3) {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Slaptažodžiui būtini mažiausiai 4 simboliai");
  }else if (email.val().trim().length<=5 || email.val().indexOf("@")<=0 || email.val().indexOf("@")>=email.val().length-4 || email.val().lastIndexOf(".")>=email.val().length-2
    || email.val().lastIndexOf(".")<=email.val().indexOf("@") || email.val().indexOf(" ")>=0) {
      $("#msg_error").css("display","block");
      $("#msg_error .w3-modal-content .w3-container p").html("Klaidingas el pašto formatas");
  }else {
    $("#msg_error").css("display","none");
    $("#msg_error .w3-modal-content .w3-container p").html("");
    $.post(
      "validation/update_settings.php",
      {
        name:name.val().trim(),
        password:pass.val().trim(),
        new_password:new_pass.val().trim(),
        email:email.val().trim()
      },function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  }
}

function hover_dlt_post_icon(){
  $(".post").hover(function(){
    $(this).children(".delete_post_icon").css("display", "block");
    }, function(){
    $(this).children(".delete_post_icon").css("display", "none");
});
}

function dlt_post_icon_tooltip(){
  $(".delete_post_icon").tooltip({
    content: "Ištrinti pasisakymą",
    tooltipClass:"custom-tooltip",
  show: {
    effect: "slideDown",
    delay: 250
  }
});
}

function email_tooltip(){
  $("#reg-form input[name='email'],#info_login #email").tooltip({
    content: "Jūsų elektroninis paštas turi būti teisingas, nes į jį bus siunčiamos naujienos ir slaptažodžio priminimai!",
    tooltipClass:"custom-tooltip",
  show: {
    effect: "slideDown",
    delay: 250
  }
});
}

function delete_post(){
  $(".delete_post_icon").click(function(){
    var post_id = $(this).parent(".post").attr("id");
    $.post(
      "validation/delete_post.php",
      {
        post_id:post_id
      },function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  });
}

function delete_profile(){
  $("#modal_delete :button").click(function(){
  var password = $("#modal_delete :password").val();
  if (password.trim().length<=0) {
    $("#msg_error").css("display","block");
    $("#msg_error .w3-modal-content .w3-container p").html("Neįrašėte slaptažodžio");
  }else {
    $.post(
      "validation/delete_profile.php",
      {
        password:password
      },
      function(data){
        if (data==111) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  }

  });
}

function delete_visitors(){
  $("#trash_visitor").click(function(){
  $.post(
      "validation/delete_visitors.php",
      function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  });
}


function visitors_notification(){
  var count = $(".w3-sidenav ul:first-of-type li:eq(1) .w3-tag");
  $.post(
    "validation/visitors_count.php",
    function(data){
      if (data>0) {
        count.html(data);
        $("title").html("*"+data+" Nauji svečiai*");
      }else {
        count.html("");
        $("title").html("Neatrašau");
      }
    }
  )
}

function block_member(){
  $("#block_member").click(function(){
    var url= window.location.href;
    var x = url.indexOf("=")+1;
    var y = url.length;
    var id = url.slice(x,y);
    $.post(
      "validation/blocked.php",
      {id:id},
      function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  });
}

function unblock_member(){
  $("#unblock_member").click(function(){
    var url= window.location.href;
    var x = url.indexOf("=")+1;
    var y = url.length;
    var id = url.slice(x,y);
    $.post(
      "validation/unblocked.php",
      {id:id},
      function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  });
}


function unblock_member1(){
  $("#block_list input[type='button']").click(function(){
    var id = $(this).parent("#block_list span").attr("id");
    $.post(
      "validation/unblocked.php",
      {id:id},
      function(data){
        if (data==1) {
          location.reload();
        }else {
          $("#msg_error").css("display","block");
          $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      }
    )
  });
}

function accord(){

  $(".accord").click(function(){
  var comment =  $(this).parent(".comments_fields").children(".comments_in").children(".comment");
  comment.css("display","block");
  });
}


function accord_hide(){

 var post = $(".post");
 var post_count = post.length;

 for (var i = 0; i < post_count; i++) {
   var comm_count = $(".post:eq("+i+") .comment").length;

   if (comm_count>3) {
     $(".post:eq("+i+") .comments_fields .accord").text("Visi Komentarai("+comm_count+")");
   }
   $(".post:eq("+i+") .comment:lt("+(comm_count-3)+")").css("display","none");
 }
}

function reload_msg(){
  $("#msg .w3-closebtn").click(function(){
    location.reload();
  })
}

function remind_email(){
  var email = $("#email_forget #email");
  if (email.val().trim().length<=5 || email.val().indexOf("@")<=0 || email.val().indexOf("@")>=email.val().length-4 || email.val().lastIndexOf(".")>=email.val().length-2
    || email.val().lastIndexOf(".")<=email.val().indexOf("@") || email.val().indexOf(" ")>=0){
      $("#msg_error").css("display","block");
      $("#msg_error .w3-modal-content .w3-container p").html("Klaidingas el pašto formatas");
    }
    else {
      $.post(
        "validation/remind_email.php",
        {email:email.val().trim()},
        function(data){
            $("#msg_error").css("display","block");
            $("#msg_error .w3-modal-content .w3-container p").html(data);
        }
      )
    }
}

function is_msg(){

  $.post(
    "validation/new_msg_exsists.php",
    function(data){
        if (data==1) {
          $("#page").append("<div id='notific_msg' class='w3-panel w3-hide-large'><a href='messages.php'>Gavai naujų žinučių</a></div>");
        }
    }
  )
}

function is_visitor(){

  $.post(
    "validation/new_visitor_exsists.php",
    function(data){
        if (data==1) {
          $("#page").append("<div id='notific_visitor' class='w3-panel w3-hide-large'><a href='visitors.php'>Tu turi naujų svečių</a></div>");
        }
    }
  )
}

function set_filter(){

  $("#filter :button").click(function(){
    var location= $( "#check #location" ).val().trim();
    var min_age = $( "#slider-age" ).slider( "values", 0 );
    var max_age = $( "#slider-age" ).slider( "values", 1 );

    if (document.getElementById('man').checked==true) {
      man=1;
    }else {
      man=0;
    }

    if (document.getElementById('woman').checked==true) {
      woman=1;
    }else {
      woman=0;
    }

    if (document.getElementById('online').checked==true) {
        online=1;
    }else {
        online=0;
    }

   if (location=="") {
     location="Nenurodyta";
   }

   $.post(
     "validation/filter.php",
     {
       man:man,
        woman:woman,
         online:online,
          min_age:min_age,
           max_age:max_age,
            location:location

     },
     function(data){
       if (data==1) {
         window.location.replace("member.php");
       }else {
         alert(data);
       }

     }
   )

  });
}

function scrollBottom(){
  $('#msg .w3-modal-content #chat').animate({ scrollTop: $(document).height() + 100000 }, "slow");
}


function checked_checkin(){

  $.post("validation/get_filter_man.php",
  function(data){
    if (data==1) {
      $('#man').prop('checked', true);
    }else {
      $('#man').prop('checked', false);
    }
  });
  $.post("validation/get_filter_woman.php",
  function(data){
    if (data==1) {
      $('#woman').prop('checked', true);
    }else {
      $('#woman').prop('checked', false);
    }
  });
  $.post("validation/get_filter_online.php",
  function(data){
    if (data==1) {
      $('#online').prop('checked', true);
    }else {
      $('#online').prop('checked', false);
    }
  });
  $.post("validation/get_filter_location.php",
  function(data){
    if (data!="Nenurodyta") {
      $('#location').val(data);
    }
  });
}

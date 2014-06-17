$(function(){

    /**头部导航切换**/
    $("#topMenu").find("li").click(function(){
      $(this).addClass("active")
      var menu = $(this).find("a").attr("href");
      $(menu).removeClass("hidden").addClass("show");
      $(menu).siblings("ul").removeClass("show").addClass("hidden");
      $(this).siblings("li").removeClass("active");
    });

    /** set the defalut nav**/
    //$("nav-sidebar").collapse();
    /** default show the first nav **/
    $("li.link:first").parents("li").addClass("active");
    $("li.link:first").parents("li").find("i.fa-angle-right").removeClass("fa-angle-right").addClass("fa-angle-down");
    $("li.link:first").parents("ul").collapse("show");
    var url = $("li.link:first").data("href");
    $(".main").load(url);

    /** 右侧箭头效果 **/
    $(".nav-sidebar li").click(function(){
        $(this).find("i.fa-angle-right").removeClass("fa-angle-right").addClass("fa-angle-down");
        if(!$(this).siblings("li").hasClass("active")){
          $(this).siblings("li").find("i.fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-right");
        }
    });

    /** ajax load the main content **/
    $(".link").click(function(){
      if(!$(this).parents("li").hasClass("active")){
        /** 如果不是当前状态 **/
        $(this).parents("li").addClass("active");

        /** 定义激活状态的对象 **/
        var active = $(this).parents("li").siblings("li").filter(".active");
        active.removeClass("active");
        active.children("ul").collapse("hide");
      }
      var url = $(this).data('href');
      $(".main").load(url);
    });


})

/** load main content **/
function loadMain(url){
    $(".main").load(url);
}

/** 发送表单 **/
function sendForm(url){
    var ids = $('input[name="id[]"]:checked').val();
    $.post(url,
            {'id':ids},
            function(data){
                calert(data.msg,data.code);
            },
            'json'
            );

}

/** post to the server **/
function editInfo(form){
    var selForm = $("#"+form);
    var url = selForm.data('href');
    $.post(url, selForm.serialize(), function(data){
        if("undefined" == typeof data.code){data.code='0';}
            calert(data.msg, data.code);}, 'json');
    return false;
}

/** alert function **/
function calert(msg, status){
    switch (status){
    case '0':
        var status_name = 'alert-danger';
        break;
    case '1':
        var status_name = 'alert-success';
        break;
    }
    html = '<div class="alert '+status_name+'">'+msg+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>'
    $(".main").prepend(html);
    window.setTimeout(function(){$(".alert").alert('close');}, 1500);
}

 



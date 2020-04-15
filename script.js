
$(".dropdown-menu a").click(function(){
    $(this).parents(".nav-item").find('.nav-link').text($(this).text());
    $(this).parents(".nav-item").find('.nav-link').val($(this).text());
});
$(document).ready(function(){

	$('.box_button_holder span').on('click', function(){
        $('.box_button_holder span').toggleClass('none-border');
        $('.box_content').slideToggle(400);
    });

    $('.link_report').on('click', function(){
        $('.link_report_content').slideToggle(400);
    });

  });
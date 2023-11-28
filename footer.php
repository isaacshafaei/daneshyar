<?php
if(class_exists('Redux')){
    $footer_layout =  daneshyar_settings('footer_elementor');
    $footer_enable =  daneshyar_settings('footer_visibility');
    $footer_wave_enable =  daneshyar_settings('footer_waves_visiblity');
    $footer_text_color =  daneshyar_settings('footer_color_scheme');
    $footer_back_o_top =  daneshyar_settings('scroll_top_btn');
}
 ?>
<?php if($footer_back_o_top) { ?>
    <a id="back-to-top" class="back-to-top">
        <i class="fal fa-angle-up"></i>
    </a>
<?php } ?>
 <?php if($footer_enable): 
     if(!is_account_page() && !is_user_logged_in( ) || !is_account_page() && is_user_logged_in( ) || is_account_page() && is_user_logged_in( )):
 if($footer_layout != 'no-footer'):
    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($footer_layout);
else:
   if($footer_wave_enable){ ?>
<div class="waves">
        <div class="top_footer_wave"></div>
        <div class="bottom_footer_wave"></div>
</div>
<?php } 
get_template_part('/inc/templates/footer/footer');
?>
<style> 
    <?php if($footer_text_color == 'light'){ ?>
    footer,footer p,footer ul li,footer a,footer span,footer h2,footer div{
        color:#fff;
    }
    <?php }else{?>
    footer,footer p,footer ul li,footer a,footer span,footer h2,footer div{
        color:#000;
    }
    <?php } ?>
 </style>
    <?php endif;//End choose footer type 
         endif; //End if account pgae and is_user_login
        endif;//End enable footer
     wp_footer(); ?>
</body>
</html>

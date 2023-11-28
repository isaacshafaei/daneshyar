<?php 
if(class_exists('Redux')){
    $full_width_header = daneshyar_settings('header_fullwidth');
    $full_width_class= '';
    if($full_width_header==true){
        $full_width_class = 'header_full_width';
    }

    $enable_topbar = daneshyar_settings('top_bar_check');
    $topbar_theme = daneshyar_settings('top_bar_color_text');
    $phone_number = daneshyar_settings('mobile_number');
    $email_addres = daneshyar_settings('emali_address');
    $enable_search = daneshyar_settings('enable_search');
}
if($enable_topbar==true){
    if(!get_post_meta(get_the_ID(  ), $perfix.'disable_top_bar',true)){
        $top_mneu = wp_nav_menu(
            array(
                'theme_location' => 'top-bar-menu',
                'container' => 'nav',
                'menu_class' => 'top-menu',
                'echo' =>false
            )
        );
        ?>
        <div class="top-bar <?php echo esc_attr($topbar_theme ); ?>">
                <div class="container <?php echo $full_width_class; ?>">
                    <div class="row">
                        <div class="top-bar-column">
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope"></i> <?php echo ($email_addres)?$email_addres:'kitwp@gmail.com'; ?></a></li>
                                <li><a href="#"><i class="fa fa-phone"></i> <?php echo ($phone_number)?$phone_number:'09138781072'; ?></a></li>
                            </ul>
                        </div>
                        <div class="top-bar-column">
                            <?php 
                            if(has_nav_menu('top-bar-menu')){
                                echo wp_kses_post($top_mneu);
                            }
                            ?>
                            <?php if($enable_search == true){ ?>
                            <div class="top-bar-search">
                                <a href="#"><i class="fa fa-search"></i></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
}

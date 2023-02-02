<?php
global $current_user;
wp_get_current_user();
$page_padding = wp_is_mobile() ? 'style="padding-top:10vh;"' : '';
 $class = wp_is_mobile() ? 'mobile' : 'desktop'; ?>
<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo $class; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, scalable=no">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.png" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
    <style>
        #vehicle-year, #vehicle-brand, #vehicle-sub-brand {
            pointer-events: all !important;
        }
    </style>
<!-- Facebook Pixel Code -->
<!--<script>-->
<!--  !function(f,b,e,v,n,t,s)-->
<!--  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?-->
<!--  n.callMethod.apply(n,arguments):n.queue.push(arguments)};-->
<!--  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';-->
<!--  n.queue=[];t=b.createElement(e);t.async=!0;-->
<!--  t.src=v;s=b.getElementsByTagName(e)[0];-->
<!--  s.parentNode.insertBefore(t,s)}(window, document,'script',-->
<!--  'https://connect.facebook.net/en_US/fbevents.js');-->
<!--  fbq('init', '2445096462202220');-->
<!--  fbq('track', 'PageView');-->
<!--</script>-->
<!--<noscript><img height="1" width="1" style="display:none"-->
<!--  src="https://www.facebook.com/tr?id=2445096462202220&ev=PageView&noscript=1"-->
<!--/></noscript>-->
<!-- End Facebook Pixel Code -->

<?php $samiPageBodyBgColor = (!empty(get_field('samiPageBodyBgColor'))) ? get_field('samiPageBodyBgColor') : '#f2f2f2';?>
	
<body style="background-color: <?php echo $samiPageBodyBgColor; ?>" <?php body_class($class); ?>>
<?php  sogo_print_script('_sogo_body_scripts');
?>

<?php  include 'templates/header-2/header-2.php'; ?>

<div id="page" class="site overflow-hidden p-relative <?php echo $samiPageBodyBgColor; ?>">

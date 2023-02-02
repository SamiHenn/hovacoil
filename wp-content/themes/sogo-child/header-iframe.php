<?php

//$page_padding = wp_is_mobile() ? 'style="padding-top:10vh;"' : '';
?>

<?php $class = wp_is_mobile() ? 'mobile' : 'desktop'; ?>
<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo $class; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, scalable=no">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.png"
          type="image/x-icon"/>
    <?php wp_head(); ?>
</head>


<body <?php body_class($class); ?>>
<?php sogo_print_script('_sogo_body_scripts');
?>

<div id="page" class="site overflow-hidden p-relative" style="padding-top: 10vh">
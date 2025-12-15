<?php
/*
@package (bmv_aca)
=========================
header.php
=========================
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <title><?php wp_title('|', true, 'right') . ' ' . bloginfo('name'); ?></title>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php if (is_singular() && pings_open(get_queried_object())) : ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php endif; ?>
  <?php wp_head() ?>
</head>
<!-- /head -->

<body <?php body_class(); ?>>
  <?php $label_image = get_field('label_image', 'option'); ?>
  <div class="site-label">
    <span class="site-label__text">Powered by</span>
    <?php if ($label_image && !empty($label_image['url'])) : ?>
      <img class="site-label__img" src="<?php echo esc_url($label_image['url']); ?>" alt="<?php echo esc_attr($label_image['alt'] ?? ''); ?>">
    <?php endif; ?>
  </div>
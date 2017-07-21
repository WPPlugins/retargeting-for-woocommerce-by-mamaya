<?php header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>
 
<data>
  <title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
  <mguid><?php echo get_option('mamaya_guid', ''); ?></mguid>
  <currency><?php echo get_woocommerce_currency(); ?></currency>
  <currency_symbol><?php echo get_woocommerce_currency_symbol(); ?></currency_symbol>
  <link><?php bloginfo_rss('url') ?></link>
  <store_link><?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?></store_link>
  <domain><?php echo $_SERVER['SERVER_NAME']; ?></domain>
  <email><?php echo $blog_title = get_bloginfo('admin_email'); ?></email>
  <description><?php bloginfo_rss('description') ?></description>
  <language><?php bloginfo_rss( 'language' ); ?></language>
  <?php
  $args = array( 'post_type' => 'product', 'posts_per_page' => 999 );
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post(); global $product;
  ?>
  <?php if (isset($_GET['id'])) { $ok = false; if ($id == $_GET['id']) { $ok = true; } } else {  $ok = true; }
  if ($ok) { ?>
  <item>
    <title><?php the_title_rss() ?></title>
    <link><?php echo get_permalink( $product->ID ); ?></link>
    <image_link><?php echo wp_get_attachment_url( get_post_thumbnail_id() ) ?></image_link>
    <price><?php echo $product->regular_price ?></price>
    <sale_price><?php echo $product->sale_price ?></sale_price>
    <quantity><?php echo $product->get_stock_quantity() ?></quantity>
    <currency><?php echo get_woocommerce_currency(); ?></currency>
    <condition><?php echo get_option('product_condition') ?></condition>
    <id><?php echo $id; ?></id>  
    <availability><?php echo $product->is_in_stock() ? get_option('product_in_stock') : get_option('product_out_stock'); ?></availability>
    <brand><?php echo get_option('product_brand') ?></brand>
    <categories><?php 
    $categories = get_the_terms( $product->$id, 'product_cat' );
    if ($categories != null) {
      $first=true;
      foreach ($categories as $cat) {
        if ($first) { $first = false; } else { echo ","; }
        echo $cat->term_id;
      }
    } ?></categories>
    <tags><?php echo $product->get_tags(); ?></tags>
  </item>
  <?php } endwhile; ?>
</data>

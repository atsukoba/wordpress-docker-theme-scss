<!--
WordPress Template Cheetsheet
Author: Atsuya Kobayashi
-->

<!-- header.php -->
<?php get_header(); ?>

<!-- footer.php -->
<?php get_footer(); ?>

<!-- site url -->
<?php echo home_url(); ?>

<!-- WP URL -->
<?php echo site_url(); ?>

<!-- loop -->
<?php $blog_posts = query_posts('post_type={TYPE}&category_name={CATEGORY}&showposts={N}&posts_per_pege={N}'); ?>

<!-- query_posts() -->
<!-- query_posts() -->

<?php foreach ($blog_posts as $post) : setup_postdata($post); ?>
  <!-- CONTENTS -->
<?php endforeach; ?>

<!-- TAXONOMY -->
<?php $blog_posts = query_posts('post_type={TYPE}&{TAXONOMY}={TERM}&order=ASC&posts_per_page=-1'); ?>


<!-- IN LOOP -->
<?php the_title(); ?>
<?php the_time('y/m/d'); ?>
<?php the_content(); ?>
<?php the_tags($before, $sep, $after); ?>
<?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
<?php the_permalink(); ?>
<?php the_field('FIELD_NAME'); ?>
<?php echo mb_substr($post->post_title, 0, N) . '...'; ?>
<?php wp_nav_menu(array('menu_class' => 'menu', 'container' => false)); ?>

<!-- PAGING -->
<?php
$big = 999999999; // need an unlikely integer
echo paginate_links(
  array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '/page/%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $the_query->max_num_pages
  )
);
?>

<!-- PAGER -->
<?php posts_nav_link('｜', 'LINK STRING', 'LINK STRING'); ?>

<!-- PAGENATION -->
<?php
echo paginate_links(
  array(
    'base' => $paginate_base,
    'format' => $paginate_format,
    'total' => $wp_query->max_num_pages,
    'mid_size' => 2,
    'current' => ($paged ? $paged : 1),
    'prev_text' => '« 前へ',
    'next_text' => '次へ »',
  )
);
?>

<!-- add custom post type on function.php-->
<?php

add_action('init', 'create_post_type');
function create_post_type()
{
  register_post_type(
    'news', // name of custom type
    array(
      'labels' => array(
        'name' => __('NEWS'),
        'singular_name' => __('NEWS')
      ),
      'public' => true,
      'menu_position' => 5,
    )
  );
}
?>

<!-- Add Custom Taxonomy -->
<?php
function self_made_taxonomies()
{
  register_taxonomy(
    'self_made_cat',
    array('self_made'),
    array(
      'label'            => 'MY_ORIGINAL_TAXONOMY',
      'show_ui'           => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'hierarchical'      => true,
    )
  );
}
add_action('init', 'self_made_taxonomies', 0);
?>

<!-- Get Custom Type Posts -->
<ul>
  <?php $args = array(
    'numberposts' => 5,
    'post_type' => 'POST_TYPE'
  );
  $customPosts = get_posts($args);
  if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post );
  ?>
  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
  <?php endforeach; ?>
  <?php else : //記事が無い場合 ?>
  <p>Sorry, no posts matched your criteria.</p>
  <?php endif;
  wp_reset_postdata(); //クエリのリセット ?>
</ul>

<!-- 管理画面: 投稿一覧カテゴリソート -->
<?php
//投稿一覧カテゴリソート機能
function cat_sort($sortable_columns)
{
  $sortable_columns['categories'] = 'category';
  return $sortable_columns;
}
add_filter('manage_edit-post_sortable_columns', 'cat_sort');
?>


<!-- 管理画面: サイドバーメニュー非表示 -->
<?php
//管理画面から削除 (例)
function remove_menus()
{
  remove_menu_page('edit-comments.php'); //コメント
  remove_menu_page('tools.php'); //ツール
  remove_menu_page('edit.php?post_type=custom_type'); //カスタム投稿タイプ
  //引数に非表示にするメニューのphpファイル名をなげる
}
add_action('admin_menu', 'remove_menus');
?>


<!-- functions.php ファイル読み込み(functionsディレクトリ内のphpファイルを読み込む) -->
<?php
foreach (glob(TEMPLATEPATH . "/functions/*.php") as $file) {
  require_once $file;
}
?>

<!-- function.php login customize -->
<?php
// added to functions.php
function custom_login()
{
  $style = '
  	<style>
		.login > #login > h1 > a {
		  background-image: url(/url/img.png);
		  background-size: 100%;
		  width: 100%;
		  height: 100px;
		}
		.login > #login > h1::after {
  			content: "";
		  font-size: 1rem;
		}
	</style>
  ';
  echo $style;
}
add_action('login_enqueue_scripts', 'custom_login');
?>

<!-- 最新10件の投稿記事タイトルの一覧を表示 -->
<ul>
  <?php wp_get_archives('type=postbypost&limit=10&format=custom'); ?>
</ul>

<?php if(is_front_page()): ?>
  // コンテンツを表示
<?php endif; ?>


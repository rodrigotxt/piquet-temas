<?php

add_image_size('banner-size', 1920, 400, true);

// style and scripts
add_action('wp_enqueue_scripts', 'bootscore_child_enqueue_styles');
function bootscore_child_enqueue_styles() {

  // style.css
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

  // Compiled Bootstrap
  $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/css/lib/bootstrap.min.css'));
  wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/lib/bootstrap.min.css', array('parent-style'), $modified_bootscoreChildCss);

  // custom.js
  wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.js', false, '', true);
}


// Breadcrumb for pages
function nav_breadcrumb() {

  $delimiter = ' <i class="fas fa-angle-right delimiter"></i> ';
  //$home = '<i class="fas fa-home"></i>'; 
  $home = 'Home';
  $before = '<span class="current-page">';
  $after = '</span>';

  if (!is_home() && !is_front_page() || is_paged()) {

    global $post;
    $homeLink = get_bloginfo('url');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

    if (is_category()) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . single_cat_title('', false) . $after;
    } elseif (is_day()) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
    } elseif (is_month()) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
    } elseif (is_year()) {
      echo $before . get_the_time('Y') . $after;
    } elseif (is_single() && !is_attachment()) {
      if (get_post_type() != 'post') {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category();
        $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
    } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
    } elseif (is_attachment()) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID);
      $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
    } elseif (is_page() && !$post->post_parent) {
      echo $before . get_the_title() . $after;
    } elseif (is_page() && $post->post_parent) {
      $parent_id = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
    } elseif (is_search()) {
      echo $before . 'Results for search "' . get_search_query() . '"' . $after;
    } elseif (is_tag()) {
      echo $before . 'Posts with tag "' . single_tag_title('', false) . '"' . $after;
    } elseif (is_404()) {
      echo $before . 'Fehler 404' . $after;
    }

    if (get_query_var('paged')) {
      if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
      echo ': ' . __('Page') . ' ' . get_query_var('paged');
      if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
    }

    echo '</nav>';
  }
}
function base_url() {
  return base_dir();
}
function base_dir() {
  return get_stylesheet_directory_uri();
}
function printpre($var, $die = true) {
  print_r(['<pre>', $var]);
  return $die ? die() : false;
}
function getImovelDestaque() {
  $posts = get_posts(array('category' => 'destaque', 'numberposts' => 1, 'post_type' => 'imovel'));
  return $posts[0];
}
function getImoveis($limit = 3) {
  $posts = get_posts(array('numberposts' => $limit, 'post_type' => 'imovel', 'orderby' => 'rand'));
  return $posts;
}
function getMoveisHome($limit = 6) {
  $posts = get_posts(array('category' => 'home', 'numberposts' => $limit, 'post_type' => 'imovel'));
  return $posts;
}
function showBoxImovel($post = null, $id = false) {
  $post_id = $post ? $post->ID : $id;
  $data = get_fields($post_id);
?>
<div class="box-imovel">
    <div class="photo">
        <img src="<?= base_dir() ?>/img/home/home-foto02.png" alt="">
    </div>
    <div class="text">
        <p class="title"><a href="<?= the_permalink($post->ID) ?>"><?= $post->post_title; ?></a></p>
        <p class="local"><?= $data['endereco']['cidade'] ?> - <?= $data['endereco']['bairro'] ?></p>
        <hr>
    </div>
    <div class="icons">
        <ul>
            <li class="bed">T<?= $data['caracteristicas']['quartos'] ?></li>
            <li class="bath"><?= $data['caracteristicas']['banheiros'] ?> banheiros</li>
            <li class="square"><?= $data['caracteristicas']['m2'] ?> m<sup>2</sup></li>
            <li class="car"><?= $est = $data['caracteristicas']['vagas_estacionamento']; ?>
                vaga<?= $est > 1 ? 's' : '' ?></li>
        </ul>
    </div>
</div>
<?php
}
function showSlides($images, $size = false) {
  $id = 'slide' . uniqid();
  if ($images) { ?>
<div id="<?= $id ?>" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner  d-flex align-items-center">
        <?php
        foreach ($images as $k => $img) { ?>
        <?php $url = $size ? $img['sizes'][$size] : $img['url']; ?>
        <div class="carousel-item <?= $k == 0 ? 'active' : '' ?>">
            <img src="<?= $url ?>" class="d-block w-100" alt="...">
        </div>
        <?php } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php }
}


function binary_thumbnail_upscale($default, $orig_w, $orig_h, $new_w, $new_h, $crop) {
  if (!$crop) return null;
  $aspect_ratio = $orig_w / $orig_h;
  $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
  $crop_w = round($new_w / $size_ratio);
  $crop_h = round($new_h / $size_ratio);
  $s_x = floor(($orig_w - $crop_w) / 2);
  $s_y = floor(($orig_h - $crop_h) / 2);
  return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
}
add_filter('image_resize_dimensions', 'binary_thumbnail_upscale', 10, 6);


function valorMonetario($number, $symbol = true) {
  $n = number_format($number, 2, ',', '.');
  if ($symbol) {
    $n .= '€';
  }
  return $n;
}
function my_acf_google_map_api($api) {
  $api['key'] = 'AIzaSyCDZ058y2rYbz7fFcZwPxTHSwtfLfvoqP0';
  return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

function my_acf_init() {
  acf_update_setting('google_api_key', 'AIzaSyCDZ058y2rYbz7fFcZwPxTHSwtfLfvoqP0');
}
add_action('acf/init', 'my_acf_init');

function insert_jquery() {
  wp_enqueue_script('jquery', get_theme_file_uri('/js/jquery-3.5.1.min.js'), null, '3.5.1', false);
}
add_filter('wp_enqueue_scripts', 'insert_jquery', 1);

function formatMoney($value, $shorten = true, $currency = "EUR") {
  if ($shorten) {
    if ($value > 1000000) {
      $value = $value / 1000000;
      return $value . ' milhões ';
    }
  }
  $fmt = new NumberFormatter('pt_PT', NumberFormatter::CURRENCY);
  return $fmt->formatCurrency($value, $currency);
}

function imovel_filter($query) {
  if (!is_admin() && is_post_type_archive('imovel') && $query->is_main_query()) {

    $param = $_GET;
    $meta_query = [];

    /*
	'meta_query'	=> array(
		'relation'		=> 'AND',
		array(
			'key'		=> 'location',
			'value'		=> 'Melbourne',
			'compare'	=> '='
		),
		array(
			'key'		=> 'attendees',
			'value'		=> 100,
			'type'		=> 'NUMERIC',
			'compare'	=> '>'
		)
    */


    // tipo imovel
    if (isset($param['tipoImovel'])) {
      $query->set('category_name', strtolower($param['tipoImovel']));
    }
    if (isset($param['tamanhoMin']) && $param['tamanhoMin'] > 0) {
      $hasmeta = true;
      $meta_query[] = array(
        'key' => 'caracteristicas_m2',
        'value'  => $param['tamanhoMin'],
        'type'    => 'NUMERIC',
        'compare'  => '>'
      );
    }
    if (isset($param['tamanhoMax']) && $param['tamanhoMax'] > 0) {
      $hasmeta = true;
      $meta_query[] = array(
        'key' => 'caracteristicas_m2',
        'value'  => $param['tamanhoMax'],
        'type'    => 'NUMERIC',
        'compare'  => '<'
      );
    }
    if (isset($param['precoMin']) && $param['precoMin'] > 0) {
      $hasmeta = true;
      $meta_query[] = array(
        'key' => 'valor_do_imovel',
        'value'  => $param['precoMin'],
        'type'    => 'NUMERIC',
        'compare'  => '>'
      );
    }
    if (isset($param['precoMax']) && $param['precoMax'] > 0) {
      $hasmeta = true;
      $meta_query[] = array(
        'key' => 'valor_do_imovel',
        'value'  => $param['precoMax'],
        'type'    => 'NUMERIC',
        'compare'  => '>'
      );
    }
    /*
    if (isset($param['tamanhoMin']) & $param['tamanhoMin'] > 0) {
      $hasmeta = true;
      $meta_query[] = array(
        'key' => 'caracteristica_m2',
        'value'  => $param['tamanhoMin'],
        'type'    => 'NUMERIC',
        'compare'  => '<'
      );
    }
    */
    if ($hasmeta) {
      $meta = array('relation' => 'AND', $meta_query);
      $query->set('meta_query', $meta);
    }
    //printpre($query);
  }
}
add_action('pre_get_posts', 'imovel_filter');
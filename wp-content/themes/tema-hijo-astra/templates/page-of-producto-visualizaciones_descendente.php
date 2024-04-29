<?php
    /*
    Template Name: Page of Visualizaciones
    */

get_header(); ?>

<div class="wrap">

    <?php if ( have_posts() ) : ?>
    <?php endif; ?>

    <div id="primary" class="content-area">
        <main id="content" class="site-content" role="main">

            <?php
            if(is_user_logged_in()) {
                $type = 'articulo';
                $args = array(
                    'post_type' => $type,
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'posts_per_page' => 10,
                    'ignore_sticky_posts' => 1,
                    'meta_key' => 'visitas',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'estado',
                            'value' => 'disponible',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'estado',
                            'value' => 'reservado',
                            'compare' => '=',
                        ),
                    ),
                    'orderby' => array(
                        'meta_value_num' => 'DESC',
                        'post_count' => 'DESC'
                    )
                );
                $temp = $wp_query; // assign ordinal query to temp variable for later use  
                $wp_query = null;
                $wp_query = new WP_Query($args); 
                //--------------------------

                if ($wp_query->have_posts()) {
                    echo "<div class='product-table'>";
                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <div class='product-row'>
                            <div class='product-image'>
                                <img src='<?php echo get_the_post_thumbnail_url();?>' alt='<?php the_title_attribute(); ?>'>
                            </div>
                            <div class='product-info'>
                                <h2 class='product-title'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h2>
                                <p class='product-description'><?php the_field('descripcion'); ?></p>
                                <p class='product-price'>Precio: <?php the_field('precio'); ?></p>
                                <p class='product-status'>Estado: <?php the_field('estado'); ?></p>
                                <p class='product-quantity'>Cantidad: <?php the_field('cantidad'); ?></p>
                                <p class='product-visits'>Visitas: <?php the_field('visitas'); ?></p>
                            </div>
                        </div>
                    <?php endwhile;
                    echo "</div>";
                } else {
                    echo "<p>No se encontraron artículos.</p>";
                }
            } else {
              echo '<h1 class="page-title">Contenido disponible para usuarios registrados, si quieres registrarte pulse <a href="http://localhost/MusicWorld/Registro/">aqui</a></h1>';
                        }

            ?>

        </main>
    </div>
</div>
<style>
.table {
  border-collapse: collapse;
  margin-top: 30px;
  width: 100%;
}

.table th, .table td {
  border: 1px solid #ddd;
  padding: 8px;
  
}

.table th {
  background-color: #f2f2f2;
  text-align: left;
}
.product-row {
  display: flex;
  align-items: center;
  border-bottom: 1px solid #ddd;
  padding: 10px;
}

.product-row:last-child {
  border-bottom: none;
}

@media screen and (max-width: 767px) {
  .product-row {
    flex-direction: column;
    align-items: flex-start;
    padding: 20px 10px;
  }

  .product-row .product-image {
    margin-bottom: 20px;
  }
}
.product-image {
  width: 250px;
  height: 600px;
  margin-right: 20px;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.product-info {
  flex: 1;
}

.product-title {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}

.product-description {
  margin: 5px 0;
  font-size: 14px;
  line-height: 1.4;
}

.product-price {
  margin: 5px 0;
  font-size: 16px;
  font-weight: bold;
}

.product-status {
  margin: 5px 0;
  font-size: 14px;
}

.product-quantity {
  margin: 5px 0;
  font-size: 14px;
}

.product-visits {
  margin: 5px 0;
  font-size: 14px;
}


</style>

<?php
get_footer();
?>
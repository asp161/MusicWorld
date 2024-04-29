<?php get_header(); ?>

<div class="wrap">

    <?php if ( have_posts() ) : ?>
        <header class="page-header">
           
        </header><!-- .page-header -->
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
                    'meta_key' => 'cantidad',
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
                $temp = $wp_query; 
                $wp_query = null;
                $wp_query = new WP_Query($args); 

                if ( $wp_query->have_posts() ) :
                    echo '<table class="product-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Imagen</th>';
                    echo '<th>Información del producto</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ( $wp_query->have_posts() ) :
                        $wp_query->the_post();
                        echo '<tr>';
                        echo '<td class="product-image"><img src="' . get_the_post_thumbnail_url() . '"></td>';
                        echo '<td class="product-info">';
                        echo '<header class="entry-header">';
                        echo '<h1 class="entry-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h1>';
                        echo '</header><!-- .entry-header -->';
                        echo '<div class="entry-content">';
                        echo '<p><strong>Descripción:</strong> ' . get_field('descripcion') . '</p>';
                        echo '<p><strong>Precio:</strong> ' . get_field('precio') . '</p>';
                        echo '<p><strong>Estado:</strong> ' . get_field('estado') . '</p>';
                        echo '<p><strong>Cantidad:</strong> ' . get_field('cantidad') . '</p>';
                        echo '<p><strong>Visitas:</strong> ' . get_field('visitas') . '</p>';
                        echo '</div><!-- .entry-content -->';
                        echo '</td>';
                        echo '</tr>';
                    endwhile;
                    echo '</tbody>';
                    echo '</table>';
                endif;
                wp_reset_postdata(); // reset the query 
            } else {
              echo '<h1 class="page-title">Contenido disponible para usuarios registrados, si quieres registrarte pulse <a href="http://localhost/MusicWorld/Registro/">aqui</a></h1>';            }
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
  height: 500px;
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
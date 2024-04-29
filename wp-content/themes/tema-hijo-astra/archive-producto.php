<?php
/**
 * Template Name: Wallapop
 *
 * Print posts of a Custom Post Type.
 */

get_header(); ?>

<div class="wrap">

    <?php if ( have_posts() ) : ?>
        <header class="page-header">
        </header>
    <?php endif; ?>

    <div id="primary" class="content-area">
        <main id="content" class="site-content" role="main">

            <?php
            
            if(is_user_logged_in()){
                $type = 'articulo';
                $args = array (
                'post_type' => $type,
                'post_status' => 'publish',
                'paged' => $paged,
                'posts_per_page' => 10,
                'ignore_sticky_posts'=> 1
                );
                $temp = $wp_query; 
                $wp_query = null;
                $wp_query = new WP_Query($args); 
        
                echo "<table class='product-table' cellspacing='0' cellpadding='0'>";
            
                while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            
                    <tr>
                        <td class="product-image">
                            <?php $thumb_id = get_post_thumbnail_id();
                            $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); ?>
                            <div class="image-wrapper">
                                <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                        </td>
                        
                        <td class="product-details">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><h2 class="product-title"><?php the_title(); ?></h2></a>
                            <p class="product-info"><span class="product-label">Descripcion: </span><a href="<?php the_permalink(); ?>"><?php the_field('descripcion') ?></a></p>
                            <p class="product-info"><span class="product-label">Precio: </span> <?php the_field('precio')?> €</p>
                            <p class="product-info"><span class="product-label">Estado: </span> <?php the_field('estado')?> </p>
                            <p class="product-info"><span class="product-label">Unidades: </span> <?php the_field('cantidad')?> </p>
                            <p class="product-info"><span class="product-label">Visitas:</span> <?php the_field('visitas')?> </p>
                    <?php if (get_field('cantidad') > 0) { ?>
                            <button class="reservar-btn" data-product="<?php echo get_the_ID(); ?>">Reservar</button>
        <?php } ?>
</td>

                    </tr>
                
                <?php
                endwhile;
                echo "</table>";    

            }
            else {
                echo '<h1 class="page-title">Contenido disponible para usuarios registrados, si quieres registrarte pulse <a href="http://localhost/MusicWorld/Registro/">aqui</a></h1>';
            }
            ?>

        </main>
    </div>
</div>
<style>
table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 20px;
}
th,
td {
text-align: left;
padding: 8px;
}

th {
background-color: #ddd;
font-weight: bold;
}

tr:nth-child(even) {
background-color: #f2f2f2;
}

.entry-title {
margin-top: 0;
}

.entry-content {
margin-bottom: 20px;
}

.site-content {
margin-top: 30px;
}

.product-table td {
vertical-align: top;
}

.product-image img {
width: 250px;
height: 500px;
height: auto;
object-fit: cover;
border-radius: 5px;
box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
}

.product-details {
padding: 10px;
border: 1px solid #ddd;
border-radius: 5px;
margin-left: 10px;
}

.product-title {
margin-top: 0;
}

.product-info {
margin: 0;
font-size: 16px;
line-height: 1.5;
}

.product-label {
font-weight: bold;
}

</style>
<script>
jQuery(document).ready(function($) {
    $('.reservar-btn').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product');
        var postData = {
            action: 'reservar_producto',
            product_id: productId
        };
        $.post('<?php echo admin_url('admin-ajax.php'); ?>', postData, function(response) {
            if (response.success) {
                alert('Producto reservado con éxito');
                location.reload();
            } else {
                alert('Error al reservar el producto');
            }
        });
    });
});
</script>

<?php
get_footer();
?>

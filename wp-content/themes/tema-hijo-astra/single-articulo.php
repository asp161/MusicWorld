<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/content-#single-post
 *
 * @package WordPress
 * @subpackage Astra
 * @since Astra
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">

      <?php
      while (have_posts()) :
        the_post();
        echo "<div class='featured-image'><img src='" . get_the_post_thumbnail_url() . "'></div>";
        echo "<div class='product-info'>";
        echo "<h1 class='product-title'>" . get_the_title() . "</h1>";
        echo "<p class='product-description'>" . get_the_content() . "</p>";
        echo "<ul class='product-meta'>";
        echo "<li><span>Vendedor:</span> " . get_the_author() . "</li>";
        $custom_field_vals1 = get_post_custom_values('titulo');
        if ($custom_field_vals1) {
          echo "<li><span>Título:</span></li>";
          foreach ($custom_field_vals1 as $value) {
            echo "<li>" . $value . "</li>";
          }
        }
        $custom_field_vals2 = get_post_custom_values('descripcion');
        if ($custom_field_vals2) {
          echo "<li><span>Descripción:</span></li>";
          foreach ($custom_field_vals2 as $value) {
            echo "<li>" . $value . "</li>";
          }
        }
        $custom = get_post_custom();
        echo "<li><span>Precio:</span> " . $custom['precio'][0] . "€</li>";
        $custom_field_vals4 = get_post_custom_values('estado');
        if ($custom_field_vals4) {
          echo "<li><span>Estado:</span></li>";
          foreach ($custom_field_vals4 as $value) {
            echo "<li>" . $value . "</li>";
          }
        }
        echo "<li><span>Cantidad:</span> " . $custom['cantidad'][0] . "</li>";
        $custom_field_visitas = get_post_custom_values('visitas');
        if ($custom_field_visitas) {
          echo "<li><span>Visitas:</span> " . $custom_field_visitas[0] . "</li>";
        }
        echo "</ul>";
        echo "</div>";
         if (get_field('cantidad') > 0) { ?>
          <button class="reservar-btn" data-product="<?php echo get_the_ID(); ?>">Reservar</button>
<?php } 

    
      endwhile; 
      ?>

    </main>
  </div>
  <?php get_sidebar(); ?>
</div>
<style>
/* Estilos para la página de visualización de un producto */
.product-info {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 1rem;
  margin-bottom: 2rem;
  background-color: #f8f8f8;
  border-radius: 10px;
  padding: 1rem;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-info img {
  max-width: 100%;
  display: block;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-info ul {
  margin: 0;
  padding: 0;
  list-style: none;
  font-size: 1.2rem;
}

.product-info li {
  margin-bottom: 0.5rem;
}

.product-info span {
  font-weight: bold;
  margin-right: 0.5rem;
}

.product-info h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

.product-info h2 {
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
}

.product-info h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.product-info p {
  margin: 0;
  line-height: 1.5;
  font-size: 1.2rem;
}

.product-info button {
  padding: 1rem;
  border: none;
  background-color: #4caf50;
  color: white;
  font-size: 1.2rem;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 1rem;
  transition: background-color 0.2s ease;
}

.product-info button:hover {
  background-color: #388e3c;
}



    </style>



<?php
get_footer();
?>

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
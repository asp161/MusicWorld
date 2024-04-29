<?php
/*
Plugin Name: Contador de visualizaciones de productos
*/


// Actualizar contador de visualizaciones cada vez que se visualiza un producto
function actualizar_contador_visualizaciones() {
    if ( is_singular( 'articulo' ) ) {
        $post_id= get_the_ID();
        $visitas_actuales= get_post_meta($post_id, 'visitas', true);
        $nuevas_visita= intval($visitas_actuales)+1;
        update_post_meta($post_id, 'visitas', $nuevas_visita);
    }
}
add_action( 'wp_head', 'actualizar_contador_visualizaciones' );

add_action('wp_ajax_reservar_producto', 'reservar_producto_callback');
add_action('wp_ajax_nopriv_reservar_producto', 'reservar_producto_callback');

function reservar_producto_callback() {
    $productId = intval($_POST['product_id']);
    $product = get_post($productId);
    if ($product && $product->post_type == 'articulo') {
        $cantidad = intval(get_field('cantidad', $productId));
        if ($cantidad > 0) {
            $cantidad--;
            update_field('cantidad', $cantidad, $productId);
            if ($cantidad == 0) {
                update_field('estado', 'reservado', $productId);
            }
            wp_send_json_success();
        }
    }
    wp_send_json_error();
}




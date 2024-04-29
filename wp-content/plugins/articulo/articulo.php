<?php
/*
Plugin Name: UA-tipo de dato Producto
Description: Tipo de dato PRODUCTO y funciones de la WEB-Productos 
Version: 1.0
Author: Departamento de Lenguaje u Sistemas Informáticos
Author URI: http://www.dlsi.ua.es
*/


// Register Custom Post Type
function custom_post_articulo() {

    $labels = array(
        'name'                  => _x( 'Articulos', 'Post Type General Name', 'bk' ),
        'singular_name'         => _x( 'Articulos', 'Post Type Singular Name', 'bk' ),
        'menu_name'             => __( 'Articulos', 'bk' ),
        'name_admin_bar'        => __( 'Articulos', 'bk' ),
        'archives'              => __( 'Articulos Archivos', 'bk' ),
        'parent_item_colon'     => __( 'Parent Producto:', 'bk' ),
        'all_items'             => __( 'Todos los Articulos', 'bk' ),
        'add_new_item'          => __( 'Nuevo Articulo', 'bk' ),
        'add_new'               => __( 'Nuevo Articulo',  'bk' ),
        'new_item'              => __( 'Nuevo Articulo', 'bk' ),
        'edit_item'             => __( 'Editar Articulo', 'bk' ),
        'update_item'           => __( 'Actualizar Articulo', 'bk' ),
        'view_item'             => __( 'Ver Articulo', 'bk' ),
        'search_items'          => __( 'Buscar Articulo', 'bk' ),
        'not_found'             => __( 'No encontrado', 'bk' ),
        'not_found_in_trash'    => __( 'No encontrado en la papelera', 'bk' ),
        'featured_image'        => __( 'Featured Image', 'bk' ),
        'set_featured_image'    => __( 'Set featured image', 'bk' ),
        'remove_featured_image' => __( 'Remove featured image', 'bk' ),
        'use_featured_image'    => __( 'Use as featured image', 'bk' ),
        'insert_into_item'      => __( 'Insertar en Articulo', 'bk' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Articulo', 'bk' ),
        'items_list'            => __( 'Lista de Articulos', 'bk' ),
        'items_list_navigation' => __( 'Navegación en lista de Articulos', 'bk' ),
        'filter_items_list'     => __( 'Filtrar lista de Articulos', 'bk' ),
    );
    $args = array(
        'label'                 => __( 'Articulo', 'bk' ),
        'description'           => __( 'Articulos', 'bk' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'post-formats', ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        //'capability_type'       => 'articulo',
        //'map_meta_cap'          => true,

    );
    register_post_type( 'articulo', $args );

}
add_action( 'init', 'custom_post_articulo', 0 );


//----------------Shortcode for exclusive content
    add_shortcode('exclusive','logged_in_content');
    function logged_in_content ($atts,$content = null){
        if(is_user_logged_in()) return '<p>'.$content.'</p>';
        else return '<h2> Registrate si quieres conocer mas...</h2>';
    }
?>
<?php
    /**
     * Template Name: pagina_producto
     * 
     * Inserts posts of Custom Post Type
    */

    if(isset($_POST['new_post']) == '1') {


        $title = $_POST['nombre'];
        $content = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];
        $cantidad = $_POST['cantidad'];
        $post_type = 'articulo';

        $wordpress_upload_dir = wp_upload_dir();
        $new_file_name = $_FILES["custom-upload"]["name"];
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $new_file_name;

        while(file_exists($new_file_path)) {
            $i++;
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $new_file_name;
        }

        $mime = mime_content_type($_FILES["custom-upload"]["tmp_name"]);
        $new_post = array (
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_type' => $post_type
        );

        $post_id = wp_insert_post($new_post);

        if(move_uploaded_file($_FILES["custom-upload"]["tmp_name"], $new_file_path)) {
            $upload_id = wp_insert_attachment(array('guid' => $new_file_path,
                                                    'post_mime_type' => $mime,
                                                    'post_title' => sanitize_file_name($new_file_name),
                                                    'post_content' => '',
                                                    'post_status' => 'inherit'), $new_file_path);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));
            set_post_thumbnail($post_id, $upload_id);
        }


        add_post_meta($post_id, 'nombre', $title, true);
        add_post_meta($post_id, 'descripcion', $content, true);
        add_post_meta($post_id, 'precio', $precio, true);
        add_post_meta($post_id, 'estado', $estado, true);
        add_post_meta($post_id, 'cantidad', $cantidad, true);

        //add_post_meta($post_id, 'fecha de publicacion', $contenido, true); No hay que ponerlo porque se pasa como contenido del post ($content)
        $post = get_post($post_id);
        wp_redirect($post->guid);
    }

    get_header(); 
?>

<div class="wrap">
    <div id="primary" class="content-area">
        <main id="content" class="site-content" role="main">
            <?php
                if(is_user_logged_in()) {
                ?>    
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                    echo '<div class="single-featured-image-header">';
                    the_post_thumbnail('twentyseventeen-featured-image');
                    echo '</div>';
                    the_title('<header class="entry-header"><h1 class="entry-title">', '</h1></header>');
                ?>
                <div class="entry-content">
                    <form action="" method="post" name="front_end" enctype="multipart/form-data">
                        <p>
                            <label for="nombre" class="label"><?php _e("Nombre"); ?></label>
                            <input type="text" name="nombre" size="45">
                        </p>
                        <p>
                            <label for="descripcion" class="label"><?php _e("Descripcion"); ?></label>
                            <textarea rows="4" cols="66" name="descripcion"></textarea>
                        </p>
                        <p>
                            <label for="precio" class="label"><?php _e("Precio"); ?></label>
                            <input type="text" name="precio" size="45">
                        </p>
                        <p>
                            <label for="estado" class="label"><?php _e("Estado"); ?></label>
                            <select name="estado">
                                <option value="disponible" selected>Disponible</option>
                                <option value="reservado">Reservado</option>
                                <option value="vendido">Vendido</option>
                            </select>
                        </p>
                        <p>
                            <label for="cantidad" class="label"><?php _e("Cantidad"); ?></label>
                            <input type="number" name="cantidad">
                        </p>
                        <input type="file" name="custom-upload" id="custom-upload">
                        <input type="hidden" name="new_post" value="1">
                        <button type="submit">Actualizar</button>
                    </form>
                </div>
            </article>

            <?php
                }
                else echo '<h1 class="page-title">Contenido disponible para usuarios registrados, si quieres registrarte pulse <a href="http://localhost/MusicWorld/Registro/">aqui</a></h1>';                //------------------
            ?>
        </main>
    </div>
</div>

<style>
    label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

input[type="text"],
textarea {
  display: block;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 20px;
  font-size: 16px;
  box-sizing: border-box;
}

select {
  display: block;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 20px;
  font-size: 16px;
  box-sizing: border-box;
  background-color: #fff;
}

input[type="number"] {
  display: block;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 20px;
  font-size: 16px;
  box-sizing: border-box;
}

button[type="submit"] {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}

.error-message {
  color: red;
  margin-bottom: 10px;
}

</style>
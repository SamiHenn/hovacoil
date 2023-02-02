<?php
/**
 * User: Oren
 * Date: 6/15/2015
 * Time: 10:51 AM
 */

namespace sogo;


class helper {
    public static function create_input($args){
        ?>
        <label for="<?php $args['id']?>" class="field-label hidden"><?php $args['label']?></label>
        <input class="short-field required" type="text" placeholder="<?php _e('Type Title Here', 'sogoc')?>"
               value="<?php echo $args['val']?>" name="<?php echo $args['id']?>" id="<?php echo $args['id']?>"/>

    <?php
    }
    public static function page_dropdown($post_type,$option_none ){
        $args = array(
            'selected'              => 0,
            'name'                  => $post_type. "_id",
            'show_option_none'      => $option_none, // string
            'sort_order'            => 'ASC',
            'sort_column'           => 'post_title',
            'hierarchical'          => 1,
            'post_type'             => $post_type,

        );
        wp_dropdown_pages($args);
    }



    public static function upload_feature_image( $file_input_name ){
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $uploadedfile = $_FILES[$file_input_name];
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

            if ( $movefile && !isset( $movefile['error'] ) ) {
                return  $movefile['url'];
            } else {
                /**
                 * Error generated by _wp_handle_upload()
                 * @see _wp_handle_upload() in wp-admin/includes/file.php
                 */
                return $movefile['error'];
            }
    }

    public static function manage_media_upload( $file_input_name, $post_id, $thumb = false){
        $files = $_FILES[$file_input_name];

        $ids = array();

        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );
                $_FILES = array ($file_input_name => $file);
                foreach ($_FILES as $file => $array) {

                    $ids[] = self::handle_attachment($file,$post_id,$thumb );
                }
            }
        }
        return $ids;


    }



    public static function handle_attachment($file_handler,$post_id,$set_thu=false) {

        // check to make sure its a successful upload
        if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $attach_id = media_handle_upload( $file_handler, $post_id );

        // If you want to set a featured image frmo your uploads.
        if ($set_thu) set_post_thumbnail($post_id, $attach_id);

        return $attach_id;
    }



    public static function input(){

    }


} 
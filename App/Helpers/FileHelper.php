<?php 

/** ----------------------------------------------- **/
/** ------------- FİLE FUNCTIONS -------------- **/
/** ----------------------------------------------- **/

// return file imga url
if ( ! function_exists('get_file_image') ) {
  /**
  * require file
  * @param string $file_path
  * @param array $file_type
  */
  function get_file_image($file, $type = 'default')
  {
    switch (strval($type)) {
      case 'jpg':
      case 'jpeg':
      case 'png':
      case 'gif':
      case 'bmp':
      case 'webp':
      case 'svg':
        return $file;
        break;

      default:
        return 'default/file_type/'.$type.'.png';
        break;
    } // switch
  }
}
?>

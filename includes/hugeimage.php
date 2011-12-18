<?php

require_once ABSPATH . 'wp-content/plugins/nextgen-gallery/lib/image.php';

class HugeImage extends nggImage {
    var $hugeimage_path;
  
    function set_hugeimage() {
        $this->hugeimage_path = "testing_path_now";
    }
}
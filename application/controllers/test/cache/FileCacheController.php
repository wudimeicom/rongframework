<?php

class FileCacheController extends Rong_Controller {

    public function __construct() {
        parent::__construct();
    }
    //http://127.0.0.9/index.php/test/cache/FileCache
    public function indexAction() {
        require_once 'Rong/Cache.php';
        date_default_timezone_set("Asia/Shanghai");
        $config = array(
            "cache_dir" => ROOT . "/data/cache"
        );
        echo "<h3>Demo cache</h3>";
        $cache = Rong_Cache::factory("File", $config);
        echo '1.save data to cache as the name of "color" , with tags "color" and "basic_color" <br />';
        $cache->set("color", array("green", "orange"), 30, array("color", "basic_color"));
        echo '2.get the cache by the name "color" <br />';
        $val = $cache->get("color");
        print_r($val);

        $cache->update("color", array("blue"), array("new_tag"));
        echo '<br /> 3.update the cache with new value and new tage:<br />';
        $val = $cache->get("color");
        print_r($val);
        echo '<br />delete tag "color" and then output it\'s value:<br />';
        $val = $cache->delete("color");
        $val = $cache->get("color");
        var_dump($val);
        echo '<br />delte old caches:<br />';
        $cache->deleteOld();
        echo '<br />delete by tag name,it maths any tag name of "color" or "basic_color":<br />';
        $cache->deleteByTag(array("color", "basic_color"), "any");
    }

}

?>

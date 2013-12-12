<?php

class UriController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }

    //http://127.0.0.9/test/uri/URI/index/five/six
    //http://127.0.0.9/index.php/test/uri/URI/index/five/six
    //http://127.0.0.9/test/uri/URI/index/five/six?id=2
    //http://127.0.0.9/test/uri/URI/index/five/six/test.html?id=2
    public function indexAction() {
        echo "<br />\$this->uri->item(3):";
        echo $this->uri->item(3);
        echo "<br />\$this->uri->item(4):";
        echo $this->uri->item(4);
        echo "<br />\$this->uri->item(5):";
        echo $this->uri->item(5);
        echo "<br />";
        echo "Rong_Uri:" . $this->getObject("Rong_Uri");
        echo "<br /> \$_GET:";
        print_r($_GET);
    }
    /**
     * http://127.0.0.9/test/uri/URI/queryString?id=2
     * http://127.0.0.9/test/uri/URI/queryString/five/six/test.html?id=2
     * 
     */
    public function queryStringAction() {
        print_r($_GET);
    }

}

?>

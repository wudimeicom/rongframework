<?php

class RouteController extends Rong_Controller {

    public function __construct() {

        parent::__construct();
    }
    /**
     * urls to visit this action 
     *http://127.0.0.9/test/route/Route/product/19850423
     * http://127.0.0.9/index.php/product-19850423.html
     * http://127.0.0.9/product-19850423.html    #config the url_rewrite modules on apache
     *http://127.0.0.9/index.php?do=/product-19850423.html
     *http://127.0.0.9/product-19850423.html?page=28
     */
    public function productAction() {
        echo "<h3>\$_GET:</h3>";
        print_r($_GET);
        echo "<h3>\$this->uri->item(5):</h3>";
        echo $this->uri->item(5);
        echo "<h3>Route rule:</h3>";
        echo 'index.php add this: &lt;?php $route->add( "product-:num.html","test/route/Route/product/$1" );';
    }
    /**
     * http://127.0.0.9/test/route/Route/user/1001/YangQingRong/profile
     * http://127.0.0.9/user/1001/YangQingRong/profile.html
     * http://127.0.0.9/index.php/user/1001/YangQingRong/profile.html
     * ...
     */
    public function userAction() {
        echo "<h3>\$this->uri->item(5):</h3>";
        echo $this->uri->item(5);
        echo "<h3>\$this->uri->item(6):</h3>";
        echo $this->uri->item(6);
        echo "<h3>\$this->uri->item(7):</h3>";
        echo $this->uri->item(7);
        echo "<h3>code</h3>";
        echo 'index.php add this: &lt;?php $route->add("user/:num/:word/:any.html" , "test/route/Route/user/$1/$2/$3" );';
    }
    /**
     * http://127.0.0.9/test/route/Route/article/101/cup/1
     * http://127.0.0.9/article/101/cup.html?id=1
     * http://127.0.0.9/index.php/article/101/cup.html?id=1
     * http://127.0.0.9/index.php?do=/article/101/cup.html?id=1
     */
    public function articleAction() {
        echo "<h3>\$this->uri->item(5):</h3>";
        echo $this->uri->item(5);
        echo "<h3>\$this->uri->item(6):</h3>";
        echo $this->uri->item(6);
         echo "<h3>\$this->uri->item(7):</h3>";
        echo $this->uri->item(7);
        echo "<h3>code</h3>";
        echo "index.php add this: &lt;?php \$route->add( 'article/([0-9]{3,4})/([a-zA-Z]{1,3})\.html\?id=:num' , 'test/route/Route/article/$1/$2/$3' );";
    }

}

?>

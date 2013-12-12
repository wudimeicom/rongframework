<?php

class AclController extends Rong_Controller {

    public function __construct() {
        parent::__construct();
    }
    //http://127.0.0.9/index.php/test/acl/Acl
    public function indexAction() {
        echo "<h3>rong acl</h3>";
        require_once 'Rong/Acl.php';
        $Acl = new Rong_Acl();

        $Acl->addRole(new Rong_Acl_Role("guest", "some normal guest"))
                ->addRole(  new Rong_Acl_Role( "national_news_admin", "national news administator", array("guest") )
        );

        $Acl->addResource(  new Rong_Acl_Resource("news", "news") )
           ->addResource( new Rong_Acl_Resource("national_news", "national news", array("news", "national_news"))
        );

        echo "<b>1.deny all operation for role 'guest':</b> <br />";

        $Acl->deny("guest", "news", "ALL");
        echo $Acl->isAllowed("guest", "news", "read") ?
                "guest is allowed to use the 'read' operation of  'news' " :
                "Guest is denied to use the 'read' operation of resource 'news'"
        ;

        echo "<br />";
exit();
        echo $Acl->isAllowed("national_news_admin", "national_news", "read") ?
                "national_news_admin  is allowed to use the 'read' operation of  'news'. " :
                "national_news_admin  is denied to use the 'read' operation of resource 'news'";
        echo "<br /> <br />";

        echo '<b>2.Allow all operation for guest: </b> <br />';

        $Acl->allow("guest", "news", "ALL");
        echo $Acl->isAllowed("guest", "news", "read") ?
                "guest is allowed to use the 'read' operation of  'news'" :
                "guest is denied to use the 'read' operation of resource 'news'";
        echo "<br />";
        echo $Acl->isAllowed("national_news_admin", "national_news", "read") ?
                "national_news_admin is allowed to use the 'read' operation of  'news'." :
                "national_news_admin is denied to use the 'read' operation of resource 'news'";
        echo "<br /><br />";

        echo '<b > 3.some specail operations.</b> <br />';
        $Acl->allow("guest", "news", array("read", "edit"));
        echo $Acl->isAllowed("guest", "news", "read") ?
                "guest  is allowed to use the read operation of  news" :
                "guest  is denied to use the read operation of   news";
        echo "<br /> ";

        echo $Acl->isAllowed("national_news_admin", "national_news", "read") ?
                "national_news_admin is allowed to use the read operation of national_news" :
                "national_news_admin is denied to use the read operation of  national_news.";
        echo "<br />";

        echo $Acl->isAllowed("guest", "news", "edit") ?
                "guest  is allowed to use the edit operation of  news" :
                "guest  is denied to use the edit operation of   news ";
        echo "<br /> ";

        echo $Acl->isAllowed("national_news_admin", "national_news", "edit") ?
                "national_news_admin  is allowed to use the edit operation of national_news." :
                "national_news_admin  is denied to use the edit operation of  national_news";
        echo "<br />";

        echo $Acl->isAllowed("guest", "news", "delete") ?
                "guest  is allowed to use the delete operation of  news" :
                "guest  is denied to use the delete operation of   news ";
        echo "<br /> ";

        echo $Acl->isAllowed("national_news_admin", "national_news", "delete") ?
                "national_news_admin  is allowed to use the delete operation of national_news" :
                "national_news_admin  is denied to use the delete operation of   national_news";
        echo "<br /> <br />";

        // 4. 涓婁笅灞傝鑹蹭笉涓�嚧,浠ヨ繎瀛愬眰鐨勪负鍑嗐�
        echo "<b>4. Tow relative roles  use the same resource with defferent rule,affected with the nearest one.</b> <br />";

        $Acl->allow("guest", "news", array("read", "edit"));
        $Acl->deny("national_news_admin", "news", array("read"));

        echo $Acl->isAllowed("guest", "news", "read") ?
                "guest is allowed to use the delete operation of  news " :
                "guest 涓嶈兘浣跨敤 news 鐨�read 鎿嶄綔";
        echo "<br />";

        echo $Acl->isAllowed("national_news_admin", "national_news", "read") ?
                "national_news_admin is allowed to use the read operation of national_news" :
                "national_news_admin is denied to read national_news";
        echo "<br /> <br />";

        echo "   \n\n   <hr /> \n\n<pre>  ";
        print_r($Acl);
        echo "</pre>";
        exit();
    }

}

?>

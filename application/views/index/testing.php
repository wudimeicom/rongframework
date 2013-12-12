<!DOCTYPE  html>
<html>
    <head>
        <?php include dirname( __FILE__) . "/../includes/head.php"; ?>
    </head>
    <body class="body">
<?php include dirname( __FILE__) . "/../includes/top.php"; ?>
        <div class="content">
<?php include dirname( __FILE__) . "/../includes/leftmenu.php"; ?>
            <div class="panel">
                <div class="panel_padding"> 
                    

                    <h1>testing</h1>
                    
                    

                        <h3>rong framework demos</h3>
                        <ol>
                            <li>
                                Base visit Uri type<br />
                                <table border="1">
                                    <tr>
                                        <td>
                                            path info: </td><td>
                                            <a target="_blank" href="<?php echo config("site_root"); ?>/index.php/test/uri/URI/queryString?id=2">
                                                index.php/test/uri/URI/queryString?id=2
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            uri rewrite:</td><td>
                                            <a target="_blank" href="<?php echo config("site_root"); ?>/test/uri/URI/queryString?id=2">
                                                /test/uri/URI/queryString?id=2
                                            </a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            $_GET["do"]:</td><td>
                                            <a target="_blank" href="<?php echo config("site_root"); ?>/index.php?do=/test/uri/URI/queryString?id=2">
                                                /index.php?do=/test/uri/URI/queryString?id=2
                                            </a> <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>伪静态 static url</td>
                                        <td><a href="<?php echo config("site_root"); ?>/product-5.html">伪静态 static url</a></td>
                                    </tr>
                                </table>

                            </li>
                            <li>

                                database model
                                <a href="<?php echo config("site_root"); ?>/index.php/test/db/Db" target="_blank">test db</a> <br />
                                <a href="<?php echo config("site_root"); ?>/index.php/test/db/Db/limit" target="_blank">database table PageLink</a> <br />
                                <a href="<?php echo config("site_root"); ?>/index.php/test/db/Model" target="_blank">database model</a>
                                <a href="<?php echo config("site_root"); ?>/index.php/test/db/Sqlite" target="_blank">connect to sqlite</a>
                            </li>
                            <li>
                                Rong_View example:
                                <a href="<?php echo config("site_root"); ?>/index.php/test/phpview/PhpView" target="_blank">
                                    test view
                                </a>
                            </li>
                            <li>
                                uri item:
                                <a href="<?php echo config("site_root"); ?>/index.php/test/uri/URI/index/five/six" target="_blank">
                                    show uri items  
                                </a>
                            </li>
                            <li>
                                Rong_Cache:
                                <a href="<?php echo config("site_root"); ?>/index.php/test/cache/FileCache" target="_blank">
                                    test cache
                                </a>
                            </li>
                            <li>
                                Rong_Acl:
                                <a href="<?php echo config("site_root"); ?>/index.php/test/acl/Acl" target="_blank">
                                    test acl
                                </a>
                            </li>
                            <li>
                                Route:
                                <a href="<?php echo config("site_root"); ?>/product-5.html" target="_blank">
                                    rewrite with number
                                </a>
                                &nbsp;
                                <a href="<?php echo config("site_root"); ?>/user/1001/lucy/a_english_teacher.html" target="_blank">
                                    rewrite with number,word,any words
                                </a>


                                &nbsp;
                                <a href="<?php echo config("site_root"); ?>/article/323/abc.html?id=3" target="_blank">
                                    rewrite with expression
                                </a>

                            </li>
                            <li>
                                Wudimei Template Engine:
                                <a href="<?php echo config("site_root"); ?>/index.php/test/wudimei/Students" target="_blank">view template engine</a>
                            </li>
                        </ol>
                        <a href="http://js.wudimei.com/" target="_blank">wudimei js :a oop javascript framework (pending...)</a>
                    


                 </div>
            </div>
            <div class="clear"></div>
        </div>
<?php include dirname( __FILE__) . "/../includes/bottom.php"; ?>
    </body>
</html>

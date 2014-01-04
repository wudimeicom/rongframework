<!DOCTYPE html>
<html>
    <head>
        <title>Rong_Db connect to sqlite</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link href="style.css" rel="stylesheet" type="text/css" />        <meta name="keywords" content="Rong_Db connect to sqlite,Rong Framework" />
        <meta name="description" content="Rong_Db connect to sqlite,Rong Framework" />
    </head>
    <body>
        <div class="Page">
            <div class="top">
    <div class="rf">Rong Framework</div>
</div>            <div class="content"> 
                <div>
                    <a href="index.html">Table Of Contents</a>
                </div>
                
                 <div class="ctrl">
                    Prev Page:
                                        <a href="Rong.Db.html"> class Rong_Db,connect to mysql</a>
                    
                    &nbsp;
                    <a href="index.html">Table Of Contents</a>
                    &nbsp;
                    Next Page :
                                        <a href="Rong.Db.Model.html">Database Model</a>
                                    </div> 
                <h3>Rong_Db connect to sqlite</h3>
                connect to sqlite is very simple.we have to supply file name,privage,table prefix to Rong_Db::factory.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /></span><span style="color: #FF8000">/**<br />&nbsp;*&nbsp;file&nbsp;encoding&nbsp;utf-8<br />&nbsp;*&nbsp;文件字符编码utf-8<br />&nbsp;*/<br /></span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">).</span><span style="color: #DD0000">"/../../lib"</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">set_include_path</span><span style="color: #007700">(&nbsp;&nbsp;</span><span style="color: #DD0000">"."&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">.&nbsp;&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">get_include_path</span><span style="color: #007700">()&nbsp;);<br /><br /></span><span style="color: #FF8000">//require&nbsp;the&nbsp;Rong_Db&nbsp;from&nbsp;the&nbsp;include&nbsp;path<br /><br /></span><span style="color: #0000BB">ini_set</span><span style="color: #007700">(</span><span style="color: #DD0000">"display_errors"</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">1&nbsp;</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">error_reporting</span><span style="color: #007700">(</span><span style="color: #0000BB">E_ALL</span><span style="color: #007700">|</span><span style="color: #0000BB">E_WARNING</span><span style="color: #007700">);<br />require_once&nbsp;</span><span style="color: #DD0000">'Rong/Db.php'</span><span style="color: #007700">;<br /><br />echo&nbsp;</span><span style="color: #DD0000">"&lt;h1&gt;test&nbsp;database&nbsp;model&nbsp;(测试数据库模型)&lt;/h1&gt;"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$GLOBALS</span><span style="color: #007700">[</span><span style="color: #DD0000">"debug"</span><span style="color: #007700">]&nbsp;=</span><span style="color: #0000BB">1</span><span style="color: #007700">;</span><span style="color: #FF8000">//debug&nbsp;the&nbsp;sql&nbsp;if&nbsp;is&nbsp;set<br /><br /></span><span style="color: #0000BB">$db&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">Rong_Db</span><span style="color: #007700">::</span><span style="color: #0000BB">factory</span><span style="color: #007700">(</span><span style="color: #DD0000">"Sqlite"</span><span style="color: #007700">,&nbsp;array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">"filename"&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">).</span><span style="color: #DD0000">"/test_sqlite.db"</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">"mode"&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">0777</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">"table_prefix"&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #DD0000">"w_"&nbsp;</span><span style="color: #FF8000">//table&nbsp;prefix<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #007700">));<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />echo&nbsp;</span><span style="color: #0000BB">$db</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">error</span><span style="color: #007700">();</span></span></code></div><br>the first parameter of Rong_Db::factory()is the driver name.eg:"Mysql","Sqlite".the second one is configuration.<br>while the drive name equals "Sqlite",the coinfiguration parammeter like this:<br>filename : file name of sqlite<br>mode : private<br>table_prefix: table prefix<br><br>create a table in sqlite:<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$db</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">query</span><span style="color: #007700">(</span><span style="color: #DD0000">'CREATE&nbsp;TABLE&nbsp;&nbsp;w_article(&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id&nbsp;&nbsp;&nbsp;integer&nbsp;PRIMARY&nbsp;KEY&nbsp;&nbsp;,&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;title&nbsp;varchar(255)&nbsp;,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;content&nbsp;varchar(255)<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)'</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #0000BB">$db</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">error</span><span style="color: #007700">();</span></span></code></div><br>the code can be found in test/db_sqlite.php,it's same as test/db.php,the mysql version.<br>

                <div class="ctrl">
                    Prev Page:
                                        <a href="Rong.Db.html"> class Rong_Db,connect to mysql</a>
                    
                    &nbsp;
                    <a href="index.html">Table Of Contents</a>
                    &nbsp;
                    Next Page :
                                        <a href="Rong.Db.Model.html">Database Model</a>
                                    </div> 
            </div>
            <div class="bottom">
 To get the last version of Rong Framework.please vist <a href="http://rong.wudimei.com" target="_balnk">http://rong.wudimei.com</a></div>  
        </div>
    </body>
</html>
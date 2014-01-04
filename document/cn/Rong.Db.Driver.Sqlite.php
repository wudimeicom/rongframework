<!DOCTYPE html>
<html>
    <head>
        <title>Rong_Db连接到sqlite</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link href="style.css" rel="stylesheet" type="text/css" />        <meta name="keywords" content="Rong_Db连接到sqlite,Rong Framework" />
        <meta name="description" content="Rong_Db连接到sqlite,Rong Framework" />
    </head>
    <body>
        <div class="Page">
            <div class="top">
    <div class="rf">Rong Framework</div>
</div>            <div class="content"> 
                <div>
                    <a href="index.html">目录</a>
                </div>
                
                 <div class="ctrl">
                    上一页:
                                        <a href="Rong.Db.html"> Rong_Db类连接使用mysql数据库</a>
                    
                    &nbsp;
                    <a href="index.html">目录</a>
                    &nbsp;
                    下一页 :
                                        <a href="Rong.Db.Model.html">数据库模型</a>
                                    </div> 
                <h3>Rong_Db连接到sqlite</h3>
                连接到sqlite比较简单。在Rong_Db::factory中要提供文件名、读写权限、表前缀几个数据。<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /></span><span style="color: #FF8000">/**<br />&nbsp;*&nbsp;file&nbsp;encoding&nbsp;utf-8<br />&nbsp;*&nbsp;文件字符编码utf-8<br />&nbsp;*/<br /></span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">).</span><span style="color: #DD0000">"/../../lib"</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">set_include_path</span><span style="color: #007700">(&nbsp;&nbsp;</span><span style="color: #DD0000">"."&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">.&nbsp;&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">get_include_path</span><span style="color: #007700">()&nbsp;);<br /><br /></span><span style="color: #FF8000">//require&nbsp;the&nbsp;Rong_Db&nbsp;from&nbsp;the&nbsp;include&nbsp;path<br /><br /></span><span style="color: #0000BB">ini_set</span><span style="color: #007700">(</span><span style="color: #DD0000">"display_errors"</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">1&nbsp;</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">error_reporting</span><span style="color: #007700">(</span><span style="color: #0000BB">E_ALL</span><span style="color: #007700">|</span><span style="color: #0000BB">E_WARNING</span><span style="color: #007700">);<br />require_once&nbsp;</span><span style="color: #DD0000">'Rong/Db.php'</span><span style="color: #007700">;<br /><br />echo&nbsp;</span><span style="color: #DD0000">"&lt;h1&gt;test&nbsp;database&nbsp;model&nbsp;(测试数据库模型)&lt;/h1&gt;"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$GLOBALS</span><span style="color: #007700">[</span><span style="color: #DD0000">"debug"</span><span style="color: #007700">]&nbsp;=</span><span style="color: #0000BB">1</span><span style="color: #007700">;</span><span style="color: #FF8000">//debug&nbsp;the&nbsp;sql&nbsp;if&nbsp;is&nbsp;set<br /><br /></span><span style="color: #0000BB">$db&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">Rong_Db</span><span style="color: #007700">::</span><span style="color: #0000BB">factory</span><span style="color: #007700">(</span><span style="color: #DD0000">"Sqlite"</span><span style="color: #007700">,&nbsp;array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">"filename"&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">).</span><span style="color: #DD0000">"/test_sqlite.db"</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">"mode"&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">0777</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">"table_prefix"&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #DD0000">"w_"&nbsp;</span><span style="color: #FF8000">//table&nbsp;prefix<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #007700">));<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />echo&nbsp;</span><span style="color: #0000BB">$db</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">error</span><span style="color: #007700">();</span></span></code></div><br>Rong_Db::factory()方法第一个参数是数据库驱动名，有Mysql、Sqlite等供选择。第二个参数是配置参数。<br>当驱动名为Sqlite时，配置参数要提供的数组元素：<br>filename : 文件名<br>mode : 文件权限<br>table_prefix: 表前缀<br><br>通过query来创建一个表：<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$db</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">query</span><span style="color: #007700">(</span><span style="color: #DD0000">'CREATE&nbsp;TABLE&nbsp;&nbsp;w_article(&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id&nbsp;&nbsp;&nbsp;integer&nbsp;PRIMARY&nbsp;KEY&nbsp;&nbsp;,&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;title&nbsp;varchar(255)&nbsp;,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;content&nbsp;varchar(255)<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)'</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #0000BB">$db</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">error</span><span style="color: #007700">();</span></span></code></div><br>在test/db_sqlite.php中可以看到这些代码。其它参照test/db.php<br>

                <div class="ctrl">
                    上一页:
                                        <a href="Rong.Db.html"> Rong_Db类连接使用mysql数据库</a>
                    
                    &nbsp;
                    <a href="index.html">目录</a>
                    &nbsp;
                    下一页 :
                                        <a href="Rong.Db.Model.html">数据库模型</a>
                                    </div> 
            </div>
            <div class="bottom">
 要获取最新的Rong Framework,请访问<a href="http://rong.wudimei.com" target="_balnk">http://rong.wudimei.com</a></div>  
        </div>
    </body>
</html>
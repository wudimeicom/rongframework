<!DOCTYPE html>
<html>
    <head>
        <title>客户端</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link href="style.css" rel="stylesheet" type="text/css" />        <meta name="keywords" content="客户端,Rong Framework" />
        <meta name="description" content="客户端,Rong Framework" />
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
                                        <a href="Rong.Service.Server.php"> 服务端</a>
                    
                    &nbsp;
                    <a href="index.html">目录</a>
                    &nbsp;
                    下一页 :
                                        <a href="Rong.Net.html">网络</a>
                                    </div> 
                <h3>客户端</h3>
                让我们来调用我们刚创建的远程函数吧。<br>记得刚才那个远程服务的网址：<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /></span><span style="color: #FF8000">/**<br />&nbsp;*&nbsp;file&nbsp;encoding&nbsp;utf-8<br />&nbsp;*&nbsp;文件字符编码utf-8<br />&nbsp;*/<br /></span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">)&nbsp;.&nbsp;</span><span style="color: #DD0000">"/../../lib"</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">set_include_path</span><span style="color: #007700">(</span><span style="color: #DD0000">"."&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">get_include_path</span><span style="color: #007700">());<br /><br />require_once&nbsp;</span><span style="color: #DD0000">'Rong/Service/Client.php'</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">$server_url&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #DD0000">"http://127.0.0.9/test/service_server.php"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$client&nbsp;</span><span style="color: #007700">=&nbsp;new&nbsp;</span><span style="color: #0000BB">Rong_Service_Client</span><span style="color: #007700">(&nbsp;</span><span style="color: #0000BB">$server_url&nbsp;</span><span style="color: #007700">);</span></span></code></div><br>如果服务器端设置了密码，在客户端要给出密码，否则不用给出。<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$client</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">password&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #DD0000">"123456"</span><span style="color: #007700">;</span></span></code></div><br>调用时只要把函数名当成客户端实例的方法来调用即可。<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$sum&nbsp;</span><span style="color: #007700">=</span><span style="color: #0000BB">$client</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">addNumber</span><span style="color: #007700">(</span><span style="color: #0000BB">1.2</span><span style="color: #007700">,</span><span style="color: #0000BB">5.3</span><span style="color: #007700">);<br />echo&nbsp;</span><span style="color: #DD0000">"1.2+5.3="&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$sum</span><span style="color: #007700">;<br />echo&nbsp;</span><span style="color: #DD0000">"&lt;br&nbsp;/&gt;"</span><span style="color: #007700">;</span></span></code></div><br>好了，我们获得了返回结果6.5(1.2+5.3=6.5)<br><br><br>

                <div class="ctrl">
                    上一页:
                                        <a href="Rong.Service.Server.php"> 服务端</a>
                    
                    &nbsp;
                    <a href="index.html">目录</a>
                    &nbsp;
                    下一页 :
                                        <a href="Rong.Net.html">网络</a>
                                    </div> 
            </div>
            <div class="bottom">
 要获取最新的Rong Framework,请访问<a href="http://rong.wudimei.com" target="_balnk">http://rong.wudimei.com</a></div>  
        </div>
    </body>
</html>
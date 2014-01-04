<!DOCTYPE html>
<html>
    <head>
        <title>服务端</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link href="style.css" rel="stylesheet" type="text/css" />        <meta name="keywords" content="服务端,Rong Framework" />
        <meta name="description" content="服务端,Rong Framework" />
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
                                        <a href="Rong.Service.html"> 远程调用服务</a>
                    
                    &nbsp;
                    <a href="index.html">目录</a>
                    &nbsp;
                    下一页 :
                                        <a href="Rong.Service.Client.php">客户端</a>
                                    </div> 
                <h3>服务端</h3>
                使用远程调用，首先包含Server类<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$PathToRongFramework&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">)&nbsp;.&nbsp;</span><span style="color: #DD0000">"/../../lib"</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">set_include_path</span><span style="color: #007700">(</span><span style="color: #DD0000">"."&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">get_include_path</span><span style="color: #007700">());<br /><br />require_once&nbsp;</span><span style="color: #DD0000">'Rong/Service/Server.php'</span><span style="color: #007700">;</span></span></code></div><br>我们来开发一个求和的函数：<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /><br /></span><span style="color: #007700">function&nbsp;</span><span style="color: #0000BB">addNumber</span><span style="color: #007700">(&nbsp;</span><span style="color: #0000BB">$num1</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$num2&nbsp;</span><span style="color: #007700">)<br />{<br />&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$sum&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">$num1&nbsp;</span><span style="color: #007700">+&nbsp;</span><span style="color: #0000BB">$num2</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;</span><span style="color: #0000BB">$sum</span><span style="color: #007700">;<br />}</span></span></code></div><br>接着我们实例化Server 类：<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server&nbsp;</span><span style="color: #007700">=&nbsp;new&nbsp;</span><span style="color: #0000BB">Rong_Service_Server</span><span style="color: #007700">();</span></span></code></div><br>如果要加密传输，我们可以加入一个密码，当然也可以不加。如果服务器商加了密码，客户端也必须加密码。如果不加，那客户端也不能加密码。<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">password&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #DD0000">"123456"</span><span style="color: #007700">;</span></span></code></div><br>接着要把这个函数名添加到函数列表中。<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">addFunction</span><span style="color: #007700">(</span><span style="color: #DD0000">"addNumber"</span><span style="color: #007700">);</span></span></code></div><br>好了，启动这个服务吧。<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">start</span><span style="color: #007700">();</span></span></code></div><br>


                <div class="ctrl">
                    上一页:
                                        <a href="Rong.Service.html"> 远程调用服务</a>
                    
                    &nbsp;
                    <a href="index.html">目录</a>
                    &nbsp;
                    下一页 :
                                        <a href="Rong.Service.Client.php">客户端</a>
                                    </div> 
            </div>
            <div class="bottom">
 要获取最新的Rong Framework,请访问<a href="http://rong.wudimei.com" target="_balnk">http://rong.wudimei.com</a></div>  
        </div>
    </body>
</html>
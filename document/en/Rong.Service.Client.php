<!DOCTYPE html>
<html>
    <head>
        <title>client</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link href="style.css" rel="stylesheet" type="text/css" />        <meta name="keywords" content="client,Rong Framework" />
        <meta name="description" content="client,Rong Framework" />
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
                                        <a href="Rong.Service.Server.php"> server</a>
                    
                    &nbsp;
                    <a href="index.html">Table Of Contents</a>
                    &nbsp;
                    Next Page :
                                        <a href="Rong.Net.html">Network</a>
                                    </div> 
                <h3>client</h3>
                let's call the function "addNumber($num1,$num2)" we created.<br>please rember the url of service server.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /></span><span style="color: #FF8000">/**<br />&nbsp;*&nbsp;file&nbsp;encoding&nbsp;utf-8<br />&nbsp;*&nbsp;文件字符编码utf-8<br />&nbsp;*/<br /></span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">)&nbsp;.&nbsp;</span><span style="color: #DD0000">"/../../lib"</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">set_include_path</span><span style="color: #007700">(</span><span style="color: #DD0000">"."&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">get_include_path</span><span style="color: #007700">());<br /><br />require_once&nbsp;</span><span style="color: #DD0000">'Rong/Service/Client.php'</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">$server_url&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #DD0000">"http://127.0.0.9/test/service_server.php"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$client&nbsp;</span><span style="color: #007700">=&nbsp;new&nbsp;</span><span style="color: #0000BB">Rong_Service_Client</span><span style="color: #007700">(&nbsp;</span><span style="color: #0000BB">$server_url&nbsp;</span><span style="color: #007700">);</span></span></code></div><br>if the server site set the password,please give the password the the client instance.if no,don't give password.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$client</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">password&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #DD0000">"123456"</span><span style="color: #007700">;</span></span></code></div><br>when calling,call the remoting service function as the method of client.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$sum&nbsp;</span><span style="color: #007700">=</span><span style="color: #0000BB">$client</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">addNumber</span><span style="color: #007700">(</span><span style="color: #0000BB">1.2</span><span style="color: #007700">,</span><span style="color: #0000BB">5.3</span><span style="color: #007700">);<br />echo&nbsp;</span><span style="color: #DD0000">"1.2+5.3="&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$sum</span><span style="color: #007700">;<br />echo&nbsp;</span><span style="color: #DD0000">"&lt;br&nbsp;/&gt;"</span><span style="color: #007700">;</span></span></code></div><br>Okay,we got the result: 6.5(1.2+5.3=6.5)<br><br><br>

                <div class="ctrl">
                    Prev Page:
                                        <a href="Rong.Service.Server.php"> server</a>
                    
                    &nbsp;
                    <a href="index.html">Table Of Contents</a>
                    &nbsp;
                    Next Page :
                                        <a href="Rong.Net.html">Network</a>
                                    </div> 
            </div>
            <div class="bottom">
 To get the last version of Rong Framework.please vist <a href="http://rong.wudimei.com" target="_balnk">http://rong.wudimei.com</a></div>  
        </div>
    </body>
</html>
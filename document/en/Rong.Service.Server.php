<!DOCTYPE html>
<html>
    <head>
        <title>server</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link href="style.css" rel="stylesheet" type="text/css" />        <meta name="keywords" content="server,Rong Framework" />
        <meta name="description" content="server,Rong Framework" />
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
                                        <a href="Rong.Service.html"> remote calling service</a>
                    
                    &nbsp;
                    <a href="index.html">Table Of Contents</a>
                    &nbsp;
                    Next Page :
                                        <a href="Rong.Service.Client.php">client</a>
                                    </div> 
                <h3>server</h3>
                To use the remoting call ,please include the server class at first.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$PathToRongFramework&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">dirname</span><span style="color: #007700">(</span><span style="color: #0000BB">__FILE__</span><span style="color: #007700">)&nbsp;.&nbsp;</span><span style="color: #DD0000">"/../../lib"</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">set_include_path</span><span style="color: #007700">(</span><span style="color: #DD0000">"."&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$PathToRongFramework&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">PATH_SEPARATOR&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">get_include_path</span><span style="color: #007700">());<br /><br />require_once&nbsp;</span><span style="color: #DD0000">'Rong/Service/Server.php'</span><span style="color: #007700">;</span></span></code></div><br>let us develop a function for calling.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /><br /></span><span style="color: #007700">function&nbsp;</span><span style="color: #0000BB">addNumber</span><span style="color: #007700">(&nbsp;</span><span style="color: #0000BB">$num1</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$num2&nbsp;</span><span style="color: #007700">)<br />{<br />&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$sum&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">$num1&nbsp;</span><span style="color: #007700">+&nbsp;</span><span style="color: #0000BB">$num2</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;</span><span style="color: #0000BB">$sum</span><span style="color: #007700">;<br />}</span></span></code></div><br>then create a server instance.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server&nbsp;</span><span style="color: #007700">=&nbsp;new&nbsp;</span><span style="color: #0000BB">Rong_Service_Server</span><span style="color: #007700">();</span></span></code></div><br>the server can be add a password for data transfer encryption.it's optional.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">password&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #DD0000">"123456"</span><span style="color: #007700">;</span></span></code></div><br>then we add the function to the function-list.<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">addFunction</span><span style="color: #007700">(</span><span style="color: #DD0000">"addNumber"</span><span style="color: #007700">);</span></span></code></div><br>okay,let's start the server!<br><div class="code"  ><code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br />$server</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">start</span><span style="color: #007700">();</span></span></code></div><br>

                <div class="ctrl">
                    Prev Page:
                                        <a href="Rong.Service.html"> remote calling service</a>
                    
                    &nbsp;
                    <a href="index.html">Table Of Contents</a>
                    &nbsp;
                    Next Page :
                                        <a href="Rong.Service.Client.php">client</a>
                                    </div> 
            </div>
            <div class="bottom">
 To get the last version of Rong Framework.please vist <a href="http://rong.wudimei.com" target="_balnk">http://rong.wudimei.com</a></div>  
        </div>
    </body>
</html>
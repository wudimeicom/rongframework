<!DOCTYPE  html  PUBLIC  "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <link href="/skin/default/css/rf.css" type="" rel="stylesheet"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            body{ background-color: #F0F0F0;}
             .MessagePanel{ width: 500px; margin-left: auto; margin-right: auto; margin-top: 50px; border: 1px solid #E0E0E0; background-color: white; }
              .Title{ padding: 3px 10px; font-size: 14px; font-weight: bold; border-bottom: 1px solid #E0E0E0;background-color: #E0E5FF; }
              .Content{ padding: 3px 10px; line-height: 25px; min-height: 100px; }
              .ButtonPanel{ padding: 3px 10px;background-color: #FAFAFA;border-top: 1px solid #E0E0E0; text-align: right;}
              .ButtonPanel a{ text-decoration: none; color: #333; font-weight: bold; border: 1px solid saddlebrown; background-color: burlywood; padding: 0px 10px; }
        </style>
    </head>
    <body>
        <div class="MessagePanel">
            <div class="Title">
                Hi!
            </div>
            <div class="Content">
                <?php echo $message; ?>
                
                
            </div>
            <div class="ButtonPanel">
                    <a href="<?php echo $url; ?>">OK</a>
            </div>
        </div>
           
    </body>
</html>
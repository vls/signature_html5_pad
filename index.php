<?php
require_once 'sigToSvg.php';

$msg = "";
if(array_key_exists('output', $_POST)) {
    $output = $_POST['output'];
    if(!empty($output)) {
        $obj = new sigToSvg($output);
        $s = $obj->getImage();
        file_put_contents("output/".time().".svg", $s);
        $msg = "保存成功";
    }
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>签到页面</title>
        <script src="j/jquery.min.js"></script>
        <script src="j/jquery.signaturepad.min.js"></script>
        <script src="j/json2.min.js"></script>
        <link rel=stylesheet href="c/css/bootstrap.min.css">
        <link rel=stylesheet href="c/jquery.signaturepad.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript">
            $(function(){
                var c = $('#can_sign');
                var ct = c.get(0).getContext('2d');
                //var container = $(c).parent();
                var container = $("div.container");
                var wrapper = $(".sigWrapper");
                //var pad = $(".sigPad");

                //Run function when browser resizes
                $(window).resize( respondCanvas );

                function respondCanvas(){ 
                    var w = $(container).width();
                    var h = $(container).height();
                    //pad.attr('width', w);
                    //pad.attr('height', h);
                    wrapper.css('width', w);
                    wrapper.css('height', h);
                    c.attr('width', w ); //max width
                    c.attr('height', h ); //max height

                    //Call a function to redraw other content (texts, images etc)
                }

                //Initial call 
                respondCanvas();

                var options = {};
                options.defaultAction = "drawIt";
                options.drawOnly = true;
                $('.container').signaturePad(options);
            });

        </script>
        <style type="text/css">
            body {
                text-align:center;
            }
            div.container {
                width: 90%;
                height: 70%;
                display:inline-block;  
            }
            form {
                display: inline-block;
                text-align: center;
                margin:0 auto;
            }
            button {
                margin-top: 10px;
            }
            #wrapper{
                position: absolute;
                top:0;
                bottom:0;
                left:0;
                right:0;
            }

            .outer{
                display:table;
                table-layout:fixed;
                height:100%;
                width:100%;
            }

            .inner{
                display:table-cell;
                text-align:center;
                vertical-align:top;
                width:100%;
                position:relative;
            }
        </style>
    </head>
    <body>

<div id="wrapper">
    <?php
    if($msg) {
?>
    <div class="alert alert-success"><?=$msg;?></div>
<?php
    }
    ?>

    <div class="outer">
        <div class="inner">

    <div class="container">
      <p class="drawItDesc">请签名</p>
      <ul class="sigNav">
        <li class="clearButton"><a href="#clear">清除</a></li>
      </ul>
      <div class="sig sigWrapper">
        <canvas id="can_sign" class="pad" width="800" height="400"></canvas>
      </div>
    <form method="post" action="" class="sigPad">
      <button type="submit" class="btn btn-primary">保存</button>
        <input type="hidden" name="output" class="output">
    </form>
    </div>
</div>
</div>
</div>

    </body>
</html>

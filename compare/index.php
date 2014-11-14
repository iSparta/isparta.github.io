
<html class="blank">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>动态图对比</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">

</head>
    <body>
        <h1>动态图对比<span class="tips">提示：可以按住"ctrl"和"+"键放大对比;可以在右边选择背景颜色</h1>
            
            <script id="j-tmpl" type="text/template">         
            <div class="imgcont clearfix" id="imgcont1">
                <div class="img">
                    <img src="<?php echo $gifimg; ?>"/>
                    <p>GIF</p>
                    <p>帧数：<strong><?php echo $num[$i] ?></strong>帧</p>
                    <p>大小：<strong><?php echo round(intval(filesize($gifimg))/1024, 2) ?></strong>k</p>
                </div>
                <div class="img">
                    <img src="<?php echo $apngimg; ?>"/>
                    <p>APNG</p>
                     <p>帧数：<strong><?php echo $num[$i] ?></strong>帧</p>
                    <p>大小：<strong><?php echo round(intval(filesize($apngimg))/1024, 2) ?></strong>k</p>
                </div>
                 <div class="img" style="display:none" >
                    
                    <img src="<?php echo $lossimg; ?>"/>
                    <p>PNG 有损后转换</p>
                     <p>帧数：<strong><?php echo $num[$i] ?></strong>帧</p>
                    <p>大小：<strong><?php echo round(intval(filesize($lossimg))/1024, 2) ?></strong>k</p>
                </div>
                <div class="img" style="display:none">
                    
                    <img src="<?php echo $apnglossimg; ?>"/>
                    <p>APNG 有损</p>
                     <p>帧数：<strong><?php echo $num[$i] ?></strong>帧</p>
                    <p>大小：<strong><?php echo round(intval(filesize($apnglossimg))/1024, 2) ?></strong>k</p>
                </div>
               

                
            </div>
            </script>
            
            
            
        </div>
        <div class="color">
            <div class="blank"></div>
            <div class="white"></div>
            <div class="transparent"></div>
            <div class="red"></div>
            <div class="green"></div>
            <div class="blue"></div>
        </div>
        <div class="show">
            <div class="item">
                <input type="checkbox" id="check_gif" name="check_gif" checked="checked" data-to="1"/>
                <label for="check_gif">GIF</label>
            </div>
            <div class="item">
                <input type="checkbox" id="check_apng" name="check_apng" checked="checked" data-to="2"/>
                <label for="check_apng">apng</label>
                
            </div>
            <div class="item">
                <input type="checkbox" id="check_loss" name="check_loss" data-to="3"/>
                <label for="check_loss">apngloss1</label>
                
            </div>
            <div class="item">
                <input type="checkbox" id="check_apngloss" name="check_apngloss" data-to="4"/>
                <label for="check_apngloss">apngloss2</label>
                
            </div>


            
        </div>

        <script type="text/javascript" src="../js/jquery.min.js"></script>
        
        <script type="text/javascript" src="../js/apng-canvas.js"></script>
        <script type="text/javascript" src="../js/doT.js"></script>
        
        <script type="text/javascript">
        function getImageSize(url) { 
            var xhr = new XMLHttpRequest();

             var BlobBuilder = (document.BlobBuilder || document.WebKitBlobBuilder);
            // console.log(url)
            xhr.open('GET', url, true);
            
            xhr.overrideMimeType('text/plain; charset=x-user-defined');
            
            xhr.onreadystatechange = function(e) {
                
                if (this.readyState == 4 && this.status == 200) {
                    var bb = new BlobBuilder();
                    bb.append(this.response);
                    var reader = new FileReader();
                    reader.onload = function(e) { 
                        console.log(e)
                    };
                    reader.readAsBinaryString(bb.getBlob());
                }
            };
            xhr.send();
        } 
        $(function(){
            var namepre1="image/dongtai/";
            var num=[16,6,30,30,17,12,30,12,30,12,10,10,10,12,18,11,25];
            var gifimg=[];
            var apngimg=[];
            var lossimg=[];
            var apnglossimg=[];
            for(var i=1;i<11;i++){
                // gifimg="image/dongtai/gif/"+i+".gif";
                // apngimg="image/dongtai/apng/"+i+".png";
                // lossimg="image/dongtai/loss/"+i+".png";
                // apnglossimg="image/dongtai/apngloss/"+i+".png";
                gifimg[i]={};
                gifimg[i].src="image/dongtai/gif/"+i+".gif";
                gifimg[i].num=num[i-1];
                getImageSize(gifimg[i].src)
                // var reader = new FileReader();
                // var d = new Deferred();

                

                // reader.readAsDataURL(gifimg[i].src);
                // reader.onload=function(e){
                //     console.log(e)
                // }
                // var image = new Image();
                
                // image.onload = (function (obj,img){
                //     return function(){
                //        console.log(obj)
                //        if (obj.readyState == "complete");
                //        {
                //             initFileSize=obj.fileSize;
                //             var fileSize=Math.ceil(initFileSize/1024);
                //             console.log(filesize)
                //         }
                //     }
                // })(image,gifimg);
                // image.src=gifimg[i].src;

            };

        });
        $(function(){
            APNG.ifNeeded(function() {
                for (var i = 0; i < document.images.length; i++) {
                    var img = document.images[i];

                    if (/\.png$/i.test(img.src)) APNG.animateImage(img);
                }
            });
            $(".color div").click(function(){
                $("html")[0].className="";
                $("html").addClass($(this)[0].className)
            });

            $(".show input").change(function(e){
                var id=parseInt($(this).attr("data-to"));
                
                if(this.checked){
                    $(".imgcont .img:nth-child("+id+")").show();

                }else{
                    $(".imgcont .img:nth-child("+id+")").hide();
                }

            })

        });
        // 模版

        </script>

</body>
</html>
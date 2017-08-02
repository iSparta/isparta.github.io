function downloadInit(){
    var macUrl="https://github.com/iSparta/iSparta/releases/download/2.0/iSparta-mac.zip";
    var win32Url="https://github.com/iSparta/iSparta/releases/download/2.0/iSparta-win32.zip";
    var win64Url="https://github.com/iSparta/iSparta/releases/download/2.0/iSparta-win64.zip";
    var unknownUrl="https://github.com/iSparta/iSparta/releases";
    var osInfo = getOsInfo();
    if(osInfo === "mac") {
        $("#download_btn").attr("href",macUrl);
    } else if (osInfo === "win64") {
        $("#download_btn").attr("href",win64Url);
    } else if (osInfo === "win32") {
        $("#download_btn").attr("href",win32Url);
    } else {
        $("#download_btn").attr("href",unknownUrl);
    }
}
function apngviewerInit(){
    var FileName="";
    // window.onbeforeunload=function(){
    //     delFiles();
    //     return "是否离开该页面？";
    // }
    if (window.File && window.FileReader && window.FileList && window.Blob){  
        $(".support").show();
        $(document).bind({
            dragleave:function(e){    
                e.preventDefault();
            },
            drop:function(e){     
                e.preventDefault();
            },
            dragenter:function(e){
                e.preventDefault();
            },

            dragover:function(e){      
                e.preventDefault();
            }
        });
        var isOn=false;
        $("body")[0].ondragover = function() {
            $(".preview_area").addClass("on");
            if(isOn=false){
                $(".preview_area .txt1").hide();
                $(".preview_area .txt2").show();                
            }
            return false;
        };

        $("body")[0].ondragleave = function(e) { 
            $(".preview_area").removeClass("on");
            if(isOn=false){
                $(".preview_area .txt1").show();
                $(".preview_area .txt2").hide();
            }
            return false;
        };
        $("body")[0].ondrop = function(e) {

            $(".preview_area").removeClass("on");
            var img=e.dataTransfer.files[0];
            if(img.type=="image/png"){
                $(".preview_area .txt1").hide();
                $(".preview_area .txt2").hide();
                // delFiles();
                $(".preview_area").find(".preview").remove();
                $(".preview_area .loading").show();
                var reader = new FileReader();
                var d = new Deferred();
                reader.readAsDataURL(img);

                reader.onload=function(e){
                    // console.log(e.target.result);
                    var url=e.target.result;
                    var imgDom=$('<div class="preview"><img src="'+url+'"/></div>').appendTo($(".preview_area")).find("img");

                    var reader = new FileReader();
                    var d = new Deferred();
                    reader.readAsBinaryString(img);

                    reader.onload=function(e){
                        // console.log(e.target.result);
                        var url=e.target.result;
                        url=encodeURI(url);
                        // $('<div class="preview"><img  data-src="'+url+'"/></div>').appendTo($(".preview_area"));
                        imgDom.attr("data-src",url);
                        APNG.animateImage(imgDom[0]);
                        $(".preview_area .loading").hide();
                    }
                    
                }


                // var reader = new FileReader();
                // var d = new Deferred();
                // reader.readAsBinaryString(img);

                // reader.onload=function(e){
                //     // console.log(e.target.result);
                //     var url=e.target.result;
                //     url=encodeURI(url);
                //     $('<div class="preview"><img  data-src="'+url+'"/></div>').appendTo($(".preview_area"));
                //     APNG.animateImage($(".preview img")[0]);
                // }

                // var xhr = new XMLHttpRequest();
                // xhr.open("post", "upload.php", true);
                // xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                // xhr.addEventListener("load", function(e){
                //     FileName=e.target.responseText;
                //      $(".preview_area .loading").hide();
                //     var url="upload/"+e.target.responseText;
                //     $(".preview_area .preview").remove();
                //     $('<div class="preview"><img src="'+url+'"/></div>').appendTo($(".preview_area"));

                //     APNG.animateImage($(".preview img")[0]);
                // }, false);
                // var fd = new FormData();
                // fd.append('xfile', img);

                // xhr.send(fd);
            }else{
                $(".preview_area .txt1").show();
                $(".preview_area .txt2").hide();                
                $(".tips").show();
            }
            e.preventDefault(); //取消默认浏览器拖拽效果
            return false;
        };
        $(".bg > div").click(function(){
            $(".preview_area").css("background",$(this).css("background"))
        })
    }
    else {
        $(".unsupport").show();
    }

    function delFiles(){
        if(FileName){
            $.post("del.php",{name:FileName},function(){
               
            });
        }
    }
}
function getOsInfo(){

    var _pf = navigator.platform;
    var appVer = navigator.userAgent;
    
    if (_pf == "Win32" || _pf == "Windows") {
        if (appVer.indexOf("WOW64")>-1) { 
            _bit = "win64"; 
        } else { 
            _bit = "win32";
        }
        return _bit;
    }
    if (_pf.indexOf("Mac")!=-1) { 
        return "mac"; 
    } else if (_pf == "X11") {
        return "unix"; 
    } else if (String(_pf).indexOf("Linux") > -1) { 
        return "linux"; 
    } else {
        return "unknown"; 
    }
}
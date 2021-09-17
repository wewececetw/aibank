<!DOCTYPE html>
<html lang="zh_TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>圖檔總管</title>
    <style>
        body{
            font-family: Roboto, "微軟正黑體", "Microsoft JhengHei", "Adobe 繁黑體 Std B", "儷黑 Pro"; 
            font-size: 80%;
        }
        #form{
            width: 600px;
        }
        #folderExplorer{
            float: left;
            width: 100px;
        }
        #fileExplorer{
            float: left;
            width: 95%;
            border-left:1px solid #dff0ff; 
        }
        .thumbnail{
            float: left;
            margin: 3px;
            padding: 3px;
            border:1px solid #dff0ff; 
        }
        ul{
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        li{
            padding: 0;
        }
    </style>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="{{ asset('/js/ckeditor4/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function(){
            var funcNum = <?php echo $request.';'; ?>
            $('#fileExplorer').on('click','img',function(){
                var fileUrl = $(this).attr('title');
                window.opener.CKEDITOR.tools.callFunction(funcNum,fileUrl);
                window.close();
            }).hover(function(){
                $(this).css('cursor','pointer');
            })
        });
    </script>
</head>
<body>
    <div id='fileExplorer'>
        @foreach($fileNames as $fileName)
            <div class="thumbnail">
                <img src="{{asset('uploads/common/'.$fileName)}}" alt="thumb" title="{{asset("uploads/common/$fileName")}}" width="120" height="100">
                </br>
                {{$fileName}}
            </div>
        @endforeach
    </div>
</body>
    
</html>
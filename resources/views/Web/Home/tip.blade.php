<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <title>tip</title>
    <style>
        .container {
            padding: 20px;
        }

        .title {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="title"><h1>{{$title}}</h1></div>
    <hr class="layui-bg-cyan">
    <div class="content">{{$content}}</div>
</div>
</body>
<script src="{{$static}}layui/layui.js"></script>
<script>
</script>
</html>

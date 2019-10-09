<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/popup3.css">
    <title>popup3</title>
</head>
<body>
<div class="title">
    开启后每隔指定天数系统会为您自动采集，请确保账户中的{{$set['walletPoundage']}}充足。没有{{$set['walletPoundage']}}
    也能自动采集，但是{{$set['walletPoundage']}}为负数是无法提现。
</div>
<form class="layui-form" action="/auto">
    <div class="layui-form-item border-bottom">
        <div class="text">自动采集</div>
        <input type="checkbox" lay-skin="switch" lay-filter="filter" id="checkbox" name="switchValue">
        <input hidden id="switchValue" value="{{$member['auto_buy']}}" name="switchValue">
    </div>
</form>

<div class="container" id="container">
    <div class="layui-form-item border-bottom">
        <div class="text">周期设置</div>
        <select class="sel" id="sel1" name="time">
            <option value="{{$set['goodsCeil1']}}">{{$set['goodsCeil1']}}天</option>
        </select>
    </div>

    <div class="layui-form-item border-bottom">
        <div class="text">数量设置</div>
        <select class="sel" onchange="sel(this)" id="sel2" name="number">
            @for($i = $set['goodsTop1'];$i > 0;$i--)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>

    <div class="layui-form-item border-bottom">
        <div class="text">采集金额</div>
        <input class="input" id="inp" value="1000" readonly="true">元</input>
    </div>

    <div>
        <div class="container-title">自动采集清单</div>
        <div id="list">

        </div>
    </div>
</div>
</body>
<script src="{{$static}}layui/layui.js"></script>
<script src="{{$static}}js/popup3.js"></script>
<script>

</script>


</html>

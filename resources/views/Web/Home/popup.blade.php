<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/homepage.css">
    <link rel="stylesheet" href="{{$static}}css/popup.css">
    <title>popup</title>
</head>
<body>
<div class="popup">
    <div class="popup-tips">
        <h3>工作任务：家谱数据-采集、推广</h3>
    </div>
    <div class="popup-img">
        <img id="img" src="{{$static}}img/123.png"/>
    </div>
    <div class="popup-head">
        <h2>买入({{$set['goodsName']}})任务量</h2>
    </div>
    <div class="popup-inp">
        <input type="text" id="inp1" value="" onkeyup="val(this)"> <a>元</a></input>
    </div>
    <input hidden value="0" id="total" name="total">
    <input hidden value="{{$time}}" id="time" name="time">
    <input hidden value="{{$inPro}}" id="inPro" name="inPro">
    <input hidden value="0" id="number" name="number">
    <input hidden value="{{$set['buyPoundage']}}" id="poundage" name="poundage">
    <input hidden value="{{$set['goodsTotal']}}" id="amount1" name="amount">

    <div class="popup-inp-tips">
        <h5>你当前的买入量下限是<span id="min">1</span>单，上限是<span id="max">{{$mode}}</span>单</h5>
        <h5>请根据你自己的工作能力选择合适需要买入的</h5>
        <h5>({{$set['goodsName']}})任务量。单价：<span id="amount">{{$set['goodsTotal']}}</span>元/单</h5>
    </div>
    <div class="popup-leg">
        <h2>消耗<input readonly="true" value="0" id="inp2">{{$set['walletPoundage']}}</h2>
    </div>
    <div class="popup-bottom">
        <h5>你当前可用{{$set['walletPoundage']}}数量：<span id="inp3">{{$member['poundage']}}</span>{{$set['walletPoundage']}}</h5>
    </div>
</div>
</body>
<script src="{{$static}}layui/layui.js"></script>
<script src="{{$static}}js/popup.js"></script>

</html>

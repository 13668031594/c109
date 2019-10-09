<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/qianbao.css">
    <title>qianbao</title>
</head>
<body>
<fieldset class="layui-elem-field layui-field-title title">
    <legend>钱包</legend>
</fieldset>
<div class="layui-field-box content">
    <div class="content-list">
        <h3>{{$set['walletBalance']}}</h3>
        <div class="content-list-news">
            <h1><i class="layui-icon layui-icon-rmb"></i> {{$member['balance']}}</h1>
            <div class="content-list-bot"><a href="/wallet-record?wallet=0">查看详情</a></div>
        </div>
    </div>

    <div class="content-list">
        <h3>{{$set['walletPoundage']}}</h3>
        <div class="content-list-news">
            <h1><i class="layui-icon layui-icon-fire"></i> {{$member['poundage']}}</h1>
            <div class="content-list-bot"><a href="/wallet-record?wallet=1">查看详情</a></div>
        </div>
    </div>

    <div class="content-list">
        <h3>{{$set['walletReward']}}</h3>
        <div class="content-list-news">
            <h1><i class="layui-icon layui-icon-dollar"></i> {{$member['reward']}}</h1>
            <div class="content-list-bot"><a href="/wallet-record?wallet=2">查看详情</a></div>
        </div>
    </div>

    <div class="content-list">
        <h3>{{$set['walletGxd']}}</h3>
        <div class="content-list-news">
            <h1><i class="layui-icon layui-icon-praise"></i> {{$member['gxd']}}</h1>
            <div class="content-list-bot"><a href="/wallet-record?wallet=3">查看详情</a></div>
        </div>
    </div>

</div>

</body>
<script src="{{$static}}layui/layui.js"></script>
</html>

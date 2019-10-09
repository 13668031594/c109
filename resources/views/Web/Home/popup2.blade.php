<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">

    <link rel="stylesheet" href="{{$static}}css/popup2.css">
    <title>popup2</title>
</head>
<body>
<div class="subject">
    <div class="subject-content">
        <div class="content">
            账户选择
            <select class="content-sel" onchange="sel(this)" id="sel" name="accountType">
                <option value="0">请选择账户</option>
                <option value="1">本息账户</option>
                <option value="2">奖励账户</option>
            </select>
        </div>
        <input id="input1" class="input" value="">
        <input id="input2" class="input" value="">
        <input id="input3" class="input" value="">
        <input id="input4" class="input" value="">
        <div class="content">
            <div>拥有金额</div>
            <input placeholder="当前拥有金额" readonly="true" id="inp1">
        </div>

        <div class="content">
            <div>可卖金额</div>
            <input placeholder="可卖出金额" readonly="true" id="inp2">
        </div>

        <div class="content">
            <div>卖出金额</div>
            <input placeholder="卖出金额" class="content-inp" id="inp3" name="amount">
        </div>
    </div>

    <p class="tips">最低卖出金额为：{{$set['sellBase']}} 且必须为{{$set['sellTimes']}}的倍数</p>
</div>
</body>
<script src="{{$static}}layui/layui.js"></script>
<script src="{{$static}}js/popup2.js"></script>
</html>

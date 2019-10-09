<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="{{$static}}layui/css/layui.css">
		<link rel="stylesheet" href="{{$static}}css/market.css">
		<title>交易市场</title>
	</head>
	<body>
		<div class="container">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
				<legend>交易市场</legend>
			</fieldset>

			<div class="btn">
				<button type="button" class="layui-btn layui-btn-fluid" onclick="popup(this)">我要寄售</button>
			</div>

			<div class="layui-tab">
				<ul class="layui-tab-title">
					<li class="layui-this">寄售列表</li>
					<li>我的寄售</li>
					<li>我的交易</li>
				</ul>
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show">
					<div class="content">
						<table id="demo" lay-filter="test"></table>
					</div>
				</div>
					
				<div class="layui-tab-item">
					<div class="content">
						<table id="demo2" lay-filter="test"></table>
					</div>
				</div>

				<div class="layui-tab-item">
					<div class="content">
						<table id="demo3" lay-filter="test"></table>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script src="{{$static}}layui/layui.js"></script>
	<script src="{{$static}}js/market.js"></script>
	<script>
		// 一些地址
		var URL = {
        // 出售地址
        SELL: '/trad',
		};
		var bili = {{$set['consignPoundage'] / 100}};
	</script>
</html>

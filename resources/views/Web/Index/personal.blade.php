<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="{{$static}}layui/css/layui.css">
	<title>个人资料</title>
	<style>
        body {
            background: #fff;
        }
		.container{
			margin-bottom:60px;
			display:flex;
			flex-wrap:wrap;
		}
		.container-content{
			flex:1;
			width:600px;
		}
		.content{
			display:flex;
			margin:15px 0px 0px 15px;
		}
		.content-title{
			width:60px;
			min-width:50px;
			font-size:15px;
			line-height:38px;
		}
		.content-remarks{
			color:#c2c2c2;
			margin-left:10px;
			line-height:38px;
		}
		.content-inp{
			width:220px;
			margin-right:10px;
			position: relative;
		}
		.content-inp-btn{
			position: absolute;
			top: 5px;
			right: 5px;
			background-color:red;
			border-radius: 3px;
			padding:5px 10px;
			color:#fff;
			cursor: pointer;
			box-shadow:0px 1px 3px #000;
		}
		.tip{
			margin-left:30px;
			color:#c2c2c2;
		}
		.inp{
			width:120px;
		}
		.layui-input{
			border:0px;
		}
		.layui-elem-field{
			margin:0px 10px;
		}
    </style>
</head>
<body>
	<div class="container">
		<div class="container-content">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
				<legend>个人资料</legend>
			</fieldset>
			<div class="content">
				<div class="content-title">推荐人</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['referee_nickname']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">手机</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['phone']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">昵称</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['nickname']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">qq</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['qq']}}" readonly="true"></div>
			</div>

			<div class="content">
				<div class="content-title">状态</div>
				<div class="content-inp"><input class="layui-input" value="{{$contrast['status'][$member['status']]}}" readonly="true"></div>
			</div>

			<div class="content">
				<div class="content-title">身份</div>
				<div class="content-inp"><input class="layui-input" value="{{$contrast['grade'][$member['grade']]}}" readonly="true"></div>
			</div>

			<div class="content">
				<div class="content-title">注册日期</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['created_at']}}" readonly="true"></div>
			</div>

			<div class="content">
				<a class="layui-btn" href="/mima">修改密码</a>
			</div>
		</div>
		
		<div class="container-content">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
				<legend>银行信息</legend>
			</fieldset>

			<div class="tip">银行信息无法更改，如需更改请联系客服</div>

			<div class="content">
				<div class="content-title">银行</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['bank_name']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">卡号</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['bank_no']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">持有人</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['bank_man']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">支付宝</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['alipay']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">支行地址</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['bank_address']}}" readonly="true"></div>
			</div>
			
			<div class="content">
				<div class="content-title">备注</div>
				<div class="content-inp"><input class="layui-input" value="{{$member['note']}}" readonly="true"></div>
			</div>
		</div>
	</div>
<script src="{{$static}}layui/layui.js"></script>
</body>
</html>

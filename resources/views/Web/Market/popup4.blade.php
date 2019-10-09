<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="{{$static}}layui/css/layui.css">
		<title>Document</title>
		<style>
			.layui-form-item{
				margin-bottom:0px;
			}
			.layui-form-item input{
				border:0px;
			}
		</style>
	</head>
	<body>
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">贡献点</label>
				<div class="layui-input-inline">
				    <input type="text" placeholder="请输入贡献点数量" name="gxd" class="layui-input" onchange="xinghuo(this)" id="inp1">
				</div>
			</div>

			<div class="layui-form-item">
				<label class="layui-form-label">寄售金额</label>
				<div class="layui-input-inline">
				    <input type="text" placeholder="请输入金额" name="balance" class="layui-input" id="inp2">
				</div>
			</div>
			
			<div class="layui-form-item">
				<label class="layui-form-label">星伙比例</label>
				<div class="layui-input-inline">
				    <input type="text" readonly="readonly" value="" class="layui-input" onchange="proportion(this)" id="proportion">
				</div>
			</div>
			
			<div class="layui-form-item">
				<label class="layui-form-label">消耗星伙</label>
				<div class="layui-input-inline">
				    <input type="text" readonly="readonly" value="0" name="poundage" class="layui-input" id="inp3">
				</div>
			</div>
		</div>
	</body>
	<script src="{{$static}}layui/layui.js"></script>
	<script>
		//Demo
		layui.use('form', function(){
		  var form = layui.form;
		  
		});
		function xinghuo(obj){
			var proportion = document.getElementById('proportion'),
				inp3 = document.getElementById('inp3');
			inp3.value = obj.value * proportion.value;
		}
	</script>
</html>

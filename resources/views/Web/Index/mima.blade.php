<!doctype html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <title>修改密码</title>
	<style>
		 body {
            background: #fff;
        }
	</style>
 </head>
 <body>
	
	<form class="layui-form" action="">
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
			<legend>修改密码</legend>
		</fieldset>

		<div class="layui-form-item">
			<div class="layui-input-block">
				初始密码为:123456
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">新密码</label>
			<div class="layui-input-inline">
				<input type="password" name="password" lay-verify="pass1" placeholder="请输入新密码" autocomplete="off" class="layui-input" id="inp1">
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">再次输入</label>
			<div class="layui-input-inline">
				<input type="password" name="password" lay-verify="pass2" placeholder="请再次输入新密码" autocomplete="off" class="layui-input" id="inp2">
			</div>
		</div>
		
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit lay-filter="formDemo">确定修改</button>
			</div>
		</div>
	</form>
 </body>
 <script src="{{$static}}layui/layui.js"></script>
 <script>
	layui.use('form', function(){
	  var form = layui.form
			, layer = layui.layer
			, $ = layui.$;

		form.verify({
			pass1: [
				/^[\S]{6,12}$/
				, '新密码必须6到12位，且不能出现空格'
			],
			pass2: [
				/^[\S]{6,12}$/
				, '请再次输入新密码'
			]
		});
	  //监听提交
	  form.on('submit(formDemo)', function(data){
		  var inp1 = document.getElementById('inp1'),
		  	  inp2 = document.getElementById('inp2');
		  if (inp1.value == inp2.value)
		  {
			  layer.alert('操作成功,请重新登录',{closeBtn: 0}, function(index){
				  parent.location.href = 'login.html';
			  });
		  }else{
			  layer.msg('两次输入密码不相同,请重新输入');
		  }
		  
		  return false;
	  });
	});
 </script>
</html>

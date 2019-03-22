<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>银行</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{$static}}res/js/jquery.js"

            ></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a href="javascript:;">银行列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form layui-form-min" action="/admin/bank/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">

        <div class="layui-form-item">
            <label class="layui-form-label">银行名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="name" placeholder="请输入银行名称" autocomplete="off"
                       class="layui-input" value='{{isset($self) ? $self['name'] : ''}}'
                       maxlength="20"/>
                <!-- 编辑时 input 结束改为 readonly/>  -->
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">显示排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort" title="显示排序" lay-filter="numberZ"
                       placeholder="显示排序" autocomplete="off" value="{{isset($self) ? $self['sort'] : '50'}}"
                       class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" id='submit' lay-submit lay-filter="*">立即提交</button>
                <!-- <button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
            </div>
        </div>
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element'], function () {

    }); //加载入口
</script>
</body>

</html>
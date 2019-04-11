<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>休息日</title>
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
          <a href="javascript:;">休息日列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form layui-form-min" action="/admin/rest_day/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">

        <div class="layui-form-item">
            <label class="layui-form-label">休息日名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="name" placeholder="请输入休息日名称" autocomplete="off"
                       class="layui-input" value='{{isset($self) ? $self['name'] : ''}}'
                       maxlength="20"/>
                <!-- 编辑时 input 结束改为 readonly/>  -->
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">开始时间</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" id="begin" name="begin"
                       placeholder="开始时间" value="{{isset($self) ? $self['begin'] : ''}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">结束时间</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" id="end" name="end"
                       placeholder="结束时间" value="{{isset($self) ? $self['end'] : ''}}">
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
    }).use(['mForm', 'layer', 'jquery', 'element', 'laydate'], function () {
        var laydate = layui.laydate;

        laydate.render({
            elem: '#begin', //指定元素
            type: 'date',
        });

        laydate.render({
            elem: '#end', //指定元素
            type: 'date',
        });
    }); //加载入口
</script>
</body>

</html>
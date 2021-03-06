<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>提示文字</title>
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
          <a href="javascript:;">文章管理</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/prompt/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">

        <div class="layui-form-min">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" lay-verify="required" placeholder="标题" autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self['title'] : ''}}' maxlength="20" {{isset($self) ? 'readonly' : null}}/>
                </div>
            </div>
        </div>

        <div class="layui-form-min">
            <div class="layui-form-item">
                <label class="layui-form-label">关键字</label>
                <div class="layui-input-block">
                    <input type="text" name="keyword" lay-verify="required" placeholder="关键字" autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self['keyword'] : ''}}' maxlength="20" {{isset($self) ? 'readonly' : null}}/>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea id="fwb-content" name="fwb-content" style="display: none;">{{isset($self) ? $self['content'] : '请填写提示内容'}}</textarea>
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
    }).use(['mForm', 'layer', 'layedit', 'element'], function () {
        var layedit = layui.layedit;
        layedit.build('content', {
            height: 380
        }); //建立编辑器

        var form = layui.form;
        form.on('switch(show)', function (data) {
            if (data.elem.checked) {
                $('#show').prop('value', 'on');
            } else {
                $('#show').prop('value', 'off');
            }
        });
    }); //加载入口
</script>
</body>

</html>
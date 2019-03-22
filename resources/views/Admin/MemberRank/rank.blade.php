<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>会员等级</title>
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
          <a href="javascript:;">会员等级列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/rank/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">
        <div class="layui-form-min">

            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" required lay-verify="required" title="名称" placeholder="请输入会员等级名称"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["name"] : ''}}'
                           maxlength="30"/>
                </div>
                <div class="layui-form-mid layui-word-aux">显示的名称</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">团队人数</label>
                <div class="layui-input-inline">
                    <input type="text" name="child" lay-verify="child" title="团队人数" placeholder="达到此等级需要的团队人数"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["child"] : ''}}'
                           maxlength="12"/>
                </div>
                <div class="layui-form-mid layui-word-aux">达到此等级需要的团队人数</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">充值折扣</label>
                <div class="layui-input-inline">
                    <input type="text" name="discount" lay-verify="discount" title="充值折扣" placeholder="达到此等级需要的充值折扣"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["discount"] : ''}}'
                           maxlength="12"/>
                </div>
                <div class="layui-form-mid layui-word-aux">充值折扣</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">工资比例</label>
                <div class="layui-input-inline">
                    <input type="text" name="wage" lay-verify="wage" title="工资比例" placeholder="工资比例"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["wage"] : ''}}'
                           maxlength="12"/>
                </div>
                <div class="layui-form-mid layui-word-aux">工资比例</div>
            </div>
        </div>

        <div class="layui-form-min">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" id='submit' lay-submit lay-filter="*">确认保存</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element']); //加载入口
</script>
</body>

</html>
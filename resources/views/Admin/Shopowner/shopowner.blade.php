<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>店长</title>
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
          <a href="javascript:;">店长列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form layui-form-min"
          action="/admin/shopowner/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">

        @if(isset($self))
            <div class="layui-form-item">
                <label class="layui-form-label">店长昵称</label>
                <div class="layui-input-block">
                    <input type="text" name="nickname" lay-verify="name" placeholder="店长昵称" autocomplete="off"
                           class="layui-input" value='{{isset($self['member']) ? $self['member']['nickname'] : ''}}'
                           maxlength="20" readonly/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">店长手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" lay-verify="name" placeholder="店长手机号" autocomplete="off"
                           class="layui-input" value='{{isset($self['member']) ? $self['member']['phone'] : ''}}'
                           maxlength="20" readonly/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">累计佣金</label>
                <div class="layui-input-block">
                    <input type="text" name="reward_all" lay-verify="name" placeholder="店长昵称" autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self['reward_all'] : ''}}'
                           maxlength="20" readonly/>
                </div>
            </div>
        @else
            <div class="layui-form-item">
                <label class="layui-form-label">店长手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="phone"  placeholder="店长手机号" autocomplete="off"
                           class="layui-input" value=''
                           maxlength="20"/>
                </div>
            </div>
        @endif

        <div class="layui-form-item">
            <label class="layui-form-label">佣金比例%</label>
            <div class="layui-input-block">
                <input type="text" name="reward" title="显示排序" lay-filter="number"
                       placeholder="显示排序" autocomplete="off" value="{{isset($self) ? $self['reward'] : '1.0000'}}"
                       class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">

        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline" style="width:90px;">
                    <select name="status" lay-verify="">
                        @foreach($status as $k => $v)
                            <option value="{{$k}}" {{(isset($self) && $self['status'] == $k) ? 'selected' : null}}>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
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
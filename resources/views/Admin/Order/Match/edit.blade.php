<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>匹配</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"

            ></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a href="javascript:;">匹配列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/match/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">
        <div class="layui-form-min">

            <div class="layui-form-item">
                <label class="layui-form-label">订单号</label>
                <div class="layui-form-mid">{{$self["order"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">卖家昵称</label>
                <div class="layui-form-mid">{{$self["sell_nickname"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">卖家账号</label>
                <div class="layui-form-mid">{{$self["sell_account"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">卖家手机</label>
                <div class="layui-form-mid">{{$self["sell_phone"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">买家昵称</label>
                <div class="layui-form-mid">{{$self["buy_nickname"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">买家账号</label>
                <div class="layui-form-mid">{{$self["buy_account"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">买家手机</label>
                <div class="layui-form-mid">{{$self["buy_phone"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">金额</label>
                <div class="layui-form-mid">{{$self["total"]}}</div>
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
        </div>

        <hr>

        <div class="layui-form-min">
            @if(isset($self))
                <div class="layui-form-item">
                    <label class="layui-form-label">下单时间</label>
                    <div class="layui-form-mid">{{$self['created_at']}}</div>
                </div>
            @endif
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
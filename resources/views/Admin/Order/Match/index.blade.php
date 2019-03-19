<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>匹配订单</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css"/>
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
          <a><cite>匹配订单</cite></a>
        </span>
    </div>

    <div class="toolTable">
        <form class="layui-form layui-inline layui-form-query">
            <div class="layui-input-inline layui-query-select" style="width:90px;">
                <select name="status" lay-verify="" style="height:30px;">
                    <option value="">状态</option>
                    @foreach($arrays['status'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:90px;">
                <select name="keywordType" lay-verify="" style="height:30px;">
                    <option value="order">交易号</option>
                    <option value="sell_phone">卖家手机</option>
                    <option value="sell_account">卖家账号</option>
                    <option value="sell_nickname">卖家昵称</option>
                    <option value="buy_phone">买家手机</option>
                    <option value="buy_account">买家账号</option>
                    <option value="buy_nickname">买家昵称</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <input type="text" name='keyword' placeholder="请输入关键字" class="layui-input layui-input-mid"/>
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn layui-btn-sm" lay-submit lay-filter="query">
                    <i class="layui-icon ">&#xe615;</i>搜索
                </button>
            </div>
        </form>
    </div>

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/match/show?id=@{{ d.id }}">详情</a>
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/match/wallet-record?id=@{{ d.id }}">钱包</a>--}}
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/match/record?id=@{{ d.id }}">记录</a>--}}
    @if(in_array('match.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i lass="layui-icon layui-icon-delete"></i>删除</a>
</script>
<script>

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;
        var status = {!! $status !!};

        mTable.init({
            url: {
                del: '/admin/match/delete',
                table: '/admin/match/table',
                edit: '/admin/match/edit',
                add: '/admin/match/create'
            },
            isPage: true,
            cols: [[
                {field: 'order', width: 100, title: '交易号'},
                {
                    field: 'status', width: 80, title: '状态', templet: function (d) {
                    return '<span class="layui-badge  layui-bg-blue">' + status[d.status] + '</span>'
                }
                },
                {field: 'total', width: 100, title: '金额'},
                {field: 'sell_account', width: 100, title: '卖家账号'},
                {field: 'sell_phone', width: 120, title: '卖家手机'},
                {field: 'sell_nickname', width: 100, title: '卖家昵称'},
                {field: 'buy_account', width: 100, title: '买家账号'},
                {field: 'buy_phone', width: 120, title: '买家手机'},
                {field: 'buy_nickname', width: 100, title: '买家昵称'},
                {
                    field: 'image',
                    title: '支付凭证',
                    width: 100,
                    templet: function (d) {
                        if (d.image) {
                            return "<div><a target='_blank' href=" + d.image + "><img class='images' src=" + d.image + " /></a></div>";
                        } else {
                            return '';
                        }
                    }
                },
                {field: 'pay_time', width: 170, title: '支付时间'},
                {field: 'created_at', width: 170, title: '创建时间'},
                {fixed: 'right', title: '操作', minWidth: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>寄售订单</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css"/>
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
          <a><cite>寄售列表</cite></a>
        </span>
    </div>

    <div class="toolTable">
        <form class="layui-form layui-inline layui-form-query">
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="status" lay-verify="" style="height:30px;">
                    <option value="">状态</option>
                    @foreach($arrays['status'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="keywordType" lay-verify="" style="height:30px;">
                    <option value="order">订单号</option>
                    <option value="phone">手机</option>
                    <option value="account">账号</option>
                    <option value="nickname">昵称</option>
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
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/sell/show?id=@{{ d.id }}">详情</a>
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/sell/wallet-record?id=@{{ d.id }}">钱包</a>--}}
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/sell/record?id=@{{ d.id }}">记录</a>--}}
    @if(in_array('sell.edit',$powers) || in_array('-1',$powers))
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
                del: '/admin/sell/delete',
                table: '/admin/sell/table',
                edit: '/admin/sell/edit',
                add: '/admin/sell/create'
            },
            isPage: true,
            cols: [[
                {field: 'order', width: 100, title: '订单号'},
                {field: 'account', width: 80, title: '账号'},
                {field: 'nickname', width: 100, title: '昵称'},
                {field: 'phone', width: 120, title: '手机'},
                {
                    field: 'status', width: 120, title: '状态', templet: function (d) {
                    return '<span class="layui-badge  layui-bg-blue">' + status[d.status] + '</span>'

                }
                },
                {field: 'total', width: 100, title: '金额'},
                {field: 'remind', width: 100, title: '剩余'},
                {field: 'created_at', width: 170, title: '创建时间'},
                {fixed: 'right', title: '操作', minWidth: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
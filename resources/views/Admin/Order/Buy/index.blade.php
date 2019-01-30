<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>采集订单</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css"/>
    <link rel="stylesheet" href="{{$static}}res/css/common.css"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a><cite>采集列表</cite></a>
        </span>
    </div>

    {{--<div class="toolTable">
        <button class="layui-btn layui-btn-sm" data-type="addData">
            <i class="layui-icon">&#xe654;</i>添加会员
        </button>
    </div>--}}

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/buy/show?id=@{{ d.id }}">详情</a>
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/buy/wallet-record?id=@{{ d.id }}">钱包</a>--}}
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/buy/record?id=@{{ d.id }}">记录</a>--}}
    {{--<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>--}}
    {{--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i lass="layui-icon layui-icon-delete"></i>删除</a>--}}
</script>
<script>

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;
        var status = {!! $status !!};
        var abn = {!! $abn !!};
        var froms = {!! $from !!};


        mTable.init({
            url: {
                del: '/admin/buy/delete',
                table: '/admin/buy/table',
                edit: '/admin/buy/edit',
                add: '/admin/buy/create'
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
                {
                    field: 'abn', width: 80, title: '异常', templet: function (d) {
                    if (d.abn == '20') {
                        return '<span class="layui-badge  layui-bg-red">' + abn[d.abn] + '</span>'
                    } else {
                        return '<span class="layui-badge  layui-bg-blue">' + abn[d.abn] + '</span>'
                    }

                }
                },
                {
                    field: 'from', width: 80, title: '来源', templet: function (d) {
                    return '<span class="layui-badge layui-bg-green">' + froms[d.from] + '</span>'

                }
                },
                {field: 'total', width: 100, title: '金额'},
                {field: 'poundage', width: 100, title: '手续费'},
                {field: 'in', width: 100, title: '收益'},
                {field: 'created_at', width: 170, title: '创建时间'},
                {fixed: 'right', title: '操作', minWidth: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
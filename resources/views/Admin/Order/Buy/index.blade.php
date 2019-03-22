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
    <script src="{{$static}}res/js/jquery.js"

            ></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a><cite>采集列表</cite></a>
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
                <select name="abn" lay-verify="" style="height:30px;">
                    <option value="">异常</option>
                    @foreach($arrays['abn'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="from" lay-verify="" style="height:30px;">
                    <option value="">来源</option>
                    @foreach($arrays['from'] as $k => $v)
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

            <label class="layui-form-label" style="width: 70px;">选择时间段</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="time-start" name="startTime" value="" placeholder="开始时间">
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="time-end" name="endTime" value="" placeholder="结束时间">
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
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/buy/show?id=@{{ d.id }}">详情</a>
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/buy/wallet-record?id=@{{ d.id }}">钱包</a>--}}
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/buy/record?id=@{{ d.id }}">记录</a>--}}
    @if(in_array('buy.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i lass="layui-icon layui-icon-delete"></i>删除</a>
</script>
<script>

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element', 'laydate'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;
        var status = {!! $status !!};
        var abn = {!! $abn !!};
        var froms = {!! $from !!};
        var laydate = layui.laydate;


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
                {field: 'poundage', width: 100, title: '星伙'},
                {field: 'in', width: 100, title: '收益'},
                {field: 'in_over', width: 170, title: '收益时间'},
                {field: 'created_at', width: 170, title: '创建时间'},
                {fixed: 'right', title: '操作', minWidth: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();

        laydate.render({
            elem: '#time-start', //指定元素
//            format: 'HH:mm',
//            type:'time',
        });

        laydate.render({
            elem: '#time-end', //指定元素
        });
    });
</script>
</body>

</html>
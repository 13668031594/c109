<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>客服</title>
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
          <a><cite>客服列表</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('customer.create',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm" data-type="addData">
                <i class="layui-icon">&#xe654;</i>添加客服
            </button>
        @endif
    </div>

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    @if(in_array('customer.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
    @if(in_array('customer.destroy',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                class="layui-icon layui-icon-delete"></i>删除</a>
    @endif

</script>
<script>

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;
        var theSwitch = {!! $switch_json !!}

        mTable.init({
            url: {
                del: '/admin/customer/delete',
                table: '/admin/customer/table',
                edit: '/admin/customer/edit',
                add: '/admin/customer/create'
            },
            isPage: true,
            cols: [[
                {field: 'nickname', title: '昵称'},
                {field: 'text', title: '联系方式'},
                {
                    field: 'type', width: 120, title: '随机分配', templet: function (d) {

                    return '<span class="layui-badge layui-bg-gray">' + theSwitch[d.switch] + '</span>'

                }
                },
                {field: 'created_at', title: '创建时间'},
                {fixed: 'right', title: '操作', width: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
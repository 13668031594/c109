<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>休息日</title>
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
          <a><cite>休息日列表</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('rest_day.create',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm" data-type="addData">
                <i class="layui-icon">&#xe654;</i>添加休息日
            </button>
        @endif
    </div>

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    @if(in_array('rest_day.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
    @if(in_array('rest_day.destroy',$powers) || in_array('-1',$powers))
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

        mTable.init({
            url: {
                del: '/admin/rest_day/delete',
                table: '/admin/rest_day/table',
                edit: '/admin/rest_day/edit',
                add: '/admin/rest_day/create'
            },
            isPage: true,
            cols: [[
                {field: 'sort', title: '排序'},
                {field: 'name', title: '名称'},
                {field: 'begin', title: '开始时间'},
                {field: 'end', title: '结束时间'},
                {field: 'created_at', title: '创建时间'},
                {fixed: 'right', title: '操作', width: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
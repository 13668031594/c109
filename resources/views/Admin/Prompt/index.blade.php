<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>提示文字管理</title>
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
          <a><cite>提示文字管理</cite></a>
        </span>
    </div>

    @if(auth('master')->id() == '1')
    <div class="toolTable">
        <button class="layui-btn layui-btn-sm" data-type="addData">
            <i class="layui-icon">&#xe654;</i>添加提示文字
        </button>
        <button class="layui-btn layui-btn-sm layui-btn-danger" data-type="delData">
            <i class="layui-icon ">&#xe640;</i>批量删除
        </button>
    </div>
    @endif

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
</script>
<script>
    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;

        mTable.init({
            url: {
                del: '/admin/prompt/delete',
                table: '/admin/prompt/table',
                edit: '/admin/prompt/edit',
                add: '/admin/prompt/create'
            },
            isPage: true,
            cols: [[
                {field: 'id', width: 50, type: 'checkbox'},
                {field: 'title', width: 200, title: '标题'},
                {field: 'keyword', title: '关键字'},
                {field: 'created_at', title: '创建时间'},
                {fixed: 'right', title: '操作', width: 160, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
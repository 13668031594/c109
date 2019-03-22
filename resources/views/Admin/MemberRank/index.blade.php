<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>会员等级</title>
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
          <a><cite>会员等级列表</cite></a>
        </span>
    </div>

    {{--<div class="toolTable">
        <button class="layui-btn layui-btn-sm" data-type="addData">
            <i class="layui-icon">&#xe654;</i>添加会员等级
        </button>
    </div>--}}

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    @if(in_array('rank.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
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
                del: '/admin/rank/delete',
                table: '/admin/rank/table',
                edit: '/admin/rank/edit',
                add: '/admin/rank/create'
            },
            isPage: true,
            cols: [[
                {field: 'sort', width: 80, title: '排序'},
                {field: 'name', width: 120, title: '名称'},
                {field: 'child', width: 200, title: '需要团队'},
                {field: 'discount', width: 100, title: '折扣%'},
                {field: 'wage', width: 100, title: '工资比例%'},
                {fixed: 'right', title: '操作', minWidth: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
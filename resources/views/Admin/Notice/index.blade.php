<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>公告管理</title>
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
          <a><cite>公告管理</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('notice.create',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm" data-type="addData">
                <i class="layui-icon">&#xe654;</i>添加公告
            </button>
        @endif

        @if(in_array('notice.destroy',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm layui-btn-danger" data-type="delData">
                <i class="layui-icon ">&#xe640;</i>批量删除
            </button>
        @endif
    </div>

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    @if(in_array('notice.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
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
                del: '/admin/notice/delete',
                table: '/admin/notice/table',
                edit: '/admin/notice/edit',
                add: '/admin/notice/create'
            },
            isPage: true,
            cols: [[
                {field: 'id', width: 50, type: 'checkbox'},
                {field: 'title', width: 200, title: '标题'},
                {field: 'sort', width: 100, title: '排序'},
                {field: 'man', width: 120, title: '发布人'},
                {
                    field: 'status', width: 80, title: '状态', templet: function (d) {
                    if (d.status == '20') {

                        return '<span class="layui-badge  layui-bg-red">' + status[d.status] + '</span>'
                    } else {

                        return '<span class="layui-badge  layui-bg-blue">' + status[d.status] + '</span>'
                    }
                }
                },
                {field: 'created_at', title: '创建时间'},
                {fixed: 'right', title: '操作', width: 160, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
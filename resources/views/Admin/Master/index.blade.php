<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>管理员</title>
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
          <a><cite>管理员列表</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('master.create',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm" data-type="addData">
                <i class="layui-icon">&#xe654;</i>添加管理员
            </button>
        @endif
    </div>

    <table lay-filter="table" id='idTable' lay-data='{id:"idTable"}'>
    </table>
</div>

<script src="{{$static}}layui/layui.js"></script>

<script type="text/html" id="tableTool">
    @if(in_array('master.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
    @if(in_array('master.destroy',$powers) || in_array('-1',$powers))
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
                del: '/admin/master/delete',
                table: '/admin/master/table',
                edit: '/admin/master/edit',
                add: '/admin/master/create'
            },
            isPage: true,
            cols: [[
                {field: 'account', width: 200, title: '帐号'},
                {field: 'nickname', title: '昵称'},
                {field: 'power_name', title: '权限组'},
                {field: 'login_times', title: '登录次数'},
                {field: 'login_ip', title: '登录IP'},
                {field: 'created_at', title: '创建时间'},
                {fixed: 'right', title: '操作', width: 150, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
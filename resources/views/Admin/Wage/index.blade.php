<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>工资</title>
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
          <a><cite>待发列表</cite></a>
        </span>
    </div>

    <div class="toolTable">

        <form class="layui-form layui-inline layui-form-query">
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="keywordType" lay-verify="" style="height:30px;">
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
    @if(in_array('wage.wage',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/wage/wage?id=@{{ d.uid }}">发放</a>
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
                del: '/admin/wage/delete',
                table: '/admin/wage/table',
                edit: '/admin/wage/edit',
                add: '/admin/wage/create'
            },
            isPage: true,
            cols: [[
                {field: 'account', width: 80, title: '帐号'},
                {field: 'phone', width: 120, title: '手机'},
//                {field: 'email', width: 150, title: '邮箱'},
                {field: 'nickname', width: 100, title: '昵称'},
                {field: 'rank_name', width: 100, title: '等级'},
                {field: 'wage', width: 100, title: '待发工资'},
                {field: 'wage_all', width: 100, title: '累计工资'},
                {field: 'created_at', width: 170, title: '创建时间'},
                {fixed: 'right', title: '操作', minWidth: 330, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
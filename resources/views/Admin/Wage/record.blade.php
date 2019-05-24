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
          <a href="javascript:;">工资</a>
          <a><cite>明细记录</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('wage.record_destroy',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm layui-btn-danger" data-type="delData">
                <i class="layui-icon ">&#xe640;</i>批量删除
            </button>
        @endif
        <form class="layui-form layui-inline layui-form-query">

            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="type" lay-verify="" style="height:30px;">
                    <option value="">全部</option>
                    <option value="91">发放</option>
                    <option value="92">获得</option>
                </select>
            </div>

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
                <label class="layui-form-label layui-form-label-mid">时间筛选</label>

                <div class="layui-input-inline">
                    <input type="text" placeholder="请选择起始时间" name="startTime" class="layui-input layui-input-mid"
                           id="startTime" readonly/>
                </div>
            </div>
            <div class="layui-input-inline">
                <input type="text" placeholder="请选择结束时间" name="endTime" class="layui-input layui-input-mid" id="endTime"
                       readonly/>
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
    @if(in_array('wage.record_destroy',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                class="layui-icon layui-icon-delete"></i>删除</a>
    @endif
</script>

<script>

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element', 'laydate'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;
        var laydate = layui.laydate;

        laydate.render({
            elem: '#startTime',
            type: 'datetime'
        });
        laydate.render({
            elem: '#endTime',
            type: 'datetime'
        });

        mTable.init({
            url: {
                del: '/admin/wage/record-delete',
                table: '/admin/wage/record-table',
                edit: 'wage.html?',
                add: 'wage.html'
            },
            cols: [[
                {field: 'id', width: 50, type: 'checkbox'},
                {field: 'account', width: 80, title: '帐号'},
                {field: 'phone', width: 120, title: '手机'},
//                {field: 'email', width: 150, title: '邮箱'},
                {field: 'nickname', width: 100, title: '昵称'},
                {field: 'rank_name', width: 100, title: '等级'},
                {
                    field: 'type', width: 100, title: '类型', templet: function (d) {
                    if(d.type == '91')return '发放';
                    else return '获得';
                }
                },
                {field: 'record', title: '详情'},
                {field: 'created_at', width: 170, title: '时间'},
                {fixed: 'right', title: '操作', width: 90, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
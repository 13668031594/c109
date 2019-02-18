<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>会员列表</title>
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
          <a href="javascript:;">会员列表</a>
          <a href="javascript:;">钱包</a>
          <a href="javascript:;">{{$self['nickname']}}</a>
          <a><cite>明细记录</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('member.record_destroy',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm layui-btn-danger" data-type="delData">
                <i class="layui-icon ">&#xe640;</i>批量删除
            </button>
        @endif
        <form class="layui-form layui-inline layui-form-query">

            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="wallet" lay-verify="" style="height:30px;">
                    <option value="">全部</option>
                    <option value="0">余额</option>
                    <option value="1">手续费</option>
                    <option value="2">奖励账户</option>
                    <option value="3">贡献点</option>
                    <option value="4">鼓励账户</option>
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="type" lay-verify="" style="height:30px;">
                    <option value="">全部</option>
                    @foreach($type as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>

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
    @if(in_array('member.record_destroy',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                class="layui-icon layui-icon-delete"></i>删除</a>
    @endif
</script>

<script>

    var transform = {!! $type_json !!} ;

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
                del: '/admin/member/wallet-record-delete',
                table: '/admin/member/wallet-record-table?id={{$self["uid"]}}',
                edit: 'member.html?',
                add: 'member.html'
            },
            cols: [[
                {field: 'id', width: 50, type: 'checkbox'},
                {
                    field: 'type', width: 100, title: '类型', templet: function (d) {
                    return transform[d.type];
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
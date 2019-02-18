<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>会员</title>
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
          <a><cite>会员列表</cite></a>
        </span>
    </div>

    <div class="toolTable">
        @if(in_array('member.create',$powers) || in_array('-1',$powers))
            <button class="layui-btn layui-btn-sm" data-type="addData">
                <i class="layui-icon">&#xe654;</i>添加会员
            </button>
        @endif

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
                <select name="act" lay-verify="" style="height:30px;">
                    <option value="">激活</option>
                    @foreach($arrays['act'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="mode" lay-verify="" style="height:30px;">
                    <option value="">下单</option>
                    @foreach($arrays['mode'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="grade" lay-verify="" style="height:30px;">
                    <option value="">身份</option>
                    @foreach($arrays['grade'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline layui-query-select" style="width:70px;">
                <select name="type" lay-verify="" style="height:30px;">
                    <option value="">收益</option>
                    @foreach($arrays['type'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
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
    @if(in_array('member.wallet',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/member/team?id=@{{ d.id }}">团队</a>
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/member/wallet?id=@{{ d.id }}">详情</a>
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/member/wallet-record?id=@{{ d.id }}">钱包</a>
    @endif
    @if(in_array('member.record',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/member/record?id=@{{ d.id }}">记录</a>
    @endif
    @if(in_array('member.edit',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
    @endif
    @if(in_array('member.destroy',$powers) || in_array('-1',$powers))
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i lass="layui-icon layui-icon-delete"></i>删除</a>
    @endif
    @if(in_array('member.liq',$powers) || in_array('-1',$powers))
    {{--<a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin/member/liq?id=@{{ d.id }}">清算</a>--}}
    @endif
</script>
<script>

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['layer', 'mTable', 'jquery', 'element'], function () {

        var layer = layui.layer;
        var mTable = layui.mTable;
        var status = {!! $status !!};
        var type = {!! $type !!};
        var mode = {!! $mode !!};
        var act_from = {!! $act_from !!};
        var act = {!! $act !!};
        var liq = {!! $liq !!};
        var grade = {!! $grade !!};

        mTable.init({
            url: {
                del: '/admin/member/delete',
                table: '/admin/member/table',
                edit: '/admin/member/edit',
                add: '/admin/member/create'
            },
            isPage: true,
            cols: [[
                {field: 'account', width: 80, title: '帐号'},
                {field: 'phone', width: 120, title: '手机'},
                {field: 'email', width: 150, title: '邮箱'},
                {field: 'nickname', width: 100, title: '昵称'},
                {
                    field: 'status', width: 80, title: '状态', templet: function (d) {
                    return '<span class="layui-badge  layui-bg-blue">' + status[d.status] + '</span>'

                }
                },
                {
                    field: 'status', width: 80, title: '激活', templet: function (d) {
                    return '<span class="layui-badge  layui-bg-blue">' + act[d.act] + '</span>'

                }
                },
                {
                    field: 'mode', width: 80, title: '下单', templet: function (d) {
                    return '<span class="layui-badge layui-bg-green">' + mode[d.mode] + '</span>'

                }
                },
                {
                    field: 'grade', width: 80, title: '身份', templet: function (d) {
                    return '<span class="layui-badge">' + grade[d.grade] + '</span>'

                }
                },
                {
                    field: 'type', width: 80, title: '收益', templet: function (d) {
                    return '<span class="layui-badge layui-bg-gray">' + type[d.type] + '</span>'

                }
                },
                {field: 'poundage', width: 100, title: '手续费'},
                {field: 'balance', width: 100, title: '余额'},
                {field: 'gxd', width: 100, title: '贡献点'},
                {field: 'reward', width: 100, title: '奖励'},
                {field: 'incite', width: 100, title: '鼓励'},
                {field: 'created_at', width: 170, title: '创建时间'},
                {fixed: 'right', title: '操作', minWidth: 330, align: 'center', toolbar: '#tableTool'}
            ]]
        });
        mTable.render();
    });
</script>
</body>

</html>
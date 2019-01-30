<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>订单详情</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
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
          <a href="javascript:;">采集订单</a>
          <a href="javascript:;">订单详情</a>
          <a><cite>{{$self['order']}}</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/">
        <input type='hidden' name='id' id='id' value='{{$self["id"]}}'/>
        <div class="layui-row">

            <div class="layui-col-sm6">
                <fieldset class="layui-elem-field layui-field-title">
                    <legend>订单详情</legend>
                    <div class="layui-field-box">
                        <table class="layui-table" lay-even>
                            <colgroup>
                                <col width="150">
                                <col width="200">
                            </colgroup>
                            <tbody>
                            <tr>
                                <td>订单号</td>
                                <td>{{$self['order']}}</td>
                            </tr>
                            <tr>
                                <td>下单时间</td>
                                <td>{{$self['created_at']}}</td>
                            </tr>
                            <tr>
                                <td>状态 / 来源 / 异常</td>

                                <td>
                                    <span class="layui-badge-rim">{{$status[$self['status']]}}</span> /
                                    <span class="layui-badge-rim">{{$from[$self['from']]}}</span> /
                                    <span class="layui-badge-rim">{{$abn[$self['abn']]}}</span>
                                    @if($self['abn'] == '20')
                                        <a href="javascript:;" id="abnRemove"
                                           class="layui-badge layui-bg-green">解除异常</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>金额</td>
                                <td>{{$self['total']}}</td>
                            </tr>
                            <tr>
                                <td>首付款 / 比例</td>
                                <td>{{$self['first_total']}} / {{$self['first_pro']}}%</td>
                            </tr>
                            <tr>
                                <td>匹配 / 完结</td>
                                <td>{{$self['first_match'] ?? '待匹配'}} / {{$self['first_end'] ?? '未完结'}}</td>
                            </tr>
                            <tr>
                                <td>尾款</td>
                                <td>{{$self['tail_total']}}</td>
                            </tr>
                            <tr>
                                <td>匹配 / 完结</td>
                                <td>{{$self['tail_match'] ?? '待匹配'}} / {{$self['tail_end'] ?? '未完结'}}</td>
                            </tr>
                            <tr>
                                <td>收益 / 比例</td>
                                <td>{{$self['in']}} / {{$self['in_pro']}}%</td>
                            </tr>
                            <tr>
                                <td>贡献点</td>
                                <td>{{$self['gxd']}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </fieldset>

            </div>
            <div class="layui-col-sm5 layui-col-sm-offset1">
                <div style="max-width:400px;margin-top:10px;">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>会员详情</legend>
                        <div class="layui-field-box">
                            <table class="layui-table">
                                <colgroup>
                                    <col width="150">
                                    <col width="200">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <td>帐号</td>
                                    <td>{{$self['account']}}</td>
                                </tr>
                                <tr>
                                    <td>电话</td>
                                    <td>{{$self['phone']}}</td>
                                </tr>
                                <tr>
                                    <td>昵称</td>
                                    <td>{{$self['nickname']}}</td>
                                </tr>
                                <tr>
                                    <td>身份</td>
                                    <td>{$self['member_grade_name']}</td>
                                </tr>
                                <!--<tr>
                                    <td>注册时间</td>
                                    <td>2016-11-28</td>
                                </tr>-->
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    {{--
                                        <fieldset class="layui-elem-field layui-field-title">
                                            <legend>操作详情</legend>
                                            <div class="layui-field-box">
                                                <table class="layui-table">
                                                    <colgroup>
                                                        <col width="150">
                                                        <col width="200">
                                                    </colgroup>
                                                    <tbody>
                                                    <tr>
                                                        <td>操作人</td>
                                                        <td>{{$self['change_nickname']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>操作时间</td>
                                                        <td>{$self['change_date']}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>--}}

                </div>
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>发货信息</legend>
            <div class="layui-field-box">
                <table class="layui-table">
                    <colgroup>
                        <col width="150">
                        <col width="200">
                    </colgroup>
                    <tbody>
                    <tr>
                        <td>平台</td>
                        <td>{$self['store_platform_name']}</td>
                    </tr>
                    <tr>
                        <td>发货店铺</td>
                        <td>{$self['store_name']}</td>
                    </tr>
                    <tr>
                        <td>发货人</td>
                        <td>{$self['store_man']}</td>
                    </tr>
                    <tr>
                        <td>手机号</td>
                        <td>{$self['store_phone']}</td>
                    </tr>
                    <tr>
                        <td>快递名</td>
                        <td>{$self['express_name']}</td>
                    </tr>
                    <tr>
                        <td>选择商品</td>
                        <td>{$self['goods_name']}</td>
                    </tr>
                    <tr>
                        <td>每单数量</td>
                        <td>{$self['goods_number']}</td>
                    </tr>
                    <tr>
                        <td>快递数量</td>
                        <td>{$self['express_number']}</td>
                    </tr>

                    <tr>
                        <td>发货清单</td>
                        {if $self['order_status'] == '20'}
                        <td><a href="/admin/send/index?id={$self['id']}" class="layui-badge-rim"
                               id="orderStatus">查看清单</a></td>
                        {else/}
                        <td> 该订单未发货</td>
                        {/if}
                    </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>

        {if $self['order_status'] == '10'}
        <fieldset class="layui-elem-field layui-field-title">
            <legend>待发货清单</legend>
            <div class="layui-field-box">
                <table class="layui-table">
                    <colgroup>
                        <col width="130">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>收货人</th>
                        <th style="width: 170px;">联系电话</th>
                        <th>地址</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $express as $v}
                    <tr>
                        <td>{$v['name']}</td>
                        <td>{$v['phone']}</td>
                        <td>{$v['address']}</td>
                    </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </fieldset>
        {/if}
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>

    // url
    var url = {
        abn: '/admin/buy/abn?id={{$self["id"]}}',
        status: '/'
    };

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'element']);


    $(function () {

        $("#abnRemove").on('click', function () {
            layer.confirm('确定要解除这个订单的所有异常状态吗？', function (index) {
                layer.close(index);
                $.getJSON(url.abn, {pay: 1}, function (data) {
                    if (data.status == 'success') {
                        //window.location.reload();
                        layer.msg('操作成功');
                    } else {
                        layer.msg('操作失败');
                    }
                });
            });
        })
    });

</script>
</body>

</html>
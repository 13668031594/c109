<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/homepage.css">
    <link rel="stylesheet" href="{{$static}}css/font-awesome.min.css">
    <title>homepage</title>
</head>
<body>
<div class="content">
    @if(count($notice['message']) > 0)
        <div class="announcement">
            <i class="layui-icon layui-icon-speaker"></i>
            <ul id="announcement" style="position: absolute; top:0;left:40px;">
                @foreach($notice['message'] as $v)
                    <li><a href="notice?id={{$v['id']}}">{{$v['title']}}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="tips">
        <i class="layui-icon layui-icon-about"></i>
        <a href="prompt?type={{$member['type']}}">温馨提示：您当前的身份为{{$type[$member['type']]}}推广员，点击查看</a>
    </div>
    <div class="list-container">
        <div class="layui-row button-container site-demo-button" id="layerDemo">
            <div class="layui-col-xs3 margin">
                <button data-method="mairu" type="button" class="layui-btn layui-btn-fluid button" id="but1">买入推广权
                </button>
            </div>
            <div class="layui-col-xs3 margin">
                <button data-method="yuyue" type="button" class="layui-btn layui-btn-fluid button">自动预约</button>
            </div>
            <div class="layui-col-xs3 margin">
                <button data-method="maichu" type="button" class="layui-btn layui-btn-fluid button">卖出推广权</button>
            </div>
        </div>
    </div>

    <div class="notice background">
        <h3>进行中推广订单</h3>
    </div>

    <!--<div class="notice">-->
    <!--<a>当前没有进行的订单</a><br>
    <a>当前没有进行的订单</a>-->
    <div class="list-container layui-row">
        <div class="list-content layui-col-space10">
            <div class="layui-col-sm6">
                <div class="h-l-c">
                @foreach($all['buy'] as $v)
                    <!-- 循环开始 -->
                        <div class="details background-image1 list-shadow">
                            <h5>订单号({{$v['order']}})</h5>
                            <div class="layui-row">
                                <div class="layui-col-xs4"><h2>{{$status[$v['status']]}}</h2></div>
                                <div class="layui-col-xs8">
                                    <h3>
                                        我 <i class="layui-icon layui-icon-next"></i>
                                        <b>{{$v['total']}}</b> <i class="layui-icon layui-icon-next"></i>
                                        {{$v['sell_nickname']}}
                                    </h3>
                                    <h5>订单创建日期:{{$v['created_at']}}</h5>
                                </div>
                            </div>
                            <div class="link" onclick="showPay(this)"><i class="fa fa-arrow-right"
                                                                         style="color:#fff;"></i>
                            </div>
                            <div class="pay-info layui-hide">
                                <p>打款人领导：{{$v['buy_p']}}</p>
                                <p>打款人：{{$v['buy_nickname']}}</p>
                                <ul class="bank">
                                    <li>银行名称:{{$v['bank_name']}}</li>
                                    <li class="card">银行卡号:{{$v['bank_no']}}</li>
                                    <li>开户地址:{{$v['bank_address']}}</li>
                                    <li>持卡人:{{$v['bank_man']}}</li>
                                    <li>支付宝:{{$v['alipay']}}</li>
                                    <li>备注:{{$v['note']}}</li>
                                </ul>
                                <p>收款人领导：{{$v['sell_p']}}</p>
                                <p>收款人：{{$v['sell_nickname']}}</p>
                                <div class="layui-btn-container">
                                    <button type="button" onclick="onUpload(this)" class="layui-btn">上传付款凭证</button>
                                    <input type="file" class="layui-hide"/>
                                    <!-- onBuyConfirm 1 = id -->
                                    <button type="button" onclick="onBuyConfirm(this,{{$v['id']}})"
                                            class="layui-btn layui-btn-normal">
                                        确认
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- 循环结束 -->
                    @endforeach
                </div>
            </div>
            <div class="layui-col-sm6">
                <div class="h-l-c">
                    @foreach($all['sell'] as $v)
                        <div class="details background-image2 list-shadow">
                            <h5>订单号({{$v['order']}})</h5>
                            <div class="layui-row">
                                <div class="layui-col-xs4"><h2>{{$status[$v['status']]}}</h2></div>
                                <div class="layui-col-xs8">
                                    <h3>
                                        {{$v['buy_nickname']}} <i class="layui-icon layui-icon-next"></i>
                                        <b>{{$v['total']}}</b> <i class="layui-icon layui-icon-next"></i>
                                        我
                                    </h3>
                                    <h5>订单创建日期:{{$v['created_at']}}</h5>
                                </div>
                            </div>
                            <div class="link" onclick="showPay(this)"><i class="fa fa-arrow-right"
                                                                         style="color:#fff;"></i>
                            </div>
                            <div class="pay-info layui-hide">
                                <p>打款人领导：{{$v['buy_p']}}</p>
                                <p>打款人：{{$v['buy_nickname']}}</p>
                                <div class="pay-images">
                                    <a target="_parent" href="{{$v['pay']}}">
                                        <img src="{{$v['pay']}}"/>
                                    </a>
                                </div>
                                <p>收款人领导：{{$v['sell_p']}}</p>
                                <p>收款人：{{$v['sell_nickname']}}</p>
                                <div class="layui-btn-container">
                                    {{--<button type="button" onclick="viewImage()" class="layui-btn">查看付款凭证</button>--}}
                                    <button type="button" onclick="onSellConfirm(1)" class="layui-btn layui-btn-normal">
                                        确认收款
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->

    <div class="notice background">
        <h3>申请推广列表</h3>
    </div>

    <div class="list-container layui-row">
        <div class="list-content layui-col-space10">
            <div class="layui-col-sm6">
                <div class="h-l-c">
                    <ul id="biuuu_city_list">
                        <!--<li>
                            <div class="drop-down">
                                <div class="list background-image1"><h1>买入申请</h1><h5>参与者：恭喜发财1</h5><h5>
                                    申请单编号：1517610214(品名：法国红酒)</h5>
                                    <h2>金额：1000RMB(数量：3)</h2><h5>状态：匹配成功</h5><h5>日期：2019-08-08 18:45:47</h5>
                                    <div class="link" onclick="link(this)"><i class="fa fa-arrow-right"
                                                                              style="color:#fff;"></i></div>
                                </div>
                                <div class="drop-down-content show2"><h5>已匹配金额：1000元</h5>
                                    <div class="details background-image1">
                                        <h5>订单号(匹配买入订单)</h5>
                                        <div class="layui-row">
                                            <div class="layui-col-xs4"><h2>待支付</h2></div>
                                            <div class="layui-col-xs8"><h3>是啥<a>100</a>&gt;您</h3><h5>订单创建日期:2019-08-08
                                                19:04:14</h5></div>
                                        </div>
                                        <div class="link"><i class="fa fa-arrow-right" style="color:#fff;"></i></div>
                                        <div class="pay-info show2">
                                            <ul class="bank">
                                                <li>姓名:妮可妮可</li>
                                                <li class="card">银行卡号:6227003762070149427</li>
                                                <li>开户地址:重庆观音桥建新支行</li>
                                                <li>银行名称:建设银行</li>
                                            </ul>
                                            <div class="layui-btn-container">
                                                <button type="button" class="layui-btn">上传付款凭证</button>
                                                <button type="button" class="layui-btn">查看付款凭证</button>
                                                <button type="button" class="layui-btn layui-btn-normal">确认</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>-->
                    </ul>
                    <div id="demo1"></div>
                </div>
            </div>
            <div class="layui-col-sm6">
                <div class="h-l-c">
                    <ul id="biuuu_city_list2"></ul>
                    <div id="demo2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script>

    // 一些地址
    var URL = {
        // 申请列表地址
        BUY_LIST: 'buy-list',
        // 卖出列表地址
        SELL_LIST: 'sell-list',
        // 打款上传凭证
        BUY_CONFIRM: 'pay',
        // 确认收款
        SELL_CONFIRM: 'pay',
        // 采集地址
        BUY: 'buy',
        // 出售地址
        SELL: 'sell',
        // 自动采集
        AUTO: 'auto'
    };

    //账户选择
    var zhanghu = 0;
    //本息账户拥有金额
    var bxyongyou = {{$member['balance']}};
    //本息账户可用金额
    var bxkeyong = {{$member['balance']}};
    //奖励账户拥有金额
    var jlyongyou = {{$member['reward']}};
    //奖励账户可用金额
    var jlkeyong = {{$member['reward']}};

    var auto = {{$popup3['member']['auto_buy']}};

    // 手续费数量
    var poundage = {{$member['poundage']}};

    // 自动采集开关
    if (auto == '10'){
        var autoSwitch = true;
    }else {
        var autoSwitch = false;
    }

    // 采集数量
    var autoNumber = {{$popup3['member']['auto_number'] ?? 0}};
    // 采集周期
    var autoTimes = {{$set['goodsCeil1']}};
    // 采集金额
    var autoAmount = {{$popup3['member']['auto_number'] * $set['goodsTotal']}};
    // 采集数据列表
    var autoListData = {!!  $popup3['list']  !!};


</script>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="{{$static}}layui/layui.js"></script>
<script src="{{$static}}js/xinghuo.js"></script>
</html>

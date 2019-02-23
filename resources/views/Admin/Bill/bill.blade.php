<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>统计</title>
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
          <a href="javascript:;">统计</a>
          <a><cite>统计管理</cite></a>
        </span>
    </div>
    <form class="layui-form" action="/admin/bill/index" method="get">
        <div class="layui-form-item form-radio-type" style='height:60px;'>
            <input type="hidden" name="type" value="4"/>
            <ul id="order-type">
                <li lang="1" @if($type=='today')class="choice"@endif><a href="/admin/bill/index?type=today">今日</a></li>
                <li lang="2" @if($type=='yesterday')class="choice"@endif><a
                            href="/admin/bill/index?type=yesterday">昨日</a></li>
                <li lang="3" @if($type=='4')class="choice"@endif>时间段</li>
                <li lang="4" @if($type=='1')class="choice"@endif><a href="/admin/bill/index?type=1">本月</a></li>
                <li lang="" @if($type=='all')class="choice"@endif><a href="/admin/bill/index?type=all">全部</a></li>
            </ul>
            <div class="layui-inline time-interval" @if($type!='4')style="overflow: hidden; display:none;"@endif>
                <label class="layui-form-label" style="width: 70px;">选择时间段</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="time-start" name="startTime"
                           placeholder="开始时间" @if($type=='4')value="{{$begin}}"@endif>
                </div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="time-end" name="endTime" placeholder="结束时间"
                           @if($type=='4')value="{{$end}}"@endif>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit lay-filter="count">搜索</button>
                </div>
            </div>
        </div>
    </form>
    <fieldset class="layui-elem-field">
        <legend>注册会员</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日注册</h3>
                    <div class='number'><span>{{$today_reg}}</span>人</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日注册</h3>
                    <div class='number'><span>{{$yesterday_reg}}</span>人</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总会员</h3>
                    <div class='number'><span>{{$all_reg}}</span>人</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>激活会员</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日激活</h3>
                    <div class='number'><span>{{$today_act}}</span>人</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日激活</h3>
                    <div class='number'><span>{{$yesterday_act}}</span>人</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总激活</h3>
                    <div class='number'><span>{{$all_act}}</span>人</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>星伙</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日收入</h3>
                    <div class='number'><span>{{$today_poundage}}</span>个</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日收入</h3>
                    <div class='number'><span>{{$yesterday_poundage}}</span>个</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总收入</h3>
                    <div class='number'><span>{{$all_poundage}}</span>个</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>采集数</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日采集数</h3>
                    <div class='number'><span>{{$today_buy_num}}</span>单</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日采集数</h3>
                    <div class='number'><span>{{$yesterday_buy_num}}</span>单</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总采集数</h3>
                    <div class='number'><span>{{$all_buy_num}}</span>单</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>采集金额</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日采集金额</h3>
                    <div class='number'><span>{{$today_buy_total}}</span>元</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日采集金额</h3>
                    <div class='number'><span>{{$yesterday_buy_total}}</span>元</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总采集金额</h3>
                    <div class='number'><span>{{$all_buy_total}}</span>元</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>卖出数</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日卖出数</h3>
                    <div class='number'><span>{{$today_sell_num}}</span>单</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日卖出数</h3>
                    <div class='number'><span>{{$yesterday_sell_num}}</span>单</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总卖出数</h3>
                    <div class='number'><span>{{$all_sell_num}}</span>单</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>卖出金额</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日卖出金额</h3>
                    <div class='number'><span>{{$today_sell_total}}</span>元</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日卖出金额</h3>
                    <div class='number'><span>{{$yesterday_sell_total}}</span>元</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总卖出金额</h3>
                    <div class='number'><span>{{$all_sell_total}}</span>元</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>匹配数</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日匹配数</h3>
                    <div class='number'><span>{{$today_match_num}}</span>单</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日匹配数</h3>
                    <div class='number'><span>{{$yesterday_match_num}}</span>单</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总匹配数</h3>
                    <div class='number'><span>{{$all_match_num}}</span>单</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>匹配金额</legend>
        <div class="layui-field-box format-container">
            <div class="layui-row layui-col-space30 format">
                <div class="layui-col-md3">
                    <h3>今日匹配金额</h3>
                    <div class='number'><span>{{$today_match_total}}</span>元</div>
                </div>
                <div class="layui-col-md3">
                    <h3>昨日匹配金额</h3>
                    <div class='number'><span>{{$yesterday_match_total}}</span>元</div>
                </div>
                <div class="layui-col-md6">
                    <h3>总匹配金额</h3>
                    <div class='number'><span>{{$all_match_total}}</span>元</div>
                    <div class='prompt'>受上面的筛选影响</div>
                </div>
            </div>
        </div>
    </fieldset>

    {{--
        <div class="layui-form-item form-radio-type" style='height:60px;'>
            <input type="hidden" id="time-type2" name="timeType2" value=""/>
            <ul id="order-type2">
                <li lang="1">本月</li>
                <li lang="2">本季</li>
                <li lang="3" class="choice">本周</li>
                <li lang="4">时间段</li>
            </ul>
            <div class="layui-inline time-interval2" style="overflow: hidden; display:none;">
                <label class="layui-form-label" style="width: 70px;">选择时间段</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="time-start2" name="startTime2"
                           placeholder="开始时间">
                </div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="time-end2" name="endTime2" placeholder="结束时间">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" id='chartClick'>搜索</button>
                </div>
            </div>
        </div>

        <div class="layui-row layui-col-space30">
            <div id='t1' class='layui-col-md4' style='height:250px;'></div>
            <div id='t2' class='layui-col-md4' style='height:250px;'></div>
            <div id='t3' class='layui-col-md4' style='height:250px;'></div>
        </div>
        <div class="layui-row layui-col-space30">
            <div id='t4' class='layui-col-md4' style='height:250px;'></div>
            <div id='t5' class='layui-col-md4' style='height:250px;'></div>
            <div id='t6' class='layui-col-md4' style='height:250px;'></div>
        </div>
        <div class="layui-row layui-col-space30">
            <div id='t7' class='layui-col-md3' style='height:250px;'></div>
            <div id='t8' class='layui-col-md3' style='height:250px;'></div>
            <div id='t9' class='layui-col-md3' style='height:250px;'></div>
            <div id='t10' class='layui-col-md3' style='height:250px;'></div>
        </div>--}}
</div>
<script src="https://cdn.bootcss.com/echarts/4.2.0-rc.2/echarts.min.js"></script>
<script src="{{$static}}layui/layui.js"></script>
<script>

    // 图表初始化
    var myEChart = [
        {
            id: 't1',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'order_number',
            chart: {},
        },
        {
            id: 't2',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'order_total',
            chart: {},
        },
        {
            id: 't3',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'express_number',
            chart: {},
        },
        {
            id: 't4',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'express_total',
            chart: {},
        },
        {
            id: 't5',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'goods_number',
            chart: {},
        },
        {
            id: 't6',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'goods_total',
            chart: {},
        },
        {
            id: 't7',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'new_member',
            chart: {},
        },
        {
            id: 't8',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'buy_grade_number',
            chart: {},
        },
        {
            id: 't9',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: 'buy_grade_total',
            chart: {},
        },
        {
            id: 't10',
            option: {
                title: '图标1',
                subtitle: '副标题',
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                name: ['12-1', '12-2', '12-3', '12-4', '12-5', '12-6', '12-7']
            },
            remote: '',
            chart: {},
        },
    ];

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element', 'laydate'], function () {

        var laydate = layui.laydate;

        $('#order-type li').click(function () {
            $('#order-type li').each(function () {
                $(this).prop('class', '');
            });
            $('#time-type').val($(this).prop('lang'));
            $(this).prop('class', 'choice');
            if ($(this).prop('lang') == '3') {
                $('.time-interval').show();
            } else {
                $('.time-interval').hide();
            }
        });

        $('#order-type2 li').click(function () {
            $('#order-type2 li').each(function () {
                $(this).prop('class', '');
            });
            $('#time-type2').val($(this).prop('lang'));
            $(this).prop('class', 'choice');
            if ($(this).prop('lang') == '4') {
                $('.time-interval2').show();
            } else {
                $('.time-interval2').hide();
            }

            MyChart.setWhere({
                startTime: '',
                endTime: '',
                type: $("#time-type2").val()
            });

            MyChart.refreshCharts();
        });

        $("#chartClick").click(function () {
            MyChart.setWhere({
                startTime: $("#time-start2").val(),
                endTime: $("#time-end2").val(),
                type: $("#time-type2").val()
            });
            MyChart.refreshCharts();
        });

        laydate.render({
            elem: '#time-start', //指定元素
//            format: 'HH:mm',
//            type:'time',
        });

        laydate.render({
            elem: '#time-end', //指定元素
        });

        laydate.render({
            elem: '#time-start2', //指定元素
        });

        laydate.render({
            elem: '#time-end2', //指定元素
        });

        MyChart.init(myEChart);
        MyChart.create();

        /*form.on('submit(count)', function(data){
            console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
            console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });*/

    }); //加载入口

    var MyChart = {
        // 图标数组
        charts: [],
        where: {},

        setWhere: function (where) {
            this.where = where;
        },

        init: function (charts) {
            this.charts = charts || [];
        },

        create: function () {
            var _this = this;
            for (var i = 0; i < this.charts.length; i++) {
                this.charts[i].chart = echarts.init(document.getElementById(this.charts[i].id));
                this.remote(this.charts[i]);
            }
        },
        remote: function (object) {

//            console.log( this.where);
            $.get('/admin/bill/one?one=' + object.remote, this.where, function (data) {

                if (data.status == 'success') {

                    object.option.data = data.message.data;
                    object.option.name = data.message.name;
                    object.option.title = data.message.title;
                    object.option.subtitle = data.message.subtitle;
                }
//                console.log(object);
                object.chart.setOption(createOptions(object.option));
            });
        },
        refreshCharts: function () {

            for (var i = 0; i < this.charts.length; i++) {
                this.remote(this.charts[i]);
            }
        },
        getCharts: function (id) {
            return this.charts;
        }
    };

    function createOptions(params) {
        var option = {
            grid: {
                left: '10%',   //距离左边的距离
                right: '6%', //距离右边的距离
                bottom: '30%',//距离下边的距离
                top: '5%' //距离上边的距离
            },
            //backgroundColor: '#7db876',
            "title": {
                "text": params.title,　　　　//标题
                subtext: params.subtitle,　　　　　　　　　//副标题
                "top": '80%',
                "left": '10%',
                "textStyle": {　　　　　　　　　　　　//标题的文字样式
                    "fontSize": 16,
                    "color": "#444",
                    "text-align": "left",
                    "margin-top": "20px"
                }
            },
            xAxis: {
                type: 'category',
                data: params.name
            },
            yAxis: {
                type: 'value'
            },
            series: [{

                data: params.data,
                type: 'line'
            }]
        };

        return option;
    }
</script>
</body>

</html>
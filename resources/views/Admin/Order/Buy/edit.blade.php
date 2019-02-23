<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>采集</title>
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
          <a href="javascript:;">采集列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/buy/{{isset($self) ? 'update/'.$self['id'] : 'store'}}">
        <div class="layui-form-min">

            <div class="layui-form-item">
                <label class="layui-form-label">订单号</label>
                <div class="layui-form-mid">{{$self["order"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">下单人</label>
                <div class="layui-form-mid">{{$self["nickname"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">账号</label>
                <div class="layui-form-mid">{{$self["account"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">手机</label>
                <div class="layui-form-mid">{{$self["phone"]}}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">金额</label>
                <div class="layui-input-block">
                    <input type="text" name="total" required title="金额" lay-verify="required|number"
                           placeholder="总金额"
                           autocomplete="off" class="layui-input" value='{{$self['total']}}'/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">星伙</label>
                <div class="layui-input-block">
                    <input type="text" name="poundage" required title="星伙" lay-verify="required|number"
                           placeholder="星伙"
                           autocomplete="off" class="layui-input" value='{{$self['poundage']}}'/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">收益</label>
                <div class="layui-input-block">
                    <input type="text" name="in" required title="收益" lay-verify="required|number"
                           placeholder="总收益"
                           autocomplete="off" class="layui-input" value='{{$self['in']}}'/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">贡献点</label>
                <div class="layui-input-block">
                    <input type="text" name="gxd" required title="贡献点" lay-verify="required|number"
                           placeholder="总贡献点"
                           autocomplete="off" class="layui-input" value='{{$self['gxd']}}'/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">首付款</label>
                <div class="layui-input-block">
                    <input type="text" name="first_total" required title="首付款" lay-verify="required|number"
                           placeholder="总首付款"
                           autocomplete="off" class="layui-input" value='{{$self['first_total']}}'/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">尾款</label>
                <div class="layui-input-block">
                    <input type="text" name="tail_total" required title="尾款" lay-verify="required|number"
                           placeholder="尾款"
                           autocomplete="off" class="layui-input" value='{{$self['tail_total']}}'/>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">尾款已匹配</label>
                <div class="layui-input-block">
                    <input type="text" name="tail_complete" required title="尾款已匹配" lay-verify="required|number"
                           placeholder="尾款已匹配"
                           autocomplete="off" class="layui-input" value='{{$self['tail_complete']}}'/>
                </div>
            </div>

            <div class="layui-form-item">

            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="status" lay-verify="">
                            @foreach($status as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['status'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">来源</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="from" lay-verify="">
                            @foreach($from as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['from'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="layui-form-min">
            @if(isset($self))
                <div class="layui-form-item">
                    <label class="layui-form-label">下单时间</label>
                    <div class="layui-form-mid">{{$self['created_at']}}</div>
                </div>
            @endif
        </div>

        <div class="layui-form-min">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" id='submit' lay-submit lay-filter="*">确认保存</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element']); //加载入口
</script>
</body>

</html>
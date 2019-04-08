<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>会员</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{$static}}res/js/jquery.js"></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a href="javascript:;">会员列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/member/{{isset($self) ? 'update/'.$self['uid'] : 'store'}}">
        <div class="layui-form-min">

            <div class="layui-form-item">
                <label class="layui-form-label">推荐人</label>

                @if (isset($self))
                    <div class="layui-form-mid">{{$self["referee_account"]}}|{{$self["referee_nickname"]}}</div>
                @else
                    <div class="layui-input-inline">
                        <input type="text" name="referee" title="推荐人" placeholder="请填写正确的推荐人"
                               autocomplete="off" class="layui-input" maxlength="11">
                    </div>
                    <div class="layui-form-mid layui-word-aux">推荐人的推荐号,没有留空</div>
                @endif
            </div>

            {{--<div class="layui-form-item">
                <label class="layui-form-label">账号</label>
                <div class="layui-input-inline">
                    <input type="text" name="account" title="账号" placeholder="请输入会员帐号"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["account"] : ''}}'
                           maxlength="12" {{isset($self)?'readonly':null}} />
                </div>
                <div class="layui-form-mid layui-word-aux">登录时的帐号,不填则自动生成</div>
            </div>--}}

            <div class="layui-form-item">
                <label class="layui-form-label">手机</label>
                <div class="layui-input-inline">
                    <input type="text" name="phone" lay-verify="phone" title="手机号码" placeholder="请输入手机号码"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["phone"] : ''}}'
                           maxlength="12"/>
                </div>
                <div class="layui-form-mid layui-word-aux">登录时的手机号码</div>
            </div>

            {{--<div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" required lay-verify="required" title="邮箱" placeholder="请输入会员邮箱"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["email"] : ''}}'
                           maxlength="30"/>
                </div>
                <div class="layui-form-mid layui-word-aux">登录时的邮箱</div>
            </div>--}}
            {{--<div class="layui-form-item">
                <label class="layui-form-label">身份证姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="idcard_name" title="身份证姓名" placeholder="请输入会员身份证姓名"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["idcard_name"] : ''}}'
                           maxlength="30"/>
                </div>
                <div class="layui-form-mid layui-word-aux">请输入会员身份证姓名</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">身份证号</label>
                <div class="layui-input-inline">
                    <input type="text" name="idcard_no" title="身份证号" placeholder="请输入会员身份证号"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["idcard_no"] : ''}}'
                           maxlength="30"/>
                </div>
                <div class="layui-form-mid layui-word-aux">请输入会员身份证号</div>
            </div>--}}
            <div class="layui-form-item">
                <label class="layui-form-label">qq号</label>
                <div class="layui-input-inline">
                    <input type="text" name="qq" title="qq号" placeholder="请输入会员qq号"
                           autocomplete="off"
                           class="layui-input" value='{{isset($self) ? $self["qq"] : ''}}'
                           maxlength="30"/>
                </div>
                <div class="layui-form-mid layui-word-aux">请输入会员qq号</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-inline">
                    <input type="text" name="nickname" required lay-verify="required" placeholder="请输入会员昵称"
                           autocomplete="off" class="layui-input" value='{{isset($self) ? $self["nickname"] : ''}}'>
                </div>
                <div class="layui-form-mid layui-word-aux">显示的昵称名字</div>
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
                    <label class="layui-form-label">排单模式</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="mode" lay-verify="">
                            @foreach($mode as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['mode'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">

            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">收益模式</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="type" lay-verify="">
                            @foreach($type as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['type'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">身份</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="grade" lay-verify="">
                            @foreach($grade as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['grade'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">

            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">匹配优先级</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="match_level" lay-verify="">
                            @foreach($match_level as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['match_level'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">团队客服</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="special_customer" lay-verify="">
                            @foreach($special_customer as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['special_customer'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">

            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">账号类型</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="special_type" lay-verify="">
                            @foreach($special_type as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['special_type'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">账号等级</label>
                    <div class="layui-input-inline" style="width:90px;">
                        <select name="special_level" lay-verify="">
                            @foreach($special_level as $k => $v)
                                <option value="{{$k}}" {{(isset($self) && $self['special_level'] == $k) ? 'selected' : null}}>{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <blockquote class="layui-elem-quote">收款信息用于会员提现，非必填</blockquote>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">收款银行</label>
                <div class="layui-input-inline">
                    <select name="bank_id" lay-verify="">
                        <option value="">请选择收款银行</option>
                        @foreach($bank as $k => $v)
                            <option value="{{$v['id']}}" {{(isset($self) && ($self[
                            'bank_id'] == $v['id'])) ? 'selected' : ''}}>{{$v['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">支行</label>
                <div class="layui-input-inline">
                    <input type="text" name="bank_address" placeholder="请输入支行"
                           autocomplete="off" class="layui-input" value='{{isset($self) ? $self["bank_address"] : ''}}'>
                </div>
                <div class="layui-form-mid layui-word-aux">支行</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">收款人</label>
                <div class="layui-input-inline">
                    <input type="text" name="bank_man" placeholder="请输入收款人姓名"
                           autocomplete="off" class="layui-input" value='{{isset($self) ? $self["bank_man"] : ''}}'>
                </div>
                <div class="layui-form-mid layui-word-aux">收款人姓名</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">收款账号</label>
                <div class="layui-input-inline">
                    <input type="text" name="bank_no" placeholder="请输入收款账号"
                           autocomplete="off" class="layui-input" value='{{isset($self) ? $self["bank_no"] : ''}}'>
                </div>
                <div class="layui-form-mid layui-word-aux">收款账号</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">支付宝</label>
                <div class="layui-input-inline">
                    <input type="text" name="alipay" placeholder="请输入支付宝"
                           autocomplete="off" class="layui-input" value='{{isset($self) ? $self["alipay"] : ''}}'>
                </div>
                <div class="layui-form-mid layui-word-aux">支付宝</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-inline">
                    <input type="text" name="note" placeholder="请输入备注"
                           autocomplete="off" class="layui-input" value='{{isset($self) ? $self["note"] : ''}}'>
                </div>
                <div class="layui-form-mid layui-word-aux">备注</div>
            </div>

            <hr>

            <div class="layui-form-item">

            </div>

            @if(isset($self))
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <blockquote class="layui-elem-quote">如不修改密码，请勿操作密码</blockquote>
                </div>
            </div>
            @endif

            <div class="layui-form-item">
                <label class="layui-form-label">登录密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" required lay-verify="pass" placeholder="登录密码"
                           autocomplete="off" class="layui-input"
                           value='{{isset($self) ? 'sba___duia' : '123456'}}' maxlength="20">
                </div>
                <div class="layui-form-mid layui-word-aux">初始密码为：123456</div>
            </div>

            {{--<div class="layui-form-item">
                <label class="layui-form-label">支付密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="pay_pass" required lay-verify="pass" placeholder="支付密码"
                           autocomplete="off" class="layui-input"
                           value='{{isset($self) ? 'sba___duia' : '123456'}}' maxlength="20">
                </div>
                <div class="layui-form-mid layui-word-aux">初始密码为：123456</div>
            </div>--}}
        </div>
        <hr>
        <div class="layui-form-min">
            @if(isset($self))
            <div class="layui-form-item">
                <label class="layui-form-label">注册时间</label>
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
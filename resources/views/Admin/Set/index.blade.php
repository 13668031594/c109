<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>系统设置</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css">
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
          <a><cite>系统设置</cite></a>
        </span>
    </div>
    <form class="layui-form" lay-filter="form" action="/admin/set">

        <div class="layui-tab layui-tab-card" lay-filter="tab">
            <ul class="layui-tab-title">
                <li class="layui-this">基础设置</li>
                <li>注册激活</li>
                <li>封号设置</li>
                <li>钱包设置</li>
                <li>订单买卖</li>
                <li>商品设置</li>
                <li>匹配设置</li>
                <li>付款设置</li>
                <li>收款设置</li>
                <li>订单提现</li>
                <li>奖励钱包</li>
                <li>账号状态</li>
                <li>挂售设置</li>
                <li>版本更新</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-min">

                        <div class="layui-form-item">
                            <label class="layui-form-label">网站名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="webName" lay-verify="required" title="网站名称"
                                       placeholder="网站名称" autocomplete="off" value="{{$self['webName']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">前台显示的网站名字</div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">title</label>
                            <div class="layui-input-inline">
                                <input type="text" name="webTitle" lay-verify="required" title="网站title"
                                       placeholder="网站title" autocomplete="off" value="{{$self['webTitle']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">网站顶部title显示到关键词</div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">keyword</label>
                            <div class="layui-input-inline">
                                <input type="text" name="webKeyword" title="关键字"
                                       placeholder="关键字" autocomplete="off" value="{{$self['webKeyword']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">网站关键字</div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">网站描述</label>
                            <div class="layui-input-block">
                        <textarea type="text" name="webDesc" title="网站描述"
                                  placeholder="网站描述" autocomplete="off"
                                  class="layui-textarea">{{$self['webDesc']}}</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">底部版权</label>
                            <div class="layui-input-block">
                        <textarea type="text" name="webCopyright" title="底部版权"
                                  placeholder="底部版权" autocomplete="off"
                                  class="layui-textarea">{{$self['webCopyright']}}</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">网站总开关</label>
                            <div class="layui-input-block">
                                <input type="checkbox" id='webSwitch' lay-filter="webSwitch"
                                       lay-skin="switch"
                                       lay-text="开启|关闭" {{$self["webSwitch"] == 'on' ? 'checked' : ''}}/>
                                <input type="hidden" id='webSwitchValue' name="webSwitch"
                                       value="{{$self['webSwitch']}}"/>
                            </div>
                        </div>

                        <div id="webOn" class="layui-form-item"
                             @if($self['webSwitch'] == 'off')style="display:none"@endif>
                            <div class="layui-form-item">
                                <label class="layui-form-label">日常开站</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" id="webOpenTime" name="webOpenTime"
                                           placeholder="开站时间" value="{{$self['webOpenTime']}}">
                                </div>
                                <div class="layui-form-mid layui-word-aux">每日开站时间</div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">日常闭站</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" id="webCloseTime" name="webCloseTime"
                                           placeholder="闭站时间" value="{{$self['webCloseTime']}}">
                                </div>
                                <div class="layui-form-mid layui-word-aux">每日闭站时间</div>
                            </div>

                            <label class="layui-form-label">闭站时描述</label>
                            <div class="layui-input-block">
                            <textarea id="webCloseReason" title="闭站时描述" name="webCloseReason" lay-verify="reason"
                                      placeholder="请输入闭站时描述"
                                      class="layui-textarea">{{$self['webCloseReason']}}
                            </textarea>
                            </div>
                        </div>

                        <div id="webOff" class="layui-form-item"
                             @if($self['webSwitch'] == 'on')style="display:none"@endif>
                            <label class="layui-form-label">关闭原因</label>
                            <div class="layui-input-block">
                            <textarea id="webCloseTxt" title="关闭原因" name="webCloseTxt" lay-verify="reason"
                                      placeholder="请输入关闭原因"
                                      class="layui-textarea">{{$self['webCloseTxt']}}
                            </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">注册开关</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='accountRegSwitch' lay-filter="accountRegSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['accountRegSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='accountRegSwitchValue' name="accountRegSwitch"
                                   value="{{$self['accountRegSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许团队长注册账号</div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">每日赠送</label>
                            <div class="layui-input-inline">
                                <input type="text" name="accountRegGive" title="每日赠送" lay-filter="number"
                                       placeholder="每日赠送" autocomplete="off"
                                       value="{{$self['accountRegGive']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">每天赠送的星伙数</div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">自动激活</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='accountRegAct' lay-filter="accountRegAct"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['accountRegAct'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='accountRegActValue' name="accountRegAct"
                                   value="{{$self['accountRegAct']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">团队长注册后直接激活账号</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">默认一单</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='accountModeDefault' lay-filter="accountModeDefault"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['accountModeDefault'] == '10' ? 'checked' : ''}}/>
                            <input type="hidden" id='accountModeDefaultValue' name="accountModeDefault"
                                   value="{{$self['accountModeDefault']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">账号注册后默认开启一单模式</div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">消耗贡献点</label>
                            <div class="layui-input-inline">
                                <input type="text" name="accountRegGxd" title="消耗贡献点" lay-filter="numberZ"
                                       placeholder="消耗贡献点" autocomplete="off" value="{{$self['accountRegGxd']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">注册时需要消耗的贡献点数量</div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">激活开关</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='accountActSwitch' lay-filter="accountActSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['accountActSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='accountActSwitchValue' name="accountActSwitch"
                                   value="{{$self['accountActSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许团队长激活账号</div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">每日激活数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="accountActNum" title="每日激活数" lay-filter="numberZ"
                                       placeholder="每日激活数" autocomplete="off" value="{{$self['accountActNum']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">每天可以激活的账号数量</div>
                        </div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">消耗星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="accountActPoundage" title="消耗星伙" lay-filter="numberZ"
                                       placeholder="消耗星伙" autocomplete="off"
                                       value="{{$self['accountActPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">激活一个账号需要消耗的星伙数</div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">负债激活</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='accountActPoundageNone' lay-filter="accountActPoundageNone"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['accountActPoundageNone'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='accountActPoundageNoneValue' name="accountActPoundageNone"
                                   value="{{$self['accountActPoundageNone']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许团队长在星伙不足的情况下激活账号</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">抢激活开始</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="accountActStart" name="accountActStart"
                                   placeholder="抢激活开始" value="{{$self['accountActStart']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">开始抢激活码的时间</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">抢激活结束</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="accountActEnd" name="accountActEnd"
                                   placeholder="抢激活结束" value="{{$self['accountActEnd']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">抢激活码的结束时间</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">发激活结果</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="accountActResult" name="accountActResult"
                                   placeholder="发激活结果" value="{{$self['accountActResult']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">发放激活码的时间</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">禁止注册</label>
                        <div class="layui-input-block">
                        <textarea type="text" name="accountRegOut" title="禁止注册的地区"
                                  placeholder="禁止注册的地区" autocomplete="off"
                                  class="layui-textarea">{{$self['accountRegOut']}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">注册</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='deleteIndexRegSwitch' lay-filter="deleteIndexRegSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['deleteIndexRegSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='deleteIndexRegSwitchValue' name="deleteIndexRegSwitch"
                                   value="{{$self['deleteIndexRegSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">自主注册不排单封号开关</div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="deleteIndexRegTime" title="时间" lay-filter="numberZ"
                                       placeholder="时间" autocomplete="off" value="{{$self['deleteIndexRegTime']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">自主注册不排单超过该时间，则自动封号</div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">激活</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='deleteAdminActSwitch' lay-filter="deleteAdminActSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['deleteAdminActSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='deleteAdminActSwitchValue' name="deleteAdminActSwitch"
                                   value="{{$self['deleteAdminActSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">后台激活不排单封号开关</div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="deleteAdminActTime" title="时间" lay-filter="numberZ"
                                       placeholder="时间" autocomplete="off" value="{{$self['deleteAdminActTime']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">后台激活不排单超过该时间，则自动封号</div>
                        </div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">封号惩罚</label>
                            <div class="layui-input-inline">
                                <input type="text" name="deletePoundage" title="封号惩罚"
                                       placeholder="封号惩罚" autocomplete="off" value="{{$self['deletePoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">封号时自动扣除的星伙数量</div>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">贡献点</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletGxd" title="贡献点别名"
                                       placeholder="贡献点别名" autocomplete="off" value="{{$self['walletGxd']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">贡献点在前台显示时的名称</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletPoundage" title="星伙别名"
                                       placeholder="星伙别名" autocomplete="off" value="{{$self['walletPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">星伙在前台显示时的名称</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖励账户</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletReward" title="奖励账户别名"
                                       placeholder="奖励账户别名" autocomplete="off" value="{{$self['walletReward']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">奖励账户在前台显示时的名称</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">余额</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletBalance" title="余额别名"
                                       placeholder="余额别名" autocomplete="off" value="{{$self['walletBalance']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">余额在前台显示时的名称</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">鼓励账户</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletIncite" title="鼓励账户别名"
                                       placeholder="鼓励账户别名" autocomplete="off" value="{{$self['walletIncite']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">鼓励账户在前台显示时的名称</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">星伙价值</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletPoundageBalance" title="星伙价值" lay-filter="numberZ"
                                       placeholder="星伙价值" autocomplete="off" value="{{$self['walletPoundageBalance']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">一个星伙相对于余额的价值</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">贡献点价值</label>
                            <div class="layui-input-inline">
                                <input type="text" name="walletGxdBalance" title="贡献点价值" lay-filter="numberZ"
                                       placeholder="贡献点价值" autocomplete="off" value="{{$self['walletGxdBalance']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">一个贡献点相对于余额的价值</div>
                        </div>
                    </div>

                </div>
                <div class="layui-tab-item">

                    <div class="layui-form-item">
                        <label class="layui-form-label">负债卖出</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='sellPoundageNone' lay-filter="sellPoundageNone"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['sellPoundageNone'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='sellPoundageNoneValue' name="sellPoundageNone"
                                   value="{{$self['sellPoundageNone']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许用户负星伙时卖出</div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">卖出基数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="sellBase" title="卖出基数" lay-filter="numberZ"
                                       placeholder="卖出基数" autocomplete="off" value="{{$self['sellBase']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">卖出订单不得低于此金额</div>
                        </div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">卖出倍数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="sellTimes" title="卖出倍数" lay-filter="numberZ"
                                       placeholder="卖出倍数" autocomplete="off" value="{{$self['sellTimes']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">卖出订单金额必须是此数的正整数倍</div>
                        </div>
                    </div>

                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">卖出上限</label>
                            <div class="layui-input-inline">
                                <input type="text" name="sellTop" title="卖出上限" lay-filter="numberZ"
                                       placeholder="卖出上限" autocomplete="off" value="{{$self['sellTop']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">单日卖出上限金额</div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">手动买入</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='buySwitch' lay-filter="buySwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['buySwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='buySwitchValue' name="buySwitch"
                                   value="{{$self['buySwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许用户手动买入订单</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">自动买入</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='buyAutoSwitch' lay-filter="buyAutoSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['buyAutoSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='buyAutoSwitchValue' name="buyAutoSwitch"
                                   value="{{$self['buyAutoSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许用户自动买入订单</div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">收取星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="buyPoundage" title="收取星伙" lay-filter="numberZ"
                                       placeholder="收取星伙" autocomplete="off" value="{{$self['buyPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">每买一件商品需要支付的星伙</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">负债买入</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='buyPoundageNone' lay-filter="buyPoundageNone"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['buyPoundageNone'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='buyPoundageNoneValue' name="buyPoundageNone"
                                   value="{{$self['buyPoundageNone']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许用户负星伙时买入订单</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">金额递增</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='buyTotalUpSwitch' lay-filter="buyTotalUpSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['buyTotalUpSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='buyTotalUpSwitchValue' name="buyTotalUpSwitch"
                                   value="{{$self['buyTotalUpSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">订单金额必须大于等于历史最大订单</div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">快单周期</label>
                            <div class="layui-input-inline">
                                <input type="text" name="fastOrderDay" title="快速订单周期" lay-filter="numberZ"
                                       placeholder="快速订单周期" autocomplete="off" value="{{$self['fastOrderDay']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">快速订单收益周期</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">快单数量</label>
                            <div class="layui-input-inline">
                                <input type="text" name="fastOrderNumber" title="快速订单数量" lay-filter="numberZ"
                                       placeholder="快速订单数量" autocomplete="off" value="{{$self['fastOrderNumber']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">前几单可以采集快速订单</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">抢单开关</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='robSwitch' lay-filter="robSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['robSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='robSwitchValue' name="robSwitch"
                                   value="{{$self['robSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许多单的用户进行抢单</div>
                    </div>
                    <div id="robOn" class="layui-form-item"
                         @if($self['robSwitch'] == 'off')style="display:none"@endif>

                        <div class="layui-form-min">
                            <div class="layui-form-item">
                                <label class="layui-form-label">派单数量</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="robNum" title="派单数量" lay-filter="numberZ"
                                           placeholder="派单数量" autocomplete="off" value="{{$self['robNum']}}"
                                           class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">每天派发的抢单数量</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">抢单开始</label>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="robStartTime" name="robStartTime"
                                       placeholder="抢单开始" value="{{$self['robStartTime']}}">
                            </div>
                            <div class="layui-form-mid layui-word-aux">抢单开始时间</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">抢单结束</label>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="robEndTime" name="robEndTime"
                                       placeholder="抢单结束" value="{{$self['robEndTime']}}">
                            </div>
                            <div class="layui-form-mid layui-word-aux">抢单结束时间</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">抢单结果</label>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="robResultTime" name="robResultTime"
                                       placeholder="抢单结果" value="{{$self['robResultTime']}}">
                            </div>
                            <div class="layui-form-mid layui-word-aux">发送抢单结果时间</div>
                        </div>

                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="goodsName" lay-verify="required" title="商品名称"
                                   placeholder="商品名称" autocomplete="off" value="{{$self['goodsName']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">前台显示的商品名称</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品金额</label>
                        <div class="layui-input-inline">
                            <input type="text" name="goodsTotal" lay-filter="numberZ" title="商品金额"
                                   placeholder="商品金额" autocomplete="off" value="{{$self['goodsTotal']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">商品金额</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">封面</label>
                        <div class="layui-input-inline">
                            <button type="button" class="layui-btn" id="goods">
                                <i class="layui-icon">&#xe67c;</i>上传封面
                            </button>
                        </div>
                        <div class="layui-form-mid layui-word-aux">封面尺寸为：100X100</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">封面预览</label>
                        <div class="layui-input-inline">
                            <img id="goodsCoverUrl" src="{{$self['goodsCover']}}" width="100" height="100"/>
                            <input type="hidden" id="goodsCover" name="goodsCover" value="{{$self['goodsCover']}}"/>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">一单上限</label>
                        <div class="layui-input-inline">
                            <input type="text" name="goodsTop0" lay-filter="numberZ" title="一单上限"
                                   placeholder="一单上限" autocomplete="off" value="{{$self['goodsTop0']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">一单模式下，一单购买商品数量</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">多单上限</label>
                        <div class="layui-input-inline">
                            <input type="text" name="goodsTop1" lay-filter="numberZ" title="多单上限"
                                   placeholder="多单上限" autocomplete="off" value="{{$self['goodsTop1']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">多单模式下，一单购买商品数量</div>
                    </div>
                    {{--<div class="layui-form-item">
                        <label class="layui-form-label">一单收益</label>
                        <div class="layui-input-inline" style="width: 40px;">
                            <input type="text" name="goodsLower0" lay-filter="numberZ" title="一单收益"
                                   placeholder="" autocomplete="off" value="{{$self['goodsLower0']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">-</div>
                        <div class="layui-input-inline" style="width: 40px;">
                            <input type="text" name="goodsCeil0" lay-verify="required" title="一单收益"
                                   placeholder="" autocomplete="off" value="{{$self['goodsCeil0']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">一单模式下，可选的收益时间，单位：天</div>
                    </div>--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label">多单收益</label>
                        <div class="layui-input-inline" style="width: 40px;">
                            <input type="text" name="goodsLower1" lay-filter="numberZ" title="多单收益"
                                   placeholder="" autocomplete="off" value="{{$self['goodsLower1']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">-</div>
                        <div class="layui-input-inline" style="width: 40px;">
                            <input type="text" name="goodsCeil1" lay-verify="required" title="多单收益"
                                   placeholder="" autocomplete="off" value="{{$self['goodsCeil1']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">多单模式下，可选的收益时间，单位：天</div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">新人立配</label>
                        <div class="layui-input-inline">
                            <input type="text" name="matchNewMember" lay-filter="numberZ" title="新人立配"
                                   placeholder="新人立配" autocomplete="off" value="{{$self['matchNewMember']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">新会员享有立即匹配订单的次数</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">首付款匹配</label>
                        <div class="layui-input-inline">
                            <input type="text" name="matchFirstStart" lay-filter="numberZ" title="首付款匹配"
                                   placeholder="首付款匹配" autocomplete="off" value="{{$self['matchFirstStart']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">开始匹配首付款订单的时间，单位：天</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">全款匹配</label>
                        <div class="layui-input-inline">
                            <input type="text" name="matchTailStart" lay-filter="numberZ" title="尾款匹配"
                                   placeholder="尾款匹配" autocomplete="off" value="{{$self['matchTailStart']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">开始匹配尾款订单的时间，单位：天</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">预付款比例</label>
                        <div class="layui-input-inline">
                            <input type="text" name="matchFirstPro" lay-filter="number" title="预付款比例"
                                   placeholder="预付款比例" autocomplete="off" value="{{$self['matchFirstPro']}}"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">预付款相对于全款的比例，填写30.5即为30.5%</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">模拟匹配</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="matchSimu" name="matchSimu"
                                   placeholder="模拟匹配" value="{{$self['matchSimu']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">模拟匹配结果的时间</div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">付款时间</label>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="payStart" name="payStart"
                                   placeholder="付款开始" value="{{$self['payStart']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">-</div>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="payEnd" name="payEnd"
                                   placeholder="付款结束" value="{{$self['payEnd']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">可以付款的时间段</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">奖励时间段</label>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="payRewardStart" name="payRewardStart"
                                   placeholder="奖励开始" value="{{$self['payRewardStart']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">-</div>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="payRewardEnd" name="payRewardEnd"
                                   placeholder="奖励结束" value="{{$self['payRewardEnd']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">此时间段内付款，享有奖励贡献点</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">惩罚时间段</label>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="payPunishStart" name="payPunishStart"
                                   placeholder="惩罚开始" value="{{$self['payPunishStart']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">-</div>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="payPunishEnd" name="payPunishEnd"
                                   placeholder="惩罚结束" value="{{$self['payPunishEnd']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">此时间段内付款，会扣除贡献点</div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖励贡献点</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payRewardGxd" title="奖励贡献点" lay-filter="numberZ"
                                       placeholder="奖励贡献点" autocomplete="off" value="{{$self['payRewardGxd']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">规定时间内付款，奖励的贡献点</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">惩罚贡献点</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payPunishGxd" title="惩罚贡献点" lay-filter="numberZ"
                                       placeholder="惩罚贡献点" autocomplete="off" value="{{$self['payPunishGxd']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">规定时间内付款，扣除的贡献点</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖励星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payRewardPoundage" title="奖励星伙" lay-filter="number"
                                       placeholder="奖励星伙" autocomplete="off" value="{{$self['payRewardPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">规定时间内付款，奖励的星伙</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">惩罚星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payPunishPoundage" title="惩罚星伙" lay-filter="number"
                                       placeholder="惩罚星伙" autocomplete="off" value="{{$self['payPunishPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">规定时间内付款，扣除的星伙</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">未付款封号</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="payPunishSealAccount" name="payPunishSealAccount"
                                   placeholder="未付款封号" value="{{$self['payPunishSealAccount']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">超过此时间未付款，奖封停账号</div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">收款时间</label>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="inStart" name="inStart"
                                   placeholder="收款开始" value="{{$self['inStart']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">-</div>
                        <div class="layui-input-inline" style="width:58px;">
                            <input type="text" class="layui-input" id="inEnd" name="inEnd"
                                   placeholder="收款结束" value="{{$self['inEnd']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">可以确认收款的时间段</div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">惩罚贡献点</label>
                            <div class="layui-input-inline">
                                <input type="text" name="inOvertimePunishGxd" title="惩罚贡献点" lay-filter="numberZ"
                                       placeholder="惩罚贡献点" autocomplete="off" value="{{$self['inOvertimePunishGxd']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">规定时间内未确认收款，扣除的贡献点</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">惩罚星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="inOvertimePunishPoundage" title="惩罚星伙" lay-filter="number"
                                       placeholder="惩罚星伙" autocomplete="off"
                                       value="{{$self['inOvertimePunishPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">规定时间内未确认收款，扣除的星伙</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">自动确认</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" id='inOvertimeAuto' lay-filter="inOvertimeAuto"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self["inOvertimeAuto"] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='inOvertimeAutoValue' name="inOvertimeAuto"
                                   value="{{$self['inOvertimeAuto']}}"/>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">负债提现</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" id='withdrawSwitch' lay-filter="withdrawSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self["withdrawSwitch"] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='withdrawSwitchValue' name="withdrawSwitch"
                                   value="{{$self['withdrawSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">贡献点为负时，是否允许从订单中提现</div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">扣除比例</label>
                            <div class="layui-input-inline">
                                <input type="text" name="withdrawPro" title="提现时扣除贡献点比例" lay-filter="numberZ"
                                       placeholder="提现时扣除贡献点比例" autocomplete="off" value="{{$self['withdrawPro']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">提现时，扣除的贡献点比例</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">签到开始</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="signStart" name="signStart"
                                   placeholder="签到开始" value="{{$self['signStart']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">每天开始签到时间</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">签到结束</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="signEnd" name="signEnd"
                                   placeholder="签到结束" value="{{$self['signEnd']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">每天签到结束时间</div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">奖励比例</label>
                            <div class="layui-input-inline">
                                <input type="text" name="rewardPro" title="奖励比例" lay-filter="number"
                                       placeholder="奖励比例" autocomplete="off" value="{{$self['rewardPro']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">下级买单，上级奖励比例，填写5.5即为5.5%</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">提现开关</label>
                        <div class="layui-input-inline" style="width:70px;">
                            <input type="checkbox" id='rewardSwitch' lay-filter="rewardSwitch"
                                   lay-skin="switch"
                                   lay-text="开启|关闭" {{$self['rewardSwitch'] == 'on' ? 'checked' : ''}}/>
                            <input type="hidden" id='rewardSwitchValue' name="rewardSwitch"
                                   value="{{$self['rewardSwitch']}}"/>
                        </div>
                        <div class="layui-form-mid layui-word-aux">是否允许将奖励账户提现到余额</div>
                    </div>
                    <div id="rewardOn" class="layui-form-item"
                         @if($self['rewardSwitch'] == 'off')style="display:none"@endif>

                        <div class="layui-form-item">
                            <label class="layui-form-label">负债提现</label>
                            <div class="layui-input-inline" style="width:70px;">
                                <input type="checkbox" id='rewardPoundageNone' lay-filter="rewardPoundageNone"
                                       lay-skin="switch"
                                       lay-text="开启|关闭" {{$self['rewardPoundageNone'] == 'on' ? 'checked' : ''}}/>
                                <input type="hidden" id='rewardPoundageNoneValue' name="rewardPoundageNone"
                                       value="{{$self['rewardPoundageNone']}}"/>
                            </div>
                            <div class="layui-form-mid layui-word-aux">是否允许星伙不足时提现</div>
                        </div>
                        {{--<div class="layui-form-min">
                            <div class="layui-form-item">
                                <label class="layui-form-label">提现基数</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="rewardBase" title="提现基数" lay-filter="numberZ"
                                           placeholder="提现基数" autocomplete="off" value="{{$self['rewardBase']}}"
                                           class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">提现的最低数量</div>
                            </div>
                        </div>
                        <div class="layui-form-min">
                            <div class="layui-form-item">
                                <label class="layui-form-label">提现倍数</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="rewardTimes" title="提现倍数" lay-filter="numberZ"
                                           placeholder="提现倍数" autocomplete="off" value="{{$self['rewardTimes']}}"
                                           class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">提现的数额必须是此数的正整数倍</div>
                            </div>
                        </div>--}}
                        <div class="layui-form-min">
                            <div class="layui-form-item">
                                <label class="layui-form-label">沉淀比例</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="rewardDeposit" title="沉淀比例" lay-filter="number"
                                           placeholder="沉淀比例" autocomplete="off" value="{{$self['rewardDeposit']}}"
                                           class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">提现时，需要沉淀的奖励账户比例，填写50即为50%</div>
                            </div>
                        </div>
                        <div class="layui-form-min">
                            <div class="layui-form-item">
                                <label class="layui-form-label">贡献点消耗</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="rewardGxd" title="贡献点消耗" lay-filter="numberZ"
                                           placeholder="贡献点消耗" autocomplete="off" value="{{$self['rewardGxd']}}"
                                           class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">老会员提现时，消耗的贡献点数</div>
                            </div>
                        </div>
                        {{--<div class="layui-form-min">
                            <div class="layui-form-item">
                                <label class="layui-form-label">提现禁止</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="rewardTime" title="提现禁止" lay-filter="numberZ"
                                           placeholder="提现禁止" autocomplete="off" value="{{$self['rewardTime']}}"
                                           class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">上次派单时间超过此数时，无法提现奖励账户</div>
                            </div>
                        </div>--}}
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">新转老</label>
                            <div class="layui-input-inline">
                                <input type="text" name="typeOld" title="新转老" lay-filter="numberZ"
                                       placeholder="新转老" autocomplete="off" value="{{$self['typeOld']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">新会员转为老会员的时间，填写30即为30天</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">动态利率</label>
                            <div class="layui-input-inline">
                                <input type="text" name="typePro1" title="动态利率" lay-filter="number"
                                       placeholder="动态利率" autocomplete="off" value="{{$self['typePro1']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">动态状态下订单收益率，填写1即为1%</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">静态利率</label>
                            <div class="layui-input-inline">
                                <input type="text" name="typePro0" title="静态利率" lay-filter="number"
                                       placeholder="静态利率" autocomplete="off" value="{{$self['typePro0']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">静态状态下订单收益率，与动态相差的部分将加入贡献点</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">动转静</label>
                            <div class="layui-input-inline">
                                <input type="text" name="type10" title="动转静" lay-filter="numberZ"
                                       placeholder="动转静" autocomplete="off" value="{{$self['type10']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">动态下长时间未推荐新人则转为动态，单位：天</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">静转动</label>
                            <div class="layui-input-inline">
                                <input type="text" name="type01" title="静转动" lay-filter="numberZ"
                                       placeholder="静转动" autocomplete="off" value="{{$self['type01']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">静态下推荐新人并买单打到限额后，转回动态</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">永动人数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="typeAllNum" title="永动人数" lay-filter="numberZ"
                                       placeholder="永动人数" autocomplete="off" value="{{$self['typeAllNum']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">永久动态的推荐人数要求</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">永动金额</label>
                            <div class="layui-input-inline">
                                <input type="text" name="typeAllTotal" title="永动金额" lay-filter="numberZ"
                                       placeholder="永动金额" autocomplete="off" value="{{$self['typeAllTotal']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">永久动态的下单金额要求</div>
                        </div>
                    </div>

                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">挂售基数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="consignBase" title="挂售基数" lay-filter="numberZ"
                                       placeholder="挂售基数" autocomplete="off" value="{{$self['consignBase']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">挂售金额不得低于此数</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">挂售倍数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="consignTimes" title="挂售倍数" lay-filter="numberZ"
                                       placeholder="挂售倍数" autocomplete="off" value="{{$self['consignTimes']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">挂售金额必须为此数的正整数倍</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">星伙</label>
                            <div class="layui-input-inline">
                                <input type="text" name="consignPoundage" title="星伙" lay-filter="number"
                                       placeholder="星伙" autocomplete="off" value="{{$self['consignPoundage']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">手续相当于此数百分比的星伙</div>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">IOS版本</label>
                            <div class="layui-input-inline">
                                <input type="text" name="versionIos" title="IOS版本" required
                                       placeholder="IOS版本" autocomplete="off" value="{{$self['versionIos']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">IOS的APP版本</div>
                        </div>
                    </div>
                    <div class="layui-form-min">
                        <div class="layui-form-item">
                            <label class="layui-form-label">安卓版本</label>
                            <div class="layui-input-inline">
                                <input type="text" name="versionAndroid" title="安卓版本" required
                                       placeholder="安卓版本" autocomplete="off" value="{{$self['versionAndroid']}}"
                                       class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">安卓的APP版本</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button id='submit' class="layui-btn" lay-filter="*" lay-submit>保存</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{$static}}layui/layui.js"></script>
<script>

    var urls = {
        upload: '/admin/set/goods', // logo上传地址
    };

    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element', 'upload', 'laydate'], function () {

        var element = layui.element;
        var form = layui.form;
        var layer = layui.layer;
        var laydate = layui.laydate;

        var upload = layui.upload;
        upload.render({
            elem: '#goods'
            , url: urls.upload
            , field: 'images'
            , exts: 'jpg|png|gif|bmp|jpeg'
            , size: 3000//kb
            , number: 1
            , done: function (res, index, upload) {
                console.log(res);
                /**
                 * 返回格式
                 * {
                 *      status : ,
                 *      message : ,
                 *      image : , 成功以后图片预览地址
                 *      imageId : 成功以后图片id
                 * }
                 */

                // image
                // imageId  图片id

                if (res.status == 'success') {
                    layer.msg('上传成功');
                    $("#goodsCoverUrl").prop('src', res.image);
                    $("#goodsCover").prop('value', res.image);
                } else {
                    layer.msg('上传失败');
                }
            }
        });

        // 监听开关
        form.on('switch(webSwitch)', function (data) {
            if (data.elem.checked) {
                $('#webOn').show();
                $('#webOff').hide();
                $('#webSwitchValue').prop('value', 'on');
            } else {
                $('#webOn').hide();
                $('#webOff').show();
                $('#webSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(accountRegSwitch)', function (data) {
            if (data.elem.checked) {
                $('#accountRegSwitchValue').prop('value', 'on');
            } else {
                $('#accountRegSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(accountActSwitch)', function (data) {
            if (data.elem.checked) {
                $('#accountActSwitchValue').prop('value', 'on');
            } else {
                $('#accountActSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(accountActPoundageNone)', function (data) {
            if (data.elem.checked) {
                $('#accountActPoundageNoneValue').prop('value', 'on');
            } else {
                $('#accountActPoundageNoneValue').prop('value', 'off');
            }
        });
        form.on('switch(accountModeDefault)', function (data) {
            if (data.elem.checked) {
                $('#accountModeDefaultValue').prop('value', '10');
            } else {
                $('#accountModeDefaultValue').prop('value', '20');
            }
        });
        form.on('switch(deleteIndexRegSwitch)', function (data) {
            if (data.elem.checked) {
                $('#deleteIndexRegSwitchValue').prop('value', 'on');
            } else {
                $('#deleteIndexRegSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(deleteAdminActSwitch)', function (data) {
            if (data.elem.checked) {
                $('#deleteAdminActSwitchValue').prop('value', 'on');
            } else {
                $('#deleteAdminActSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(buySwitch)', function (data) {
            if (data.elem.checked) {
                $('#buySwitchValue').prop('value', 'on');
            } else {
                $('#buySwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(buyAutoSwitch)', function (data) {
            if (data.elem.checked) {
                $('#buyAutoSwitchValue').prop('value', 'on');
            } else {
                $('#buyAutoSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(buyPoundageNone)', function (data) {
            if (data.elem.checked) {
                $('#buyPoundageNoneValue').prop('value', 'on');
            } else {
                $('#buyPoundageNoneValue').prop('value', 'off');
            }
        });
        form.on('switch(sellPoundageNone)', function (data) {
            if (data.elem.checked) {
                $('#sellPoundageNoneValue').prop('value', 'on');
            } else {
                $('#sellPoundageNoneValue').prop('value', 'off');
            }
        });
        form.on('switch(buyTotalUpSwitch)', function (data) {
            if (data.elem.checked) {
                $('#buyTotalUpSwitchValue').prop('value', 'on');
            } else {
                $('#buyTotalUpSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(robSwitch)', function (data) {
            if (data.elem.checked) {
                $('#robOn').show();
                $('#robSwitchValue').prop('value', 'on');
            } else {
                $('#robOn').hide();
                $('#robSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(inOvertimeAuto)', function (data) {
            if (data.elem.checked) {
                $('#inOvertimeAutoValue').prop('value', 'on');
            } else {
                $('#inOvertimeAutoValue').prop('value', 'off');
            }
        });
        form.on('switch(rewardSwitch)', function (data) {
            if (data.elem.checked) {
                $('#rewardOn').show();
                $('#rewardSwitchValue').prop('value', 'on');
            } else {
                $('#rewardOn').hide();
                $('#rewardSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(rewardPoundageNone)', function (data) {
            if (data.elem.checked) {
                $('#rewardPoundageNoneValue').prop('value', 'on');
            } else {
                $('#rewardPoundageNoneValue').prop('value', 'off');
            }
        });
        form.on('switch(withdrawSwitch)', function (data) {
            if (data.elem.checked) {
                $('#withdrawSwitchValue').prop('value', 'on');
            } else {
                $('#withdrawSwitchValue').prop('value', 'off');
            }
        });
        form.on('switch(accountRegAct)', function (data) {
            if (data.elem.checked) {
                $('#accountRegActValue').prop('value', 'on');
            } else {
                $('#accountRegActValue').prop('value', 'off');
            }
        });

        //日期
        laydate.render({
            elem: '#webOpenTime', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#webCloseTime', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#accountActStart', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#accountActEnd', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#accountActResult', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#accountActResult', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#robStartTime', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#robEndTime', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#robResultTime', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payStart', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payEnd', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payRewardStart', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payRewardEnd', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payPunishStart', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payPunishEnd', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#payPunishSealAccount', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#inStart', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#inEnd', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#signStart', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#signEnd', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
        laydate.render({
            elem: '#matchSimu', //指定元素
            format: 'HH:mm',
            type: 'time',
        });
    });
</script>
</body>
</html>
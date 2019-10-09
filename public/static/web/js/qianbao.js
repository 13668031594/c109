


 

layui.use('layer', function(){
	var $ = layui.jquery, layer = layui.layer;
	var active = {

		benxi: function(){
			layer.open({
			  type: 1, 
			  title: false,
			  closeBtn: 0,
			  area: ['300px','400px'],
			  resize:false,
			  btn: ['确定'],
			  btnAlign: 'r',
			  content: '<div class="details"><div class="details-list"><h3>订单提现，订单号【B375573】，获得【余额】1150，扣除【贡献点】6.00</h3><h5>2019-08-08 09:51:59</h5></div><div class="details-right"><h1>1150.00</h1></div></div> <div class="details"><div class="details-list"><h3>管理员【超级管理员】为您充值【余额】：100</h3><h5>2019-08-08 10:51:59</h5></div><div class="details-right"><h1>100.00</h1></div></div>' 
			});
		}
		
		,xinghuo: function(){
			layer.open({
			  type: 1, 
			  title: false,
			  closeBtn: 0,
			  area: ['300px','400px'],
			  resize:false,
			  btn: ['确定'],
			  btnAlign: 'r',
			  content: '<div class="details"><div class="details-list"><h3>自动采集，订单号【B375635】，扣除【星伙】1</h3><h5>2019-08-08 09:51:59</h5></div><div class="details-right"><h1>-1.00</h1></div></div> <div class="details"><div class="details-list"><h3>因账号封停，扣除累计赠送的【星伙】3.00</h3><h5>2019-08-08 10:51:59</h5></div><div class="details-right"><h1>-30.00</h1></div></div>' 
			});
		}

		,jiangli: function(){
			layer.open({
			  type: 1, 
			  title: false,
			  closeBtn: 0,
			  area: ['300px','400px'],
			  resize:false,
			  btn: ['确定'],
			  btnAlign: 'r',
			  content: '<div class="details"><div class="details-list"><h3>自动采集，订单号【B375635】，扣除【星伙】1</h3><h5>2019-08-08 09:51:59</h5></div><div class="details-right"><h1>-1.00</h1></div></div> <div class="details"><div class="details-list"><h3>因账号封停，扣除累计赠送的【星伙】3.00</h3><h5>2019-08-08 10:51:59</h5></div><div class="details-right"><h1>-30.00</h1></div></div>' 
			});
		}
		
		,gongxian: function(){
			layer.open({
			  type: 1, 
			  title: false,
			  closeBtn: 0,
			  area: ['300px','400px'],
			  resize:false,
			  btn: ['确定'],
			  btnAlign: 'r',
			  content: '<div class="details"><div class="details-list"><h3>订单提现，订单号【B375573】，获得【余额】1150，扣除【贡献点】6.00</h3><h5>2019-08-08 09:51:59</h5></div><div class="details-right"><h1>-6.00</h1></div></div> <div class="details"><div class="details-list"><h3>华夏宗亲家谱【贡献点】同步：1</h3><h5>2019-08-08 10:51:59</h5></div><div class="details-right"><h1>1.00</h1></div></div>' 
			});
		}

	};

	$('.content-list-bot').on('click', function(){
		var othis = $(this), method = othis.data('method');
		active[method] ? active[method].call(this, othis) : '';
	  });

});    

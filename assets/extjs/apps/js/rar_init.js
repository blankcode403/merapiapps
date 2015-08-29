RAR.onReady(function() {
	RAR.tip.QuickTipManager.init();    
	RAR.create('Ext.container.Viewport', {
		layout : 'border',
		items : [
				{
					region : 'north',
					xtype : 'panel',
					tbar : [
							{
								xtype : 'button',
								height : 50,
								html : '<img class="resize" src="'
										+ d.base_url
										+ 'assets/images/SplashMerapi.png"/>',
							}, '->', {
								text : "welcome, " + d.alias,
								iconCls : 'options_icon',
								menu : [ {
									iconCls : 'userinfo',
									text : lang('user_info')
								}, {
									iconCls : 'setting',
									text : lang('chg_pwd')
								}, {
									iconCls : 'logout',
									text : lang('logout'),
									handler : function() {
										RAR.Msg.show({
				                            title: lang('info'),
				                            msg: lang('logout_confirm'),
				                            buttons: Ext.Msg.YESNO,
				                            icon: Ext.Msg.QUESTION,
				                            fn: function(b) {
				                                if (b == 'yes') {
				                                    RF.logout();
				                                }
				                            }
				                        });
									}
								} ]
							}, '-', {
								text : d.lang.help,
								iconCls : 'help',
								menu : [ {
									text : lang('documentation')
								}, {
									text : lang('troubleshooting')
								}, {
									text : lang('report')
								}, {
									iconCls : 'exclamation',
									text : lang('about'),
									handler : RF.about
								} ]
							} ]
				}, {
					xtype : 'treepanel',
					iconCls : 'application_side_tree',
					title : 'Dashboard',
					region : 'west',
					width : 200,
					store : RM.module,
					split : true,
					autoScroll : true,
					scroll : true,
					collapsible : true,
					listeners : {
						itemdblclick : {
							fn : function(view, record, item, index, event) {
								if (record.data.leaf == true) {
									var node = {
										id : record.data.id,
										name : record.data.text
									};
									RF.open(node);
								}
							}
						}
					}
				}, {
					xtype : 'tabpanel',
					region : 'center',
					id : 'tab',
					activeTab : 0,
					items : [ {
						title : 'Home',
						/*items: gauges*/
						/*html : '<div align="center"><a href=' + d.base_url
								+ '><img class="resizehomepage" src="'
								+ d.base_url
								+ 'assets/images/SplashRDA.png"/></a></div>'*/
					}]
				}, {
					region : 'south',
					xtype : 'box',
					id : 'app-footer',
					height : 20,
					html : 'Powered by medialintascyber.net [MLC]'
				} ]
	});
});
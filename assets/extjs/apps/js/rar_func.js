function lang(item, replace) {
	if (typeof (replace) === 'undefined')
		replace = false;
	if (typeof d.lang[item] == 'undefined') {
		return '[' + item + ']';
	} else {
		if (replace) {
			var tpl = new RAR.Template(d.lang[item]);
			return tpl.apply(replace);
		} else {
			return d.lang[item];
		}
	}
}

var RF = new Object();
RF = {
	cpsess : function(url) {
		return d.base_url + url + '?cpsess=' + d.cpsess;
	},
	jsonRequest : function(url) {
		return RF.cpsess(url) + '&dataType=json';
	},
	dataRequest : function(action) {
		return this.jsonRequest(action);
	},
	moduleRequest : function(module) {
		return {
			url : RF.cpsess('cpanelx/modules/' + module) + '&dataType=module',
			scripts : true
		};
	},
	about : function() {
		RAR.Msg.show({
			title : lang('about'),
			msg : '<div><h3> teste </h3><p> ya tester </p></div>'
		});
	},

	logout : function() {
		document.location = RF.cpsess('adminx/sec/destroy');
	},

	lang : function(id) {
		this.id = id.toUpperCase();
		this.data = d.lang['L_' + this.id];
		this.text = function(item, replace) {
			if (typeof (replace) === 'undefined')
				replace = false;
			if (typeof (this.data[item]) === 'undefined') {
				return '[' + item + ']';
			} else {
				if (replace) {
					var tpl = new RAR.Template(this.data[item]);
					return tpl.apply(replace);
				} else {
					return this.data[item];
				}
			}
		};
		return d.data;
	},
	open : function(tab) {
		var tab_id = 'tab.' + tab.id.toLowerCase();
		var i = RAR.getCmp(tab_id);
		var mask_id = 'mask.' + tab_id;
		var icon = 'x-tree-icon-leaf';
		if (tab.iconCls) {
			icon = tab.iconCls;
		}
		if (!i) {
			RAR.getCmp('tab').add(
					RAR.create('RAR.panel.Panel', {
						iconCls : icon,
						title : tab.name,
						id : tab_id,
						bodyPadding : 5,
						autoScroll : true,
						border : false,
						layout : 'fit',
						dockedItems : [ {
							xtype : 'toolbar',
							dock : 'top',
							id : 'tbar.' + tab.id.toLowerCase(),
							items : [
									'ID MODULE' + ': ' + tab.id.toUpperCase(),
									'-', RF.button.help(tab.id), '-' ]
						} ],
						closable : true,
						loader : {
							autoLoad : RF.moduleRequest(tab.id.toLowerCase()),
							listeners : {
								exception : function(t, r, o, p) {
									RF.msg(lang('ERROR'), r.status + ': '
											+ r.statusText);
								},
								load : function() {
								}
							}
						},
					})).show();
		} else {
			i.show();
		}
	},
	createBox : function(t, s) {
		return '<div class="msg"><h3>' + t + '</h3><p>' + s + '</p></div>';
	},
	alert : function(t, m, callback) {
		RAR.Msg.show({
			title : t,
			msg : m,
			buttons : RAR.Msg.OK,
			icon : RAR.Msg.WARNING,
			listeners : {
				close : function(p, e) {
					if (typeof callback == "function") {
						callback(p, e);
					}
				}
			}
		});
	},
	button : {
		help : function(i) {
			var index = i;
			return {
				text : lang('help'),
				iconCls : 'help',
				handler : function(i) {
					if (!RAR.getCmp('help.window.' + i)) {
						new RAR.create('RAR.window.Window', {
							title : lang('help') + ': ' + index.toUpperCase(),
							iconCls : 'help',
							maximizable : true,
							autoScroll : true,
							id : 'help.window.' + i,
							bodyPadding : 8,
							autoLoad : RF.cpsess('help/module/'
									+ index.toLowerCase() + '.html'),
							width : 450,
							height : 300,
						}).show();
					}
				}
			};
		},
	},
	formFailureHandler : function(f, a) {
		var msg;
		if (a.failureType === RAR.form.action.Action.CONNECT_FAILURE) {
			msg = 'Ajax communication failed';
		} else if (a.failureType === RAR.form.action.Action.SERVER_INVALID) {
			msg = RF.msg2html(a.result.msg.msg.error);
		} else if (a.failureType === RAR.form.action.Action.LOAD_FAILURE) {
		} else if (a.failureType === RAR.form.action.Action.CLIENT_INVALID) {
			msg = 'Form fields may not be submitted with invalid values'
		}
		RF.alert(lang('ERROR'), msg);
	},
	exceptionHandler : function(t, r, o) {
		var msg;
		if (r.status == 200) {
			if (typeof o.getError() === 'undefined') {
				var d = RAR.JSON.decode(r.responseText);
				msg = RF.msg2html(d.msg.msg.error);
			} else {
				msg = o.getError();
			}
		} else {
			msg = r.status + ' : ' + r.statusText;
		}
		RF.alert(lang('ERROR'), msg);
	},
	actionConfirm : function(callback) {
		var prompt = RAR.Msg.prompt(lang('ACTION_CONFIRM'),
				lang('ENTER_PASSWORD'), function(b, t) {
					if (b == 'ok') {
						Ext.getBody().mask(lang('PLEASE_WAIT'));
						RAR.Ajax.request({
							url : RF.jsonRequest('auth/action'),
							params : {
								p : t
							},
							success : function(r) {
								Ext.getBody().unmask();
								var data = RAR.JSON.decode(r.responseText);
								if (data.block) {
									RF.logout();
								}
								if (data.success) {
									if (typeof callback == "function") {
										callback(data);
									}
								} else {
									RF.alert(lang('ERROR'), RF
											.msg2html(data.msg.msg.error));
								}
							},
							failure : function(r) {
								Ext.getBody().unmask();
								if (r.status != 200) {
									RF.alert(lang('ERROR'), r.status + ': '
											+ r.statusText);
								}
							}
						});
					}
				});
		prompt.textField.inputEl.dom.type = 'password';
	},
	msg : function(title, format) {
		var s = RAR.String.format.apply(String, Array.prototype.slice.call(
				arguments, 1));
		var m = RAR.DomHelper.append('msg-div', RF.createBox(title, s), true);
		m.hide();
		m.slideIn('r').ghost("t", {
			delay : 3000,
			remove : true
		});
	},
	msg2html : function(m) {
		var string = '';
		RAR.Array.each(m, function(v, i) {
			string += '<li>' + v + '</li>';
		});
		return '<ul class="alert-msg">' + string + '</ul>';
	}

};
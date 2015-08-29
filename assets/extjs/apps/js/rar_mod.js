var RM = new Object();
RM = {
	module : RAR.create('RAR.data.TreeStore', {
		proxy : {
			type : 'ajax',
			url : RF.jsonRequest('adminx/property/menu')
		},
		root : {
			id : '1',
			text : d.alias,
			expanded : true,
		}
	}),
}
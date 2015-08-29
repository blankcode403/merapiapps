<script language="text/javascript">
    var ar001 = new Object({
        id: 'ar001',
        uppercaseValue: true
    });

    ar001.lang = new RF.lang(ar001.id);

    ar001.dataYear = new RAR.create('RAR.data.Store', {
        autoLoad: false,
        fields: ['mp110yr'],
        proxy: {
            type: 'ajax',
            url: RF.dataRequest('cpanelx/modules/ar001/getdataYear'),
            reader: {
                type: 'json',
                root: 'data'
            },
            listeners: {
                exception: RF.exceptionHandler,
            }
        },
    });

    ar001.datamonth = new RAR.create('RAR.data.Store', {
        autoLoad: false,
        fields: ['mp110mt', 'months', 'mp110yr'],
        proxy: {
            type: 'ajax',
            url: RF.dataRequest('cpanelx/modules/ar001/getdataMonth'),
            reader: {
                type: 'json',
                root: 'data'
            },
            listeners: {
                exception: RF.exceptionHandler,
            }
        },
    });

    ar001.databranch = new RAR.create('RAR.data.Store', {
        autoLoad: false,
        fields: ['mp110br', 'mfdesc'],
        proxy: {
            type: 'ajax',
            url: RF.dataRequest('cpanelx/modules/ar001/getdataBrach'),
            reader: {
                type: 'json',
                root: 'data'
            },
            listeners: {
                exception: RF.exceptionHandler,
            }
        },
    });

    ar001.historyData = RAR.create('RAR.data.Store', {
        autoLoad: false,
        autoSync: true,
        id: 'ar001.historyData',
        autoDestroy: true,
        groupers: 'customer',
        fields: [{
            name: 'group_cust',
            type: 'string'
        }, {
            name: 'salesman',
            type: 'string'
        }, {
            name: 'customer',
            type: 'string'
        }, {
            name: 'mp110do',
            type: 'string'
        }, {
            name: 'invoice_date',
            type: 'string'
        }, {
            name: 'dar',
            type: 'string'
        }, {
            name: 'duedate',
            type: 'string'
        }, {
            name: 'hari',
            type: 'string'
        }, {
            name: 'duenxmon',
            type: 'string'
        }, {
            name: 'o0',
            type: 'string'
        }, {
            name: 'lebih31',
            type: 'string'
        }, {
            name: 'target',
            type: 'string'
        }, {
            name: 'paymen',
            type: 'string'
        }, {
            name: 'sisa',
            type: 'string'
        }, {
            name: 'myGroup',
            mapping: 'customer',
            convert: function(v) {
                var getPT = Ext.util.Format.substr(v, 9, v.length);
                return 'sub total ' + getPT + ' :';
            }
        }],
        proxy: {
            type: 'ajax',
            batchActions: false,
            api: {
                read: RF.dataRequest('cpanelx/modules/ar001/readParams'),
            },
            actionMethods: {
                read: 'POST'
            },
            reader: {
                type: 'json',
                root: 'data',
                totalProperty: 'total',
            },
            writer: {
                encode: true,
                writeAllFields: true,
                type: 'json',
                root: 'data'
            },
            listeners: {
                exception: RF.exceptionHandler,
                load: function() {
                    this.load();
                }
            }
        }
    });


    var win = null;

    function showContactForm() {
        if (!win) {
            var form = RAR.widget('form', {
                title: 'AR Detail by customer group',
                iconCls: 'form',
                id: 'ar001.filterForm',
                bodyPadding: 3,
                frame: true,
                buttonAlign: 'center',
                bodyPadding: 1,
                items: [{
                    xtype: 'fieldset',
                    title: 'Condition',
                    items: [{
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'textfield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'module_id',
                            fieldLabel: 'Module ID',
                            flex: 1,
                            id: 'ar001.module.field',
                            hidden: true,
                        }, {
                            name: 'username',
                            fieldLabel: 'Username',
                            flex: 1,
                            value: d.alias,
                            hidden: true,
                        }, {
                            id: 'mp110yr',
                            name: 'mp110yr',
                            fieldLabel: 'AR Periode',
                            xtype: 'combobox',
                            editable: false,
                            displayField: 'mp110yr',
                            valueField: 'mp110yr',
                            store: ar001.dataYear,
                        }, {
                            id: 'mp110mt',
                            name: 'mp110mt',
                            xtype: 'combobox',
                            displayField: 'months',
                            valueField: 'mp110mt',
                            editable: false,
                            store: ar001.datamonth,                           
                        }]
                    }, {
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'textfield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'mp110br',
                            fieldLabel: 'Branch',
                            xtype: 'combobox',
                            displayField: 'mfdesc',
                            valueField: 'mp110br',
                            editable: false,
                            store: ar001.databranch,                                
                        }]
                    }, {
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'textfield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'fsscode',
                            fieldLabel: 'FSS',
                            xtype: 'combobox',
                            editable: false,
                            value: '901006'
                                /*store: []*/
                        }]
                    }, {
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'textfield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'arfss',
                            fieldLabel: 'Segmen',
                            xtype: 'combobox',
                            editable: false,
                            store: []
                        }, {
                            name: 'arbulan',
                            xtype: 'combobox',
                            displayField: 'table_name',
                            /*store: ar001.dataTable*/
                        }]
                    }, {
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'textfield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'arsalesman',
                            fieldLabel: 'Salesmen',
                            xtype: 'combobox',
                            editable: false,
                            store: []
                        }, {
                            name: 'arbulan',
                            xtype: 'combobox',
                            displayField: 'table_name',
                            /*store: ar001.dataTable*/
                        }]
                    }, {
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'textfield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'arcustumer',
                            fieldLabel: 'Customer',
                            xtype: 'combobox',
                            editable: false,
                            store: []
                        }, {
                            name: 'arbulan',
                            xtype: 'combobox',
                            displayField: 'table_name',
                            /*store: ar001.dataTable*/
                        }]
                    }, {
                        xtype: 'fieldcontainer',
                        layout: 'hbox',
                        fieldDefaults: {
                            labelAlign: 'left'
                        },
                        defaultType: 'datefield',
                        defaults: {
                            margin: 5
                        },
                        items: [{
                            name: 'invoice_date_from',
                            fieldLabel: 'From',
                            format: 'Y/m/d'
                        }, {
                            name: 'invoice_date_until',
                            fieldLabel: 'Until',
                            format: 'Y/m/d',
                            maxValue: new Date()
                        }]
                    }]
                }],
                buttons: [{
                    text: 'Close',
                    handler: function() {
                        this.up('window').close();
                    }
                }, {
                    text: 'Find',
                    handler: function() {
                        var frm = this.up('form').getForm();
                        if (frm.isValid()) {
                            // CHECK NEXT CODE LISTING AND REPLACE THIS LINE WITH THAT
                            /*var name = frm.getValues();*/
                            this.up('window').close();
                            var result = RAR.getCmp('ar001.bigdata');
                            result.getStore().getProxy().extraParams = RAR.getCmp('ar001.filterForm').getValues();
                            console.log(result.getStore().getProxy().extraParams);
                            result.getStore().load();
                        }
                    }
                }]
            });

            win = Ext.widget('window', {
                title: 'Some Cool Title',
                closeAction: 'hide',
                width: 600,
                height: 400,
                layout: 'fit',
                resizable: true,
                modal: true,
                items: form
            });
        }
        win.show();
    };

    ar001.bigdata = {
        xtype: 'gridpanel',
        title: 'Detail by Customer Group/Salesman',
        id: 'ar001.bigdata',
        iconCls: 'form',
        store: ar001.historyData,
        tbar: [{
            text: 'Download xls',
            iconCls: 'find',
            handler: function() {
                st01.inventoryData.load({
                    params: {
                        query: RAR.getCmp('st01.inventNM').getValue()
                    }
                })
            }
        }, '-', {
            text: 'cariiiii',
            iconCls: 'find',
            handler: function() {
                showContactForm();
            }
        }],
        features: [{
            id: 'group',
            ftype: 'groupingsummary',
            groupHeaderTpl: '{name} ({rows.length} {[values.rows.length > 1 ? "Items" : "Item"]})',
            hideGroupedHeader: false,
        }],
        columns: [{
            xtype: 'rownumberer',
            flex: 1,
            sortable: false,
        }, {
            text: 'Customer Group',
            sortable: true,
            dataIndex: 'group_cust',
            width: 150,
        }, {
            text: 'Salesman',
            sortable: true,
            dataIndex: 'salesman',
            width: 150,
        }, {
            text: 'Customer',
            sortable: true,
            dataIndex: 'customer',
            width: 150,
            summaryType: function(records) {
                var myGroupName = records[0].get('myGroup');
                return myGroupName;
            }
        }, {
            text: 'Invoice Number',
            sortable: true,
            dataIndex: 'mp110do',
            width: 70,
        }, {
            text: 'Invoice Date',
            sortable: true,
            dataIndex: 'invoice_date',
            width: 70,
            renderer: Ext.util.Format.dateRenderer('Y/m/d'),
        }, {
            text: 'Day AR',
            sortable: true,
            dataIndex: 'dar',
            width: 70,
        }, {
            text: 'Due Date',
            sortable: true,
            dataIndex: 'duedate',
            width: 70,
            renderer: Ext.util.Format.dateRenderer('Y/m/d'),
            field: {
                xtype: 'datefield'
            }
        }, {
            text: 'Day OD',
            sortable: true,
            dataIndex: 'hari',
            width: 70,
        }, {
            text: 'Due Next Month',
            sortable: true,
            dataIndex: 'duenxmon',
            width: 100,
            renderer: function(v) {
                return Ext.util.Format.number(v, '0,000');;
            },
            summaryType: function(records) {
                var i = 0,
                    length = records.length,
                    total = 0,
                    record;

                for (; i < length; ++i) {
                    record = records[i];
                    total += record.get('duenxmon') * '1';
                }
                return total;
            },
        }, {
            text: '0-30',
            sortable: true,
            dataIndex: 'o0',
            width: 70,
            renderer: function(v) {
                return Ext.util.Format.number(v, '0,000');;
            },
        }, {
            text: '>30',
            sortable: true,
            dataIndex: 'lebih31',
            width: 70,
            renderer: function(v) {
                return Ext.util.Format.number(v, '0,000');;
            },
        }, {
            text: 'Yang Harus Ditagih',
            sortable: true,
            dataIndex: 'target',
            width: 100,
            renderer: function(v) {
                return Ext.util.Format.number(v, '0,000');;
            },
        }, {
            text: 'Tertagih',
            sortable: true,
            dataIndex: 'paymen',
            width: 100,
            renderer: function(v) {
                return Ext.util.Format.number(v, '0,000');;
            },
        }, {
            text: 'Sisa',
            sortable: true,
            dataIndex: 'sisa',
            width: 100,
            renderer: function(v) {
                return Ext.util.Format.number(v, '0,000');;
            },
            summaryType: function(records) {
                var i = 0,
                    length = records.length,
                    total = 0,
                    record;

                for (; i < length; ++i) {
                    record = records[i];
                    total += record.get('sisa') * '1';
                }
                return total;
            },
        }],
        dockedItems: [{
            xtype: 'pagingtoolbar',
            displayInfo: true,
            dock: 'bottom',
            /*store: ar001.historyData*/
        }],
    };


    ar001.view = {
        xtype: 'tabpanel',
        layout: 'card',
        items: [ar001.filterForm, ar001.bigdata]
    };


    RAR.getCmp('tab.ar001').add([ar001.view]);
    RAR.getCmp('tbar.ar001').add([]);
</script>
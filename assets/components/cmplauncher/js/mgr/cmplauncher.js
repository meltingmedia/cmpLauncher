var cmpLauncher = function(config) {
    config = config || {};
    cmpLauncher.superclass.constructor.call(this,config);
};
Ext.extend(cmpLauncher,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('cmplauncher',cmpLauncher);

cmpLauncher = new cmpLauncher();

cmpLauncher.window.CMP = function(config) {
    config = config || {};
    this.ident = config.ident || 'cmpLaunch'+Ext.id();
    Ext.applyIf(config,{
        //title: 'CMP'
        header: false
        ,headerAsText: false
        ,id: this.ident
        ,defaults: {
            bodyStyle: 'padding: 5px'
            ,hideLabel: true
            //,labelWidth: 0
        }
        ,height: 180
        ,minHeight: 180
        ,layout: 'fit'
        ,width: 120
        ,minWidth: 120
        ,collapsed: true
        ,titleCollapse: true
        ,expandOnShow: false
        ,maximizable: false
        //,resizable: false
        ,closable: false
        /*,items: [{
            html: config.content
        }]*/
        ,buttons: []
        ,fields: [{
            xtype: 'statictextfield'
            ,value: config.content
            ,height: 20
            ,width: 50
            ,hideLabel: true
        }]
        ,tools: [{
            id: 'help'
            ,handler: function() {
                MODx.msg.alert(
                    _('help')
                    ,'The content (or some part of it) is managed via a component<br />' +
                    '<p style="text-align: center">"'+config.cmp+'"</p>You can access it directly by clicking the button on the bottom of the window.');
            }
        }]
        ,buttons: []
        ,bbar: ['->',{
            text: config.cmp
            ,handler: function() {
                location.href = 'index.php?a='+config.action
            }
        }]
    });
    cmpLauncher.window.CMP.superclass.constructor.call(this,config);
};
Ext.extend(cmpLauncher.window.CMP,MODx.Window);
Ext.reg('cmplauncher-window-cmp',cmpLauncher.window.CMP);
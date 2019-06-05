    <script type = "text/javascript">

        // Creation of data model
        Ext.define('UserDataModel', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'userid', mapping : 'userid'},
                {name: 'name', mapping : 'name'},
                {name: 'email', mapping : 'email'},
                {name: 'education', mapping : 'education'},
                {name: 'city', mapping : 'city'}
            ]
        });

        Ext.define('EducationDataModel', {
            extend: 'Ext.data.Model',
            fields: [
                [ 'levelName', {name: 'id', type: 'int'}]
            ]
        });

        Ext.define('CityDataModel', {
            extend: 'Ext.data.Model',
            fields: [
                [ 'cityName', {name: 'id', type: 'int'}]
            ]
        });

         var educationData = Ext.create('Ext.data.Store', {
            storeId: 'educationData',
            model: 'EducationDataModel',
            proxy   : {
                type  : 'ajax',
                url   : '/users/load_education',
                method: "GET",
                reader: {
                    type: 'json',
                    data: 'data'
                }
            },
            autoLoad: true
        });

        var cityData = Ext.create('Ext.data.Store', {
            storeId: 'cityData',
            model: 'CityDataModel',
            proxy   : {
                type  : 'ajax',
                url   : '/users/load_city',
                method: "GET",
                reader: {
                    type: 'json',
                    data: 'data'
                }
            },
            autoLoad: true
        });


        var addUser = new Ext.Window({
            width : 500, //you set your width here
            height : 500, //set your height
            title : 'add user',
            modal : true,
            closeAction : 'hide',
            items   : [{
                xtype : 'form', //reference to the form
                layout: 'anchor',
                bodyStyle: {
                    background: 'none',
                    padding: '10px',
                    border: '0'
                },
                defaults: {
                    xtype : 'textfield',
                    anchor: '100%'
                },
                items : [{
                    name  : 'name',
                    fieldLabel: 'User Name'
                },{
                    name  : 'email',
                    fieldLabel: 'Email'
                },{
                    name  : 'level',
                    fieldLabel: 'Education',
                    xtype:'combo',
                    store : educationData,
                    queryMode: 'remote',
                    valueField : 'id',
                    displayField : 'level',
                    triggerAction : 'all',
                    typeAhead : true,
                    minChars : 1,
                    tabIndex:7,
                    forceSelection:true,
                    allowBlank : false
                },{
                    name  : 'City',
                    fieldLabel: 'City',
                    xtype: 'combo',
                    store : cityData,
                    queryMode: 'remote',
                    valueField : 'id',
                    displayField : 'name',
                    triggerAction : 'all',
                    typeAhead : true,
                    minChars : 1,
                    tabIndex:7,
                    forceSelection:true,
                    allowBlank : false
                }]
            }],
            buttons: [{
                text: 'OK',
                name: "Add",
                handler: function (button, e) {
                    var form = this.up('window').down('form');
                    var values = form.getValues();
                    Ext.Ajax.on('beforerequest', function(conn, options) {
                        Ext.Ajax.setDefaultHeaders({
                            'X-CSRF-TOKEN':stoken
                        });
                    });

                    Ext.Ajax.request({
                        url : '/users/create',
                        method    : 'POST',
                        jsonData  : values,
                        success   : function(response) {
                            var resp = Ext.JSON.decode(response.responseText);
                            Ext.Msg.show({
                                title : 'Confirmation',
                                msg   : 'Пользователь :'+resp+' создан',
                                width : 400,
                                buttons: Ext.Msg.OK,
                                fn    : function(btn) {
                                    if(btn == 'ok') {
                                        win.close();
                                    }
                                },
                            });
                        },
                        failure: function(response) {
                            Ext.Msg.alert('Failure', 'Failed to create User.');
                        }
                    });
                    this.up('window').close();

                }
            },{
                text   : 'Cancel',
                handler: function () {
                    this.up('window').close();
                }
            }]
        });


        Ext.onReady(function() {
            // Creation of first grid store
            var usersStore = Ext.create('Ext.data.Store', {
                storeId: 'usersStore',
                model: 'UserDataModel',
                proxy   : {
                    type  : 'ajax',
                    //obfuscate
                    url   : '/users/load_users',
                    //obfuscate
                    method: "GET",
                    reader: {
                        type: 'json',
                        data:'data'
                    }
                },
                autoLoad: true
            });

            // Creation of first grid
            Ext.create('Ext.grid.Panel', {
                id                : 'usersGrid',
                store             : usersStore,
                stripeRows        : true,
                title             : 'Users Grid',  // Title for the grid
                renderTo          :'gridDiv',         // Div id where the grid has to be rendered
                width             : 800,
                collapsible       : true,             // property to collapse grid
                enableColumnMove  :true,              // property which allows column to move to different position by dragging that column.
                enableColumnResize:true,        // property which allows to resize column run time.
                tbar              :
                [{ xtype: 'button', text: 'Add User', action  : 'add',
                    style: 'background-color: green',
                    handler: function() {
                         var form = addUser;
                         form.show();
                    }
                }],
                columns           :
                    [{
                        header: "User Name",
                        dataIndex: 'name',
                        id : 'name',
                        flex:  1,        // property defines the amount of space this column is going to take in the grid container with respect to all.
                        sortable: true,  // property to sort grid column data.
                        hideable: true   // property which allows column to be hidden run time on user request.
                    },{
                        header: "Email",
                        dataIndex: 'email',
                        flex: .5,
                        sortable: true,
                        hideable: false   
                    },{
                        header: "Education",
                        dataIndex: 'education',
                        flex: .5,
                        sortable: true,
                        hideable: false   
                    },{
                        header: "City",
                        dataIndex: 'city',
                        flex: .5,
                        sortable: true,
                    },{ header: 'Action', width: 50, xtype:'actioncolumn',
                        items : [{
                            icon    : 'images/delete.png',
                            tooltip : 'Delete',
                            handler : function(gView, rowIndex, colIndex) {
                                var grid = gView.up('grid');
                                var values = grid.getStore().getAt(rowIndex).data;
                                Ext.Msg.show({
                                    title : 'Confirmation',
                                    msg   : 'Удалить пользователя '+values.name+' ?',
                                    width : 400,
                                    buttons: Ext.Msg.OK,
                                    fn    : function(btn) {
                                        if(btn == 'ok') {
                                            Ext.Ajax.on('beforerequest', function(conn, options) {
                                                Ext.Ajax.setDefaultHeaders({
                                                    'X-CSRF-TOKEN':stoken
                                                });
                                            });

                                            Ext.Ajax.request({
                                                url : '/users/delete',
                                                method    : 'POST',
                                                jsonData  : values,
                                                success   : function(response) {
                                                },
                                                failure: function(response) {
                                                    Ext.Msg.alert('Failure', 'Failed to create User.');
                                                }
                                            });
                                            grid.getStore().load();
                                        }
                                    },
                                });
                            }
                        }]
                    }
                    ]
            });
        });
    </script>

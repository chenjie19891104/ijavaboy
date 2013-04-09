(function() {
    tinymce.create('tinymce.plugins.dropcap', {
        init : function(ed, url) {
            ed.addButton('dropcap', {
                title : 'Add a Dropcap',
                image : url+'/icons/dropcap_1.png',
                onclick : function() {
                     ed.selection.setContent('[dropcap]' + ed.selection.getContent() + '[/dropcap]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('dropcap', tinymce.plugins.dropcap);
	
	tinymce.create('tinymce.plugins.dropcap2', {
        init : function(ed, url) {
            ed.addButton('dropcap2', {
                title : 'Add a Dropcap 2',
                image : url+'/icons/dropcap_2.png',
                onclick : function() {
                     ed.selection.setContent('[dropcap2]' + ed.selection.getContent() + '[/dropcap2]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('dropcap2', tinymce.plugins.dropcap2);
	
	tinymce.create('tinymce.plugins.highlight', {
        init : function(ed, url) {
            ed.addButton('highlight', {
                title : 'Add a Highlight',
                image : url+'/icons/highlight.png',
                onclick : function() {
                     ed.selection.setContent('[highlight]' + ed.selection.getContent() + '[/highlight]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('highlight', tinymce.plugins.highlight);
	
	tinymce.create('tinymce.plugins.button', {
        init : function(ed, url) {
            ed.addButton('button', {
                title : 'Add a Button',
                image : url+'/icons/button.png',
                onclick : function() {
                     ed.selection.setContent('[button link="url"]' + ed.selection.getContent() + '[/button]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('button', tinymce.plugins.button);
	
	tinymce.create('tinymce.plugins.info', {
        init : function(ed, url) {
            ed.addButton('info', {
                title : 'Add a Info Notification',
                image : url+'/icons/info.png',
                onclick : function() {
                     ed.selection.setContent('[info]' + ed.selection.getContent() + '[/info]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('info', tinymce.plugins.info);
	
	tinymce.create('tinymce.plugins.warning', {
        init : function(ed, url) {
            ed.addButton('warning', {
                title : 'Add a Warning Notification',
                image : url+'/icons/warning.png',
                onclick : function() {
                     ed.selection.setContent('[warning]' + ed.selection.getContent() + '[/warning]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('warning', tinymce.plugins.warning);
	
	tinymce.create('tinymce.plugins.error', {
        init : function(ed, url) {
            ed.addButton('error', {
                title : 'Add a Error Notification',
                image : url+'/icons/error.png',
                onclick : function() {
                     ed.selection.setContent('[error]' + ed.selection.getContent() + '[/error]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('error', tinymce.plugins.error);
	
	tinymce.create('tinymce.plugins.success', {
        init : function(ed, url) {
            ed.addButton('success', {
                title : 'Add a Success Notification',
                image : url+'/icons/check.png',
                onclick : function() {
                     ed.selection.setContent('[success]' + ed.selection.getContent() + '[/success]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('success', tinymce.plugins.success);
	
	tinymce.create('tinymce.plugins.note', {
        init : function(ed, url) {
            ed.addButton('note', {
                title : 'Add a Note Notification',
                image : url+'/icons/note.png',
                onclick : function() {
                     ed.selection.setContent('[note]' + ed.selection.getContent() + '[/note]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('note', tinymce.plugins.note);
	
	tinymce.create('tinymce.plugins.download', {
        init : function(ed, url) {
            ed.addButton('download', {
                title : 'Add a Download Notification',
                image : url+'/icons/download.png',
                onclick : function() {
                     ed.selection.setContent('[download]' + ed.selection.getContent() + '[/download]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('download', tinymce.plugins.download);
	
	tinymce.create('tinymce.plugins.divider', {
        init : function(ed, url) {
            ed.addButton('divider', {
                title : 'Add a Divider',
                image : url+'/icons/divider.png',
                onclick : function() {
                     ed.selection.setContent('[divider]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('divider', tinymce.plugins.divider);
	
	tinymce.create('tinymce.plugins.singlecol', {
        init : function(ed, url) {
            ed.addButton('singlecol', {
                title : 'Add a Single Column',
                image : url+'/icons/singlecol.png',
                onclick : function() {
                     ed.selection.setContent('[singlecol]' + ed.selection.getContent() + '[/singlecol]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('singlecol', tinymce.plugins.singlecol);
	
	tinymce.create('tinymce.plugins.singlecol_last', {
        init : function(ed, url) {
            ed.addButton('singlecol_last', {
                title : 'Add a Single Column - Last',
                image : url+'/icons/singlecol_last.png',
                onclick : function() {
                     ed.selection.setContent('[singlecol_last]' + ed.selection.getContent() + '[/singlecol_last]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('singlecol_last', tinymce.plugins.singlecol_last);
	
	tinymce.create('tinymce.plugins.onethirdcol', {
        init : function(ed, url) {
            ed.addButton('onethirdcol', {
                title : 'Add a One Third Column',
                image : url+'/icons/onethird.png',
                onclick : function() {
                     ed.selection.setContent('[onethirdcol]' + ed.selection.getContent() + '[/onethirdcol]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('onethirdcol', tinymce.plugins.onethirdcol);
	
	tinymce.create('tinymce.plugins.onethirdcol_last', {
        init : function(ed, url) {
            ed.addButton('onethirdcol_last', {
                title : 'Add a One Third Column - Last',
                image : url+'/icons/onethird_last.png',
                onclick : function() {
                     ed.selection.setContent('[onethirdcol_last]' + ed.selection.getContent() + '[/onethirdcol_last]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('onethirdcol_last', tinymce.plugins.onethirdcol_last);
	
	tinymce.create('tinymce.plugins.twocol', {
        init : function(ed, url) {
            ed.addButton('twocol', {
                title : 'Add a Two Column',
                image : url+'/icons/twocol.png',
                onclick : function() {
                     ed.selection.setContent('[twocol]' + ed.selection.getContent() + '[/twocol]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('twocol', tinymce.plugins.twocol);
	
	tinymce.create('tinymce.plugins.twocol_last', {
        init : function(ed, url) {
            ed.addButton('twocol_last', {
                title : 'Add a Two Column - Last',
                image : url+'/icons/twocol_last.png',
                onclick : function() {
                     ed.selection.setContent('[twocol_last]' + ed.selection.getContent() + '[/twocol_last]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('twocol_last', tinymce.plugins.twocol_last);
	
	tinymce.create('tinymce.plugins.twothirdcol', {
        init : function(ed, url) {
            ed.addButton('twothirdcol', {
                title : 'Add a Two Third Column',
                image : url+'/icons/twothird.png',
                onclick : function() {
                     ed.selection.setContent('[twothirdcol]' + ed.selection.getContent() + '[/twothirdcol]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('twothirdcol', tinymce.plugins.twothirdcol);
	
	tinymce.create('tinymce.plugins.twothirdcol_last', {
        init : function(ed, url) {
            ed.addButton('twothirdcol_last', {
                title : 'Add a Two Third Column - Last',
                image : url+'/icons/twothird_last.png',
                onclick : function() {
                     ed.selection.setContent('[twothirdcol_last]' + ed.selection.getContent() + '[/twothirdcol_last]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('twothirdcol_last', tinymce.plugins.twothirdcol_last);
	
	tinymce.create('tinymce.plugins.threecol', {
        init : function(ed, url) {
            ed.addButton('threecol', {
                title : 'Add a Three Column',
                image : url+'/icons/threecol.png',
                onclick : function() {
                     ed.selection.setContent('[threecol]' + ed.selection.getContent() + '[/threecol]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('threecol', tinymce.plugins.threecol);
	
	tinymce.create('tinymce.plugins.threecol_last', {
        init : function(ed, url) {
            ed.addButton('threecol_last', {
                title : 'Add a Three Column - Last',
                image : url+'/icons/threecol_last.png',
                onclick : function() {
                     ed.selection.setContent('[threecol_last]' + ed.selection.getContent() + '[/threecol_last]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('threecol_last', tinymce.plugins.threecol_last);
	
	tinymce.create('tinymce.plugins.fourcol', {
        init : function(ed, url) {
            ed.addButton('fourcol', {
                title : 'Add a Four Column',
                image : url+'/icons/fourcol.png',
                onclick : function() {
                     ed.selection.setContent('[fourcol]' + ed.selection.getContent() + '[/fourcol]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('fourcol', tinymce.plugins.fourcol);
})();
<?php 
	$eid = AppKitRandomUtil::genSimpleId(10, 'principaledit-');
	
	// Principal admin model from the view
	$pa =& $t['pa'];
	
	$pid = $rd->getParameter('principal');
	
	// var_dump($pa->getSelectedValues($pid));
?>
<div id="<?php echo $eid; ?>"></div>
<script type="text/javascript">

(function() {

	var PrincnipalEdit = function() {

		var panel = undefined;
		
		var eid = '<?php echo $eid?>'; 

		var targets = <?php echo json_encode($pa->getTargetArray()); ?>;
		
		var selected = <?php echo json_encode($pa->getSelectedValues($pid)); ?>;
		
		var pub = {
			getMenuItems : function() {
				var menu = [];
				Ext.iterate(targets, function(k, v) {
					menu.push({
						text: v.name,
						iconCls: 'silk-key',
						handler: function(b,e) {
						PrincnipalEdit.addHandler(v.name);
						}
					});
				});
				return menu;
			},

			buildPanel : function() {
				panel = new Ext.Panel({
					renderTo: eid,
					layout: 'form',
					width: 400,
					bodyStyle: 'padding: 2px 2px 2px 2px',
					tbar: [{
						text: '<?php echo $tm->_("add"); ?>',
						iconCls: 'silk-add',
						menu: this.getMenuItems(),
					}],

					defaults: {
						border: false
					},

					items: [{ height: 1 }]
				});
				
				panel.doLayout();

				// Fill the panel with the defaults
				Ext.iterate(selected, function(tname,tva) {
					
					if (Ext.isObject(tva)) {
						Ext.iterate(tva, function(index, item) {
							this.addHandler(tname, item);
						}, this);
					}
					
				}, this);
				return true;
			},

			addHandler : function(name, selected) {

				if (selected == undefined) {
					selected = {};
				}

				var aItems = [{
					'xtype': 'label',
					'text': name
				}];

				var fields = targets[name].fields;
				
				aItems.push({
					xtype: 'hidden',
					name: 'principal_target[' + targets[name].id + '][set][]',
					value: 1
				});
				
				aItems.push({
					xtype: 'hidden',
					name: 'principal_target[' + targets[name].id + '][name][]',
					value: name
				});
				
				Ext.iterate(fields, function(k, v) {
					var val = "";
					
					if (selected[k]) {
						val = selected[k];
					}
					
					aItems.push({
						xtype: 'textfield',
						fieldLabel: k,
						name: 'principal_value[' + targets[name].id + '][' + k + '][]',
						value: val
					});
				});
				
				var np = new Ext.Panel({
					layout: 'hbox',
					bodyStyle: 'padding: 2px 2px 2px 2px',
					items: [{
						xtype: 'button',
						iconCls: 'silk-cross',
						handler: function(b, e) {
							var p = b.findParentByType('panel');
							if (p) {
								p.destroy();
							}
						}
					}, {
						layout: 'form',
						width: 380,
						labelWidth: 100,
						bodyStyle: 'padding: 2px 2px 2px 2px',
						border: false,
						items: aItems
					}]
				});

				panel.add(np);
				panel.doLayout();
				np.doLayout();
			}
		}

		return pub;
		
	}();
	
	PrincnipalEdit.buildPanel();
})();

</script>
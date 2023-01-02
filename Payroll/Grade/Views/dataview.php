<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div data-options="region:'center'" title="" style="overflow:auto;padding:1px">
	<table id="dg" class="easyui-datagrid" style="width:<?=!@$isMobile?'auto':'1024px'?>;height:500px" 		
		data-options="idField:'id', toolbar:'#toolbar', url:'<?=current_url()?>/get_data', queryParams:{<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},
            pagination:true, rownumbers:true, fitColumns:true, singleSelect:true">
		<thead>
			<tr>
				<th field="ck" checkbox="true"></th>
				<th field="name" width="150" sortable="true">Name</th>
				<th field="description">Description</th>
				<th field="base_sallary_">Base Sallary</th>
				<th field="ic_prorate">Prorate(Yes/No)</th>
				<th field="component_plus_" width="400">Allowances</th>
				<th field="component_minus_" width="400">Deductions</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div style="margin-bottom:5px">
			<?=$perm['c']==='1'?'<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="newData()"><i class="fas fa-plus"></i> New Data</a>':''?>
			<?=$perm['u']==='1'?'<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="editData()"><i class="fas fa-edit"></i> Edit Data</a>':''?>
			<?=$perm['d']==='1'?'<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="destroyData()"><i class="fas fa-minus"></i> Remove Data</a>':''?>
		</div>
		<div class="search-box">
			<table>
				<tr>
					<td>Name</td>
					<td><?=easyui_textbox(['id'=>'sname','name'=>'sname'])?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="doSearch()"><i class="fas fa-search"></i> Search</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearSearch()"><i class="fas fa-sync"></i> Reset</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:<?=@$isMobile?'auto':'600px'?>;height:350px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<form id="fm" method="POST" novalidate>
			<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
			<div class="fitem">
				<label>Name:</label>
				<?=easyui_textbox(['name'=>'name','required'=>true])?>
			</div>
			<div class="fitem">
				<label>Description:</label>
				<?=easyui_textarea(['name'=>'description'])?>
			</div>
			<div class="fitem">
				<label>Base Sallary:</label>
				<?=easyui_textbox(['name'=>'base_sallary'])?>
			</div>
			<div class="fitem">
				<label>Prorate?:</label>
				<input type="checkbox" name="prorate" value="1" />
			</div>
			<h6>Allowance</h6>
			<hr/>
			<?php
			$labeles=$db->query('select label from payrollcomponents WHERE `plus`=1 GROUP BY label');
			foreach($labeles->getResultArray()as $label){
				$components=$db->table('payrollcomponents')->getWhere(array('label'=>$label['label']));
				if($components->getNumRows()>0){
					echo '<div class="fitem">';
					echo '<label>'.$label['label'].'</label>:&nbsp;';
					echo '<select class="easyui-combobox" name="'.easyui_clearstr($label['label']).'">';
					echo '<option value="0">---</option>';
					foreach($components->getResultArray()as $component){
						echo '<option value="'.$component['id'].'">'.$component['name'].'</option>';
					}
					echo '</select>';
					echo '</div>';
				}
			}
			?>
			<br/>
			<h6>Deduction</h6>
			<hr/>
			<?php
			$labeles=$db->query('select label from payrollcomponents WHERE `plus`=0 GROUP BY label');
			foreach($labeles->getResultArray()as $label){
				$components=$db->table('payrollcomponents')->getWhere(array('label'=>$label['label']));
				if($components->getNumRows()>0){
					echo '<div class="fitem">';
					echo '<label>'.$label['label'].'</label>:&nbsp;';
					echo '<select class="easyui-combobox" name="'.easyui_clearstr($label['label']).'">';
					echo '<option value="0"></option>';
					foreach($components->getResultArray()as $component){
						echo '<option value="'.$component['id'].'">'.$component['name'].'</option>';
					}
					echo '</select>';
					echo '</div>';
				}
			}
			?>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData()">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('extra-css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/bootstrap/easyui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/color.css">
<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>
<script type="text/javascript" src="<?=base_url()?>/plugins/easyui/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/plugins/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">
	var csrfName = $('.txt_csrfname').attr('name');
	var csrfHash = $('.txt_csrfname').val();
	var url;
	var method;
	function doSearch(){
		$('#dg').datagrid('load',{
			[csrfName]: csrfHash,
			sname: $('#sname').val(),
		});
	}
	function clearSearch(){
		location.reload();
	}
	function newData(){	
		$('#dlg').dialog('open').dialog('setTitle','New <?=$title?>');
		$('#fm').form('clear');
		url = '<?=current_url();?>';
		method='POST';
	}
	function editData(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Edit <?=$title?>');
			$('#fm').form('clear');	
			$('#fm').form('load',row);
			url = '<?=current_url();?>/'+row.ck;
			method='PUT';
		}
	}
	function saveData(){
		var result;
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(param){
				param[csrfName]=csrfHash;
				if(method=='PUT'){
					param._method='PUT';
				}
				return $(this).form('validate');
			},
			success: function(result){
				result = eval('('+result+')');
				if (result.success===false){
					var message="";
					Object.values(result.errorMessages).forEach(val => {
						message+=val+"<br>";
					});
					$.messager.show({
						title: 'Error',
						msg: message
					});
				} else {
					$('#dlg').dialog('close');
					$('#dg').datagrid('reload');
				}
			}
		});
	}
	function destroyData(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Are you sure you want to destroy this <?=$title?>?',function(r){
				if (r){
					$.post('<?=current_url();?>/'+row.id,{_method:'DELETE',[csrfName]:csrfHash},function(result){
						if (result.success){
							$('#dg').datagrid('reload');
						} else {
							$.messager.show({
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'json');
				}
			});
		}
	}
</script>
<?= $this->endSection() ?>
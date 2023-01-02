<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div data-options="region:'center'" title="" style="overflow:auto;padding:1px">
	<table id="dg" class="easyui-datagrid" style="width:<?=!@$isMobile?'auto':'1024px'?>;height:500px" 		
		data-options="idField:'id', toolbar:'#toolbar', url:'<?=current_url()?>/get_data', queryParams:{<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},
            pagination:true, rownumbers:true, fitColumns:true, singleSelect:true">
		<thead>
			<tr>
				<th field="ck" checkbox="true"></th>
				<th field="eid_number">E-ID</th>
				<th field="fullname" width="150px" sortable="true">Name</th>
				<th field="base_sallary_" sortable="true">Base Sallary</th>
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
					<td>EID</td><td><?=easyui_textbox(array('id'=>'seid_number','name'=>'seid_number'))?></td>
					<td>Fullname</td><td><?=easyui_textbox(array('id'=>'sfullname','name'=>'sfullname'))?></td>
					<td>Department</td><td><?=easyui_department(array('id'=>'sdepartment_id','name'=>'sdepartment_id'))?></td>
					<td>Branch</td><td><?=easyui_branch(array('id'=>'sbranch_id','name'=>'sbranch_id'))?></td>
				</tr>
				<tr>
					<td>Jobtitle</td><td><?=easyui_jobtitle(array('id'=>'sjobtitle_id','name'=>'sjobtitle_id'))?></td>
					<td>Grade</td><td><?=easyui_grade(array('id'=>'sgrade_id','name'=>'sgrade_id'))?></td>
					<td>Status</td><td><?=easyui_employment_status(array('id'=>'semployment_status_id'))?></td>
					<td>Project</td><td><?=easyui_project(array('id'=>'sproject_id'))?></td>
				</tr>
				<tr>
					<td>Type</td><td><?=easyui_combobox_option(array('label'=>'TAG_HISTORY','id'=>'stag_history'))?></td>
					<td>Start Date</td><td><?=easyui_datebox(array('id'=>'fdate','name'=>'fdate'))?> to <?=easyui_datebox(array('id'=>'ldate','name'=>'ldate'))?></td>
					<td colspan=2>
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="doSearch()"><i class="fas fa-search"></i> Search</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearSearch()"><i class="fas fa-sync"></i> Reset</a>
						<?php if($perm['excel']==1){?>
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="toXls()"><i class="fas fa-file-excel-o"></i>&nbsp;&nbsp;Export Excel</a>
						<?php }?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:<?=@$isMobile?'auto':'600px'?>;height:350px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<form id="fm" method="POST" novalidate>
			<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
			<div class="fitem">
				<label class="fitem">Name:</label>
				<?=easyui_textbox(array('id'=>'ffullname','name'=>'fullname','width'=>'170px','required'=>true,'readonly'=>true))?>&nbsp;
				<a href="javascript:void(0)" class="btnEmp easyui-linkbutton" iconCls="icon-search" onclick="openEmp()"></a>
				<input id="femployee_id" type="hidden" name="employee_id">
			</div>
			<div class="fitem">
				<label>Base Sallary:</label>
				<?=easyui_moneybox(['name'=>'base_sallary'])?>
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
<?=view('\Modules\Employee\Views\employeelist')?>
<?= $this->endSection() ?>
<?= $this->section('extra-css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/bootstrap/easyui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/color.css">
<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>
<script type="text/javascript" src="<?=base_url()?>/plugins/easyui/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/plugins/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/plugins/ext/datebox-ymd.js"></script>
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
					$.post('<?=current_url();?>/'+row.employee_id,{_method:'DELETE',[csrfName]:csrfHash},function(result){
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

	//employee search
	function doSearch2(){
		var sis_all;
		if($('#sis_all2').is(":checked")){
			sis_all=1;
		}else{
			sis_all=0;
		}
		$('#dg_employee').datagrid('load',{
			[csrfName]: csrfHash,
			seid_number: $('#seid_number2').val(),
			sfullname: $('#sfullname2').val(),
			sbranch_id: $('#sbranch_id2').combobox('getValue'),
			sdepartment_id: $('#sdepartment_id2').combobox('getValue'),
			sjobtitle_id: $('#sjobtitle_id2').combobox('getValue'),
			sgrade_id: $('#sgrade_id2').combobox('getValue'),
			semployment_status_id: $('#semployment_status_id2').combobox('getValue'),
			sproject_id: $('#sproject_id2').combobox('getValue'),
			sis_all: sis_all,
		});
	}
	function openEmp(){
		$('#dlg_employee').dialog('open').dialog('setTitle','Employee');
	}
	function selectEmp(){
		var row = $('#dg_employee').datagrid('getSelected');
		$('#ffullname').textbox('setValue',row.fullname);
		$('#femployee_id').val(row.employee_id);		
		$('#dlg_employee').dialog('close');
	}
	function toXls(){
		$('#fs').form('submit');
	}
</script>
<?= $this->endSection() ?>
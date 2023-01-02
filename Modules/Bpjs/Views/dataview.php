<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div data-options="region:'center'" title="" style="overflow:auto;padding:1px">
	<table id="dg" class="easyui-datagrid" style="width:<?=!@$isMobile?'auto':'1024px'?>;height:500px" 		
		data-options="idField:'id', toolbar:'#toolbar', url:'<?=current_url()?>/get_data', queryParams:{<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},
            pagination:true, rownumbers:true, fitColumns:true, singleSelect:true">
		<thead>
			<tr>
				<th field="ck" checkbox="true"></th>
				<th field="eid_number">Number</th>
				<th field="fullname" width="100" sortable="true">Name</th>
				<th field="branch_name">Branch Name</th>
				<th field="project_name">Project Name</th>
				<th field="card_number">KS Card Number</th>
				<th field="register_date">KS Register Date</th>
				<th field="bpjstk_card_number">TK Card Number</th>
				<th field="bpjstk_register_date">TK Register Date</th>
				<th field="ic_download"><i class="fas fa-paperclip"></i></th>
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
					<td>Department</td><td><?=easyui_department(array('id'=>'sbranch_id','name'=>'sbranch_id'))?></td>
				</tr>
				<tr>
					<td>Branch</td><td><?=easyui_branch(array('id'=>'sbranch_id','name'=>'sbranch_id'))?></td>
					<td>Jobtitle</td><td><?=easyui_jobtitle(array('id'=>'sjobtitle_id','name'=>'sjobtitle_id'))?></td>
					<td>Grade</td><td><?=easyui_grade(array('id'=>'sgrade_id','name'=>'sgrade_id'))?></td>
				</tr>
				<tr>
					<td>Project</td><td><?=easyui_project(array('id'=>'sproject_id'))?></td>
					<td>Status</td><td><?=easyui_employment_status(array('id'=>'semployment_status_id'))?></td>
					<td>Start Date</td><td><?=easyui_datebox(array('id'=>'fdate','name'=>'fdate'))?> to <?=easyui_datebox(array('id'=>'ldate','name'=>'ldate'))?>
					&nbsp;
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
	<div id="dlg" class="easyui-dialog" style="width:<?=@$isMobile?'auto':'700px'?>;height:600px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<form id="fm" method="POST" enctype="multipart/form-data" novalidate>
			<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
			<div class="fitem">
				<label class="fitem">Nama:</label>
				<?=easyui_textbox(array('id'=>'ffullname','name'=>'fullname','width'=>'170px','required'=>true,'readonly'=>true))?>&nbsp;
				<a href="javascript:void(0)" class="btnEmp easyui-linkbutton" iconCls="icon-search" onclick="openEmp()"></a>
				<input id="femployee_id" type="hidden" name="employee_id">
			</div>
			<hr/>
			<b>BPJS Kesehatan</b>
			<div class="fitem">
				<label>Number:</label>
				<?=easyui_numberbox(array('name'=>'card_number','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Register Date:</label>
				<?=easyui_datebox(array('name'=>'register_date'))?>
			</div>
			<hr/>
			<table>
				<?php
				$siblings=$db->query("select `option` FROM options WHERE label='SIBLING' AND `option` NOT IN('Mother','Father')");
				foreach($siblings->getResultArray()as $sibling){
					echo '<tr>
						<td>&nbsp;<strong>'.$sibling['option'].'</strong></td>
						<td>&nbsp;'.easyui_textbox(['name'=>"fullname_".easyui_clearstr($sibling['option']),'id'=>"fullname_".easyui_clearstr($sibling['option']),'prompt'=>'Fullname','readonly'=>true]).'</td>
						<td>&nbsp;'.easyui_numberbox(['name'=>"card_number_".easyui_clearstr($sibling['option']),'prompt'=>'Number']).'</td>
						<td>&nbsp;'.easyui_datebox_birth(['name'=>"register_date_".easyui_clearstr($sibling['option']),'prompt'=>'Reg. Date']).'</td>
					</tr>';
				}
				?>
			</table>
			<hr/>
			<b>BPJS Tenaga Kerja</b>
			<div class="fitem">
				<label>Number:</label>
				<?=easyui_numberbox(array('name'=>'bpjstk_card_number'))?>
			</div>
			<div class="fitem">
				<label>Register Date:</label>
				<?=easyui_datebox(array('name'=>'bpjstk_register_date'))?>
			</div>
			<hr/>
			<div class="fitem">
				<label>Receipn:</label>
				<input name="userfile" class="easyui-filebox" style="width:200px">
			</div>
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
			seid_number: $('#seid_number').val(),
			sfullname: $('#sfullname').val(),
			sbranch_id: $('#sbranch_id').combobox('getValue'),
			sdepartment_id: $('#sdepartment_id').combobox('getValue'),
			sjobtitle_id: $('#sjobtitle_id').combobox('getValue'),
			sgrade_id: $('#sgrade_id').combobox('getValue'),
			semployment_status_id: $('#semployment_status_id').combobox('getValue'),
			sproject_id: $('#sproject_id').combobox('getValue'),
			fdate: $('#fdate').datebox('getValue'),
			ldate: $('#ldate').datebox('getValue')
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
		<?php foreach($siblings->getResultArray()as $sibling){?>
			$.post('<?=current_url();?>/getsiblingfullname/'+row.id,{_method:'POST',[csrfName]:csrfHash,'sibling':'<?=$sibling['option']?>'},function(result){
				if (result.success){
					$('#fullname_<?=easyui_clearstr($sibling['option'])?>').textbox('setValue',result.fullname);
				}
			},'json');
		<?php }?>
		$.post('<?=current_url();?>/getbpjstk/'+row.id,{_method:'POST',[csrfName]:csrfHash},function(result){
			if (result.success){
				$('#bpjstk_card_number').textbox('setValue',result.card_number);
				$('#bpjstk_register_date').textbox('setValue',result.register_date);
			}
		},'json');
		$('#dlg_employee').dialog('close');
	}
	function toXls(){
		$('#fs').form('submit');
	}
</script>
<?= $this->endSection() ?>
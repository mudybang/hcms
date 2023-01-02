<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div data-options="region:'center'" title="" style="overflow:auto;padding:1px">
	<table id="dg" class="easyui-datagrid" style="width:<?=!@$isMobile?'auto':'1024px'?>;height:500px" 		
		data-options="idField:'id', toolbar:'#toolbar', url:'<?=current_url()?>/get_data', queryParams:{<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},
            pagination:true, rownumbers:true, fitColumns:true, singleSelect:true">
		<thead>
			<tr>
				<th field="ck" checkbox="true"></th>
				<th field="eid_number">Eid</th>
				<th field="fullname" width="100" sortable="true">Name</th>
				<th field="tag_history">Tag</th>
				<th field="number">Number</th>
				<th field="start_date">Start</th>				
				<th field="note">Note</th>
				<th field="branch_name">Branch</th>
				<th field="department_name">Dept.</th>
				<th field="jobtitle">Jobtitle</th>
				<th field="grade_name">Grade</th>
				<th field="project_name">Project</th>
				<th field="employee_status">Status</th>
				<th field="ic_draft">Draft</th>
				<th field="ic_signed">Signed</th>
				<th field="ic_download"><i class="fas fa-paperclip"></i></th>
				<th field="placement"><i class="fas fa-box"></i></th>
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
	<div id="dlg" class="easyui-dialog" style="width:<?=@$isMobile?'auto':'600px'?>;height:440px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<form id="fm" method="POST" enctype="multipart/form-data" novalidate>
			<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
			<div class="fitem">
				<label class="fitem">Name:</label>
				<?=easyui_textbox(array('id'=>'ffullname','name'=>'fullname','width'=>'170px','required'=>true,'readonly'=>true))?>&nbsp;
				<a href="javascript:void(0)" class="btnEmp easyui-linkbutton" iconCls="icon-search" onclick="openEmp()"></a>
				<input id="femployee_id" type="hidden" name="employee_id">
			</div>
			<div class="fitem">
				<label>Type:</label>
				<?=easyui_combobox_option(array('label'=>'TAG_HISTORY_R','name'=>'tag_history', 'required'=>true))?>
			</div>
			<div class="fitem">
				<label>Start Date:</label>
				<?=easyui_datebox(array('name'=>'start_date','id'=>'fstart_date','required'=>true))?>
			</div>			
			<div class="fitem">
				<label>Note :</label>
				<?=easyui_textarea(array('name'=>'note'))?>
			</div>
			<div class="fitem">
				<label>Branch:</label>
				<?=easyui_branch(array('name'=>'branch_id','id'=>'fbranch_id'))?>
			</div>
			<div class="fitem">
				<label>Department:</label>
				<?=easyui_department(array('name'=>'department_id','id'=>'fdepartment_id'))?>
			</div>
			<div class="fitem">
				<label>Jobtitle:</label>
				<?=easyui_jobtitle(array('name'=>'jobtitle_id','id'=>'fjobtitle_id'))?>
			</div>
			<div class="fitem">
				<label>Grade:</label>
				<?=easyui_grade(array('name'=>'grade_id','id'=>'fgrade_id'))?>
			</div>
			<div class="fitem">
				<label>Status:</label>
				<?=easyui_employment_status(array('name'=>'employment_status_id','id'=>'femployment_status_id'))?>
			</div>
			<div class="fitem">
				<label>Signed:</label>
				<input type="checkbox" name="signed" value="1" />
			</div>
			<div class="fitem">
				<label>Placement:</label>
				<?=easyui_textbox(array('name'=>'placement'))?>
			</div>
			<div class="fitem">
				<label>Attachment:</label>
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
			stag_history: $('#stag_history').combobox('getValue'),
			fdate: $('#fdate').datebox('getValue'),
			ldate: $('#ldate').datebox('getValue')
		});
	}
	function clearSearch(){
		location.reload();
	}
	function newData(){
		$(".btnEmp").show();
		$('#dlg').dialog('open').dialog('setTitle','New <?=$title?>');
		$('#fm').form('clear');
		url = '<?=current_url();?>';
		method='POST';
	}
	function editData(){
		$(".btnEmp").hide();
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
								msg: result.errorMessage
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
		$('#fstart_date').datebox('setValue',row.join_date);
		$('#femployee_id').val(row.employee_id);
		$('#fbranch_id').combobox('setValue',row.branch_id);
		$('#fdepartment_id').combobox('setValue',row.department_id);
		$('#fjobtitle_id').combobox('setValue',row.jobtitle_id);
		$('#fgrade_id').combobox('setValue',row.grade_id);
		$('#fproject_id').combobox('setValue',row.project_id);
		$('#femployment_status_id').combobox('setValue',row.employment_status_id);
		$('#dlg_employee').dialog('close');
	}
	function toXls(){
		$('#fs').form('submit');
	}
</script>
<?= $this->endSection() ?>
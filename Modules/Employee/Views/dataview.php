<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div data-options="region:'center'" title="" style="overflow:auto;padding:1px">
	<table id="dg" class="easyui-datagrid" style="width:<?=!@$isMobile?'auto':'1024px'?>;height:500px" 		
		data-options="idField:'id', toolbar:'#toolbar', url:'<?=current_url()?>/get_data', queryParams:{<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},
            pagination:true, rownumbers:true, fitColumns:true, singleSelect:true">
			<thead data-options="frozen:true">
            <tr>
				<th field="ck" checkbox="true"></th>
				<th field="img_profile" width="38" align="center"><i class=" fa-lg fas fa-user-circle"></i></th>
				<th field="eid_number" width="100" sortable="true">EID Number</th>
				<th field="fullname" width="150" sortable="true">Fullname</th>
            </tr>
        </thead>
		<thead>
			<tr>
				<th field="education_name">Education</th>
				<th field="attachment_" align="center">CV/Resume</i></th>
				<th field="ic_detail" align="center"><i class='fas fa-file'></i></th>
				<th field="join_date">Join Date</th>
				<th field="jobtitle">Jobtitle</th>
				<th field="grade_name">Grade</th>
				<th field="department_name">Department</th>
				<th field="branch_name">Branch</th>
				<th field="project_name">Project</th>
				<th field="gender">Gender</th>
				<th field="place_day_birth">Place, Birthday</th>
				<th field="marital_status">Marital Status</th>
				<th field="contact">Contact</th>
				<th field="address_">Address</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div style="margin-bottom:5px">
			<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="newData()"><i class="fas fa-plus"></i> New Data</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="editData()"><i class="fas fa-edit"></i> Edit Data</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="destroyData()"><i class="fas fa-minus"></i> Remove Data</a>
		</div>
		<div class="search-box">
			<table>
				<tr>
					<td>E-Ktp</td>
					<td><?=easyui_textbox(array('id'=>'sektp_number','name'=>'sektp_number'))?></td>
					<td>Fullname</td>
					<td><?=easyui_textbox(array('id'=>'sfullname','name'=>'sfullname'))?></td>
					<td>Education</td>
					<td><?=easyui_combobox_option(array('id'=>'seducation_level','name'=>'seducation_level','label'=>'EDUCATION_LEVEL'))?></td>
				</tr>
				<tr>
					<td>Department</td>
					<td><?=easyui_department(array('id'=>'sdepartment_id','name'=>'sdepartment_id'))?></td>
					<td>Jobtitle</td>
					<td><?=easyui_jobtitle(array('id'=>'sjobtitle_id','name'=>'sjobtitle_id'))?></td>
					<td>Grade</td>
					<td><?=easyui_grade(array('id'=>'sgrade_id','name'=>'sgrade_id'))?></td>
				</tr>
				<tr>
					<td>Branch</td>
					<td><?=easyui_branch(array('id'=>'sbranch_id','name'=>'sbranch_id'))?></td>
					<td>Project</td>
					<td><?=easyui_project(array('id'=>'sproject_id','name'=>'sproject_id'))?></td>
					<td>Eid Number</td>
					<td><?=easyui_textbox(array('id'=>'seid_number','name'=>'seid_number'))?></td>
				</tr>
				<tr>
					<td>Join Date</td>
					<td colspan=2><?=easyui_datebox(array('id'=>'fdate','name'=>'fdate'))?> to <?=easyui_datebox(array('id'=>'ldate','name'=>'ldate'))?></td>
					<td>Non Active&nbsp;<input type="checkbox" id="sis_all" name="sis_all" value="1"></td>
					<td colspan=4 align="right">
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Search</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" onclick="clearSearch()">Reset</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:<?=@$isMobile?'auto':'600px'?>;height:500px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<form id="fm" method="POST"  enctype="multipart/form-data" novalidate>
			<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
			<div class="fitem">
				<label>Photo:</label>
				<input class="easyui-filebox" name="userfile[0]" data-options="prompt:'Choose a jpg file'" style="width:200px;">
			</div>
			<div class="fitem">
				<label>E-KTP Number:</label>
				<?=easyui_textbox(array('name'=>'ektp_number','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Fullname:</label>
				<?=easyui_textbox(array('name'=>'fullname','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Gender:</label>
				<?=easyui_combobox_option(array('name'=>'gender','label'=>'GENDER','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Place, Day Birth:</label>
				<?=easyui_textbox(array('name'=>'place_birth','prompt'=>'Place','required'=>true))?>,&nbsp;
				<?=easyui_datebox_birth(array('name'=>'date_birth','prompt'=>'Day','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Religion:</label>
				<?=easyui_combobox_option(array('name'=>'religion','label'=>'RELIGION'))?>
			</div>
			<div class="fitem">
				<label>Address:</label>
				<?=easyui_textarea(array('name'=>'address','required'=>true))?>,&nbsp;
			</div>
			<div class="fitem">
				<label>&nbsp;</label>
				<?=easyui_textbox(array('name'=>'district','prompt'=>'Kelurahan','required'=>true))?>,&nbsp;
				<?=easyui_textbox(array('name'=>'village','prompt'=>'Kecamatan','required'=>true))?>
			</div>
			<div class="fitem">
				<label>City, Province:</label>
				<?=easyui_textbox(array('name'=>'city','prompt'=>'City','required'=>true))?>,&nbsp;
				<?=easyui_province(array('name'=>'province','prompt'=>'Province','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Postcode:</label>
				<?=easyui_numberbox(array('name'=>'postcode','prompt'=>'Postcode','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Marital Status:</label>
				<?=easyui_combobox_option(array('name'=>'marital_status','label'=>'MARITAL_STATUS','required'=>true))?>
			</div>
			<hr/>
			<div class="fitem">
				<label>Join Date:</label>
				<?=easyui_datebox(array('name'=>'join_date','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Department:</label>
				<?=easyui_department(array('name'=>'department_id','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Jobtitle, Grade:</label>
				<?=easyui_jobtitle(array('name'=>'jobtitle_id','required'=>true))?>&nbsp;
				<?=easyui_grade(array('name'=>'grade_id','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Branch, Project:</label>
				<?=easyui_branch(array('name'=>'branch_id','required'=>true))?>&nbsp;
				<?=easyui_project(array('name'=>'project_id'))?>
			</div>
			<div class="fitem">
				<label>Status:</label>
				<?=easyui_employment_status(array('name'=>'employment_status_id','required'=>true))?>
			</div>
			<hr/>
			<div class="fitem">
				<label>Contact:</label>
				<?=easyui_textbox(array('name'=>'email','prompt'=>'Email','required'=>true))?>,&nbsp;
				<?=easyui_textbox(array('name'=>'phone','prompt'=>'phone','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Education, Note:</label>
				<?=easyui_education(array('name'=>'education_id','required'=>true))?>,&nbsp;
			</div>
			<div class="fitem">
				<label>CV/Resume:</label>
				<input class="easyui-filebox" name="userfile[1]" data-options="prompt:'Choose a pdf file'" style="width:400px;">
			</div>
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
<script type="text/javascript" src="<?=base_url()?>/plugins/ext/datebox-ymd.js"></script>
<script type="text/javascript">
	var csrfName = $('.txt_csrfname').attr('name');
	var csrfHash = $('.txt_csrfname').val();
	var url;
	var method;
	function doSearch(){
		if($('#sis_all').is(":checked")){
			sis_all=1;
		}else{
			sis_all=0;
		}
		$('#dg').datagrid('load',{
			[csrfName]: csrfHash,
			sektp_number: $('#sektp_number').val(),
			sfullname: $('#sfullname').val(),
			seducation_level: $('#seducation_level').combobox('getValue'),
			sdepartment_id: $('#sdepartment_id').combobox('getValue'),
			sjobtitle_id: $('#sjobtitle_id').combobox('getValue'),
			sgrade_id: $('#sgrade_id').combobox('getValue'),
			sbranch_id: $('#sbranch_id').combobox('getValue'),
			sproject_id: $('#sproject_id').combobox('getValue'),
			seid_number: $('#seid_number').val(),
			fdate: $('#fdate').datebox('getValue'),
			ldate: $('#ldate').datebox('getValue'),
			sis_all: sis_all,
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
					if(result.warningMessages){
						var message="";
						Object.values(result.warningMessages).forEach(val => {
							message+=val+"<br>";
						});
						$.messager.show({
							title: 'Error',
							msg: message
						});
					}
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
<div id="dlg_employee" class="easyui-dialog" style="width:900px;height:493px;" closed="true" buttons="#dlg_employee-buttons">
	<table id="dg_employee" class="easyui-datagrid" style="width:<?=!$isMobile?'auto':'1024px'?>;height:513px"
		data-options="idField:'ck_employee', toolbar:'#toolbar_employee', url:'<?=base_url('employee/get_data')?>', queryParams:{<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},
            pagination:true, rownumbers:true, fitColumns:true, singleSelect:true">
		<thead>
			<tr>
				<th field="ck_employee" checkbox="true"></th>
				<th field="eid_number" width="100">E-Id</th>
				<th field="fullname" sortable="true" width="200">Fullname</th>
				<th field="jobtitle" width="100">Jobtitle</th>
				<th field="department_name" width="100">Department</th>
				<th field="branch_name" width="100">Branch</th>
				<th field="project_name" width="100">Project</th>
				<th field="employee_status" width="100">Status</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar_employee">
		<div class="search-box">
			<table>
				<tr>
					<td>EID</td><td><?=easyui_textbox(array('id'=>'seid_number2'))?></td>
					<td>Fullname</td><td><?=easyui_textbox(array('id'=>'sfullname2'))?></td>
					<td>Department</td><td><?=easyui_department(array('id'=>'sdepartment_id2'))?></td>
				</tr>
				<tr>
					<td>Branch</td><td><?=easyui_branch(array('id'=>'sbranch_id2'))?></td>
					<td>Jobtitle</td><td><?=easyui_jobtitle(array('id'=>'sjobtitle_id2'))?></td>
					<td>Grade</td><td><?=easyui_grade(array('id'=>'sgrade_id2'))?></td>
				</tr>
				<tr>
					<td>Project</td><td><?=easyui_project(array('id'=>'sproject_id2'))?></td>
					<td>Status</td><td><?=easyui_employment_status(array('id'=>'semployment_status_id2'))?></td>
					<td>Non Active <input style="width:20px;" type="checkbox" id="sis_all2" value=1></td>
					<td align="right" colspan=2><a href="javascript:void(0)" class="easyui-linkbutton" onclick="doSearch2()"><i class="fas fa-search"></i> Search</a></td>
				</tr>
			</table>
		</div>
	</div>
	<div id="dlg_employee-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="selectEmp()">Select</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_employee').dialog('close')">Cancel</a>
	</div>
</div>
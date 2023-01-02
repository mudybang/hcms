<?= $this->extend('dashboard') ?>
<?= $this->section('topmenu')?>
    <?= view('\Modules\Employee\Views\topmenu') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<form id="ff_history" method="post" enctype="multipart/form-data">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead class="bg-navy">
                    <tr>
                        <th><i class="fas fa-times"></i></th>
                        <th>Type</td>
                        <th>Start Date</td>
                        <th>Department</th>
                        <th>Jobtitle</th>
                        <th>Grade</th>
                        <th>Branch</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Attachment</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($histories as $history){
                    echo '<tr>
                        <td>
                            <a href="javascript:void(0)" onclick="deleteRow('.$history['id'].')">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                        <td>'.$history['tag_history'].'</td>
                        <td>'.$history['start_date'].'</td>
                        <td>'.$history['department_name'].'</td>
                        <td>'.$history['jobtitle'].'</td>
                        <td>'.$history['grade_name'].'</td>
                        <td>'.$history['branch_name'].'</td>
                        <td>'.$history['project_name'].'</td>
                        <td>'.$history['employment_status'].'</td>
                        <td>'.$history['note'].'</td>
                        <td>'.(isset($history['attachment'])&&file_exists(FCPATH.'/uploads/employees/history/'.$history['attachment'])?
                            '<a target="_blank" href="'.base_url("uploads/employees/history/".$history['attachment']).'" download="'.$edit['eid_number'].'_history">
                            <i class="fas fa-download"></i></a>':'--no-attachment--').
                        '</td>
                        
                    </tr>';
                }
                echo '<tr>
                        <td>&nbsp;</td>
                        <td>'.easyui_combobox_option(array('label'=>'TAG_HISTORY','name'=>'tag_history','required'=>true,'prompt'=>'Type','width'=>'100px')).'</td>
                        <td>'.easyui_datebox(array('name'=>'start_date','prompt'=>'Start Date','width'=>'100px')).'</td>
                        <td>'.easyui_department(array('name'=>'department_id','prompt'=>'Department','width'=>'150px','value'=>$edit['department_id'])).'</td>
                        <td>'.easyui_jobtitle(array('name'=>'jobtitle_id','prompt'=>'Jobtitle','width'=>'150px','value'=>$edit['jobtitle_id'])).'</td>
                        <td>'.easyui_grade(array('name'=>'grade_id','prompt'=>'Grade','width'=>'150px','value'=>$edit['grade_id'])).'</td>                        
                        <td>'.easyui_branch(array('name'=>'branch_id','prompt'=>'Branch','width'=>'150px','value'=>$edit['branch_id'])).'</td>
                        <td>'.easyui_project(array('name'=>'project_id','prompt'=>'Project','width'=>'150px','value'=>$edit['project_id'])).'</td>
                        <td>'.easyui_employment_status(array('name'=>'employment_status_id','prompt'=>'Project','width'=>'150px','value'=>$edit['employment_status_id'])).'</td>
                        <td>'.easyui_textarea(array('name'=>'note','prompt'=>'Note','width'=>'150px')).'</td>
                        <td><input name="userfile" class="easyui-filebox" data-options="prompt:\'JPG file...\'" style="width:200px"></td>
                    </tr>
                    <tr>
                        <td colspan="11">
                            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Save</a>
                        </td>
                    </tr>';
                ?>
                </tbody>
            </table>
        </div>
    </form>
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
<script>
    function submitForm(){
        $('#ff_history').form('submit', {
            url: '<?=base_url("employee/create_history/$employee_id")?>',
            success: function(data){
                var data = eval('(' + data + ')');
                if (data.success){
                    location.reload();
                }else{
                    $.messager.show({
                        title: 'Error',
                        msg: data.errorMessage
                    });
                }
            },
        });
    }
    function deleteRow(pk){
        $.messager.confirm('Confirm','Are you sure you want to destroy this row?',function(r){
			if (r){
				$.post('<?=base_url("employee/delete_history/$employee_id")?>',{id:pk,<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},function(result){
					if (result.success){
                        location.reload();
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
</script>
<?= $this->endSection() ?>
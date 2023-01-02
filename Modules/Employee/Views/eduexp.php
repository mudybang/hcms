<?= $this->extend('dashboard') ?>
<?= $this->section('topmenu')?>
    <?= view('\Modules\Employee\Views\topmenu') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<form id="ff_education" method="post">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <table class="table table-sm table-striped">
        <thead class="bg-navy">
            <tr><td colspan="6">Educations</td></tr>
            <tr>
                <th>Level</td>
                <th>Major</th>
                <th>Year</th>
                <th>Institution</th>
                <th>Certify Number</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($educations as $education){
            echo '<tr>
                <td>'.$education['label'].'</td>
                <td>'.$education['major'].'</td>
                <td>'.$education['year_graduate'].'</td>
                <td>'.$education['institution_name'].'</td>
                <td>'.$education['certification_number'].'</td>
                <td>
                    <a href="javascript:void(0)" onclick="deleteEducation('.$education['id'].')">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>';
        }
        echo '<tr>
                <td>'.easyui_education(array('name'=>'education_id','required'=>true,'prompt'=>'Level','width'=>'100px')).'</td>
                <td>'.easyui_textbox(array('name'=>'major','prompt'=>'Major')).'</td>
                <td>'.easyui_numberbox(array('name'=>'year_graduate','prompt'=>'Year','width'=>'65px')).'</td>
                <td>'.easyui_textbox(array('name'=>'institution_name','prompt'=>'Institution')).'</td>
                <td>'.easyui_textbox(array('name'=>'certification_number','prompt'=>'Cretify','width'=>'100px')).'</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFormEducation()" style="width:80px">Save</a>
                </td>
            </tr>';
        ?>
        </tbody>
    </table>
</form>
<form id="ff_experience" method="post">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <table class="table table-sm table-striped">
        <thead class="bg-navy">
            <tr><th colspan="8">Experiences</th></tr>
            <tr>
                <th>Company Name</td>
                <th>Jobtitle</th>
                <th>Start</th>
                <th>End</th>
                <th>Job Description</th>
                <th>Sallary</th>
                <th>Reason Leave</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($experiences as $experience){
            echo '<tr>
                <td>'.$experience['company_name'].'</td>
                <td>'.$experience['jobtitle'].'</td>
                <td>'.$experience['year_start'].'</td>
                <td>'.$experience['year_end'].'</td>
                <td>'.$experience['job_desc'].'</td>
                <td>'.number_format($experience['sallary']).'</td>
                <td>'.$experience['reason_leave'].'</td>
                <td>
                    <a href="javascript:void(0)" onclick="deleteExperience('.$experience['id'].')">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>';
        }
        echo '<tr>
                <td>'.easyui_textbox(array('name'=>'company_name','required'=>true,'prompt'=>'Company','width'=>'100px')).'</td>
                <td>'.easyui_textbox(array('name'=>'jobtitle','required'=>true,'prompt'=>'Jobtitle','width'=>'100px')).'</td>
                <td>'.easyui_numberbox(array('name'=>'year_start','prompt'=>'Start','width'=>'65px')).'</td>
                <td>'.easyui_numberbox(array('name'=>'year_end','prompt'=>'End','width'=>'65px')).'</td>
                <td>'.easyui_textarea(array('name'=>'job_desc','prompt'=>'Description')).'</td>
                <td>'.easyui_numberbox(array('name'=>'sallary','prompt'=>'Sallary','width'=>'100px')).'</td>
                <td>'.easyui_textbox(array('name'=>'reason_leave','prompt'=>'Reason Leave','width'=>'100px')).'</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFormExperience()" style="width:80px">Save</a>
                </td>
            </tr>';
        ?>
        </tbody>
    </table>
</form>
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
    function submitFormEducation(){
        $('#ff_education').form('submit', {
            url: '<?=base_url("employee/create_edu/$employee_id")?>',
            success: function(data){
                var data = eval('(' + data + ')');
                if (data.success){
                    location.href="<?=current_url()?>";
                }else{
                    $.messager.show({
                        title: 'Error',
                        msg: data.errorMsg
                    });
                }
            },
        });
    }
    function deleteEducation(pk){
        $.messager.confirm('Confirm','Are you sure you want to destroy this row?',function(r){
			if (r){
				$.post('<?=base_url("employee/delete_edu/$employee_id")?>',{id:pk,<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},function(result){
					if (result.success){
                        location.href="<?=current_url()?>";
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
    function submitFormExperience(){
        $('#ff_experience').form('submit', {
            url: '<?=base_url("employee/create_exp/$employee_id")?>',
            success: function(data){
                var data = eval('(' + data + ')');
                if (data.success){
                    location.href="<?=current_url()?>";
                }else{
                    $.messager.show({
                        title: 'Error',
                        msg: data.errorMsg
                    });
                }
            },
        });
    }
    function deleteExperience(pk){
        $.messager.confirm('Confirm','Are you sure you want to destroy this row?',function(r){
			if (r){
				$.post('<?=base_url("employee/delete_exp/$employee_id")?>',{id:pk,<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},function(result){
					if (result.success){
                        location.href="<?=current_url()?>";
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
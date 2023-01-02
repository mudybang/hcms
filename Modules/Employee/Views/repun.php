<?= $this->extend('dashboard') ?>
<?= $this->section('topmenu')?>
    <?= view('\Modules\Employee\Views\topmenu') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<form id="ff_reward" method="post" enctype="multipart/form-data">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <table class="table">
        <thead class="bg-navy">
            <tr>
                <th colspan="7">Rewards</th>
            </tr>
            <tr>
                <th>Title</td>
                <th>Date</th>
                <th>By </th>
                <th>Note</th>
                <th>Attachment</th>
                <th>&nbsp;X</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($rewards as $reward){
            echo '<tr>
                <td>'.$reward['title'].'</td>
                <td>'.$reward['given_date'].'</td>
                <td>'.$reward['given_by'].'</td>
                <td>'.$reward['description'].'</td>
                <td>'.(isset($reward['attachment'])&&file_exists(FCPATH.'/uploads/employees/reward/'.$reward['attachment'])?
                    '<a target="_blank" href="'.base_url("uploads/employees/reward/".$reward['attachment']).'" download="'.$eid_number.'_reward">
                    <i class="fas fa-download"></i></a>':'--no-attachment--').
                '</td>
                <td>
                    <a href="javascript:void(0)" onclick="deleteReward('.$reward['id'].')">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>';
        }
        echo '<tr>
                <td>'.easyui_textbox(array('name'=>'title','prompt'=>'Title','required'=>true)).'</td>
                <td>'.easyui_datebox(array('name'=>'given_date','prompt'=>'Date','width'=>'95px','required'=>true)).'</td>
                <td>'.easyui_textbox(array('name'=>'given_by','prompt'=>'Give By','required'=>true)).'</td>
                <td>'.easyui_textarea(array('name'=>'description','prompt'=>'Note','width'=>'300px')).'</td>
                <td><input class="easyui-filebox" name="userfile" data-options="prompt:\'image/pdf file\'" style="width:200px;"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFormReward()" style="width:80px">Save</a>
                </td>
            </tr>';
        ?>
        </tbody>
    </table>
</form>
<form id="ff_punishment" method="post" enctype="multipart/form-data">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <table class="table">
        <thead class="bg-navy">
            <tr>
                <th colspan="7">Punishment</th>
            </tr>
            <tr>
                <th>Title</td>
                <th>Date</th>
                <th>By</th>
                <th>Note</th>
                <th>Attachment</th>
                <th>&nbsp;X</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($punishments as $punishment){
            echo '<tr>
                <td>'.$punishment['title'].'</td>
                <td>'.$punishment['given_date'].'</td>
                <td>'.$punishment['given_by'].'</td>
                <td>'.$punishment['description'].'</td>
                <td>'.(isset($punishment['attachment'])&&file_exists(FCPATH.'/uploads/employees/punishment/'.$punishment['attachment'])?
                    '<a target="_blank" href="'.base_url("uploads/employees/punishment/".$punishment['attachment']).'" download="'.$eid_number.'_punishment">
                    <i class="fas fa-download"></i></a>':'--no-attachment--').
                '</td>
                <td>
                    <a href="javascript:void(0)" onclick="deletePunishment('.$punishment['id'].')">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>';
        }
        echo '<tr>
                <td>'.easyui_textbox(array('name'=>'title','prompt'=>'Title')).'</td>
                <td>'.easyui_datebox(array('name'=>'given_date','prompt'=>'Date','width'=>'95px')).'</td>
                <td>'.easyui_textbox(array('name'=>'given_by','prompt'=>'Give By')).'</td>
                <td>'.easyui_textarea(array('name'=>'description','prompt'=>'Note','width'=>'300px')).'</td>
                <td><input class="easyui-filebox" name="userfile" data-options="prompt:\'image/pdf file\'" style="width:200px;"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="7">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFormPunishment()" style="width:80px">Save</a>
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
    function submitFormReward(){
        $('#ff_reward').form('submit', {
            url: '<?=base_url("employee/create_reward/$employee_id")?>',
            success: function(data){
                var data = eval('(' + data + ')');
                if (data.success){
                    location.href="<?=current_url()?>";
                }else{
					$.messager.show({
						title: 'Error',
						msg: data.errorMessage
					});
                }
            },
        });
    }
    function deleteReward(pk){
        $.messager.confirm('Confirm','Are you sure you want to destroy this row?',function(r){
			if (r){
				$.post('<?=base_url("employee/delete_reward/$employee_id")?>',{id:pk,<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},function(result){
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
    function submitFormPunishment(){
        $('#ff_punishment').form('submit', {
            url: '<?=base_url("employee/create_punishment/$employee_id")?>',
            success: function(data){
                var data = eval('(' + data + ')');
                if (data.success){
                    location.href="<?=current_url()?>";
                }else{
                    $.messager.show({
						title: 'Error',
						msg: data.errorMessage
					});
                }
            },
        });
    }
    function deletePunishment(pk){
        $.messager.confirm('Confirm','Are you sure you want to destroy this row?',function(r){
			if (r){
				$.post('<?=base_url("employee/delete_punishment/$employee_id")?>',{id:pk,<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},function(result){
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
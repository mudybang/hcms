<?= $this->extend('dashboard') ?>
<?= $this->section('topmenu')?>
    <?= view('\Modules\Employee\Views\topmenu') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<form id="ff" method="post" enctype="multipart/form-data">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <table class="table table-sm table-striped">
        <thead class="bg-navy">
            <tr><td colspan="5">Sdps</td></tr>
            <tr>
                <th>Title</td>
                <th>Intitution</th>
                <th>Valid(date)</th>
                <th>Attachment</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($sdps as $sdp){
            echo '<tr>
                <td>'.$sdp['title'].'</td>
                <td>'.$sdp['institution_name'].'</td>
                <td>'.$sdp['expired_date'].'</td>
                <td>'.(isset($sdp['attachment'])&&file_exists(FCPATH.'/uploads/employees/sdp/'.$sdp['attachment'])?
                    '<a target="_blank" href="'.base_url("uploads/employees/punishment/".$sdp['attachment']).'" download="'.$eid_number.'_sdp">
                    <i class="fas fa-download"></i></a>':'--no-attachment--').
                '</td>
                <td>
                    <a href="javascript:void(0)" onclick="deleteRow('.$sdp['id'].')">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>';
        }
        echo '<tr>
                <td>'.easyui_sdp(array('name'=>'sdp_id','required'=>true,'prompt'=>'Name','width'=>'100px')).'</td>
                <td>'.easyui_textbox(array('name'=>'institution_name','prompt'=>'Institution')).'</td>
                <td>'.easyui_datebox(array('name'=>'validation_date_end','prompt'=>'Date','width'=>'100px')).'</td>
                <td><input class="easyui-filebox" name="userfile" data-options="prompt:\'image/pdf file\'" style="width:200px;"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Save</a>
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
    function submitForm(){
        $('#ff').form('submit', {
            url: '<?=base_url("employee/create_sdp/$employee_id")?>',
            success: function(data){
                var result = eval('(' + data + ')');
                if (result.success){
                    location.href="<?=current_url()?>";
                }else{
					$.messager.show({
						title: 'Error',
						msg: result.errorMessage
					});
                }
            },
        });
    }
    function deleteRow(pk){
        $.messager.confirm('Confirm','Are you sure you want to destroy this row?',function(r){
			if (r){
				$.post('<?=base_url("employee/delete_sdp/$employee_id")?>',{id:pk,<?= csrf_token(); ?>:'<?= csrf_hash(); ?>'},function(result){
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
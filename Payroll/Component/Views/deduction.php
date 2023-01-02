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
				<th field="label" width="150" sortable="true">Payslip Label</th>
				<th field="formula" width="150">Formula(E)</th>
				<th field="rp_value_" width="100" align="right">Value(E)</th>
				<th field="formula_bp" width="150">Formula(C)</th>
				<th field="rp_value_bp_" width="100" align="right">Value(C)</th>
				<th field="min_rp_value_" width="100" align="right">Min.</th>
				<th field="limit_base_value" width="100" align="right">Limit Base.</th>
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
			&nbsp;&nbsp;<span>Name</span>:
			<?=easyui_textbox(array('id'=>'sname','name'=>'sname'))?>
			&nbsp;&nbsp;<span>Label</span>:
			<?=easyui_textbox(array('id'=>'slabel','name'=>'slabel'))?>
			<a href="javascript:void(0)" class="easyui-linkbutton" onclick="doSearch()"><i class="fas fa-search"></i> Search</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearSearch()"><i class="fas fa-sync"></i> Reset</a>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:<?=@$isMobile?'auto':'600px'?>;height:350px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<form id="fm" method="POST" novalidate>
			<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
			<div class="fitem">
				<label>Name:</label>
				<?=easyui_textbox(array('name'=>'name','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Payslip Alias:</label>
				<?=easyui_textbox(array('name'=>'label','required'=>true))?>
			</div>
			<div class="fitem">
				<label>Formula(E):</label>
				<?=easyui_textbox(array('name'=>'formula'))?>
			</div>
			<div class="fitem">
				<label>Value(E):</label>
				<?=easyui_numberbox(array('name'=>'rp_value'))?>
			</div>
			<div class="fitem">
				<label>Formula(C):</label>
				<?=easyui_textbox(array('name'=>'formula_bp'))?>
			</div>
			<div class="fitem">
				<label>Value(C):</label>
				<?=easyui_numberbox(array('name'=>'rp_value_bp'))?>
			</div>
			<div class="fitem">
				<label>Min. Value:</label>
				<?=easyui_numberbox(array('name'=>'min_rp_value'))?>
			</div>
			<div class="fitem">
				<label>Limit Base Value:</label>
				<?=easyui_numberbox(array('name'=>'limit_base_value'))?>
				<i>Limiter percent from</i>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData()">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
</div>
<div class="text-secondary">
    <ul>
        <li>(E) Dipotong dari Penghasilan Pekerja.</li>
        <li>(C) Dibebankan ke Perusahaan.</li>
    </ul>
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
			slabel: $('#slabel').val(),
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
</script>
<?= $this->endSection() ?>
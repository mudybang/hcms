<?= $this->extend('dashboard') ?>
<?= $this->section('topmenu')?>
    <?= view('\Modules\Employee\Views\topmenu') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php if(!empty(session()->getFlashdata('message'))) : ?>
    <div class="alert alert-success text-xs">
        <?php echo session()->getFlashdata('message');?>
    </div>
<?php endif ?>
<?php if(!empty(session()->getFlashdata('errorMessage'))){
    foreach(session()->getFlashdata('errorMessage')as $message){?>
        <div class="alert alert-danger text-xs">
            <?=$message?>
        </div>
<?php }} ?>
<div class="easyui-panel" title="<?=$title?>" style="width:100%;padding:30px 60px;">
    <form id="ff" method="post">
        <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
        <div class="fitem">
            <label>EID Number:</label>
            <?=easyui_textbox(array('name'=>'eid_number','value'=>@$edit['eid_number'],'readonly'=>@$edit['eid_number']?true:false))?>
            <?=@$edit['eid_number']==''?'<input type="checkbox" name="is_generate_eid" value="1" />':''?>
        </div>
        <div class="fitem">
            <label>Join Date:</label>
            <?=@$edit['join_date']?>
        </div>
        <div class="fitem">
            <label>Branch:</label>
            <?=@$edit['branch_name']?>
        </div>
        <div class="fitem">
            <label>Jobtitle:</label>
            <?=@$edit['jobtitle']?>
        </div>
        <div class="fitem">
            <label>Project:</label>
            <?=@$edit['project_name']?>
        </div>
        <div class="fitem">
            <label>Department:</label>
            <?=@$edit['department_name']?>
        </div>
        <div class="fitem">
            <label>Grade:</label>
            <?=@$edit['grade_name']?>
        </div>
        <div class="fitem">
            <label>Status:</label>
            <?=@$edit['employee_status']?>
        </div>
        <br/>
        <h4>TAX</h4>
        <hr/>
        <div class="fitem">
            <label>NPWP Number:</label>
            <?=easyui_numberbox(array('name'=>'npwp_number','prompt'=>'Number','value'=>@$edit['npwp_number']))?>
        </div>
        <div class="fitem">
            <label>PTKP Code:</label>
            <?=easyui_ptkp(array('name'=>'ptkp_code','prompt'=>'Select','value'=>@$edit['ptkp_code']))?>
        </div>
        <br/>
        <h4>Bank</h4>
        <hr/>
        <div class="fitem">
            <label>Account Number:</label>
            <?=easyui_numberbox(array('name'=>'bank_account_number','prompt'=>'Account Number','value'=>@$edit['bank_account_number']))?>
        </div>
        <div class="fitem">
            <label>Account Name:</label>
            <?=easyui_textbox(array('name'=>'bank_account_name','prompt'=>'Account Name','value'=>@$edit['bank_account_name']))?>
        </div>
        <div class="fitem">
            <label>Bank Name:</label>
            <?=easyui_textbox(array('name'=>'bank_name','prompt'=>'Bank Name','value'=>@$edit['bank_name']))?>
        </div>
        <div style="text-align:center;padding:5px 0">
            <!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Save</a>-->
            <button  class="btn btn-primary">Save</button>
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
<?= $this->endSection() ?>
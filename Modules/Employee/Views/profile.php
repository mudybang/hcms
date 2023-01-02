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
<?php if(!empty(session()->getFlashdata('errorMessages'))){
    foreach(session()->getFlashdata('errorMessages')as $message){?>
        <div class="alert alert-danger text-xs">
            <?=$message?>
        </div>
<?php }} ?>
<?php if(!empty(session()->getFlashdata('warningMessages'))){
    foreach(session()->getFlashdata('warningMessages')as $message){?>
        <div class="alert alert-warning text-xs">
            <?=$message?>
        </div>
<?php }} ?>
<div class="easyui-panel mb-5" title="<?=$title?>" style="width:100%;padding:15px;">
<form action="<?=current_url()?>" method="POST" enctype="multipart/form-data">
<input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
<div class="row">
    <div class="col col-sm-12 col-lg-2">
        <?=$edit['img_profile']&&file_exists(FCPATH.'/uploads/employees/profile/'.$edit['img_profile'])?
        '<div class="image" style="width:100px; margin:auto;">
            <img class="img-circle img-thumbnail" src="'.base_url().'/uploads/employees/profile/'.$edit['img_profile'].'" />
        </div>':''
        ?>
        </hr>
    </div>
    <div class="col col-sm-12 col-lg-6">
        <div class="fitem">
            <label>Photo:</label>
            <input class="easyui-filebox" name="userfile[0]" data-options="prompt:'Choose a jpg file'" style="width:200px;">
        </div>
        <div class="fitem">
            <label>E-KTP Number:</label>
            <?=easyui_textbox(array('name'=>'ektp_number','required'=>true,'value'=>@$edit['ektp_number']))?>
        </div>
        <div class="fitem">
            <label>Fullname:</label>
            <?=easyui_textbox(array('name'=>'fullname','required'=>true,'value'=>$edit['fullname']))?>
        </div>
        <div class="fitem">
            <label>Gender:</label>
            <?=easyui_combobox_option(array('name'=>'gender','label'=>'GENDER','required'=>true,'value'=>$edit['gender']))?>
        </div>
        <div class="fitem">
            <label>Place, Day Birth:</label>
            <?=easyui_textbox(array('name'=>'place_birth','prompt'=>'Place','required'=>true,'value'=>$edit['place_birth']))?>,&nbsp;
            <?=easyui_datebox_birth(array('name'=>'date_birth','prompt'=>'Day','required'=>true,'value'=>$edit['date_birth']))?>
        </div>
        <div class="fitem">
            <label>Religion:</label>
            <?=easyui_combobox_option(array('name'=>'religion','label'=>'RELIGION','value'=>$edit['religion']))?>
        </div>
        <div class="fitem">
            <label>Address:</label>
            <?=easyui_textarea(array('name'=>'address','required'=>true,'value'=>$edit['address'],'type'=>'2'))?>,&nbsp;
        </div>
        <div class="fitem">
            <label>&nbsp;</label>
            <?=easyui_textbox(array('name'=>'district','prompt'=>'Kelurahan','required'=>true,'value'=>$edit['district']))?>,&nbsp;
            <?=easyui_textbox(array('name'=>'village','prompt'=>'Kecamatan','required'=>true,'value'=>$edit['village']))?>
        </div>
        <div class="fitem">
            <label>City, Province:</label>
            <?=easyui_textbox(array('name'=>'city','prompt'=>'City','required'=>true,'value'=>$edit['city']))?>,&nbsp;
            <?=easyui_textbox(array('name'=>'province','prompt'=>'Province','required'=>true,'value'=>$edit['province']))?>
        </div>
        <div class="fitem">
            <label>Postcode:</label>
            <?=easyui_numberbox(array('name'=>'postcode','prompt'=>'Postcode','required'=>true,'value'=>$edit['postcode']))?>
        </div>
        <div class="fitem">
            <label>Marital Status:</label>
            <?=easyui_combobox_option(array('name'=>'marital_status','label'=>'MARITAL_STATUS','required'=>true,'value'=>$edit['marital_status']))?>
        </div>
        <hr/>
        <div class="fitem">
            <label>Contact:</label>
            <?=easyui_textbox(array('name'=>'email','prompt'=>'Email','required'=>true,'value'=>$edit['email']))?>,&nbsp;
            <?=easyui_textbox(array('name'=>'phone','prompt'=>'phone','required'=>true,'value'=>$edit['phone']))?>
        </div>
        <div class="fitem">
            <label>CV/Resume:</label>
            <input class="easyui-filebox" name="userfile[1]" data-options="prompt:'Choose a pdf file'" style="width:200px;">
            <br/>
            <?=$edit['attachment_cv']&&file_exists(FCPATH.'/uploads/employees/cv/'.$edit['attachment_cv'])?
            '<a href="'.base_url().'/uploads/employees/cv/'.$edit['attachment_cv'].'" download="'.$edit['fullname'].'_cv">Download CV</a>':'-'?>
        </div>
    </div>
    <div class="col col-sm-12 col-lg-4">
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
    </div>
</div>
<div class="row">
    <div class="col">
        <div style="text-align:center;padding:5px 0">
            <!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Save</a>-->
            <button  class="btn btn-primary">Save</button>
        </div>
    </div>
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
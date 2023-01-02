<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<?php if(!empty(session()->getFlashdata('message'))) : ?>
    <div class="alert alert-success text-xs">
        <?php echo session()->getFlashdata('message');?>
    </div>
<?php endif ?>
<?php if(!empty(session()->getFlashdata('errorMessage'))){
    foreach(session()->getFlashdata('errorMessages')as $message){?>
        <div class="alert alert-danger text-xs">
            <?=$message?>
        </div>
<?php }} ?>
<div class="easyui-panel mb-5" title="<?=$title?>" style="width:100%;padding:15px;">
<form action="<?=current_url()?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
    <?=$edit['img_logo']&&file_exists(FCPATH.'/uploads/companies/logo/'.$edit['img_logo'])?
    '<div class="image mb-5" style="width:100px;">
        <img class="img-circle img-thumbnail" src="'.base_url().'/uploads/companies/logo/'.$edit['img_logo'].'" />
    </div>':''
    ?>
    </hr>
    <div class="fitem">
        <label>Photo:</label>
        <input class="easyui-filebox" name="userfile" data-options="prompt:'Choose a jpg file'" style="width:200px;">
    </div>
    <div class="fitem">
        <label>Name:</label>
        <?=easyui_textbox(array('name'=>'name','required'=>true,'value'=>@$edit['name']))?>
    </div>
    <div class="fitem">
        <label>Address:</label>
        <?=easyui_textarea(array('name'=>'address','required'=>true,'value'=>$edit['address'],'type'=>'2'))?>,&nbsp;
    </div>
    <div class="fitem">
        <label>Phone:</label>
        <?=easyui_textbox(array('name'=>'phone','required'=>true,'value'=>@$edit['phone']))?>
    </div>
    <div style="text-align:center;padding:5px 0">
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Save</a>-->
        <button  class="btn btn-primary">Save</button>
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
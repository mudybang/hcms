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
<?php if(!empty(session()->getFlashdata('warningMessages'))){
    foreach(session()->getFlashdata('warningMessages')as $message){?>
        <div class="alert alert-warning text-xs">
            <?=$message?>
        </div>
<?php }} ?>
<div class="easyui-panel" title="<?=$title?>" style="width:100%;padding:30px 60px;">
    <form action="<?=current_url()?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" class="txt_csrfname" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
        <div class="fitem">
            <label>E-KTP Number:</label>
            <?=$profile['ektp_number']?>
        </div>
        <div class="fitem">
        <label>Attachment E-KTP:</label>
            <input class="easyui-filebox" name="userfile[0]" data-options="prompt:'Choose a pdf/jpg file'" style="width:200px;">
            <?=$profile['attachment_ektp']&&file_exists(FCPATH.'/uploads/employees/ektp/'.$profile['attachment_ektp'])?
            '<a href="'.base_url().'/uploads/employees/ektp/'.$profile['attachment_ektp'].'" download="'.$profile['fullname'].'_ektp">Download</a>':'-'?>
        </div>
        <div class="fitem">
            <label>Family ID Number(KK):</label>
            <?=easyui_textbox(array('name'=>'kk_number','required'=>true,'value'=>$profile['kk_number']))?>
        </div>
        <div class="fitem">
            <label>Attachment KK:</label>
            <input class="easyui-filebox" name="userfile[1]" data-options="prompt:'Choose a pdf/jpg file'" style="width:200px;">
            <?=$profile['attachment_kk']&&file_exists(FCPATH.'/uploads/employees/kk/'.$profile['attachment_kk'])?
            '<a href="'.base_url().'/uploads/employees/kk/'.$profile['attachment_kk'].'" download="'.$profile['fullname'].'_kk">Download</a>':'-'?>
        </div>
        <hr/>
        <table>
        <?php
        $siblings=$db->table('options')->getWhere(['label'=>'SIBLING']);
        foreach($siblings->getResultArray()as $sibling){
            $qedit=$db->table('employee_siblings')->getWhere(['employee_id'=>$employee_id,'sibling'=>$sibling['option']]);
            if($qedit->getNumRows()>0){
                $edit=$qedit->getRowArray();
            }else{
                $edit=array();
            }
            echo '<tr>
                <td>&nbsp;'.$sibling['option'].'</td>
                <td>&nbsp;'.easyui_textbox(array('name'=>"fullname_".clearstr($sibling['option']),'prompt'=>'Fullname','required'=>$sibling['option']=='Mother'?true:false,'value'=>@$edit['fullname'])).'</td>
                <td>&nbsp;'.easyui_textbox(array('name'=>"ektp_number_".clearstr($sibling['option']),'prompt'=>'E-Ktp','value'=>@$edit['ektp_number'])).'</td>
                <td>&nbsp;'.easyui_datebox_birth(array('name'=>"date_birth_".clearstr($sibling['option']),'prompt'=>'Day Birth','value'=>@$edit['date_birth'])).'</td>
            </tr>';
        }
        ?>
        </table>
        <div style="text-align:center;padding:5px 0">
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
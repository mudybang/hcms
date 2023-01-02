<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<h2>DataGrid with Toolbar</h2>
<p>Put buttons on top toolbar of DataGrid.</p>
<div style="margin:20px 0;"></div>
<table id="tt" class="easyui-datagrid" style="width:700px;height:250px"
    url="<?=base_url()?>/role/get_data"
    title="Load Data" iconCls="icon-save"
    rownumbers="true" pagination="true">
    <thead>
        <tr>
            <th field="id" width="80">ID</th>
            <th field="label" width="120">Label</th>
            <th field="description">Description</th>
            <th field="created_at" width="80" align="right">Created@</th>
            <th field="updated_at" width="80" align="right">Updated@</th>
        </tr>
    </thead>
</table>
<?= $this->endSection() ?>
<?= $this->section('extra-css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/themes/color.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/plugins/easyui/demo/demo.css">
<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>
<script type="text/javascript" src="<?=base_url()?>/plugins/easyui/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/plugins/easyui/jquery.easyui.min.js"></script>
<?= $this->endSection() ?>
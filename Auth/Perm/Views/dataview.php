<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="grid">
  <div class="row">
    <div class="col-2">
	<p style="margin-left: 15px;">Choose Group</p>
	<div class="list-group">
	<?php foreach($groups as $key=>$list){
		echo '<a class="list-group-item list-group-item-action '.($list['id']==$group_id?'active':'').'" href="'.base_url().'/perm/'.$list['id'].'">'.$list['label'].'</a>
		';
	}?>
	</div>
	</div>
      <div class="col-10">
        <?php echo form_open();?>
        <table class="table table-striped">
          <thead class="thead-dark">
          <tr>
            <th>Module</th>
            <th width="100px">Create</th>
            <th width="100px">Read</th>
            <th width="100px">Update</th>
            <th width="100px">Delete</th>
            <!--<th width="100px">Read All</th>
            <th width="100px">Approval</th>-->
            <th width="100px">Export</th>
          </tr>
          </thead>
          <tbody style="height:300;overflow-y:scroll">	
          <?php 
          foreach($modules as $key=>$list){
            if(isset($list['id'])){
              $row=$db->query("select * from perms where group_id=$group_id and module_id=".$list['id'])->getRowArray();
              $row['c']=(isset($row['c'])?$row['c']:0);
              $row['r']=(isset($row['r'])?$row['r']:0);
              $row['u']=(isset($row['u'])?$row['u']:0);
              $row['d']=(isset($row['d'])?$row['d']:0);
              $row['r_all']=(isset($row['r_all'])?$row['r_all']:0);
              $row['a']=(isset($row['a'])?$row['a']:0);
              $row['excel']=(isset($row['excel'])?$row['excel']:0);
              if($list['id']>0){
                if($group_id>0){
                  echo '
                  <tr>
                    <td>'.$list['label'].'<input type="hidden" name="module_id[]" value="'.$list['id'].'"></td>
                    <td><input name="c['.$list['id'].']" type="checkbox" value="1" '.($row['c']>0?'checked':'').'></td>
                    <td><input name="r['.$list['id'].']" type="checkbox" value="1" '.($row['r']>0?'checked':'').'></td>
                    <td><input name="u['.$list['id'].']" type="checkbox" value="1" '.($row['u']>0?'checked':'').'></td>
                    <td><input name="d['.$list['id'].']" type="checkbox" value="1" '.($row['d']>0?'checked':'').'></td>
                    <!--<td><input name="r_all['.$list['id'].']" type="checkbox" value="1" '.($row['r_all']>0?'checked':'').'></td>
                    <td><input name="a['.$list['id'].']" type="checkbox" value="1" '.($row['a']>0?'checked':'').'></td>-->
                    <td><input name="excel['.$list['id'].']" type="checkbox" value="1" '.($row['excel']>0?'checked':'').'></td>
                  </tr>';
                }
              }else{
                echo '<tr>
                  <td colspan=8 align="left"><h6>'.$list['label'].'</h6></td>
                </tr>';
              }
            }else{
              echo '<tr>
                  <td colspan=8 align="left"><h6>'.$list['label'].'</h6></td>
                </tr>';
            }
          }?>
          </tbody>
        </table>
        <div class="p-10">
          <?=$perm['u']==='1'?'<input type="hidden" name="save" value="Save"><button class="btn btn-success"><i class="fas fa-save"></i> Save</button>':''?>
        </div>
        <br>
        <?php echo form_close();?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="grid">
  <div class="row">
    <div class="col-2">
	<p style="margin-left: 15px;">Choose Group</p>
	<div class="list-group">
	<?php foreach($groups as $key=>$list){
		echo '<a class="list-group-item list-group-item-action '.($list['id']==$group_id?'active':'').'" href="'.base_url().'/gradeview/'.$list['id'].'">'.$list['label'].'</a>
		';
	}?>
	</div>
	</div>
      <div class="col-10">
        <?php echo form_open();?>
        <table class="table table-striped">
          <thead class="thead-dark">
          <tr>
            <th>Grade</th>
            <th width="100px">Read</th>
          </tr>
          </thead>
          <tbody style="height:300;overflow-y:scroll">	
          <?php 
          foreach($grades as $key=>$list){
            if(isset($list['id'])){
              $row=$db->query("select * from grade_views where group_id=$group_id and grade_id=".$list['id'])->getRowArray();
              $row['r']=(isset($row['r'])?$row['r']:0);
              if($list['id']>0){
                if($group_id>0){
                  echo '
                  <tr>
                    <td>'.$list['name'].'<input type="hidden" name="grade_id[]" value="'.$list['id'].'"></td>
                    <td><input name="r['.$list['id'].']" type="checkbox" value="1" '.($row['r']>0?'checked':'').'></td>
                  </tr>';
                }
              }else{
                echo '<tr>
                  <td colspan=8 align="left"><h6>'.$list['name'].'</h6></td>
                </tr>';
              }
            }else{
              echo '<tr>
                  <td colspan=8 align="left"><h6>'.$list['name'].'</h6></td>
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
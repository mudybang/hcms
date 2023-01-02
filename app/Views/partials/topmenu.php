<?php
if(@$module_id>0){
	$module=$db->table('modules')->getWhere(['id'=>$module_id])->getRowArray();
	if($module['parent_module_id']>0){
    if(!isset($id)){
      $parentmenu=$db->table('modules')->getWhere(['id'=>$module['parent_module_id']])->getRowArray();
      echo '<li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link '.($parentmenu['id']==$module_id?'active':'').'" href="'.base_url().'/'.$parentmenu['slug'].'">'.$parentmenu['label'].'</a>
      </li>';
    }
		$topmenus=$db->table('modules')->getWhere(['parent_module_id'=>$module['parent_module_id']]);
		if($topmenus->getNumRows()>0){
			foreach($topmenus->getResultArray()as $topmenu){
				echo '<li class="nav-item d-none d-sm-inline-block">
					<a class="nav-link '.($topmenu['id']==$module_id?'active':'').'" href="'.base_url().'/'.$topmenu['slug'].($id>0?"/$id":"").'">'.$topmenu['label'].'</a>
				</li>';
			}
		}
	}else{
    if(!isset($id)){
      $parentmenu=$db->table('modules')->getWhere(['id'=>$module['id']])->getRowArray();
      echo '<li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link '.($parentmenu['id']==$module_id?'active':'').'" href="'.base_url().'/'.$parentmenu['slug'].'">'.$parentmenu['label'].'</a>
      </li>';
    }
		$topmenus=$db->table('modules')->getWhere(['parent_module_id'=>$module['id']]);
		if($topmenus->getNumRows()>0){
			foreach($topmenus->getResultArray()as $topmenu){
				echo '<li class="nav-item d-none d-sm-inline-block">
					<a class="nav-link '.($topmenu['id']==$module_id?'active':'').'" href="'.base_url().'/'.$topmenu['slug'].($id>0?"/$id":"").'">'.$topmenu['label'].'</a>
				</li>';
			}
		}
	}
}
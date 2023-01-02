<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <?php
    $group_id=auth()->user()->group_id;
    $menus=$db->table('menus')->orderBy('number,id', 'ASC')->get();
    foreach($menus->getResultArray()as $menu){
      $sql="select r,label,slug,icon from perms a left join modules b on a.module_id=b.id
        where r=1 and group_id='".$group_id."' and menu_id='".$menu['id']."'
        AND parent_module_id=0 order by b.number,a.module_id";
      $modules=$db->query($sql);
      if($modules->getNumRows()>0){?>
        <li class="nav-item has-treeview <?=$menu['label']==@$parent?"menu-open":""?>">
          <a href="#" class="nav-link <?=$menu['label']==@$parent?"active":""?>">
            <i class="nav-icon fas fa-<?=$menu['icon']?>"></i>
            <p>
              <?=$menu['label']?>
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            $sql="select r,label,slug,icon from perms a left join modules b on a.module_id=b.id
              where r=1 and group_id='".$group_id."' and menu_id='".$menu['id']."'
              AND parent_module_id=0 order by b.number,a.module_id";
            $modules=$db->query($sql);
            if($modules->getNumRows()>0){
              foreach($modules->getResultArray()as $module){?>
                <li class="nav-item">
                  <a href="<?=base_url().'/'.$module['slug']?>" class="nav-link <?=$module['label']==@$title?"active":""?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?=$module['label']?></p>
                  </a>
                </li>
            <?php }
            }?>
          </ul>
        </li>
      <?php }
    }?>
  </ul>
</nav>
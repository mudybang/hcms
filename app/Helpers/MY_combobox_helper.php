<?php
if ( ! function_exists('easyui_province')){
    function easyui_province($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        $query=$db->table('provinces')->orderBy('name','ASC')->get();
        foreach($query->getResultArray()as $row){
            if($value==$row['iso']){
                $html.="<option value='".$row['name']."' selected>".$row['name']."</option>";
            }else{
                $html.="<option value='".$row['name']."'>".$row['name']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_group')){
    function easyui_group($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        $query=$db->table('groups')->orderBy('label','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['label']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['label']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_department')){
    function easyui_department($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        $query=null;
        if(isset($option['master'])){
            $query=$db->table('departments')->orderBy('name','ASC')->getWhere(['active'=>1,'parent_id'=>0]);
        }else{
            $query=$db->table('departments')->orderBy('name','ASC')->getWhere(['active'=>1]);
        }
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['name']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['name']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_grade')){
    function easyui_grade($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        
        $query=$db->table('grades')->orderBy('id','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['name']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['name']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_jobtitle')){
    function easyui_jobtitle($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        
        $query=$db->table('jobtitles')->orderBy('report_level','DESC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['title']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['title']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_branch')){
    function easyui_branch($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        $query=$db->table('branchs')->orderBy('name','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['name']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['name']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_project')){
    function easyui_project($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        $query=$db->table('projects')->orderBy('name','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['name']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['name']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_education')){
    function easyui_education($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        
        $query=$db->table('educations')->orderBy('name','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['name']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['name']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_employment_status')){
    function easyui_employment_status($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        
        $query=$db->table('employmentstatuses')->orderBy('label','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['label']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['label']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_sdp')){
    function easyui_sdp($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        
        $query=$db->table('sdps')->orderBy('title','ASC')->getWhere(['active'=>1]);
        foreach($query->getResultArray()as $row){
            if($value==$row['id']){
                $html.="<option value='".$row['id']."' selected>".$row['title']."</option>";
            }else{
                $html.="<option value='".$row['id']."'>".$row['title']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_ptkp')){
    function easyui_ptkp($option){
        $db = db_connect();
        $w="";
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        $attribute.=isset($option['multiple'])?' multiple="true"':'';
        $attribute.=isset($option['multiline'])?' multiline="true"':'';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':'style="width:197px;"';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $value=isset($option['value'])?$option['value']:'';
        $html='<select '.$attribute.'>
            <option value=""></option>';
        
        $query=$db->table('ptkps')->orderBy('id','ASC')->get();
        foreach($query->getResultArray()as $row){
            if($value==$row['code']){
                $html.="<option value='".$row['code']."' selected>".$row['code'].'-'.$row['uraian']."</option>";
            }else{
                $html.="<option value='".$row['code']."'>".$row['code'].'-'.$row['uraian']."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}

if ( ! function_exists('easyui_directsp')){
    function easyui_directsp($option){
        $attribute='';
        $attribute.=isset($option['id'])?'id="'.$option['id'].'"':'';
        $attribute.=isset($option['class'])?' class="easyui-combobox '.$option['class'].'"':'class="easyui-combobox"';
        if(!isset($option['alias'])){
            $attribute.=isset($option['name'])?' name="'.$option['name'].'"':'';
        }else{
            $attribute.=isset($option['alias'])?' name="'.$option['alias'].'"':'';
        }
        $attribute.=isset($option['width'])?' style="width:'.$option['width'].';"':' style="width:100px;"';
        $attribute.=isset($option['required'])?' data-options="required:true,prompt:\'---\'"':'';
        $attribute.=isset($option['readonly'])?' disabled="true"':'';

        $name=isset($option['name'])?$option['name']:'';
        $value=isset($option['value'])?$option['value']:'';

        $html='<select '.$attribute.'>
            <option value=""></option>';
        $arr=['2','3'];
        foreach($arr as $item){
            if($item==$value){
                $html.="<option value='".$item."' selected>".$item."</option>";
            }else{
                $html.="<option value='".$item."'>".$item."</option>";
            }
        }
        $html.='</select>';
        return $html;
    }
}
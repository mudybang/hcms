<?php 
namespace App\Libraries;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Validation\Validation;
use Config\Services;

class UploadFile{
    protected $request;
    protected $validator;
    public function __construct(){
        $this->request = service('request');
    }
    function single_upload($id,$dir,$parent="employees") {
        $errors=[];
        $img = $this->request->getFile('userfile');
        if(!$img->isValid()){
            return ['success'=>true];
        }else{
            if($img->getClientExtension()=='pdf'){
                $validationRule = [
                    'userfile' => [
                        'label' => 'Pdf File',
                        'rules' => 'uploaded[userfile]'
                            . '|mime_in[userfile,application/pdf,application/x-pdf]'
                            . '|max_size[userfile,2000]'
                    ],
                ];
            }else{
                $validationRule = [
                    'userfile' => [
                        'label' => 'Image File',
                        'rules' => 'uploaded[userfile]'
                            . '|is_image[userfile]'
                            . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                            . '|max_size[userfile,2000]'
                            . '|max_dims[userfile,1024,768]',
                    ],
                ];
            }
            if (! $this->validate($validationRule)) {
                return ['success'=>false,'errorMessage' => $this->validator->getErrors()['userfile']];
            }
            if (! $img->hasMoved()) {
                $newname=md5($id).'.'.$img->getClientExtension();
                $img->move(WRITEPATH . "uploads/$parent/$dir", $newname, true);
                return ['success'=>true,"filename"=>$newname];
            }
            return ['success'=>false,'errorsMessage' => 'The file has already been moved.'];
        }
    }
    function multiple_upload($id,$dir_scheme=[]) {
        $errors=[];
        $files=[];
        $warnings=[];
        if ($imagefile = $this->request->getFiles()) {
            foreach ($imagefile['userfile'] as $key=>$img) {
                if(!$img->isValid()){
                    //$warnings[]="file $key empty";
                }else{
                    if(!$img->hasMoved()){
                        if($img->getClientExtension()=='pdf'){
                            $validationRule = [
                                'userfile.'.$key => [
                                    'label' => 'Image File',
                                    'rules' => 'uploaded[userfile.'.$key.']'
                                        . '|mime_in[userfile.'.$key.',application/pdf,application/x-pdf]'
                                        . '|max_size[userfile.'.$key.',2000]'
                                ],
                            ];
                        }else{
                            $validationRule = [
                                'userfile.'.$key => [
                                    'label' => 'Image File',
                                    'rules' => 'uploaded[userfile.'.$key.']'
                                        . '|is_image[userfile.'.$key.']'
                                        . '|mime_in[userfile.'.$key.',image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                                        . '|max_size[userfile.'.$key.',2000]'
                                        . '|max_dims[userfile.'.$key.',1024,768]',
                                ],
                            ];
                        }
                        if (! $this->validate($validationRule)) {
                            $warnings[]=$this->validator->getErrors()['userfile.'.$key];
                        }else{
                            $newname=md5($id).'.'.$img->getClientExtension();
                            $img->move(WRITEPATH . "uploads/employees/".$this->clean_dirname($dir_scheme[$key]), $newname, true);
                            $files[$key]="$newname";
                        }
                    }
                    else{
                        $errors[]='The file has already been moved.';
                    }
                }
            }
        }
        if(sizeof($errors)>0){
            return ['success'=>false,'errorsMessages'=>$errors];
        }
        return ['success'=>true,'files'=>$files,'warningMessages'=>$warnings];
    }
    function clean_dirname($str){
        $dirname=str_replace("img_","",$str);
        $dirname=str_replace("attachment_","",$dirname);
        return $dirname;
    }
    private function setValidator($rules, array $messages): void
    {
        $this->validator = Services::validation();

        if (is_string($rules)) {
            $validation = config('Validation');
            if (! isset($validation->{$rules})) {
                throw ValidationException::forRuleNotFound($rules);
            }

            if (! $messages) {
                $errorName = $rules . '_errors';
                $messages  = $validation->{$errorName} ?? [];
            }

            $rules = $validation->{$rules};
        }

        $this->validator->setRules($rules, $messages);
    }
    protected function validate($rules, array $messages = []): bool
    {
        $this->setValidator($rules, $messages);

        return $this->validator->withRequest($this->request)->run();
    }    
}
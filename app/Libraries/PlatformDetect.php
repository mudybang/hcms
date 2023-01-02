<?php
namespace App\Libraries;

class PlatformDetect {
    public function isMobile(){
        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return true;
        }
        return false;
    }
}
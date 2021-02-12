<?php

// allow utf8-detection: öäü€

class dx_smartynocache_oxutilsview extends dx_smartynocache_oxutilsview_parent
{
    public function getSmarty($blReload = false)
    {
        $oSmarty=parent::getSmarty($blReload);

        $oSmarty->force_compile=true;

        return $oSmarty;
    }
}
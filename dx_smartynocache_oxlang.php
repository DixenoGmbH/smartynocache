<?php
/**
 * Created by PhpStorm.
 * User: b.hesse
 * Date: 15.10.2018
 * Time: 10:25
 */

class dx_smartynocache_oxlang extends dx_smartynocache_oxlang_parent
{
    protected function _getLanguageFileData($blAdmin = false, $iLang = 0, $aLangFiles = null)
    {
        $myUtils = oxRegistry::getUtils();

        // ...get cache name:
        $sCacheName = $this->_getLangFileCacheName($blAdmin, $iLang, $aLangFiles);
        $sCachePath=$myUtils->getCacheFilePath($sCacheName);

        // stores the last modification timestamps for seen files
        $dxCachePath=$sCachePath.'.modtimes.json';

        // ...read stored timestamps to $modTimeLast-array:
        $modTimeLast=array();
        if (file_exists($dxCachePath))
        {
            $modTimeLastJSON=file_get_contents($dxCachePath);
            $modTimeLast=json_decode($modTimeLastJSON,true);
            if (!is_array($modTimeLast))
            {
                $modTimeLast=array();
            }
        }

        // This gets set to true if a new lang file was added
        // or the modification time was changed (or not known yet)
        $needsClearCache=false;

        $aLangFilesTmp=$aLangFiles;

        // get langfiles:
        if ($aLangFilesTmp === null)
        {
            if ($blAdmin) {
                $aLangFilesTmp = $this->_getAdminLangFilesPathArray($iLang);
            } else {
                $aLangFilesTmp = $this->_getLangFilesPathArray($iLang);
            }
        }

        if ($aLangFilesTmp)
        {
            // Remember the mod-times:
            // this will be saved as the new {cachefilename}.modtimes.json
            $seenTimes=array();

            foreach($aLangFilesTmp as $aLangFileName)
            {
                // Check mod-time:
                if (file_exists($aLangFileName)) {
                    $modTimeIs = filemtime($aLangFileName);
                }
                else
                {
                    $modTimeIs=0;
                }

                // Remember timestamp:
                $seenTimes[$aLangFileName]=$modTimeIs;

                // If timestamp was not known before, the file probably was added
                if (!isset($modTimeLast[$aLangFileName]))
                {
                    $needsClearCache=true;
                }
                else
                {
                    if ($modTimeLast[$aLangFileName]!=$modTimeIs)
                    {
                        $needsClearCache=true;
                    }
                }
            }
        }

        if ($needsClearCache)
        {
            // clear cache:
            // setting false forces a rebuild in parent::_getLanguageFileData()...
            $myUtils->setLangCache($sCacheName,false);

            file_put_contents($dxCachePath,json_encode($seenTimes,JSON_PRETTY_PRINT),LOCK_EX);
        }

        return parent::_getLanguageFileData($blAdmin, $iLang, $aLangFiles);
    }
}
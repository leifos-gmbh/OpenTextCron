<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

/**
 * OpenTextCron plugin
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 */
class ilOpenTextCronPlugin extends ilCronHookPlugin
{
    /**
     * @var \ilOpenTextCronPlugin|null
     */
    private static $instance = null;

    const CTYPE = 'Services';
    const CNAME = 'Cron';
    const SLOT_ID = 'crnhk';
    const PNAME = 'OpenTextCron';

    /**
     * @return \ilOpenTextCronPlugin|\ilPlugin|null
     */
    public static function getInstance() : ilOpenTextCronPlugin
    {
        if (self::$instance) {
            return self::$instance;
        }
        return self::$instance = ilPluginAdmin::getPluginObject(
            self::CTYPE,
            self::CNAME,
            self::SLOT_ID,
            self::PNAME
        );
    }
    
    /**
     * Get plugin name
     * @return string
     */
    public function getPluginName()
    {
        return self::PNAME;
    }
    
    /**
     * Init auto load
     */
    protected function init()
    {
        $this->initAutoLoad();
    }
        
    /**
     * Init auto loader
     * @return void
     */
    protected function initAutoLoad() : void
    {
        spl_autoload_register(
            array($this,'autoLoad')
        );
    }

    /**
     * Auto load implementation
     *
     * @param string class name
     */
    final private function autoLoad(string $a_classname)
    {
        $class_file = $this->getClassesDirectory() . '/class.' . $a_classname . '.php';
        if (file_exists($class_file) && include_once($class_file)) {
            return;
        }
    }

    /**
     * @param $a_id
     * @return \ilOpenTextCronCronJob
     */
    public function getCronJobInstance($a_id)
    {
        $logger = \ilLoggerFactory::getLogger('otxt');

        $job = new \ilOpenTextCronCronJob();
        return $job;
    }


    /**
     * @inheritdoc
     * @return \ilOpenTextCronCronJob[]
     */
    public function getCronJobInstances()
    {
        $job = new \ilOpenTextCronCronJob();
        return [
            $job
        ];
    }
}

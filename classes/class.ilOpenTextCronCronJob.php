<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */


/**
 * Open Text Cron job definition
 * 
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 *
 */
class ilOpenTextCronCronJob extends ilCronJob
{
	const DEFAULT_SCHEDULE_TIME = 1;

	/**
	 * @var \ilOpenTextCronPlugin
	 */
	protected $plugin;

	/**
	 * @return string
	 */
	public function getId()
	{
		return ilOpenTextCronPlugin::getInstance()->getId();
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return ilOpenTextCronPlugin::PNAME;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return \ilOpenTextCronPlugin::getInstance()->txt('cron_job_info');
	}

	/**
	 * @return int
	 */
	public function getDefaultScheduleType()
	{
		return self::SCHEDULE_TYPE_IN_HOURS;
	}

	/**
	 * @return array|int
	 */
	public function getDefaultScheduleValue()
	{
		return self::DEFAULT_SCHEDULE_TIME;
	}

	/**
	 * @return bool
	 */
	public function hasAutoActivation()
	{
		return false;
	}

	/**
	 * @return bool
	 */
	public function hasFlexibleSchedule()
	{
		return true;
	}

	/**
	 * @return bool
	 */
	public function hasCustomSettings() 
	{
		return false;
	}

	/**
	 * @return \ilCronJobResult
	 */
	public function run()
	{
		$result = new ilCronJobResult();

		$plugins = ilPluginAdmin::getActivePluginsForSlot("Services", "EventHandling", "evhk");
		foreach ($plugins as $pl)
		{
			$plugin = ilPluginAdmin::getPluginObject(
				'Services',
				'EventHandling',
				'evhk',
				$pl
			);

			if($plugin->getPluginName() == 'OpenText')
			{
				$plugin->runCronJob($result);
			}

		}

		\ilLoggerFactory::getLogger('otxt')->info('Cron job result is: ' . $result->getCode());

		return $result;
	}

	/**
	 * @return \ilOpenTextCronCronJob
	 */
	public function getPlugin()
	{
		return \ilOpenTextCronPlugin::getInstance();
	}

}

?>
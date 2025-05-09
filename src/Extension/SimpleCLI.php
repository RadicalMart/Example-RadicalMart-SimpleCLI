<?php
/*
 * @package     RadicalMart - Simple CLI Plugin
 * @subpackage  plg_radicalmart_simple_cli
 * @version     __DEPLOY_VERSION__
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2025 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

namespace Joomla\Plugin\RadicalMart\SimpleCLI\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Factory\MVCFactoryAwareTrait;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Event\SubscriberInterface;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\Filesystem\Path;
use Joomla\Registry\Registry;

class SimpleCLI extends CMSPlugin implements SubscriberInterface
{
	use MVCFactoryAwareTrait;
	use DatabaseAwareTrait;

	/**
	 * Load the language file on instantiation.
	 *
	 * @var    bool
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $autoloadLanguage = true;

	/**
	 * Returns an array of events this subscriber will listen to.
	 *
	 * @return  array
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onRadicalMartRegisterCLICommands' => 'onRadicalMartRegisterCLICommands',
		];
	}

	/**
	 * Listener for `onRadicalMartRegisterCLICommands` event.
	 *
	 * @param   array     $commands  Updated commands array.
	 * @param   Registry  $params    RadicalMart params.
	 *
	 * @since __DEPLOY_VERSION__
	 */
	public function onRadicalMartRegisterCLICommands(array &$commands, Registry $params)
	{
		$files = Folder::files(Path::clean(JPATH_PLUGINS . '/radicalmart/simple_cli/src/Console'), '.php');
		foreach ($files as $file)
		{
			if ($file === 'AbstractCommand.php')
			{
				continue;
			}

			$commands[] = 'Joomla\\Plugin\\RadicalMart\\SimpleCLI\\Console\\' . File::stripExt($file);
		}
	}
}

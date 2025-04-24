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

namespace Joomla\Plugin\RadicalMart\SimpleCLI\Console;

\defined('_JEXEC') or die;

use Joomla\Component\RadicalMart\Administrator\Console\AbstractCommand;
use Joomla\Component\RadicalMart\Administrator\Helper\CommandsHelper;
use Joomla\Database\DatabaseAwareTrait;

class MetasCommand extends AbstractCommand
{
	use DatabaseAwareTrait;

	/**
	 * The default command name
	 *
	 * @var    string|null
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected static $defaultName = 'radicalmart:cli:metas';

	/**
	 * Command text title for configure.
	 *
	 * @var   string
	 *
	 * @since __DEPLOY_VERSION__
	 */
	protected string $commandText = 'Metas: Simple CLI Command';

	/**
	 * Command description for configure help block.
	 *
	 * @var   string
	 *
	 * @since __DEPLOY_VERSION__
	 */
	protected string $commandDescription = 'run metas command';

	/**
	 * Command methods for step by step run.
	 *
	 * @var  array
	 *
	 * @since __DEPLOY_VERSION__
	 */
	protected array $methods = [
		'metasRun'
	];

	/**
	 * Method run chang products.
	 *
	 * @return void
	 *
	 * @since __DEPLOY_VERSION__
	 */
	public function metasRun(): void
	{
		$this->ioStyle->title('Metas run');

		$this->ioStyle->text('Get Total');
		$this->ioStyle->progressStart(1);
		$total = CommandsHelper::getTotalItems('#__radicalmart_metas');
		$this->ioStyle->progressFinish();

		$this->ioStyle->text('Items advance');
		$this->ioStyle->progressStart($total);
		$limit = 100;
		$last  = 0;
		$db    = $this->getDatabase();
		while (true)
		{
			// Get pks
			$pks   = CommandsHelper::getNextPrimaryKeys('#__radicalmart_metas', $last, $limit);
			$count = count($pks);
			if ($count === 0)
			{
				break;
			}

			// Run method
			foreach ($pks as $pk)
			{
				$last = (int) $pk;

				// DO SOMETHING HERE!!!!

				$this->ioStyle->progressAdvance();
			}

			$db->disconnect();

			if ($count !== $limit)
			{
				break;
			}

		}
		$this->ioStyle->progressFinish();
	}
}
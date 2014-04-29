<?php

/**
 * This file is part of the Contao Community Alliance Build System tools.
 *
 * @copyright 2014 Contao Community Alliance <https://c-c-a.org>
 * @author    Tristan Lins <t.lins@c-c-a.org>
 * @package   contao-community-alliance/build-system-repository-git
 * @license   MIT
 * @link      https://c-c-a.org
 */

namespace ContaoCommunityAlliance\BuildSystem\Repository\Command;

use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Reset command builder.
 */
class ResetCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('reset');
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
		return $this;
	}

	public function patch()
	{
		$this->processBuilder->add('--patch');
		return $this;
	}

	public function soft()
	{
		$this->processBuilder->add('--soft');
		return $this;
	}

	public function mixed()
	{
		$this->processBuilder->add('--mixed');
		return $this;
	}

	public function hard()
	{
		$this->processBuilder->add('--hard');
		return $this;
	}

	public function merge()
	{
		$this->processBuilder->add('--merge');
		return $this;
	}

	public function keep()
	{
		$this->processBuilder->add('--keep');
		return $this;
	}

	public function commit($commit)
	{
		$this->processBuilder->add($commit);
		return $this;
	}

	public function execute($path = null, $_ = null)
	{
		$this->processBuilder->add('--');
		foreach (func_get_args() as $path) {
			$this->processBuilder->add($path);
		}
		return parent::run();
	}
}

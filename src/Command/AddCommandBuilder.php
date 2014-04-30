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
 * Add command builder.
 */
class AddCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('add');
	}

	public function dryRun()
	{
		$this->processBuilder->add('--dry-run');
		return $this;
	}

	public function verbose()
	{
		$this->processBuilder->add('--verbose');
		return $this;
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function patch()
	{
		$this->processBuilder->add('--patch');
		return $this;
	}

	public function update()
	{
		$this->processBuilder->add('--update');
		return $this;
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function noAll()
	{
		$this->processBuilder->add('--no-all');
		return $this;
	}

	public function intentToAdd()
	{
		$this->processBuilder->add('--intent-to-add');
		return $this;
	}

	public function refresh()
	{
		$this->processBuilder->add('--refresh');
		return $this;
	}

	public function ignoreErrors()
	{
		$this->processBuilder->add('--ignore-errors');
		return $this;
	}

	public function ignoreMissing()
	{
		$this->processBuilder->add('--ignore-missing');
		return $this;
	}

	public function execute($pathspec = null, $_ = null)
	{
		$args = func_get_args();
		if (count($args)) {
			$this->processBuilder->add('--');
			foreach ($args as $pathspec) {
				$this->processBuilder->add($pathspec);
			}
		}
		return parent::run();
	}
}

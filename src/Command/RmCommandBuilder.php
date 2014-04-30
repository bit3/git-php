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
 * Rm command builder.
 */
class RmCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('rm');
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function dryRun()
	{
		$this->processBuilder->add('--dry-run');
		return $this;
	}

	public function recursive()
	{
		$this->processBuilder->add('-r');
		return $this;
	}

	public function cached()
	{
		$this->processBuilder->add('--cached');
		return $this;
	}

	public function ignoreUnmatch()
	{
		$this->processBuilder->add('--ignore-unmatch');
		return $this;
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
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

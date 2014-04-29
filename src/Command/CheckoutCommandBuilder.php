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

namespace ContaoCommunityAlliance\BuildSystem\Repository;

use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Checkout command builder.
 */
class CheckoutCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('checkout');
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
		return $this;
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function ours()
	{
		$this->processBuilder->add('--ours');
		return $this;
	}

	public function theirs()
	{
		$this->processBuilder->add('--theirs');
		return $this;
	}

	public function create()
	{
		$this->processBuilder->add('-b');
		return $this;
	}

	public function overwrite()
	{
		$this->processBuilder->add('-B');
		return $this;
	}

	public function track()
	{
		$this->processBuilder->add('--track');
		return $this;
	}

	public function noTrack()
	{
		$this->processBuilder->add('--no-track');
		return $this;
	}

	public function reflog()
	{
		$this->processBuilder->add('-l');
		return $this;
	}

	public function detach()
	{
		$this->processBuilder->add('--detach');
		return $this;
	}

	public function orphan($newBranch = null)
	{
		$this->processBuilder->add('--orphan');
		if ($newBranch) {
			$this->processBuilder->add($newBranch);
		}
		return $this;
	}

	public function ignoreSkipWorktreeBits()
	{
		$this->processBuilder->add('--ignore-skip-worktree-bits');
		return $this;
	}

	public function merge()
	{
		$this->processBuilder->add('--merge');
		return $this;
	}

	public function conflict($style)
	{
		$this->processBuilder->add('--conflict=' . $style);
		return $this;
	}

	public function patch()
	{
		$this->processBuilder->add('--patch');
		return $this;
	}

	public function execute($branchOrTreeIsh = null, $path = null, $_ = null)
	{
		if ($branchOrTreeIsh) {
			$this->processBuilder->add($branchOrTreeIsh);
		}

		$paths = func_get_args();
		array_shift($paths);
		if (count($paths)) {
			$this->processBuilder->add('--');
			foreach ($paths as $path) {
				$this->processBuilder->add($path);
			}
		}

		return parent::execute();
	}
}

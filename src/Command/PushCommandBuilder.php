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
 * Push command builder.
 */
class PushCommandBuilder extends AbstractCommandBuilder
{
	const RECURSE_SUBMODULES_CHECK = 'check';

	const RECURSE_SUBMODULES_ON_DEMAND = 'on-demand';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('push');
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function prune()
	{
		$this->processBuilder->add('--prune');
		return $this;
	}

	public function mirror()
	{
		$this->processBuilder->add('--mirror');
		return $this;
	}

	public function dryRun()
	{
		$this->processBuilder->add('--dry-run');
		return $this;
	}

	public function porcelain()
	{
		$this->processBuilder->add('--porcelain');
		return $this;
	}

	public function delete()
	{
		$this->processBuilder->add('--delete');
		return $this;
	}

	public function tags()
	{
		$this->processBuilder->add('--tags');
		return $this;
	}

	public function followTags()
	{
		$this->processBuilder->add('--follow-tags');
		return $this;
	}

	public function receivePack($gitReceivePack)
	{
		$this->processBuilder->add('--receive-pack=' . $gitReceivePack);
		return $this;
	}

	public function forceWithLease($refname, $expect = null)
	{
		$this->processBuilder->add('--force-with-lease' . ($refname ? ('=' . $refname . ($expect ? ':' . $expect : '')) : ''));
		return $this;
	}

	public function noForceWithLease()
	{
		$this->processBuilder->add('--no-force-with-lease');
		return $this;
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function repo($repository)
	{
		$this->processBuilder->add('--repo=' . $repository);
		return $this;
	}

	public function setUpstream()
	{
		$this->processBuilder->add('--set-upstream');
		return $this;
	}

	public function thin()
	{
		$this->processBuilder->add('--thin');
		return $this;
	}

	public function noThin()
	{
		$this->processBuilder->add('--no-thin');
		return $this;
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
		return $this;
	}

	public function verbose()
	{
		$this->processBuilder->add('--verbose');
		return $this;
	}

	public function recurseSubmodules($recurse)
	{
		$this->processBuilder->add('--recurse-submodules=' . $recurse);
		return $this;
	}

	public function verify()
	{
		$this->processBuilder->add('--verify');
		return $this;
	}

	public function noVerify()
	{
		$this->processBuilder->add('--no-verify');
		return $this;
	}

	public function execute($repository, $refspec = null, $_ = null)
	{
		$this->processBuilder->add($repository);

		$refspecs = func_get_args();
		array_shift($refspecs);
		foreach ($refspecs as $refspec) {
			$this->processBuilder->add($refspec);
		}

		return parent::execute();
	}
}

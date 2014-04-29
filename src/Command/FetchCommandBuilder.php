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
 * Fetch command builder.
 */
class FetchCommandBuilder extends AbstractCommandBuilder
{
	const RECURSE_SUBMODULES_YES = 'yes';

	const RECURSE_SUBMODULES_ON_DEMAND = 'on-demand';

	const RECURSE_SUBMODULES_NO = 'no';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('fetch');
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function append()
	{
		$this->processBuilder->add('--append');
		return $this;
	}

	public function depth($depth)
	{
		$this->processBuilder->add('--depth=' . $depth);
		return $this;
	}

	public function unshallow()
	{
		$this->processBuilder->add('--unshallow');
		return $this;
	}

	public function updateShallow()
	{
		$this->processBuilder->add('--update-shallow');
		return $this;
	}

	public function dryRun()
	{
		$this->processBuilder->add('--dry-run');
		return $this;
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function keep()
	{
		$this->processBuilder->add('--keep');
		return $this;
	}

	public function multiple()
	{
		$this->processBuilder->add('--multiple');
		return $this;
	}

	public function prune()
	{
		$this->processBuilder->add('--prune');
		return $this;
	}

	public function noTags()
	{
		$this->processBuilder->add('--no-tags');
		return $this;
	}

	public function tags()
	{
		$this->processBuilder->add('--tags');
		return $this;
	}

	public function recurseSubmodules($recurse = false)
	{
		$this->processBuilder->add('--recurse-submodules' . ($recurse ? '=' . $recurse : ''));
		return $this;
	}

	public function noRecurseSubmodules()
	{
		$this->processBuilder->add('--no-recurse-submodules');
		return $this;
	}

	public function submodulePrefix($path)
	{
		$this->processBuilder->add('--submodule-prefix=' . $path);
		return $this;
	}

	public function recurseSubmodulesDefault($recurse)
	{
		$this->processBuilder->add('--recurse-submodules-default=' . $recurse);
		return $this;
	}

	public function updateHeadOk()
	{
		$this->processBuilder->add('--update-head-ok');
		return $this;
	}

	public function uploadPack($uploadPack)
	{
		$this->processBuilder->add('--upload-pack')->add($uploadPack);
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

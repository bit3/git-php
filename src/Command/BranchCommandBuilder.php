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
 * Branch command builder.
 */
class BranchCommandBuilder extends AbstractCommandBuilder
{
	const WHEN_ALWAYS = 'always';

	const WHEN_NEVER = 'never';

	const WHEN_AUTO = 'auto';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('branch');
	}

	public function delete()
	{
		$this->processBuilder->add('-D');
		return $this;
	}

	public function createReflog()
	{
		$this->processBuilder->add('--create-reflog');
		return $this;
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function move($oldName = false)
	{
		$this->processBuilder->add('-M');
		if ($oldName) {
			$this->processBuilder->add($oldName);
		}
		return $this;
	}

	public function color($when)
	{
		$this->processBuilder->add('--color=' . $when);
		return $this;
	}

	public function noColor()
	{
		$this->processBuilder->add('--no-color');
		return $this;
	}

	public function column($options = false)
	{
		$this->processBuilder->add('--column' . ($options ? '=' . $options : ''));
		return $this;
	}

	public function noColumn()
	{
		$this->processBuilder->add('--no-column');
		return $this;
	}

	public function remotes()
	{
		$this->processBuilder->add('--remotes');
		return $this;
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function listBranches()
	{
		$this->processBuilder->add('--list');
		return $this;
	}

	public function verbose()
	{
		$this->processBuilder->add('--verbose');
		return $this;
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
		return $this;
	}

	public function abbrev($length)
	{
		$this->processBuilder->add('--abbrev=' . $length);
		return $this;
	}

	public function noAbbrev()
	{
		$this->processBuilder->add('--no-abbrev');
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

	public function setUpstream()
	{
		$this->processBuilder->add('--set-upstream');
		return $this;
	}

	public function setUpstreamTo($upstream)
	{
		$this->processBuilder->add('--set-upstream-to=' . $upstream);
		return $this;
	}

	public function unsetUpstream()
	{
		$this->processBuilder->add('--unset-upstream');
		return $this;
	}

	public function contains($commit)
	{
		$this->processBuilder->add('--contains')->add($commit);
		return $this;
	}

	public function merged($commit)
	{
		$this->processBuilder->add('--merged')->add($commit);
		return $this;
	}

	public function noMerged($commit)
	{
		$this->processBuilder->add('--no-merged')->add($commit);
		return $this;
	}

	public function execute($branchName = null)
	{
		if ($branchName) {
			$this->processBuilder->add($branchName);
		}
		return parent::execute();
	}

	public function getList()
	{
		$branches = $this->execute();
		$branches = explode("\n", $branches);
		$branches = array_map(
			function ($branch) {
				return ltrim($branch, '*');
			},
			$branches
		);
		$branches = array_map('trim', $branches);
		$branches = array_filter($branches);

		return $branches;
	}
}

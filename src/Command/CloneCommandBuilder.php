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
 * Clone command builder.
 */
class CloneCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('clone');
	}

	public function local()
	{
		$this->processBuilder->add('--local');
		return $this;
	}

	public function noHardlinks()
	{
		$this->processBuilder->add('--no-hardlinks');
		return $this;
	}

	public function shared()
	{
		$this->processBuilder->add('--shared');
		return $this;
	}

	public function reference($repository)
	{
		$this->processBuilder->add('--reference')->add($repository);
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

	public function progress()
	{
		$this->processBuilder->add('--progress');
		return $this;
	}

	public function noCheckout()
	{
		$this->processBuilder->add('--no-checkout');
		return $this;
	}

	public function bare()
	{
		$this->processBuilder->add('--bare');
		return $this;
	}

	public function mirror()
	{
		$this->processBuilder->add('--mirror');
		return $this;
	}

	public function origin($name)
	{
		$this->processBuilder->add('--origin')->add($name);
		return $this;
	}

	public function branch($name)
	{
		$this->processBuilder->add('--branch')->add($name);
		return $this;
	}

	public function uploadPack($uploadPack)
	{
		$this->processBuilder->add('--upload-pack')->add($uploadPack);
		return $this;
	}

	public function template($templateDirectory)
	{
		$this->processBuilder->add('--template=' . $templateDirectory);
		return $this;
	}

	public function config($key, $value)
	{
		$this->processBuilder->add('--config')->add($key . '=' . $value);
		return $this;
	}

	public function depth($depth)
	{
		$this->processBuilder->add('--depth')->add($depth);
		return $this;
	}

	public function noSingleBranch()
	{
		$this->processBuilder->add('--no-single-branch');
		return $this;
	}


	public function singleBranch()
	{
		$this->processBuilder->add('--single-branch');
		return $this;
	}

	public function recursive()
	{
		$this->processBuilder->add('--recursive');
		return $this;
	}

	public function separateGitDir($gitDir)
	{
		$this->processBuilder->add('--separate-git-dir=' . $gitDir);
		return $this;
	}

	public function execute($repositoryUrl)
	{
		$this->processBuilder->add($repositoryUrl);
		$this->processBuilder->add($this->repository->getRepositoryPath());
		return parent::execute();
	}
}

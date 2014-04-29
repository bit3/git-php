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
 * Init command builder.
 */
class InitCommandBuilder extends AbstractCommandBuilder
{
	const SHARE_FALSE = 'false';

	const SHARE_TRUE = 'true';

	const SHARE_UMASK = 'umask';

	const SHARE_GROUP = 'group';

	const SHARE_ALL = 'all';

	const SHARE_WORLD = 'world';

	const SHARE_EVERYBODY = 'everybody';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('init');
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
		return $this;
	}

	public function bare()
	{
		$this->processBuilder->add('--bare');
		return $this;
	}

	public function template($templateDirectory)
	{
		$this->processBuilder->add('--template=' . $templateDirectory);
		return $this;
	}

	public function separateGitDir($gitDir)
	{
		$this->processBuilder->add('--separate-git-dir=' . $gitDir);
		return $this;
	}

	public function shared($share)
	{
		$this->processBuilder->add('--shared=' . $share);
		return $this;
	}

	public function execute()
	{
		$this->processBuilder->add($this->repository->getRepositoryPath());
		return parent::run();
	}
}

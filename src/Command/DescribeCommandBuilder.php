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
 * Describe command builder.
 */
class DescribeCommandBuilder extends AbstractCommandBuilder
{
	/**
	 * Use any tag that is annotated. (default)
	 */
	const DESCRIBE_ANNOTATED_TAGS = 'annotated';

	/**
	 * Use any tag found in refs/tags namespace.
	 */
	const DESCRIBE_LIGHTWEIGHT_TAGS = 'lightweight';

	/**
	 * Use any ref found in refs/ namespace.
	 */
	const DESCRIBE_ALL = 'all';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('describe');
	}

	public function dirty($mark = false)
	{
		$this->processBuilder->add('--dirty');
		if ($mark) {
			$this->processBuilder->add($mark);
		}
		return $this;
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function tags()
	{
		$this->processBuilder->add('--tags');
		return $this;
	}

	public function contains()
	{
		$this->processBuilder->add('--contains');
		return $this;
	}

	public function abbrev($n)
	{
		$this->processBuilder->add('--abbrev=' . $n);
		return $this;
	}

	public function candidates($n)
	{
		$this->processBuilder->add('--candidates=' . $n);
		return $this;
	}

	public function exactMatch()
	{
		$this->processBuilder->add('--exact-match');
		return $this;
	}

	public function debug()
	{
		$this->processBuilder->add('--debug');
		return $this;
	}

	public function long()
	{
		$this->processBuilder->add('--long');
		return $this;
	}

	public function match($pattern)
	{
		$this->processBuilder->add('--match')->add($pattern);
		return $this;
	}

	public function always()
	{
		$this->processBuilder->add('--always');
		return $this;
	}

	public function firstParent()
	{
		$this->processBuilder->add('--first-parent');
		return $this;
	}

	public function execute($commit = 'HEAD')
	{
		$this->processBuilder->add($commit);
		return parent::run();
	}
}

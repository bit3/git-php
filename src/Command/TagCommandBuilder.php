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
 * Tag command builder.
 */
class TagCommandBuilder extends AbstractCommandBuilder
{
	const CLEANUP_VERBATIM = 'verbatim';

	const CLEANUP_WHITESPACE = 'whitespace';

	const CLEANUP_STRIP = 'strip';

	protected $signIsset = false;

	protected $localUserIsset = false;

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('tag');
	}

	public function annotate()
	{
		$this->processBuilder->add('--annotate');
		return $this;
	}

	public function sign()
	{
		$this->signIsset = true;
		$this->processBuilder->add('--sign');
		return $this;
	}

	public function localUser($keyid)
	{
		$this->localUserIsset = true;
		$this->processBuilder->add('--local-user=' . $keyid);
		return $this;
	}

	public function force()
	{
		$this->processBuilder->add('--force');
		return $this;
	}

	public function delete()
	{
		$this->processBuilder->add('--delete');
		return $this;
	}

	public function verify()
	{
		$this->processBuilder->add('--verify');
		return $this;
	}

	public function n($num)
	{
		$this->processBuilder->add('-n' . $num);
		return $this;
	}

	public function l($pattern)
	{
		$this->processBuilder->add('--list')->add($pattern);
		return $this;
	}

	public function column($options = null)
	{
		$this->processBuilder->add('--column' . ($options ? '=' . $options : ''));
		return $this;
	}

	public function noColumn()
	{
		$this->processBuilder->add('--no-column');
		return $this;
	}

	public function contains($commit)
	{
		$this->processBuilder->add('--contains')->add($commit);
		return $this;
	}

	public function pointsAt($object)
	{
		$this->processBuilder->add('--points-at')->add($object);
		return $this;
	}

	public function message($message)
	{
		$this->processBuilder->add('--message=' . $message);
		return $this;
	}

	public function file($file)
	{
		$this->processBuilder->add('--file=' . $file);
		return $this;
	}

	public function cleanup($mode)
	{
		$this->processBuilder->add('--cleanup=' . $mode);
		return $this;
	}

	public function execute($tagName, $commit = null)
	{
		if (!$this->signIsset && $this->repository->getConfig()->isSignTagsEnabled()) {
			$this->sign()->localUser($this->repository->getConfig()->getSignCommitUser());
		}
		else if ($this->signIsset && !$this->localUserIsset && $this->repository->getConfig()->isSignTagsEnabled()) {
			$this->localUser($this->repository->getConfig()->getSignCommitUser());
		}

		$this->processBuilder->add($tagName);

		if ($commit) {
			$this->processBuilder->add($commit);
		}

		return parent::run();
	}
}

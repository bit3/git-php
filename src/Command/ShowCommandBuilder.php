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
 * Show command builder.
 */
class ShowCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('show');
	}

	public function pretty($format = null)
	{
		$this->processBuilder->add('--pretty' . ($format ? '=' . $format : ''));
		return $this;
	}

	public function format($format)
	{
		$this->processBuilder->add('--format=' . $format);
		return $this;
	}

	public function abbrevCommit()
	{
		$this->processBuilder->add('--abbrev-commit');
		return $this;
	}

	public function noAbbrevCommit()
	{
		$this->processBuilder->add('--no-abbrev-commit');
		return $this;
	}

	public function oneline()
	{
		$this->processBuilder->add('--oneline');
		return $this;
	}

	public function encoding($encoding)
	{
		$this->processBuilder->add('--encoding=' . $encoding);
		return $this;
	}

	public function notes($ref = null)
	{
		$this->processBuilder->add('--notes' . ($ref ? '=' . $ref : ''));
		return $this;
	}

	public function noNotes()
	{
		$this->processBuilder->add('--no-notes');
		return $this;
	}

	public function showNotes($ref = null)
	{
		$this->processBuilder->add('--show-notes' . ($ref ? '=' . $ref : ''));
		return $this;
	}

	public function standardNotes()
	{
		$this->processBuilder->add('--standard-notes');
		return $this;
	}

	public function noStandardNotes()
	{
		$this->processBuilder->add('--no-standard-notes');
		return $this;
	}

	public function showSignature()
	{
		$this->processBuilder->add('--show-signature');
		return $this;
	}

	public function noPatch()
	{
		$this->processBuilder->add('--no-patch');
		return $this;
	}

	public function execute($object)
	{
		$this->processBuilder->add($object);
		return parent::run();
	}
}

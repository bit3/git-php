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
 * Rev-parse command builder.
 */
class RevParseCommandBuilder extends AbstractCommandBuilder
{
	const ABBREV_REF_STRICT = 'strict';

	const ABBREV_REF_LOOSE = 'loose';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('rev-parse');
	}

	public function parseopt()
	{
		$this->processBuilder->add('--parseopt');
		return $this;
	}

	public function keepDashDash()
	{
		$this->processBuilder->add('--keep-dashdash');
		return $this;
	}

	public function stopAtNonOption()
	{
		$this->processBuilder->add('--stop-at-non-option');
		return $this;
	}

	public function stuckLong()
	{
		$this->processBuilder->add('--stuck-long');
		return $this;
	}

	public function sqQuote()
	{
		$this->processBuilder->add('--sq-quote');
		return $this;
	}

	public function revsOnly()
	{
		$this->processBuilder->add('--revs-only');
		return $this;
	}

	public function noRevs()
	{
		$this->processBuilder->add('--no-revs');
		return $this;
	}

	public function flags()
	{
		$this->processBuilder->add('--flags');
		return $this;
	}

	public function noFlags()
	{
		$this->processBuilder->add('--no-flags');
		return $this;
	}

	public function defaultRev($arg)
	{
		$this->processBuilder->add('--default')->add($arg);
		return $this;
	}

	public function prefix($arg)
	{
		$this->processBuilder->add('--prefix')->add($arg);
		return $this;
	}

	public function verify()
	{
		$this->processBuilder->add('--verify');
		return $this;
	}

	public function quiet()
	{
		$this->processBuilder->add('--quiet');
		return $this;
	}

	public function sq()
	{
		$this->processBuilder->add('--sq');
		return $this;
	}

	public function not()
	{
		$this->processBuilder->add('--not');
		return $this;
	}

	public function abbrevRef($abbrev = null)
	{
		$this->processBuilder->add('--abbref-ref' . ($abbrev ? '=' . $abbrev : ''));
		return $this;
	}

	public function short($number)
	{
		$this->processBuilder->add('--short' . ($number ? '=' . $number : ''));
		return $this;
	}

	public function symbolic()
	{
		$this->processBuilder->add('--symbolic');
		return $this;
	}

	public function symbolicFullName()
	{
		$this->processBuilder->add('--symbolic-full-name');
		return $this;
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function branches($pattern)
	{
		$this->processBuilder->add('--branches=' . $pattern);
		return $this;
	}

	public function tags($pattern)
	{
		$this->processBuilder->add('--tags=' . $pattern);
		return $this;
	}

	public function remotes($pattern)
	{
		$this->processBuilder->add('--remotes=' . $pattern);
		return $this;
	}

	public function glob($pattern)
	{
		$this->processBuilder->add('--glob=' . $pattern);
		return $this;
	}

	public function exclude($pattern)
	{
		$this->processBuilder->add('--exclude=' . $pattern);
		return $this;
	}

	public function disambiguate($prefix)
	{
		$this->processBuilder->add('--disambiguate=' . $prefix);
		return $this;
	}

	public function since($date)
	{
		if ($date instanceof \DateTime) {
			$date = $date->format('Y-m-d H:i:s');
		}
		$this->processBuilder->add('--since=' . $date);
		return $this;
	}

	public function after($date)
	{
		if ($date instanceof \DateTime) {
			$date = $date->format('Y-m-d H:i:s');
		}
		$this->processBuilder->add('--after=' . $date);
		return $this;
	}

	public function until($date)
	{
		if ($date instanceof \DateTime) {
			$date = $date->format('Y-m-d H:i:s');
		}
		$this->processBuilder->add('--until=' . $date);
		return $this;
	}

	public function before($date)
	{
		if ($date instanceof \DateTime) {
			$date = $date->format('Y-m-d H:i:s');
		}
		$this->processBuilder->add('--before=' . $date);
		return $this;
	}

	public function execute($arg = null, $_ = null)
	{
		foreach (func_get_args() as $arg) {
			$this->processBuilder->add($arg);
		}
		return parent::run();
	}
}

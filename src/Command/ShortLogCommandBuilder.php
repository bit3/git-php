<?php

/**
 * This file is part of the Contao Community Alliance Build System tools.
 *
 * @copyright 2014 Contao Community Alliance <https://c-c-a.org>
 * @author    David Molineus <david.molineus@netzmacht.de>
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
 * ShortLog command builder.
 */
class ShortLogCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('shortlog');
	}

	public function numbered()
	{
		$this->processBuilder->add('--numbered');
		return $this;
	}

	public function summary()
	{
		$this->processBuilder->add('--summary');
		return $this;
	}

	public function email()
	{
		$this->processBuilder->add('--email');
		return $this;
	}

	public function format($format)
	{
		$this->processBuilder->add('--format=' . $format);
		return $this;
	}

	public function revisionRange($revisionRange)
	{
		$this->processBuilder->add($revisionRange);
		return $this;
	}

	public function w($width, $indent1 = null, $indent2 = null)
	{
		if ($indent1) {
			$width .= ',' . $indent1;

			if ($indent2) {
				$width .= ',' . $indent2;
			}
		}

		$this->processBuilder->add('-w' . $width);
		return $this;
	}

	public function execute($pathspec = null, $_ = null)
	{
		$args = func_get_args();
		if (count($args)) {
			$this->processBuilder->add('--');
			foreach ($args as $pathspec) {
				$this->processBuilder->add($pathspec);
			}
		}
		return parent::run();
	}
}

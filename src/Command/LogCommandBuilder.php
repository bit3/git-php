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
 * Log command builder.
 */
class LogCommandBuilder extends AbstractCommandBuilder
{
	const DECORATE_SHORT = 'short';

	const DECORATE_FULL = 'full';

	const DECORATE_NO = 'no';

	const WALK_SORTED = 'sorted';

	const WALK_UNSORTED = 'unsorted';

	const DATE_RELATIVE = 'relative';

	const DATE_LOCAL = 'local';

	const DATE_DEFAULT = 'default';

	const DATE_ISO = 'iso';

	const DATE_RFC = 'rfc';

	const DATE_SHORT = 'short';

	const DATE_RAW = 'raw';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('log');
	}

	public function follow()
	{
		$this->processBuilder->add('--follow');
		return $this;
	}

	public function noDecorate()
	{
		$this->processBuilder->add('--no-decorate');
		return $this;
	}

	public function decorate($decorate)
	{
		$this->processBuilder->add('--decorate' . ($decorate ? '=' . $decorate : ''));
		return $this;
	}

	public function source()
	{
		$this->processBuilder->add('--source');
		return $this;
	}

	public function useMailmap()
	{
		$this->processBuilder->add('--use-mailmap');
		return $this;
	}

	public function fullDiff()
	{
		$this->processBuilder->add('--full-diff');
		return $this;
	}

	public function logSize()
	{
		$this->processBuilder->add('--log-size');
		return $this;
	}

	public function revisionRange($revisionRange)
	{
		$this->processBuilder->add($revisionRange);
		return $this;
	}

	public function maxCount($number)
	{
		$this->processBuilder->add('--max-count=' . $number);
		return $this;
	}

	public function skip($number)
	{
		$this->processBuilder->add('--skip=' . $number);
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

	public function author($pattern)
	{
		$this->processBuilder->add('--author=' . $pattern);
		return $this;
	}

	public function grepReflog($pattern)
	{
		$this->processBuilder->add('--grep-reflog=' . $pattern);
		return $this;
	}

	public function grep($pattern)
	{
		$this->processBuilder->add('--grep=' . $pattern);
		return $this;
	}

	public function allMatch()
	{
		$this->processBuilder->add('--all-match');
		return $this;
	}

	public function regexpIgnoreCase()
	{
		$this->processBuilder->add('--regexp-ignore-case');
		return $this;
	}

	public function basicRegexp()
	{
		$this->processBuilder->add('--basicRegexp');
		return $this;
	}

	public function extendedRegexp()
	{
		$this->processBuilder->add('--extended-regexp');
		return $this;
	}

	public function fixedStrings()
	{
		$this->processBuilder->add('--fixed-strings');
		return $this;
	}

	public function perlRegexp()
	{
		$this->processBuilder->add('--perl-regexp');
		return $this;
	}

	public function removeEmpty()
	{
		$this->processBuilder->add('--remove-empty');
		return $this;
	}

	public function merges()
	{
		$this->processBuilder->add('--merges');
		return $this;
	}

	public function noMerges()
	{
		$this->processBuilder->add('--no-merges');
		return $this;
	}

	public function minParents($number)
	{
		$this->processBuilder->add('--min-parents=' . $number);
		return $this;
	}

	public function maxParents($number)
	{
		$this->processBuilder->add('--max-parents=' . $number);
		return $this;
	}

	public function noMinParents()
	{
		$this->processBuilder->add('--no-min-parents');
		return $this;
	}

	public function noMaxParents()
	{
		$this->processBuilder->add('--no-max-parents');
		return $this;
	}

	public function firstParent()
	{
		$this->processBuilder->add('--first-parent');
		return $this;
	}

	public function not()
	{
		$this->processBuilder->add('--not');
		return $this;
	}

	public function all()
	{
		$this->processBuilder->add('--all');
		return $this;
	}

	public function branches($pattern = null)
	{
		$this->processBuilder->add('--branches' . ($pattern ? '=' . $pattern : ''));
		return $this;
	}

	public function tags($pattern = null)
	{
		$this->processBuilder->add('--tags' . ($pattern ? '=' . $pattern : ''));
		return $this;
	}

	public function remotes($pattern = null)
	{
		$this->processBuilder->add('--remotes' . ($pattern ? '=' . $pattern : ''));
		return $this;
	}

	public function glob($pattern = null)
	{
		$this->processBuilder->add('--glob=' . $pattern);
		return $this;
	}

	public function exclude($pattern = null)
	{
		$this->processBuilder->add('--exclude=' . $pattern);
		return $this;
	}

	public function ignoreMissing()
	{
		$this->processBuilder->add('--ignore-missing');
		return $this;
	}

	public function bisect()
	{
		$this->processBuilder->add('--bisect');
		return $this;
	}

	public function cherryMark()
	{
		$this->processBuilder->add('--cherry-mark');
		return $this;
	}

	public function cherryPick()
	{
		$this->processBuilder->add('--cherry-pick');
		return $this;
	}

	public function leftOnly()
	{
		$this->processBuilder->add('--left-only');
		return $this;
	}

	public function rightOnly()
	{
		$this->processBuilder->add('--right-only');
		return $this;
	}

	public function cherry()
	{
		$this->processBuilder->add('--cherry');
		return $this;
	}

	public function walkReflogs()
	{
		$this->processBuilder->add('--walk-reflogs');
		return $this;
	}

	public function merge()
	{
		$this->processBuilder->add('--merge');
		return $this;
	}

	public function boundary()
	{
		$this->processBuilder->add('--boundary');
		return $this;
	}

	public function simplifyByDecoration()
	{
		$this->processBuilder->add('--simplify-by-decoration');
		return $this;
	}

	public function fullHistory()
	{
		$this->processBuilder->add('--full-history');
		return $this;
	}

	public function dense()
	{
		$this->processBuilder->add('--dense');
		return $this;
	}

	public function sparse()
	{
		$this->processBuilder->add('--sparse');
		return $this;
	}

	public function simplifyMerges()
	{
		$this->processBuilder->add('--simplify-merges');
		return $this;
	}

	public function ancestryPath()
	{
		$this->processBuilder->add('--ancestry-path');
		return $this;
	}

	public function dateOrder()
	{
		$this->processBuilder->add('--date-order');
		return $this;
	}

	public function authorDateOrder()
	{
		$this->processBuilder->add('--author-date-order');
		return $this;
	}

	public function topoOrder()
	{
		$this->processBuilder->add('--topo-order');
		return $this;
	}

	public function reverse()
	{
		$this->processBuilder->add('--reverse');
		return $this;
	}

	public function objects()
	{
		$this->processBuilder->add('--objects');
		return $this;
	}

	public function objectsEdge()
	{
		$this->processBuilder->add('--objects-edge');
		return $this;
	}

	public function unpacked()
	{
		$this->processBuilder->add('--unpacked');
		return $this;
	}

	public function noWalk($walk = null)
	{
		$this->processBuilder->add('--no-walk' . ($walk ? '=' . $walk : ''));
		return $this;
	}

	public function doWalk()
	{
		$this->processBuilder->add('--do-walk');
		return $this;
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

	public function showSignature()
	{
		$this->processBuilder->add('--show-signature');
		return $this;
	}

	public function relativeDate()
	{
		$this->processBuilder->add('--relative-date');
		return $this;
	}

	public function date($format)
	{
		$this->processBuilder->add('--date=' . $format);
		return $this;
	}

	public function parents()
	{
		$this->processBuilder->add('--parents');
		return $this;
	}

	public function children()
	{
		$this->processBuilder->add('--children');
		return $this;
	}

	public function leftRight()
	{
		$this->processBuilder->add('--left-right');
		return $this;
	}

	public function graph()
	{
		$this->processBuilder->add('--graph');
		return $this;
	}

	public function c()
	{
		$this->processBuilder->add('-c');
		return $this;
	}

	public function cc()
	{
		$this->processBuilder->add('--cc');
		return $this;
	}

	public function m()
	{
		$this->processBuilder->add('-m');
		return $this;
	}

	public function r()
	{
		$this->processBuilder->add('-r');
		return $this;
	}

	public function t()
	{
		$this->processBuilder->add('-t');
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

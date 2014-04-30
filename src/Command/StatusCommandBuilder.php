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
 * Status command builder.
 */
class StatusCommandBuilder extends AbstractCommandBuilder
{
	const UNTRACKED_FILES_NO = 'no';

	const UNTRACKED_FILES_NORMAL = 'normal';

	const UNTRACKED_FILES_ALL = 'all';

	const IGNORE_SUBMODULES_NONE = 'none';

	const IGNORE_SUBMODULES_UNTRACKED = 'untracked';

	const IGNORE_SUBMODULES_DIRTY = 'dirty';

	const IGNORE_SUBMODULES_ALL = 'all';

	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('status');
	}

	public function short()
	{
		$this->processBuilder->add('--short');
		return $this;
	}

	public function branch()
	{
		$this->processBuilder->add('--branch');
		return $this;
	}

	public function porcelain()
	{
		$this->processBuilder->add('--porcelain');
		return $this;
	}

	public function long()
	{
		$this->processBuilder->add('--long');
		return $this;
	}

	public function untrackedFiles($mode = null)
	{
		$this->processBuilder->add('--untracked-files' . ($mode ? '=' . $mode : ''));
		return $this;
	}

	public function ignoreSubmodules($when = null)
	{
		$this->processBuilder->add('--ignore-submodules' . ($when ? '=' . $when : ''));
		return $this;
	}

	public function ignored()
	{
		$this->processBuilder->add('--ignored');
		return $this;
	}

	public function z()
	{
		$this->processBuilder->add('-z');
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

	/**
	 * Return the parsed index and work tree status.
	 *
	 * @param string $pathspec
	 * @param string $_
	 *
	 * @return array Return an associative array of all files and an status array.
	 *               <code>
	 *               array(
	 *                   '<pathspec>' => array(
	 *                       'index'    => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
	 *                       'worktree' => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
	 *                   )
	 *               )
	 *               </code>
	 */
	public function getStatus($pathspec = null, $_ = null)
	{
		$this->porcelain();

		$status = call_user_func_array(array($this, 'execute'), func_get_args());
		$status = explode("\n", $status);

		$files = array();

		foreach ($status as $line) {
			if (trim($line)) {
				$index    = trim(substr($line, 0, 1));
				$worktree = trim(substr($line, 1, 1));

				if ($index && $worktree) {
					$file         = trim(substr($line, 2));
					$files[$file] = array(
						'index'    => $index ? : false,
						'worktree' => $worktree ? : false,
					);
				}
			}
		}

		return $files;
	}

	/**
	 * Return the parsed index status.
	 *
	 * @param string $pathspec
	 * @param string $_
	 *
	 * @return array Return an associative array of all files and their modification status.
	 *               <code>
	 *               array(
	 *                   '<pathspec>' => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
	 *               )
	 *               </code>
	 */
	public function getIndexStatus($pathspec = null, $_ = null)
	{
		$this->porcelain();

		$status = call_user_func_array(array($this, 'execute'), func_get_args());
		$status = explode("\n", $status);

		$files = array();

		foreach ($status as $line) {
			if (trim($line)) {
				$index = trim(substr($line, 0, 1));

				if ($index) {
					$file         = trim(substr($line, 2));
					$files[$file] = $index;
				}
			}
		}

		return $files;
	}

	/**
	 * Return the parsed work tree status.
	 *
	 * @param string $pathspec
	 * @param string $_
	 *
	 * @return array Return an associative array of all files and their modification status.
	 *               <code>
	 *               array(
	 *                   '<pathspec>' => [false | "M" | "A" | "D" | "R" | "C" | "U" | "?" | "!"],
	 *               )
	 *               </code>
	 */
	public function getWorkTreeStatus($pathspec = null, $_ = null)
	{
		$this->porcelain();

		$status = call_user_func_array(array($this, 'execute'), func_get_args());
		$status = explode("\n", $status);

		$files = array();

		foreach ($status as $line) {
			if (trim($line)) {
				$worktree = trim(substr($line, 1, 1));

				if ($worktree) {
					$file         = trim(substr($line, 2));
					$files[$file] = $worktree;
				}
			}
		}

		return $files;
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

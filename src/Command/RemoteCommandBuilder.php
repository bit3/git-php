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
 * Remote command builder.
 */
class RemoteCommandBuilder extends AbstractCommandBuilder
{
	protected function initializeProcessBuilder()
	{
		$this->processBuilder->add('remote');
	}

	public function verbose()
	{
		$this->processBuilder->add('--verbose');
		return $this;
	}

	public function add($name, $url)
	{
		$this->processBuilder->add('add')->add($name)->add($url);
		return $this;
	}

	public function rename($new, $old = null)
	{
		$this->processBuilder->add('rename');
		if ($old) {
			$this->processBuilder->add($old);
		}
		$this->processBuilder->add($new);
		return $this;
	}

	public function remove($name)
	{
		$this->processBuilder->add('remove')->add($name);
		return $this;
	}

	public function setHead($name, $branch)
	{
		$this->processBuilder->add('set-head')->add($name)->add($branch);
		return $this;
	}

	public function setHeadAuto($name)
	{
		$this->processBuilder->add('set-head')->add($name)->add('--auto');
		return $this;
	}

	public function setHeadDelete($name)
	{
		$this->processBuilder->add('set-head')->add($name)->add('--delete');
		return $this;
	}

	public function setBranches($name, $branch, $add = false)
	{
		$this->processBuilder->add('set-branches');
		if ($add) {
			$this->processBuilder->add('--add');
		}
		$this->processBuilder->add($name)->add($branch);
		return $this;
	}

	public function setUrl($name, $url, $oldUrl = null)
	{
		$this->processBuilder->add('set-url')->add($name)->add($url);
		if ($oldUrl) {
			$this->processBuilder->add($oldUrl);
		}
		return $this;
	}

	public function setPushUrl($name, $url, $oldUrl = null)
	{
		$this->processBuilder->add('set-url')->add($name)->add('--push')->add($url);
		if ($oldUrl) {
			$this->processBuilder->add($oldUrl);
		}
		return $this;
	}

	public function addUrl($name, $url)
	{
		$this->processBuilder->add('set-url')->add('--add')->add($name)->add($url);
		return $this;
	}

	public function addPushUrl($name, $url)
	{
		$this->processBuilder->add('set-url')->add('--add')->add('--push')->add($name)->add($url);
		return $this;
	}

	public function deleteUrl($name, $url)
	{
		$this->processBuilder->add('set-url')->add('--delete')->add($name)->add($url);
		return $this;
	}

	public function deletePushUrl($name, $url)
	{
		$this->processBuilder->add('set-url')->add('--delete')->add('--push')->add($name)->add($url);
		return $this;
	}

	public function show($name)
	{
		$this->processBuilder->add('show')->add($name);
		return $this;
	}

	public function prune($name, $dryRun = false)
	{
		$this->processBuilder->add('prune');
		if ($dryRun) {
			$this->processBuilder->add('--dry-run');
		}
		$this->processBuilder->add($name);
		return $this;
	}

	public function update($groupOrRemote, $prune = false)
	{
		$this->processBuilder->add('update');
		if ($prune) {
			$this->processBuilder->add('--prune');
		}
		$this->processBuilder->add($groupOrRemote);
		return $this;
	}

	/**
	 * Return a list of remote names.
	 *
	 * @return array
	 */
	public function getList()
	{
		$remotes = $this->execute();
		$remotes = explode("\n", $remotes);
		$remotes = array_map('trim', $remotes);
		$remotes = array_filter($remotes);

		return $remotes;
	}
}

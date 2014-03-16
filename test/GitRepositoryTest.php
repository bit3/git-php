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

namespace ContaoCommunityAlliance\BuildSystem\Repository\Test;

use ContaoCommunityAlliance\BuildSystem\Repository\GitRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\ProcessBuilder;

/**
 * GIT repository unit tests.
 */
class GitRepositoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	protected $initializedRepositoryPath;

	/**
	 * @var string
	 */
	protected $uninitializedRepositoryPath;

	/**
	 * @var GitRepository
	 */
	protected $initializedGitRepository;

	/**
	 * @var GitRepository
	 */
	protected $uninitializedGitRepository;

	public function setUp()
	{
		$this->initializedRepositoryPath = tempnam(sys_get_temp_dir(), 'git_');
		unlink($this->initializedRepositoryPath);
		mkdir($this->initializedRepositoryPath);

		$this->uninitializedRepositoryPath = tempnam(sys_get_temp_dir(), 'git_');
		unlink($this->uninitializedRepositoryPath);
		mkdir($this->uninitializedRepositoryPath);

		$zip = new \ZipArchive();
		$zip->open(__DIR__ . DIRECTORY_SEPARATOR . 'git.zip');
		$zip->extractTo($this->initializedRepositoryPath);

		$this->initializedGitRepository   = new GitRepository($this->initializedRepositoryPath);
		$this->uninitializedGitRepository = new GitRepository($this->uninitializedRepositoryPath);
	}

	public function tearDown()
	{
		$fs = new Filesystem();
		$fs->remove($this->initializedRepositoryPath);
		$fs->remove($this->uninitializedRepositoryPath);

		unset($this->initializedRepositoryPath);
		unset($this->uninitializedRepositoryPath);
		unset($this->initializedGitRepository);
		unset($this->uninitializedGitRepository);
	}

	public function testGetRepositoryPath()
	{
		$this->assertEquals(
			$this->initializedRepositoryPath,
			$this->initializedGitRepository->getRepositoryPath()
		);
		$this->assertEquals(
			$this->uninitializedRepositoryPath,
			$this->uninitializedGitRepository->getRepositoryPath()
		);
	}

	public function testIsInitialized()
	{
		$this->assertTrue(
			$this->initializedGitRepository->isInitialized()
		);
		$this->assertFalse(
			$this->uninitializedGitRepository->isInitialized()
		);
	}

	public function testInit()
	{
		$this->uninitializedGitRepository->init();

		$this->assertTrue(
			is_dir($this->uninitializedRepositoryPath . DIRECTORY_SEPARATOR . '.git')
		);
	}

	public function testListRemotesOnInitializedRepository()
	{
		$this->assertEquals(
			array('local'),
			$this->initializedGitRepository->listRemotes()
		);
	}

	public function testListRemotesOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->listRemotes();
	}

	public function testListBranchesOnInitializedRepository()
	{
		$this->assertEquals(
			array('master'),
			$this->initializedGitRepository->listBranches()
		);
		$this->assertEquals(
			array('master', 'remotes/local/master'),
			$this->initializedGitRepository->listBranches(true)
		);
	}

	public function testListBranchesOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->listBranches();
	}

	public function testDescribeOnInitializedRepository()
	{
		$this->assertEquals(
			'annotated-tag-2-g8dcaf85',
			$this->initializedGitRepository->describe()
		);
		$this->assertEquals(
			'annotated-tag-2-g8dcaf85',
			$this->initializedGitRepository->describe(GitRepository::DESCRIBE_ANNOTATED_TAGS)
		);
		$this->assertEquals(
			'lightweight-tag-1-g8dcaf85',
			$this->initializedGitRepository->describe(GitRepository::DESCRIBE_LIGHTWEIGHT_TAGS)
		);
		$this->assertEquals(
			'heads/master',
			$this->initializedGitRepository->describe(GitRepository::DESCRIBE_ALL)
		);
	}

	public function testDescribeOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->describe();
	}

	public function testRemoteSetUrlOnInitializedRepository()
	{
		$this->initializedGitRepository->remoteSetUrl($this->uninitializedRepositoryPath, 'local');

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.url'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.pushurl'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);
	}

	public function testRemoteSetUrlOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remoteSetUrl($this->initializedRepositoryPath, 'local');
	}

	public function testRemoteSetFetchUrlOnInitializedRepository()
	{
		$this->initializedGitRepository->remoteSetFetchUrl($this->uninitializedRepositoryPath, 'local');

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.url'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.pushurl'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			'/tmp/git'
		);
	}

	public function testRemoteSetFetchUrlOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remoteSetFetchUrl($this->initializedRepositoryPath, 'local');
	}

	public function testRemoteSetPushUrlOnInitializedRepository()
	{
		$this->initializedGitRepository->remoteSetPushUrl($this->uninitializedRepositoryPath, 'local');

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.url'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			'/tmp/git'
		);

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.pushurl'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);
	}

	public function testRemoteSetPushUrlOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remoteSetPushUrl($this->initializedRepositoryPath, 'local');
	}

	public function testRemoteAddOnInitializedRepository()
	{
		$this->initializedGitRepository->remoteAdd($this->uninitializedRepositoryPath);

		$process = ProcessBuilder::create(array('git', 'config', 'remote.origin.url'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);
	}

	public function testRemoteAddOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remoteAdd($this->initializedRepositoryPath);
	}

	public function testRemoteFetchOnInitializedRepository()
	{
		$process = ProcessBuilder::create(array('git', 'remote', 'add', 'origin', $this->initializedRepositoryPath))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->initializedGitRepository->remoteFetch();

		$process = ProcessBuilder::create(array('git', 'branch', '-a'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$branches = explode("\n", $process->getOutput());
		$branches = array_map('trim', $branches);
		$branches = array_filter($branches);

		$this->assertTrue(
			in_array('remotes/origin/master', $branches)
		);
	}

	public function testRemoteFetchOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remoteFetch();
	}

	public function testCheckoutOnInitializedRepository()
	{
		$process = ProcessBuilder::create(array('git', 'remote', 'add', 'origin', $this->initializedRepositoryPath))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->initializedGitRepository->checkout('6c42d7ba78e0e956bd4e25661a6c13d826ef590a');

		$process = ProcessBuilder::create(array('git', 'describe'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			'annotated-tag'
		);
	}

	public function testCheckoutOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->checkout('foo');
	}

	public function testPushOnInitializedRepository()
	{
		$this->markTestIncomplete();
	}

	public function testPushOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->push('foo');
	}

	public function testStatusOnInitializedRepository()
	{
		$status = $this->initializedGitRepository->status();

		$this->assertEquals(
			array(
				'existing-file.txt'      => array('working' => false, 'staging' => 'D'),
				'removed-but-staged.txt' => array('working' => 'A', 'staging' => 'D'),
				'staged-file.txt'        => array('working' => 'A', 'staging' => false),
				'unknown-file.txt'       => array('working' => '?', 'staging' => '?'),
			),
			$status
		);
	}

	public function testStatusOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->status('foo');
	}

	public function testAddOnInitializedRepository()
	{
		$this->initializedGitRepository->add('unknown-file.txt');

		$process = ProcessBuilder::create(array('git', 'status', '-s'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$status = explode("\n", $process->getOutput());
		$status = array_map('trim', $status);

		$this->assertTrue(
			in_array('A  unknown-file.txt', $status)
		);
	}

	public function testAddOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->add('unknown-file.txt');
	}

	public function testRmOnInitializedRepository()
	{
		$this->initializedGitRepository->rm('existing-file.txt');

		$process = ProcessBuilder::create(array('git', 'status', '-s'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$status = explode("\n", $process->getOutput());
		$status = array_map('trim', $status);

		$this->assertTrue(
			in_array('D  existing-file.txt', $status)
		);
	}

	public function testRmOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->rm('existing-file.txt');
	}

	public function testCommitOnInitializedRepository()
	{
		$this->initializedGitRepository->commit('Commit changes');

		$process = ProcessBuilder::create(array('git', 'status', '-s'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$status = explode("\n", $process->getOutput());
		$status = array_map('trim', $status);
		$status = array_filter($status);

		$this->assertEquals(
			array(
				'D existing-file.txt',
				'D removed-but-staged.txt',
				'?? unknown-file.txt',
			),
			$status
		);
	}

	public function testCommitOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->commit('Commit changes');
	}

	public function testTagOnInitializedRepository()
	{
		$this->initializedGitRepository->tag('unit-test');

		$process = ProcessBuilder::create(array('git', 'tag'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$tags = explode("\n", $process->getOutput());
		$tags = array_map('trim', $tags);
		$tags = array_filter($tags);

		$this->assertTrue(
			in_array('unit-test', $tags)
		);
	}

	public function testTagOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->tag('unit-test');
	}
}

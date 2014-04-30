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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::getRepositoryPath
	 */
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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::isInitialized
	 */
	public function testIsInitialized()
	{
		$this->assertTrue(
			$this->initializedGitRepository->isInitialized()
		);
		$this->assertFalse(
			$this->uninitializedGitRepository->isInitialized()
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::init
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\InitCommandBuilder::execute
	 */
	public function testInit()
	{
		$this->uninitializedGitRepository->init()->execute();

		$this->assertTrue(
			is_dir($this->uninitializedRepositoryPath . DIRECTORY_SEPARATOR . '.git')
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::getNames
	 */
	public function testListRemotesOnInitializedRepository()
	{
		$this->assertEquals(
			array('local'),
			$this->initializedGitRepository->remote()->getNames()
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::getNames
	 */
	public function testListRemotesOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remote()->getNames();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::branch
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\BranchCommandBuilder::all
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\BranchCommandBuilder::getNames
	 */
	public function testListBranchesOnInitializedRepository()
	{
		$this->assertEquals(
			array('master'),
			$this->initializedGitRepository->branch()->getNames()
		);
		$this->assertEquals(
			array('master', 'remotes/local/master'),
			$this->initializedGitRepository->branch()->all()->getNames()
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::branch
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\BranchCommandBuilder::getNames
	 */
	public function testListBranchesOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->branch()->getNames();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::describe
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\DescribeCommandBuilder::tags
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\DescribeCommandBuilder::all
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\DescribeCommandBuilder::execute
	 */
	public function testDescribeOnInitializedRepository()
	{
		$this->assertEquals(
			'annotated-tag-2-g8dcaf85',
			$this->initializedGitRepository->describe()->execute()
		);
		$this->assertEquals(
			'lightweight-tag-1-g8dcaf85',
			$this->initializedGitRepository->describe()->tags()->execute()
		);
		$this->assertEquals(
			'heads/master',
			$this->initializedGitRepository->describe()->all()->execute()
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::describe
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\DescribeCommandBuilder::execute
	 */
	public function testDescribeOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->describe()->execute();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::setUrl
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::execute
	 */
	public function testRemoteSetUrlOnInitializedRepository()
	{
		$this->initializedGitRepository->remote()->setUrl('local', $this->uninitializedRepositoryPath)->execute();

		$process = ProcessBuilder::create(array('git', 'config', 'remote.local.url'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::setUrl
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::execute
	 */
	public function testRemoteSetUrlOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remote()->setUrl('local', $this->initializedRepositoryPath)->execute();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::setPushUrl
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::execute
	 */
	public function testRemoteSetPushUrlOnInitializedRepository()
	{
		$this->initializedGitRepository->remote()->setPushUrl('local', $this->uninitializedRepositoryPath)->execute();

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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::setPushUrl
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::execute
	 */
	public function testRemoteSetPushUrlOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remote()->setPushUrl('local', $this->initializedRepositoryPath)->execute();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::add
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::execute
	 */
	public function testRemoteAddOnInitializedRepository()
	{
		$this->initializedGitRepository->remote()->add('origin', $this->uninitializedRepositoryPath)->execute();

		$process = ProcessBuilder::create(array('git', 'config', 'remote.origin.url'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			$this->uninitializedRepositoryPath
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::remote
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::add
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RemoteCommandBuilder::execute
	 */
	public function testRemoteAddOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->remote()->add('origin', $this->initializedRepositoryPath)->execute();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::fetch
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\FetchCommandBuilder::execute
	 */
	public function testRemoteFetchOnInitializedRepository()
	{
		$process = ProcessBuilder::create(array('git', 'remote', 'add', 'origin', $this->initializedRepositoryPath))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->initializedGitRepository->fetch()->execute();

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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::fetch
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\FetchCommandBuilder::execute
	 */
	public function testRemoteFetchOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->fetch()->execute();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::checkout
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\CheckoutCommandBuilder::execute
	 */
	public function testCheckoutOnInitializedRepository()
	{
		$process = ProcessBuilder::create(array('git', 'remote', 'add', 'origin', $this->initializedRepositoryPath))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->initializedGitRepository->checkout()->execute('6c42d7ba78e0e956bd4e25661a6c13d826ef590a');

		$process = ProcessBuilder::create(array('git', 'describe'))
			->setWorkingDirectory($this->initializedRepositoryPath)
			->getProcess();
		$process->run();

		$this->assertEquals(
			trim($process->getOutput()),
			'annotated-tag'
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::checkout
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\CheckoutCommandBuilder::execute
	 */
	public function testCheckoutOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->checkout()->execute('foo');
	}

	public function testPushOnInitializedRepository()
	{
		$this->markTestIncomplete();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::push
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\PushCommandBuilder::execute
	 */
	public function testPushOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->push()->execute('foo');
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::status
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\StatusCommandBuilder::getStatus
	 */
	public function testStatusOnInitializedRepository()
	{
		$status = $this->initializedGitRepository->status()->getStatus();

		$this->assertEquals(
			array(
				'removed-but-staged.txt' => array('index' => 'A', 'worktree' => 'D'),
				'unknown-file.txt'       => array('index' => '?', 'worktree' => '?'),
			),
			$status
		);
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::status
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\StatusCommandBuilder::getStatus
	 */
	public function testStatusOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->status()->getStatus();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::add
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\AddCommandBuilder::execute
	 */
	public function testAddOnInitializedRepository()
	{
		$this->initializedGitRepository->add()->execute('unknown-file.txt');

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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::add
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\AddCommandBuilder::execute
	 */
	public function testAddOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->add()->execute('unknown-file.txt');
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::rm
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RmCommandBuilder::execute
	 */
	public function testRmOnInitializedRepository()
	{
		$this->initializedGitRepository->rm()->execute('existing-file.txt');

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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::rm
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\RmCommandBuilder::execute
	 */
	public function testRmOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->rm()->execute('existing-file.txt');
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::commit
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\CommitCommandBuilder::message
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\CommitCommandBuilder::execute
	 */
	public function testCommitOnInitializedRepository()
	{
		$this->initializedGitRepository->commit()->message('Commit changes')->execute();

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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::commit
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\CommitCommandBuilder::message
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\CommitCommandBuilder::execute
	 */
	public function testCommitOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->commit()->message('Commit changes')->execute();
	}

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::tag
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\TagCommandBuilder::execute
	 */
	public function testTagOnInitializedRepository()
	{
		$this->initializedGitRepository->tag()->execute('unit-test');

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

	/**
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\GitRepository::tag
	 * @covers \ContaoCommunityAlliance\BuildSystem\Repository\Command\TagCommandBuilder::execute
	 */
	public function testTagOnUninitializedRepository()
	{
		$this->setExpectedException('ContaoCommunityAlliance\BuildSystem\Repository\GitException');
		$this->uninitializedGitRepository->tag()->execute('unit-test');
	}
}

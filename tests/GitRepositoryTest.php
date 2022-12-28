<?php

/**
 * This file is part of bit3/git-php.
 *
 * (c) Tristan Lins <tristan@lins.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    bit3/git-php
 * @author     Tristan Lins <tristan@lins.io>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Matthew Gamble <git@matthewgamble.net>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2022 Tristan Lins <tristan@lins.io>
 * @license    https://github.com/bit3/git-php/blob/master/LICENSE MIT
 * @link       https://github.com/bit3/git-php
 * @filesource
 */

namespace Bit3\GitPhp\Test;

use Bit3\GitPhp\GitRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * GIT repository unit tests.
 *
 * @covers \Bit3\GitPhp\GitRepository
 */
class GitRepositoryTest extends TestCase
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

    public function setUp(): void
    {
        $this->initializedRepositoryPath = \tempnam(\sys_get_temp_dir(), 'git_');
        \unlink($this->initializedRepositoryPath);
        \mkdir($this->initializedRepositoryPath);

        $this->uninitializedRepositoryPath = \tempnam(\sys_get_temp_dir(), 'git_');
        \unlink($this->uninitializedRepositoryPath);
        \mkdir($this->uninitializedRepositoryPath);

        $zip = new \ZipArchive();
        $zip->open(__DIR__ . DIRECTORY_SEPARATOR . 'git.zip');
        $zip->extractTo($this->initializedRepositoryPath);

        $this->initializedGitRepository   = new GitRepository($this->initializedRepositoryPath);
        $this->uninitializedGitRepository = new GitRepository($this->uninitializedRepositoryPath);
    }

    public function tearDown(): void
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
     * @covers \Bit3\GitPhp\GitRepository::getRepositoryPath
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
     * @covers \Bit3\GitPhp\GitRepository::isInitialized
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
     * @covers \Bit3\GitPhp\GitRepository::init
     * @covers \Bit3\GitPhp\Command\InitCommandBuilder::execute
     */
    public function testInit()
    {
        $this->uninitializedGitRepository->init()->execute();

        $this->assertTrue(
            \is_dir($this->uninitializedRepositoryPath . DIRECTORY_SEPARATOR . '.git')
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::config
     * @covers \Bit3\GitPhp\Command\ConfigCommandBuilder::execute
     * @covers \Bit3\GitPhp\Command\ConfigCommandBuilder::get
     */
    public function testConfigGetOnInitializedRepository()
    {
        $this->assertEquals(
            'false',
            $this->initializedGitRepository->config()->file('local')->execute('core.bare')
        );
        $this->assertEquals(
            'CCA unittest',
            $this->initializedGitRepository->config()->file('local')->get('user.name')->execute()
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::config
     * @covers \Bit3\GitPhp\Command\ConfigCommandBuilder
     */
    public function testConfigGetOnUnitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->config()->file('local')->execute('core.bare');
        $this->uninitializedGitRepository->config()->file('local')->get('user.name')->execute();
    }

    public function testConfigSetOnInitializedRepository()
    {
        $this->initializedGitRepository->config()->file('local')->execute('user.name', 'CCA unittest 2');

        $process = new Process(['git', 'config', '--local', 'user.name'], $this->initializedRepositoryPath);
        $process->run();

        $this->assertEquals(
            'CCA unittest 2',
            trim($process->getOutput())
        );
    }

    public function testConfigAddOnInitializedRepository()
    {
        $this->initializedGitRepository->config()->file('local')->add('user.name', 'CCA unittest 2')->execute();

        $process = new Process(
            ['git', 'config', '--local', '--get-all', 'user.name'], $this->initializedRepositoryPath
        );
        $process->run();

        $names = \explode("\n", $process->getOutput());
        $names = \array_map('trim', $names);
        $names = \array_filter($names);

        $this->assertEquals(
            ['CCA unittest', 'CCA unittest 2'],
            $names
        );
    }

    public function testConfigGetAllOnInitializedRepository()
    {
        $values = $this->initializedGitRepository->config()->file('local')->getAll('gitphp.test2')->execute();

        $values = \explode("\n", $values);
        $values = \array_map('trim', $values);
        $values = \array_filter($values);

        $this->assertEquals(
            ['aa123', 'ab234', 'ac345', 'bb234'],
            $values
        );

        $values = $this->initializedGitRepository->config()->file('local')->getAll('gitphp.test2', '^a.+3.+$')->execute();

        $values = \explode("\n", $values);
        $values = \array_map('trim', $values);
        $values = \array_filter($values);

        $this->assertEquals(
            ['ab234', 'ac345'],
            $values
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::getNames
     */
    public function testListRemotesOnInitializedRepository()
    {
        $this->assertEquals(
            ['local'],
            $this->initializedGitRepository->remote()->getNames()
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::getNames
     */
    public function testListRemotesOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->remote()->getNames();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::branch
     * @covers \Bit3\GitPhp\Command\BranchCommandBuilder::all
     * @covers \Bit3\GitPhp\Command\BranchCommandBuilder::getNames
     */
    public function testListBranchesOnInitializedRepository()
    {
        $this->assertEquals(
            ['master'],
            $this->initializedGitRepository->branch()->getNames()
        );
        $this->assertEquals(
            ['master', 'remotes/local/master'],
            $this->initializedGitRepository->branch()->all()->getNames()
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::branch
     * @covers \Bit3\GitPhp\Command\BranchCommandBuilder::getNames
     */
    public function testListBranchesOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->branch()->getNames();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::describe
     * @covers \Bit3\GitPhp\Command\DescribeCommandBuilder::tags
     * @covers \Bit3\GitPhp\Command\DescribeCommandBuilder::all
     * @covers \Bit3\GitPhp\Command\DescribeCommandBuilder::execute
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
     * @covers \Bit3\GitPhp\GitRepository::describe
     * @covers \Bit3\GitPhp\Command\DescribeCommandBuilder::execute
     */
    public function testDescribeOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->describe()->execute();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::setUrl
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::execute
     */
    public function testRemoteSetUrlOnInitializedRepository()
    {
        $this->initializedGitRepository->remote()->setUrl('local', $this->uninitializedRepositoryPath)->execute();

        $process = new Process(['git', 'config', 'remote.local.url'], $this->initializedRepositoryPath);
        $process->run();

        $this->assertEquals(
            \trim($process->getOutput()),
            $this->uninitializedRepositoryPath
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::setUrl
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::execute
     */
    public function testRemoteSetUrlOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->remote()->setUrl('local', $this->initializedRepositoryPath)->execute();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::setPushUrl
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::execute
     */
    public function testRemoteSetPushUrlOnInitializedRepository()
    {
        $this->initializedGitRepository->remote()->setPushUrl('local', $this->uninitializedRepositoryPath)->execute();

        $process = new Process(['git', 'config', 'remote.local.url'], $this->initializedRepositoryPath);
        $process->run();

        $this->assertEquals(
            \trim($process->getOutput()),
            '/tmp/git'
        );

        $process = new Process(['git', 'config', 'remote.local.pushurl'], $this->initializedRepositoryPath);
        $process->run();

        $this->assertEquals(
            \trim($process->getOutput()),
            $this->uninitializedRepositoryPath
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::setPushUrl
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::execute
     */
    public function testRemoteSetPushUrlOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->remote()->setPushUrl('local', $this->initializedRepositoryPath)->execute();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::add
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::execute
     */
    public function testRemoteAddOnInitializedRepository()
    {
        $this->initializedGitRepository->remote()->add('origin', $this->uninitializedRepositoryPath)->execute();

        $process = new Process(['git', 'config', 'remote.origin.url'], $this->initializedRepositoryPath);
        $process->run();

        $this->assertEquals(
            trim($process->getOutput()),
            $this->uninitializedRepositoryPath
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::remote
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::add
     * @covers \Bit3\GitPhp\Command\RemoteCommandBuilder::execute
     */
    public function testRemoteAddOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->remote()->add('origin', $this->initializedRepositoryPath)->execute();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::fetch
     * @covers \Bit3\GitPhp\Command\FetchCommandBuilder::execute
     */
    public function testRemoteFetchOnInitializedRepository()
    {
        $process = new Process(
            ['git', 'remote', 'add', 'origin', $this->initializedRepositoryPath], $this->initializedRepositoryPath
        );
        $process->run();

        $this->initializedGitRepository->fetch()->execute();

        $process = new Process(['git', 'branch', '-a'], $this->initializedRepositoryPath);
        $process->run();

        $branches = explode("\n", $process->getOutput());
        $branches = array_map('trim', $branches);
        $branches = array_filter($branches);

        $this->assertTrue(
            \in_array('remotes/origin/master', $branches)
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::fetch
     * @covers \Bit3\GitPhp\Command\FetchCommandBuilder::execute
     */
    public function testRemoteFetchOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->fetch()->execute();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::checkout
     * @covers \Bit3\GitPhp\Command\CheckoutCommandBuilder::execute
     */
    public function testCheckoutOnInitializedRepository()
    {
        $process = new Process(
            ['git', 'remote', 'add', 'origin', $this->initializedRepositoryPath], $this->initializedRepositoryPath
        );
        $process->run();

        $this->initializedGitRepository->checkout()->execute('6c42d7ba78e0e956bd4e25661a6c13d826ef590a');

        $process = new Process(['git', 'describe'], $this->initializedRepositoryPath);
        $process->run();

        $this->assertEquals(
            \trim($process->getOutput()),
            'annotated-tag'
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::checkout
     * @covers \Bit3\GitPhp\Command\CheckoutCommandBuilder::execute
     */
    public function testCheckoutOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->checkout()->execute('foo');
    }

    public function testPushOnInitializedRepository()
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::push
     * @covers \Bit3\GitPhp\Command\PushCommandBuilder::execute
     */
    public function testPushOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->push()->execute('foo');
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::status
     * @covers \Bit3\GitPhp\Command\StatusCommandBuilder::getStatus
     */
    public function testStatusOnInitializedRepository()
    {
        $status = $this->initializedGitRepository->status()->getStatus();

        $this->assertEquals(
            [
                'removed-but-staged.txt' => ['index' => 'A', 'worktree' => 'D'],
                'unknown-file.txt'       => ['index' => '?', 'worktree' => '?'],
            ],
            $status
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::status
     * @covers \Bit3\GitPhp\Command\StatusCommandBuilder::getStatus
     */
    public function testStatusOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->status()->getStatus();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::add
     * @covers \Bit3\GitPhp\Command\AddCommandBuilder::execute
     */
    public function testAddOnInitializedRepository()
    {
        $this->initializedGitRepository->add()->execute('unknown-file.txt');

        $process = new Process(['git', 'status', '-s'], $this->initializedRepositoryPath);
        $process->run();

        $status = \explode("\n", $process->getOutput());
        $status = \array_map('trim', $status);

        $this->assertTrue(
            \in_array('A  unknown-file.txt', $status)
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::add
     * @covers \Bit3\GitPhp\Command\AddCommandBuilder::execute
     */
    public function testAddOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->add()->execute('unknown-file.txt');
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::rm
     * @covers \Bit3\GitPhp\Command\RmCommandBuilder::execute
     */
    public function testRmOnInitializedRepository()
    {
        $this->initializedGitRepository->rm()->execute('existing-file.txt');

        $process = new Process(['git', 'status', '-s'], $this->initializedRepositoryPath);
        $process->run();

        $status = \explode("\n", $process->getOutput());
        $status = \array_map('trim', $status);

        $this->assertTrue(
            \in_array('D  existing-file.txt', $status)
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::rm
     * @covers \Bit3\GitPhp\Command\RmCommandBuilder::execute
     */
    public function testRmOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->rm()->execute('existing-file.txt');
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::commit
     * @covers \Bit3\GitPhp\Command\CommitCommandBuilder::message
     * @covers \Bit3\GitPhp\Command\CommitCommandBuilder::execute
     */
    public function testCommitOnInitializedRepository()
    {
        $this->initializedGitRepository->commit()->message('Commit changes')->execute();

        $process = new Process(['git', 'status', '-s'], $this->initializedRepositoryPath);
        $process->run();

        $status = \explode("\n", $process->getOutput());
        $status = \array_map('trim', $status);
        $status = \array_filter($status);

        $this->assertEquals(
            [
                'D existing-file.txt',
                'D removed-but-staged.txt',
                '?? unknown-file.txt',
            ],
            $status
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::commit
     * @covers \Bit3\GitPhp\Command\CommitCommandBuilder::message
     * @covers \Bit3\GitPhp\Command\CommitCommandBuilder::execute
     */
    public function testCommitOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->commit()->message('Commit changes')->execute();
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::tag
     * @covers \Bit3\GitPhp\Command\TagCommandBuilder::execute
     */
    public function testTagOnInitializedRepository()
    {
        $this->initializedGitRepository->tag()->execute('unit-test');

        $process = new Process(['git', 'tag'], $this->initializedRepositoryPath);
        $process->run();

        $tags = \explode("\n", $process->getOutput());
        $tags = \array_map('trim', $tags);
        $tags = \array_filter($tags);

        $this->assertTrue(
            \in_array('unit-test', $tags)
        );
    }

    /**
     * @covers \Bit3\GitPhp\GitRepository::tag
     * @covers \Bit3\GitPhp\Command\TagCommandBuilder::execute
     */
    public function testTagOnUninitializedRepository()
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Bit3\GitPhp\GitException');
        } else {
            $this->expectException('Bit3\GitPhp\GitException');
        }

        $this->uninitializedGitRepository->tag()->execute('unit-test');
    }
}

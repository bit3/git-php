GIT repository
==============

[![Build Status](https://travis-ci.org/contao-community-alliance/build-system-repository-git.png)](https://travis-ci.org/contao-community-alliance/build-system-repository-git)

This repository allows you to work with git repositories.

Usage examples
--------------

### init a new git repository

```php
use ContaoCommunityAlliance\BuildSystem\Repository\GitRepository;

$targetDirectory = '/path/to/git/target/directory';

$git = new GitRepository();
$git->init();
```

### clone a git repository

```php
use ContaoCommunityAlliance\BuildSystem\Repository\GitRepository;

$targetDirectory = '/path/to/git/target/directory';

$git = new GitRepository();
$git->cloneRepository($targetDirectory);
```

### list remotes

```php
$remotes = $git->listRemotes();

// array(
//     'origin',
//     'composer',
// )
```

### list branches

```php
$remotes = $git->listBranches();

// array(
//     'master',
//     'hotfix/1.2.3',
// )
```

### list branches including remote tracking branches

```php
$remotes = $git->listBranches();

// array(
//     'master',
//     'hotfix/1.2.3',
//     'remotes/origin/master',
//     'remotes/origin/hotfix/1.2.3',
//     'remotes/origin/release/4.5.6',
// )
```

### describe

```php
$annotatedTag   = $git->describe();
$lightweightTag = $git->describe(GitRepository::DESCRIBE_LIGHTWEIGHT_TAGS);
$recentRef      = $git->describe(GitRepository::DESCRIBE_ALL);
```

### set remote fetch and push url

```php
$git->remoteSetUrl('git@github.com:contao-community-alliance/build-system-repository-git.git');
```

### set remote fetch url

```php
$git->remoteSetFetchUrl('git@github.com:contao-community-alliance/build-system-repository-git.git');
```

### set remote push url

```php
$git->remoteSetPushUrl('git@github.com:contao-community-alliance/build-system-repository-git.git');
```

### add new remote

```php
$git->remoteAdd('git@github.com:contao-community-alliance/build-system-repository-git.git', 'github');
```

### fetch remote objects

```php
$git->remoteFetch('github');
```

### checkout

```php
$git->checkout('hotfix/1.2.3');
```

### push objects

```php
$git->push('hotfix/1.2.3', 'github');
```

### get modification status

```php
$status = $git->status();

// array(
//     'existing-file.txt'      => array('working' => false, 'staging' => 'D'),
//     'removed-but-staged.txt' => array('working' => 'A',   'staging' => 'D'),
//     'staged-file.txt'        => array('working' => 'A',   'staging' => false),
//     'unknown-file.txt'       => array('working' => '?',   'staging' => '?'),
// )
```

### add file to staging index

```php
$git->add('file/to/add.ext');
```

### remove file

```php
$git->rm('file/to/remove.ext');
```

### commit changes

```php
$git->commit('Commit message');
```

### create a tag

```php
$git->tag('v1.2.3');
```

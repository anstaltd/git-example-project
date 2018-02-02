Git example project 
===

Hello Developer! 

## Rebasing and conflicts 

So there's currently 2 branches. One called `feature/new-test-controller-update-thing` and one called `feature/different-test-controller-update`. Which one of these branches should be rebased first?  

In the branches we have edited the same line of code so these branches will conflict when we rebase because the code is different in the same place! Which is cool because as a developer we need to put different pieces of code together which is the beauty of git enabling 2 developers to simultaneously work on the same project thus decreasing the amount of time required to work on a project for one developer.

In this instance we know we're going to have a conflict, The line will be line 16 and when rebasing we'll get something like this 

```php
<?php

namespace App\Http\Controllers;

/**
 * TestController
 * @author Aaryanna Simonelli <ashleighsimonelli@gmail.com>
 */
class TestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        >>>>HEAD
        return view('test');
        ======
        >>>>dsfggfdhhj45656hdfgierg
        return view('different');
        ======
    }
}
```
Here git is showing us both 'lines' and letting us compare. HEAD represents the current version and the one below is the one being rebased in. The commit hash is usually displayed so we have a reference to what's going on. 

when we're presented with the above we need to make a decision on what piece of code we pick. In this scenario we'll require some further work done in order to 'merge' both file `test.blade.php` and `different.blade.php` however! We won't be doing this work whilst we're rebasing! Because you're now changing the history of our tree! It's best when rebasing to only alter the code that is conflicting to resolve the conflict. Then later on work on resolving issues that have arose from rebasing. In this example that would be 'merging' the 2 resourve view files. 

> Please don't commit the `>>>>` and `====` I will murder you!

### The power of git show 

To help us with conflicts we can run `git show {git_hash}` to see what the developer did at that point. So for example running `git show dsfggfdhhj45656hdfgierg` would show us what the developer committed.

A different example but the output would be something like the following 

```
commit e6a84365f05f1bff2c82deb1cf49f7aa5da9b643
Author: ashleigh simonelli <ashleighsimonelli@gmail.com>
Date:   Fri Feb 2 09:46:19 2018 +0000

    Added testController

diff --git a/app/Http/Controllers/TestController.php b/app/Http/Controllers/TestController.php
new file mode 100644
index 0000000..3090441
--- /dev/null
+++ b/app/Http/Controllers/TestController.php
@@ -0,0 +1,18 @@
+<?php
+
+namespace App\Http\Controllers;
+
+/**
+ * TestController
+ * @author Aaryanna Simonelli <ashleighsimonelli@gmail.com>
+ */
+class TestController extends Controller
+{
+    /**
+     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
+     */
+    public function index()
+    {
+        return view('welcome');
+    }
+}

```
So in the above you can see Ashleigh has committed a new controller basically. Other commits we can see different differences between what was there before the developer committed and after. It's a comparision of what was changed.

## The power of git diff

Above we looked at git show. Git show does a series of `git diff` commands for a particular commit (or position in the history). In the example above you can see a line like 

```bash
diff --git a/app/Http/Controllers/TestController.php b/app/Http/Controllers/TestController.php
```
this is comparing a singular file at different points in time! version a being in the past and b being the present or a particular point in time. 

Git diff can be used in many ways and is incredibly powerful! Below we will look at the differences between the remote and local and comparing them using git diff.

## What is staging? 

![alt git stages](https://git-scm.com/figures/18333fig0201-tn.png)

With git there's almost like a state for each change you make when you're working. Notice I said change and not file! 

When adding new files to the project, git will mark these as 'untracked' in other words untracked files/changes. Which is pretty self explanatory; the file is not in git. Which is correct because it's a completely new file! 

When using git in a project you'll notice a file called `.git`. Here git logs all the changes you make (this is how git works!). A file that is untracked has not been logged here! 

When you've made changes (to an already tracked file) git will say "Hey! You've made a difference to this file since I tracked it" and these become 'unstaged changes'. This means you've made changes BUT! You haven't added them to your stage in order to make a commit. 

For instance we use `git add -A` a LOT and what you're doing with this command is adding every change you've made into the commit. Which is handy and pretty cool! BUT sometimes for a project manage it's a pain in the arse because you could've made 2 serious changes for different reasons and now you've made one commit for these changes! 

Let's say we fixed 2 issues at the same time because they we're kinda related (shit happens blud). These changes are in 2 different files and we run a git status

Just for examples sake 

```bash
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

	modified:   .gitignore
	modified:   readme.md

```
You can see git is saying 'these changes are not staged for commit'. Meaning we haven't staged anything so we can't commit. 
So we want to commit these files differently and to do that we can use `git add` (notice I missed the `-A` option!). You wanna do the readme first? Cool let's do that 

`git add readme.md`

BOOM! DONE! The readme is now staged! And we can see this in our git status

```bash
On branch master
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

	modified:   readme.md

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

	modified:   .gitignore

```

So now we can commit the readme changes and ignore the `.gitignore` for now. So lets commit that using `git commit`.

## The difference between remote and local

Now, this might be obvious but your computer is not github. SHOCK-fucking-HORROR right? So we use github for nearly every project. So we commonly have one remote server. We can list our remotes using `git remote -v`

```bash
origin	git@github.com:chickenTikkaMasala/git-example-project.git (fetch)
origin	git@github.com:chickenTikkaMasala/git-example-project.git (push)
```

So here we can see there is one remote and with this one remote we have 2 channels. A fetch and a push. If we wanted to be fancy we could change these so we could fetch from a private bitbucket remote and push to a github one but why? So we don't bother too much with this. 

When we push we use `git push`. Which uses the default remote which is usually origin. We can add additional remote and push to them using `git push my-new-cool-remote-bro` and that will push to a different remote than origin. 

### So in this spaghetti web of remotes, where's my local?

Your local is your computer, you is developers, you is the working node in a sense. 

![alt git flow](https://www.git-tower.com/learn/content/01-git/01-ebook/en/01-command-line/04-remote-repositories/01-introduction/basic-remote-workflow.png)

Imagine there's 2 developers working on a project. Between them the remote is the connection between the 2. The remote contains the history of what both developers have done to the project. Thus both developers can compare their changes to one another using git diff. Let's say we're both working on the same branch (please don't but for arguments sake).

Both developers can make commits and change the history, when committing and pushing; if your history doesn't match the remote you will be rejected! This is because you're changing the history! And what I mean by that is you are removing someone else's work! To avoid this in this scenario we can do a comparison with the remote rather than our local history. To do this you can do 

```bash
git diff master -- remote/origin/master
```

This will show you the difference with changes. However it will not show you the different in your history! To do that you can use `git status`. If you see something like:

```bash
Your branch is behind by 1 commits
```

Oh no! The other developer committed before you could! We can fix this though! Using the stash ;) in order to use the stash we need to make sure our changes are not staged. So we can use `git reset` to take things out of the stage. Once we've done this we can use the stash!

## Stash 

The stash is like a 'cache' for your local. Stashing means you've taken your changes and 'saved' them somewhere else. Usually in order to pull on the remote. (based on the scenario above where another developer has committed on your branch and your local is now behind).

```bash
git stash
```

Be careful with with stash! I'm not 100% on using it and I believe from experience it will only stash one set of changes. So you can only use it once. 

I commonly use this combination to update my local with a remote:

```bash
git stash 
git pull
git stash apply
```

[alt git stash](https://cms-assets.tutsplus.com/uploads/users/585/posts/22988/image/git-stash-stashing-changes.png)

## Rebasing vs merging

As always there's a time and a place for everything. Essentially the difference is rebasing changes your history in order to make a nice neat tree. With merging we're merging our history BUT not altering the tree.

Rebasing makes a nice neat line of commits. It's easier to read in tig that I keep banging on about, it's easier to see the history etc. I am a bit biased because when using merge in an environment of 30 devs a lot of my work disappeared when a developer would merge my work in with the rest and their commits were favoured over mine: hence my work didn't 'work' and I got blamed for it. I see merging like SVN merging. SVN is like once branch and one branch only. If someone edits the same file as you, when merging you can only pick one version. so code can go walkies and you're left there scratching your head as to where your work went. 

# HELPS MEH I IZ CONFUZED

It's cool, git is a confusing concept to get your head around. I see git as the 4th and 5th dimension which I think blew @skinnymikeofdoom 's mind!

Another way of looking at it is like a tree. As we code the tree grows! 

![alt git tree](https://www.drupal.org/files/repositorydiagram.png)

## Git terminology 

https://git-scm.com/docs/gitglossary

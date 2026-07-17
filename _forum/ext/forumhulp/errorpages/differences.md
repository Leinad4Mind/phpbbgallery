Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/forumhulp\\errorpages/.travis.yml" "[ORIGINAL]/forumhulp\\errorpages/.travis.yml"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\errorpages/.travis.yml"
+++ /dev/null
@@ -1,60 +0,0 @@
-language: php
-
-matrix:
-  include:
-    - php: 5.4
-      env: DB=mysqli
-    - php: 5.4
-      env: DB=mysql
-    - php: 5.4
-      env: DB=mariadb
-    - php: 5.4
-      env: DB=postgres
-    - php: 5.4
-      env: DB=sqlite3
-    - php: 5.5
-      env: DB=mysqli
-    - php: 5.6
-      env: DB=mysqli
-    - php: hhvm
-      env: DB=mysqli
-  allow_failures:
-    - php: hhvm
-  fast_finish: true
-
-env:
-  global:
-    - EXTNAME="ForumHulp/errorpages"  # CHANGE name of the extension HERE
-    - SNIFF="1"            # Should we run code sniffer on your code?
-    - IMAGE_ICC="0"        # Should we run icc profile sniffer on your images?
-    - EPV="0"              # Should we run EPV (Extension Pre Validator) on your code?
-    - PHPBB_BRANCH="3.1.x"
-
-branches:
-  only:
-    - master
-    - develop
-    - /^develop-.*$/
-
-before_install:
-  - sudo mkdir travis
-  - git clone "https://github.com/nickvergessen/phpbb-ext-acme-demo.git"
-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
-  - sudo rm -rf phpbb-ext-acme-demo
-
-install:
-  - composer install --dev --no-interaction --prefer-source
-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
-  - cd ../../phpBB3
-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
-
-before_script:
-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
-
-script:
-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
-  - sh -c "if [ '$EPV' != '0' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
diff --git "[ORIGINAL]/forumhulp\\errorpages/LICENSE.txt" "[ORIGINAL]/forumhulp\\errorpages/LICENSE.txt"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\errorpages/LICENSE.txt"
+++ /dev/null
@@ -1,281 +0,0 @@
-		    GNU GENERAL PUBLIC LICENSE
-		       Version 2, June 1991
-
- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
-                          675 Mass Ave, Cambridge, MA 02139, USA
- Everyone is permitted to copy and distribute verbatim copies
- of this license document, but changing it is not allowed.
-
-			    Preamble
-
-  The licenses for most software are designed to take away your
-freedom to share and change it.  By contrast, the GNU General Public
-License is intended to guarantee your freedom to share and change free
-software--to make sure the software is free for all its users.  This
-General Public License applies to most of the Free Software
-Foundation's software and to any other program whose authors commit to
-using it.  (Some other Free Software Foundation software is covered by
-the GNU Library General Public License instead.)  You can apply it to
-your programs, too.
-
-  When we speak of free software, we are referring to freedom, not
-price.  Our General Public Licenses are designed to make sure that you
-have the freedom to distribute copies of free software (and charge for
-this service if you wish), that you receive source code or can get it
-if you want it, that you can change the software or use pieces of it
-in new free programs; and that you know you can do these things.
-
-  To protect your rights, we need to make restrictions that forbid
-anyone to deny you these rights or to ask you to surrender the rights.
-These restrictions translate to certain responsibilities for you if you
-distribute copies of the software, or if you modify it.
-
-  For example, if you distribute copies of such a program, whether
-gratis or for a fee, you must give the recipients all the rights that
-you have.  You must make sure that they, too, receive or can get the
-source code.  And you must show them these terms so they know their
-rights.
-
-  We protect your rights with two steps: (1) copyright the software, and
-(2) offer you this license which gives you legal permission to copy,
-distribute and/or modify the software.
-
-  Also, for each author's protection and ours, we want to make certain
-that everyone understands that there is no warranty for this free
-software.  If the software is modified by someone else and passed on, we
-want its recipients to know that what they have is not the original, so
-that any problems introduced by others will not reflect on the original
-authors' reputations.
-
-  Finally, any free program is threatened constantly by software
-patents.  We wish to avoid the danger that redistributors of a free
-program will individually obtain patent licenses, in effect making the
-program proprietary.  To prevent this, we have made it clear that any
-patent must be licensed for everyone's free use or not licensed at all.
-
-  The precise terms and conditions for copying, distribution and
-modification follow.
-
-		    GNU GENERAL PUBLIC LICENSE
-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
-
-  0. This License applies to any program or other work which contains
-a notice placed by the copyright holder saying it may be distributed
-under the terms of this General Public License.  The "Program", below,
-refers to any such program or work, and a "work based on the Program"
-means either the Program or any derivative work under copyright law:
-that is to say, a work containing the Program or a portion of it,
-either verbatim or with modifications and/or translated into another
-language.  (Hereinafter, translation is included without limitation in
-the term "modification".)  Each licensee is addressed as "you".
-
-Activities other than copying, distribution and modification are not
-covered by this License; they are outside its scope.  The act of
-running the Program is not restricted, and the output from the Program
-is covered only if its contents constitute a work based on the
-Program (independent of having been made by running the Program).
-Whether that is true depends on what the Program does.
-
-  1. You may copy and distribute verbatim copies of the Program's
-source code as you receive it, in any medium, provided that you
-conspicuously and appropriately publish on each copy an appropriate
-copyright notice and disclaimer of warranty; keep intact all the
-notices that refer to this License and to the absence of any warranty;
-and give any other recipients of the Program a copy of this License
-along with the Program.
-
-You may charge a fee for the physical act of transferring a copy, and
-you may at your option offer warranty protection in exchange for a fee.
-
-  2. You may modify your copy or copies of the Program or any portion
-of it, thus forming a work based on the Program, and copy and
-distribute such modifications or work under the terms of Section 1
-above, provided that you also meet all of these conditions:
-
-    a) You must cause the modified files to carry prominent notices
-    stating that you changed the files and the date of any change.
-
-    b) You must cause any work that you distribute or publish, that in
-    whole or in part contains or is derived from the Program or any
-    part thereof, to be licensed as a whole at no charge to all third
-    parties under the terms of this License.
-
-    c) If the modified program normally reads commands interactively
-    when run, you must cause it, when started running for such
-    interactive use in the most ordinary way, to print or display an
-    announcement including an appropriate copyright notice and a
-    notice that there is no warranty (or else, saying that you provide
-    a warranty) and that users may redistribute the program under
-    these conditions, and telling the user how to view a copy of this
-    License.  (Exception: if the Program itself is interactive but
-    does not normally print such an announcement, your work based on
-    the Program is not required to print an announcement.)
-
-These requirements apply to the modified work as a whole.  If
-identifiable sections of that work are not derived from the Program,
-and can be reasonably considered independent and separate works in
-themselves, then this License, and its terms, do not apply to those
-sections when you distribute them as separate works.  But when you
-distribute the same sections as part of a whole which is a work based
-on the Program, the distribution of the whole must be on the terms of
-this License, whose permissions for other licensees extend to the
-entire whole, and thus to each and every part regardless of who wrote it.
-
-Thus, it is not the intent of this section to claim rights or contest
-your rights to work written entirely by you; rather, the intent is to
-exercise the right to control the distribution of derivative or
-collective works based on the Program.
-
-In addition, mere aggregation of another work not based on the Program
-with the Program (or with a work based on the Program) on a volume of
-a storage or distribution medium does not bring the other work under
-the scope of this License.
-
-  3. You may copy and distribute the Program (or a work based on it,
-under Section 2) in object code or executable form under the terms of
-Sections 1 and 2 above provided that you also do one of the following:
-
-    a) Accompany it with the complete corresponding machine-readable
-    source code, which must be distributed under the terms of Sections
-    1 and 2 above on a medium customarily used for software interchange; or,
-
-    b) Accompany it with a written offer, valid for at least three
-    years, to give any third party, for a charge no more than your
-    cost of physically performing source distribution, a complete
-    machine-readable copy of the corresponding source code, to be
-    distributed under the terms of Sections 1 and 2 above on a medium
-    customarily used for software interchange; or,
-
-    c) Accompany it with the information you received as to the offer
-    to distribute corresponding source code.  (This alternative is
-    allowed only for noncommercial distribution and only if you
-    received the program in object code or executable form with such
-    an offer, in accord with Subsection b above.)
-
-The source code for a work means the preferred form of the work for
-making modifications to it.  For an executable work, complete source
-code means all the source code for all modules it contains, plus any
-associated interface definition files, plus the scripts used to
-control compilation and installation of the executable.  However, as a
-special exception, the source code distributed need not include
-anything that is normally distributed (in either source or binary
-form) with the major components (compiler, kernel, and so on) of the
-operating system on which the executable runs, unless that component
-itself accompanies the executable.
-
-If distribution of executable or object code is made by offering
-access to copy from a designated place, then offering equivalent
-access to copy the source code from the same place counts as
-distribution of the source code, even though third parties are not
-compelled to copy the source along with the object code.
-
-  4. You may not copy, modify, sublicense, or distribute the Program
-except as expressly provided under this License.  Any attempt
-otherwise to copy, modify, sublicense or distribute the Program is
-void, and will automatically terminate your rights under this License.
-However, parties who have received copies, or rights, from you under
-this License will not have their licenses terminated so long as such
-parties remain in full compliance.
-
-  5. You are not required to accept this License, since you have not
-signed it.  However, nothing else grants you permission to modify or
-distribute the Program or its derivative works.  These actions are
-prohibited by law if you do not accept this License.  Therefore, by
-modifying or distributing the Program (or any work based on the
-Program), you indicate your acceptance of this License to do so, and
-all its terms and conditions for copying, distributing or modifying
-the Program or works based on it.
-
-  6. Each time you redistribute the Program (or any work based on the
-Program), the recipient automatically receives a license from the
-original licensor to copy, distribute or modify the Program subject to
-these terms and conditions.  You may not impose any further
-restrictions on the recipients' exercise of the rights granted herein.
-You are not responsible for enforcing compliance by third parties to
-this License.
-
-  7. If, as a consequence of a court judgment or allegation of patent
-infringement or for any other reason (not limited to patent issues),
-conditions are imposed on you (whether by court order, agreement or
-otherwise) that contradict the conditions of this License, they do not
-excuse you from the conditions of this License.  If you cannot
-distribute so as to satisfy simultaneously your obligations under this
-License and any other pertinent obligations, then as a consequence you
-may not distribute the Program at all.  For example, if a patent
-license would not permit royalty-free redistribution of the Program by
-all those who receive copies directly or indirectly through you, then
-the only way you could satisfy both it and this License would be to
-refrain entirely from distribution of the Program.
-
-If any portion of this section is held invalid or unenforceable under
-any particular circumstance, the balance of the section is intended to
-apply and the section as a whole is intended to apply in other
-circumstances.
-
-It is not the purpose of this section to induce you to infringe any
-patents or other property right claims or to contest validity of any
-such claims; this section has the sole purpose of protecting the
-integrity of the free software distribution system, which is
-implemented by public license practices.  Many people have made
-generous contributions to the wide range of software distributed
-through that system in reliance on consistent application of that
-system; it is up to the author/donor to decide if he or she is willing
-to distribute software through any other system and a licensee cannot
-impose that choice.
-
-This section is intended to make thoroughly clear what is believed to
-be a consequence of the rest of this License.
-
-  8. If the distribution and/or use of the Program is restricted in
-certain countries either by patents or by copyrighted interfaces, the
-original copyright holder who places the Program under this License
-may add an explicit geographical distribution limitation excluding
-those countries, so that distribution is permitted only in or among
-countries not thus excluded.  In such case, this License incorporates
-the limitation as if written in the body of this License.
-
-  9. The Free Software Foundation may publish revised and/or new versions
-of the General Public License from time to time.  Such new versions will
-be similar in spirit to the present version, but may differ in detail to
-address new problems or concerns.
-
-Each version is given a distinguishing version number.  If the Program
-specifies a version number of this License which applies to it and "any
-later version", you have the option of following the terms and conditions
-either of that version or of any later version published by the Free
-Software Foundation.  If the Program does not specify a version number of
-this License, you may choose any version ever published by the Free Software
-Foundation.
-
-  10. If you wish to incorporate parts of the Program into other free
-programs whose distribution conditions are different, write to the author
-to ask for permission.  For software which is copyrighted by the Free
-Software Foundation, write to the Free Software Foundation; we sometimes
-make exceptions for this.  Our decision will be guided by the two goals
-of preserving the free status of all derivatives of our free software and
-of promoting the sharing and reuse of software generally.
-
-			    NO WARRANTY
-
-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
-REPAIR OR CORRECTION.
-
-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
-POSSIBILITY OF SUCH DAMAGES.
-
-		     END OF TERMS AND CONDITIONS
-
diff --git "[ORIGINAL]/forumhulp\\errorpages/README.md" "[ORIGINAL]/forumhulp\\errorpages/README.md"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\errorpages/README.md"
+++ /dev/null
@@ -1,39 +0,0 @@
-Errorpages
-===========
-
-Error pages displays custom error pages in your forum. As an option all errors are logged in your errorlog.
-
-[![Build Status](https://travis-ci.org/ForumHulp/errorpages.svg?branch=master)](https://travis-ci.org/ForumHulp/errorpages)
-
-## Requirements
-* phpBB 3.1.0-dev or higher
-* PHP 5.3.3 or higher
-
-## Installation
-You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:
-
-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/errorpages/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
-3. Click Error pages => `Enable`.
-
-Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.
-
-## Update
-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/errorpages/archive/master.zip).
-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
-3. Copy the contents of `errorpages-master` folder to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Enable`.
-5. Click `Details` or `Re-Check all versions` link to follow updates.
-6. Or use our Upload Extensions extension
-
-## Uninstallation
-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
-
-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/errorpages/` folder or use our Upload Extensions extension to delet all files and folders.
-
-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
-
-## License
-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
-
-© 2014 - John Peskens (ForumHulp.com)
diff --git "[ORIGINAL]/forumhulp\\errorpages/config/services.yml" "[FORUM_EXT]/forumhulp\\errorpages/config/services.yml"
--- "[ORIGINAL]/forumhulp\\errorpages/config/services.yml"
+++ "[FORUM_EXT]/forumhulp\\errorpages/config/services.yml"
@@ -2,15 +2,16 @@ services:
     kernel.listener.forumhulp_errorpages:
         class: forumhulp\errorpages\event\listener
         arguments:
-            - @config
-            - @user
-            - @template
-            - @log
+            - '@config'
+            - '@user'
+            - '@template'
+            - '@log'
         tags:
             - { name: kernel.event_listener, event: kernel.exception, method: onKernelException }
+
     forumhulp.errorpages.acp_listener:
         class: forumhulp\errorpages\event\acp_listener
         arguments:
-            - @controller.helper
+            - '@controller.helper'
         tags:
             - { name: event.listener }
\ No newline at end of file
diff --git "[FORUM_EXT]/forumhulp\\errorpages/diff_full.tmp" "[FORUM_EXT]/forumhulp\\errorpages/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\errorpages/diff_full.tmp"
@@ -0,0 +1,1242 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
+deleted file mode 100644
+index c1dfdae77..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
++++ /dev/null
+@@ -1,60 +0,0 @@
+-language: php
+-
+-matrix:
+-  include:
+-    - php: 5.4
+-      env: DB=mysqli
+-    - php: 5.4
+-      env: DB=mysql
+-    - php: 5.4
+-      env: DB=mariadb
+-    - php: 5.4
+-      env: DB=postgres
+-    - php: 5.4
+-      env: DB=sqlite3
+-    - php: 5.5
+-      env: DB=mysqli
+-    - php: 5.6
+-      env: DB=mysqli
+-    - php: hhvm
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: hhvm
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="ForumHulp/errorpages"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="0"        # Should we run icc profile sniffer on your images?
+-    - EPV="0"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.1.x"
+-
+-branches:
+-  only:
+-    - master
+-    - develop
+-    - /^develop-.*$/
+-
+-before_install:
+-  - sudo mkdir travis
+-  - git clone "https://github.com/nickvergessen/phpbb-ext-acme-demo.git"
+-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
+-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
+-  - sudo rm -rf phpbb-ext-acme-demo
+-
+-install:
+-  - composer install --dev --no-interaction --prefer-source
+-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+-  - sh -c "if [ '$EPV' != '0' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
+deleted file mode 100644
+index ce992b2ce..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
++++ /dev/null
+@@ -1,281 +0,0 @@
+-		    GNU GENERAL PUBLIC LICENSE
+-		       Version 2, June 1991
+-
+- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
+-                          675 Mass Ave, Cambridge, MA 02139, USA
+- Everyone is permitted to copy and distribute verbatim copies
+- of this license document, but changing it is not allowed.
+-
+-			    Preamble
+-
+-  The licenses for most software are designed to take away your
+-freedom to share and change it.  By contrast, the GNU General Public
+-License is intended to guarantee your freedom to share and change free
+-software--to make sure the software is free for all its users.  This
+-General Public License applies to most of the Free Software
+-Foundation's software and to any other program whose authors commit to
+-using it.  (Some other Free Software Foundation software is covered by
+-the GNU Library General Public License instead.)  You can apply it to
+-your programs, too.
+-
+-  When we speak of free software, we are referring to freedom, not
+-price.  Our General Public Licenses are designed to make sure that you
+-have the freedom to distribute copies of free software (and charge for
+-this service if you wish), that you receive source code or can get it
+-if you want it, that you can change the software or use pieces of it
+-in new free programs; and that you know you can do these things.
+-
+-  To protect your rights, we need to make restrictions that forbid
+-anyone to deny you these rights or to ask you to surrender the rights.
+-These restrictions translate to certain responsibilities for you if you
+-distribute copies of the software, or if you modify it.
+-
+-  For example, if you distribute copies of such a program, whether
+-gratis or for a fee, you must give the recipients all the rights that
+-you have.  You must make sure that they, too, receive or can get the
+-source code.  And you must show them these terms so they know their
+-rights.
+-
+-  We protect your rights with two steps: (1) copyright the software, and
+-(2) offer you this license which gives you legal permission to copy,
+-distribute and/or modify the software.
+-
+-  Also, for each author's protection and ours, we want to make certain
+-that everyone understands that there is no warranty for this free
+-software.  If the software is modified by someone else and passed on, we
+-want its recipients to know that what they have is not the original, so
+-that any problems introduced by others will not reflect on the original
+-authors' reputations.
+-
+-  Finally, any free program is threatened constantly by software
+-patents.  We wish to avoid the danger that redistributors of a free
+-program will individually obtain patent licenses, in effect making the
+-program proprietary.  To prevent this, we have made it clear that any
+-patent must be licensed for everyone's free use or not licensed at all.
+-
+-  The precise terms and conditions for copying, distribution and
+-modification follow.
+-
+-		    GNU GENERAL PUBLIC LICENSE
+-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
+-
+-  0. This License applies to any program or other work which contains
+-a notice placed by the copyright holder saying it may be distributed
+-under the terms of this General Public License.  The "Program", below,
+-refers to any such program or work, and a "work based on the Program"
+-means either the Program or any derivative work under copyright law:
+-that is to say, a work containing the Program or a portion of it,
+-either verbatim or with modifications and/or translated into another
+-language.  (Hereinafter, translation is included without limitation in
+-the term "modification".)  Each licensee is addressed as "you".
+-
+-Activities other than copying, distribution and modification are not
+-covered by this License; they are outside its scope.  The act of
+-running the Program is not restricted, and the output from the Program
+-is covered only if its contents constitute a work based on the
+-Program (independent of having been made by running the Program).
+-Whether that is true depends on what the Program does.
+-
+-  1. You may copy and distribute verbatim copies of the Program's
+-source code as you receive it, in any medium, provided that you
+-conspicuously and appropriately publish on each copy an appropriate
+-copyright notice and disclaimer of warranty; keep intact all the
+-notices that refer to this License and to the absence of any warranty;
+-and give any other recipients of the Program a copy of this License
+-along with the Program.
+-
+-You may charge a fee for the physical act of transferring a copy, and
+-you may at your option offer warranty protection in exchange for a fee.
+-
+-  2. You may modify your copy or copies of the Program or any portion
+-of it, thus forming a work based on the Program, and copy and
+-distribute such modifications or work under the terms of Section 1
+-above, provided that you also meet all of these conditions:
+-
+-    a) You must cause the modified files to carry prominent notices
+-    stating that you changed the files and the date of any change.
+-
+-    b) You must cause any work that you distribute or publish, that in
+-    whole or in part contains or is derived from the Program or any
+-    part thereof, to be licensed as a whole at no charge to all third
+-    parties under the terms of this License.
+-
+-    c) If the modified program normally reads commands interactively
+-    when run, you must cause it, when started running for such
+-    interactive use in the most ordinary way, to print or display an
+-    announcement including an appropriate copyright notice and a
+-    notice that there is no warranty (or else, saying that you provide
+-    a warranty) and that users may redistribute the program under
+-    these conditions, and telling the user how to view a copy of this
+-    License.  (Exception: if the Program itself is interactive but
+-    does not normally print such an announcement, your work based on
+-    the Program is not required to print an announcement.)
+-
+-These requirements apply to the modified work as a whole.  If
+-identifiable sections of that work are not derived from the Program,
+-and can be reasonably considered independent and separate works in
+-themselves, then this License, and its terms, do not apply to those
+-sections when you distribute them as separate works.  But when you
+-distribute the same sections as part of a whole which is a work based
+-on the Program, the distribution of the whole must be on the terms of
+-this License, whose permissions for other licensees extend to the
+-entire whole, and thus to each and every part regardless of who wrote it.
+-
+-Thus, it is not the intent of this section to claim rights or contest
+-your rights to work written entirely by you; rather, the intent is to
+-exercise the right to control the distribution of derivative or
+-collective works based on the Program.
+-
+-In addition, mere aggregation of another work not based on the Program
+-with the Program (or with a work based on the Program) on a volume of
+-a storage or distribution medium does not bring the other work under
+-the scope of this License.
+-
+-  3. You may copy and distribute the Program (or a work based on it,
+-under Section 2) in object code or executable form under the terms of
+-Sections 1 and 2 above provided that you also do one of the following:
+-
+-    a) Accompany it with the complete corresponding machine-readable
+-    source code, which must be distributed under the terms of Sections
+-    1 and 2 above on a medium customarily used for software interchange; or,
+-
+-    b) Accompany it with a written offer, valid for at least three
+-    years, to give any third party, for a charge no more than your
+-    cost of physically performing source distribution, a complete
+-    machine-readable copy of the corresponding source code, to be
+-    distributed under the terms of Sections 1 and 2 above on a medium
+-    customarily used for software interchange; or,
+-
+-    c) Accompany it with the information you received as to the offer
+-    to distribute corresponding source code.  (This alternative is
+-    allowed only for noncommercial distribution and only if you
+-    received the program in object code or executable form with such
+-    an offer, in accord with Subsection b above.)
+-
+-The source code for a work means the preferred form of the work for
+-making modifications to it.  For an executable work, complete source
+-code means all the source code for all modules it contains, plus any
+-associated interface definition files, plus the scripts used to
+-control compilation and installation of the executable.  However, as a
+-special exception, the source code distributed need not include
+-anything that is normally distributed (in either source or binary
+-form) with the major components (compiler, kernel, and so on) of the
+-operating system on which the executable runs, unless that component
+-itself accompanies the executable.
+-
+-If distribution of executable or object code is made by offering
+-access to copy from a designated place, then offering equivalent
+-access to copy the source code from the same place counts as
+-distribution of the source code, even though third parties are not
+-compelled to copy the source along with the object code.
+-
+-  4. You may not copy, modify, sublicense, or distribute the Program
+-except as expressly provided under this License.  Any attempt
+-otherwise to copy, modify, sublicense or distribute the Program is
+-void, and will automatically terminate your rights under this License.
+-However, parties who have received copies, or rights, from you under
+-this License will not have their licenses terminated so long as such
+-parties remain in full compliance.
+-
+-  5. You are not required to accept this License, since you have not
+-signed it.  However, nothing else grants you permission to modify or
+-distribute the Program or its derivative works.  These actions are
+-prohibited by law if you do not accept this License.  Therefore, by
+-modifying or distributing the Program (or any work based on the
+-Program), you indicate your acceptance of this License to do so, and
+-all its terms and conditions for copying, distributing or modifying
+-the Program or works based on it.
+-
+-  6. Each time you redistribute the Program (or any work based on the
+-Program), the recipient automatically receives a license from the
+-original licensor to copy, distribute or modify the Program subject to
+-these terms and conditions.  You may not impose any further
+-restrictions on the recipients' exercise of the rights granted herein.
+-You are not responsible for enforcing compliance by third parties to
+-this License.
+-
+-  7. If, as a consequence of a court judgment or allegation of patent
+-infringement or for any other reason (not limited to patent issues),
+-conditions are imposed on you (whether by court order, agreement or
+-otherwise) that contradict the conditions of this License, they do not
+-excuse you from the conditions of this License.  If you cannot
+-distribute so as to satisfy simultaneously your obligations under this
+-License and any other pertinent obligations, then as a consequence you
+-may not distribute the Program at all.  For example, if a patent
+-license would not permit royalty-free redistribution of the Program by
+-all those who receive copies directly or indirectly through you, then
+-the only way you could satisfy both it and this License would be to
+-refrain entirely from distribution of the Program.
+-
+-If any portion of this section is held invalid or unenforceable under
+-any particular circumstance, the balance of the section is intended to
+-apply and the section as a whole is intended to apply in other
+-circumstances.
+-
+-It is not the purpose of this section to induce you to infringe any
+-patents or other property right claims or to contest validity of any
+-such claims; this section has the sole purpose of protecting the
+-integrity of the free software distribution system, which is
+-implemented by public license practices.  Many people have made
+-generous contributions to the wide range of software distributed
+-through that system in reliance on consistent application of that
+-system; it is up to the author/donor to decide if he or she is willing
+-to distribute software through any other system and a licensee cannot
+-impose that choice.
+-
+-This section is intended to make thoroughly clear what is believed to
+-be a consequence of the rest of this License.
+-
+-  8. If the distribution and/or use of the Program is restricted in
+-certain countries either by patents or by copyrighted interfaces, the
+-original copyright holder who places the Program under this License
+-may add an explicit geographical distribution limitation excluding
+-those countries, so that distribution is permitted only in or among
+-countries not thus excluded.  In such case, this License incorporates
+-the limitation as if written in the body of this License.
+-
+-  9. The Free Software Foundation may publish revised and/or new versions
+-of the General Public License from time to time.  Such new versions will
+-be similar in spirit to the present version, but may differ in detail to
+-address new problems or concerns.
+-
+-Each version is given a distinguishing version number.  If the Program
+-specifies a version number of this License which applies to it and "any
+-later version", you have the option of following the terms and conditions
+-either of that version or of any later version published by the Free
+-Software Foundation.  If the Program does not specify a version number of
+-this License, you may choose any version ever published by the Free Software
+-Foundation.
+-
+-  10. If you wish to incorporate parts of the Program into other free
+-programs whose distribution conditions are different, write to the author
+-to ask for permission.  For software which is copyrighted by the Free
+-Software Foundation, write to the Free Software Foundation; we sometimes
+-make exceptions for this.  Our decision will be guided by the two goals
+-of preserving the free status of all derivatives of our free software and
+-of promoting the sharing and reuse of software generally.
+-
+-			    NO WARRANTY
+-
+-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
+-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
+-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
+-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
+-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
+-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
+-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
+-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
+-REPAIR OR CORRECTION.
+-
+-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
+-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
+-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
+-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
+-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
+-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
+-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
+-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
+-POSSIBILITY OF SUCH DAMAGES.
+-
+-		     END OF TERMS AND CONDITIONS
+-
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
+deleted file mode 100644
+index 367657e64..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
++++ /dev/null
+@@ -1,39 +0,0 @@
+-Errorpages
+-===========
+-
+-Error pages displays custom error pages in your forum. As an option all errors are logged in your errorlog.
+-
+-[![Build Status](https://travis-ci.org/ForumHulp/errorpages.svg?branch=master)](https://travis-ci.org/ForumHulp/errorpages)
+-
+-## Requirements
+-* phpBB 3.1.0-dev or higher
+-* PHP 5.3.3 or higher
+-
+-## Installation
+-You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:
+-
+-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/errorpages/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
+-3. Click Error pages => `Enable`.
+-
+-Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.
+-
+-## Update
+-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/errorpages/archive/master.zip).
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
+-3. Copy the contents of `errorpages-master` folder to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
+-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Enable`.
+-5. Click `Details` or `Re-Check all versions` link to follow updates.
+-6. Or use our Upload Extensions extension
+-
+-## Uninstallation
+-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
+-
+-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/errorpages/` folder or use our Upload Extensions extension to delet all files and folders.
+-
+-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
+-
+-## License
+-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
+-
+-© 2014 - John Peskens (ForumHulp.com)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/config/services.yml"
+index 33bd7f719..e2c5eac76 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/config/services.yml"
+@@ -2,15 +2,16 @@ services:
+     kernel.listener.forumhulp_errorpages:
+         class: forumhulp\errorpages\event\listener
+         arguments:
+-            - @config
+-            - @user
+-            - @template
+-            - @log
++            - '@config'
++            - '@user'
++            - '@template'
++            - '@log'
+         tags:
+             - { name: kernel.event_listener, event: kernel.exception, method: onKernelException }
++
+     forumhulp.errorpages.acp_listener:
+         class: forumhulp\errorpages\event\acp_listener
+         arguments:
+-            - @controller.helper
++            - '@controller.helper'
+         tags:
+             - { name: event.listener }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp"
+new file mode 100644
+index 000000000..1179747a0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp"
+@@ -0,0 +1,393 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
++deleted file mode 100644
++index c1dfdae77..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
+++++ /dev/null
++@@ -1,60 +0,0 @@
++-language: php
++-
++-matrix:
++-  include:
++-    - php: 5.4
++-      env: DB=mysqli
++-    - php: 5.4
++-      env: DB=mysql
++-    - php: 5.4
++-      env: DB=mariadb
++-    - php: 5.4
++-      env: DB=postgres
++-    - php: 5.4
++-      env: DB=sqlite3
++-    - php: 5.5
++-      env: DB=mysqli
++-    - php: 5.6
++-      env: DB=mysqli
++-    - php: hhvm
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: hhvm
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="ForumHulp/errorpages"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="0"        # Should we run icc profile sniffer on your images?
++-    - EPV="0"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.1.x"
++-
++-branches:
++-  only:
++-    - master
++-    - develop
++-    - /^develop-.*$/
++-
++-before_install:
++-  - sudo mkdir travis
++-  - git clone "https://github.com/nickvergessen/phpbb-ext-acme-demo.git"
++-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
++-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
++-  - sudo rm -rf phpbb-ext-acme-demo
++-
++-install:
++-  - composer install --dev --no-interaction --prefer-source
++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
++-  - sh -c "if [ '$EPV' != '0' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
++deleted file mode 100644
++index ce992b2ce..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
+++++ /dev/null
++@@ -1,281 +0,0 @@
++-		    GNU GENERAL PUBLIC LICENSE
++-		       Version 2, June 1991
++-
++- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
++-                          675 Mass Ave, Cambridge, MA 02139, USA
++- Everyone is permitted to copy and distribute verbatim copies
++- of this license document, but changing it is not allowed.
++-
++-			    Preamble
++-
++-  The licenses for most software are designed to take away your
++-freedom to share and change it.  By contrast, the GNU General Public
++-License is intended to guarantee your freedom to share and change free
++-software--to make sure the software is free for all its users.  This
++-General Public License applies to most of the Free Software
++-Foundation's software and to any other program whose authors commit to
++-using it.  (Some other Free Software Foundation software is covered by
++-the GNU Library General Public License instead.)  You can apply it to
++-your programs, too.
++-
++-  When we speak of free software, we are referring to freedom, not
++-price.  Our General Public Licenses are designed to make sure that you
++-have the freedom to distribute copies of free software (and charge for
++-this service if you wish), that you receive source code or can get it
++-if you want it, that you can change the software or use pieces of it
++-in new free programs; and that you know you can do these things.
++-
++-  To protect your rights, we need to make restrictions that forbid
++-anyone to deny you these rights or to ask you to surrender the rights.
++-These restrictions translate to certain responsibilities for you if you
++-distribute copies of the software, or if you modify it.
++-
++-  For example, if you distribute copies of such a program, whether
++-gratis or for a fee, you must give the recipients all the rights that
++-you have.  You must make sure that they, too, receive or can get the
++-source code.  And you must show them these terms so they know their
++-rights.
++-
++-  We protect your rights with two steps: (1) copyright the software, and
++-(2) offer you this license which gives you legal permission to copy,
++-distribute and/or modify the software.
++-
++-  Also, for each author's protection and ours, we want to make certain
++-that everyone understands that there is no warranty for this free
++-software.  If the software is modified by someone else and passed on, we
++-want its recipients to know that what they have is not the original, so
++-that any problems introduced by others will not reflect on the original
++-authors' reputations.
++-
++-  Finally, any free program is threatened constantly by software
++-patents.  We wish to avoid the danger that redistributors of a free
++-program will individually obtain patent licenses, in effect making the
++-program proprietary.  To prevent this, we have made it clear that any
++-patent must be licensed for everyone's free use or not licensed at all.
++-
++-  The precise terms and conditions for copying, distribution and
++-modification follow.
++-
++-		    GNU GENERAL PUBLIC LICENSE
++-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
++-
++-  0. This License applies to any program or other work which contains
++-a notice placed by the copyright holder saying it may be distributed
++-under the terms of this General Public License.  The "Program", below,
++-refers to any such program or work, and a "work based on the Program"
++-means either the Program or any derivative work under copyright law:
++-that is to say, a work containing the Program or a portion of it,
++-either verbatim or with modifications and/or translated into another
++-language.  (Hereinafter, translation is included without limitation in
++-the term "modification".)  Each licensee is addressed as "you".
++-
++-Activities other than copying, distribution and modification are not
++-covered by this License; they are outside its scope.  The act of
++-running the Program is not restricted, and the output from the Program
++-is covered only if its contents constitute a work based on the
++-Program (independent of having been made by running the Program).
++-Whether that is true depends on what the Program does.
++-
++-  1. You may copy and distribute verbatim copies of the Program's
++-source code as you receive it, in any medium, provided that you
++-conspicuously and appropriately publish on each copy an appropriate
++-copyright notice and disclaimer of warranty; keep intact all the
++-notices that refer to this License and to the absence of any warranty;
++-and give any other recipients of the Program a copy of this License
++-along with the Program.
++-
++-You may charge a fee for the physical act of transferring a copy, and
++-you may at your option offer warranty protection in exchange for a fee.
++-
++-  2. You may modify your copy or copies of the Program or any portion
++-of it, thus forming a work based on the Program, and copy and
++-distribute such modifications or work under the terms of Section 1
++-above, provided that you also meet all of these conditions:
++-
++-    a) You must cause the modified files to carry prominent notices
++-    stating that you changed the files and the date of any change.
++-
++-    b) You must cause any work that you distribute or publish, that in
++-    whole or in part contains or is derived from the Program or any
++-    part thereof, to be licensed as a whole at no charge to all third
++-    parties under the terms of this License.
++-
++-    c) If the modified program normally reads commands interactively
++-    when run, you must cause it, when started running for such
++-    interactive use in the most ordinary way, to print or display an
++-    announcement including an appropriate copyright notice and a
++-    notice that there is no warranty (or else, saying that you provide
++-    a warranty) and that users may redistribute the program under
++-    these conditions, and telling the user how to view a copy of this
++-    License.  (Exception: if the Program itself is interactive but
++-    does not normally print such an announcement, your work based on
++-    the Program is not required to print an announcement.)
++-
++-These requirements apply to the modified work as a whole.  If
++-identifiable sections of that work are not derived from the Program,
++-and can be reasonably considered independent and separate works in
++-themselves, then this License, and its terms, do not apply to those
++-sections when you distribute them as separate works.  But when you
++-distribute the same sections as part of a whole which is a work based
++-on the Program, the distribution of the whole must be on the terms of
++-this License, whose permissions for other licensees extend to the
++-entire whole, and thus to each and every part regardless of who wrote it.
++-
++-Thus, it is not the intent of this section to claim rights or contest
++-your rights to work written entirely by you; rather, the intent is to
++-exercise the right to control the distribution of derivative or
++-collective works based on the Program.
++-
++-In addition, mere aggregation of another work not based on the Program
++-with the Program (or with a work based on the Program) on a volume of
++-a storage or distribution medium does not bring the other work under
++-the scope of this License.
++-
++-  3. You may copy and distribute the Program (or a work based on it,
++-under Section 2) in object code or executable form under the terms of
++-Sections 1 and 2 above provided that you also do one of the following:
++-
++-    a) Accompany it with the complete corresponding machine-readable
++-    source code, which must be distributed under the terms of Sections
++-    1 and 2 above on a medium customarily used for software interchange; or,
++-
++-    b) Accompany it with a written offer, valid for at least three
++-    years, to give any third party, for a charge no more than your
++-    cost of physically performing source distribution, a complete
++-    machine-readable copy of the corresponding source code, to be
++-    distributed under the terms of Sections 1 and 2 above on a medium
++-    customarily used for software interchange; or,
++-
++-    c) Accompany it with the information you received as to the offer
++-    to distribute corresponding source code.  (This alternative is
++-    allowed only for noncommercial distribution and only if you
++-    received the program in object code or executable form with such
++-    an offer, in accord with Subsection b above.)
++-
++-The source code for a work means the preferred form of the work for
++-making modifications to it.  For an executable work, complete source
++-code means all the source code for all modules it contains, plus any
++-associated interface definition files, plus the scripts used to
++-control compilation and installation of the executable.  However, as a
++-special exception, the source code distributed need not include
++-anything that is normally distributed (in either source or binary
++-form) with the major components (compiler, kernel, and so on) of the
++-operating system on which the executable runs, unless that component
++-itself accompanies the executable.
++-
++-If distribution of executable or object code is made by offering
++-access to copy from a designated place, then offering equivalent
++-access to copy the source code from the same place counts as
++-distribution of the source code, even though third parties are not
++-compelled to copy the source along with the object code.
++-
++-  4. You may not copy, modify, sublicense, or distribute the Program
++-except as expressly provided under this License.  Any attempt
++-otherwise to copy, modify, sublicense or distribute the Program is
++-void, and will automatically terminate your rights under this License.
++-However, parties who have received copies, or rights, from you under
++-this License will not have their licenses terminated so long as such
++-parties remain in full compliance.
++-
++-  5. You are not required to accept this License, since you have not
++-signed it.  However, nothing else grants you permission to modify or
++-distribute the Program or its derivative works.  These actions are
++-prohibited by law if you do not accept this License.  Therefore, by
++-modifying or distributing the Program (or any work based on the
++-Program), you indicate your acceptance of this License to do so, and
++-all its terms and conditions for copying, distributing or modifying
++-the Program or works based on it.
++-
++-  6. Each time you redistribute the Program (or any work based on the
++-Program), the recipient automatically receives a license from the
++-original licensor to copy, distribute or modify the Program subject to
++-these terms and conditions.  You may not impose any further
++-restrictions on the recipients' exercise of the rights granted herein.
++-You are not responsible for enforcing compliance by third parties to
++-this License.
++-
++-  7. If, as a consequence of a court judgment or allegation of patent
++-infringement or for any other reason (not limited to patent issues),
++-conditions are imposed on you (whether by court order, agreement or
++-otherwise) that contradict the conditions of this License, they do not
++-excuse you from the conditions of this License.  If you cannot
++-distribute so as to satisfy simultaneously your obligations under this
++-License and any other pertinent obligations, then as a consequence you
++-may not distribute the Program at all.  For example, if a patent
++-license would not permit royalty-free redistribution of the Program by
++-all those who receive copies directly or indirectly through you, then
++-the only way you could satisfy both it and this License would be to
++-refrain entirely from distribution of the Program.
++-
++-If any portion of this section is held invalid or unenforceable under
++-any particular circumstance, the balance of the section is intended to
++-apply and the section as a whole is intended to apply in other
++-circumstances.
++-
++-It is not the purpose of this section to induce you to infringe any
++-patents or other property right claims or to contest validity of any
++-such claims; this section has the sole purpose of protecting the
++-integrity of the free software distribution system, which is
++-implemented by public license practices.  Many people have made
++-generous contributions to the wide range of software distributed
++-through that system in reliance on consistent application of that
++-system; it is up to the author/donor to decide if he or she is willing
++-to distribute software through any other system and a licensee cannot
++-impose that choice.
++-
++-This section is intended to make thoroughly clear what is believed to
++-be a consequence of the rest of this License.
++-
++-  8. If the distribution and/or use of the Program is restricted in
++-certain countries either by patents or by copyrighted interfaces, the
++-original copyright holder who places the Program under this License
++-may add an explicit geographical distribution limitation excluding
++-those countries, so that distribution is permitted only in or among
++-countries not thus excluded.  In such case, this License incorporates
++-the limitation as if written in the body of this License.
++-
++-  9. The Free Software Foundation may publish revised and/or new versions
++-of the General Public License from time to time.  Such new versions will
++-be similar in spirit to the present version, but may differ in detail to
++-address new problems or concerns.
++-
++-Each version is given a distinguishing version number.  If the Program
++-specifies a version number of this License which applies to it and "any
++-later version", you have the option of following the terms and conditions
++-either of that version or of any later version published by the Free
++-Software Foundation.  If the Program does not specify a version number of
++-this License, you may choose any version ever published by the Free Software
++-Foundation.
++-
++-  10. If you wish to incorporate parts of the Program into other free
++-programs whose distribution conditions are different, write to the author
++-to ask for permission.  For software which is copyrighted by the Free
++-Software Foundation, write to the Free Software Foundation; we sometimes
++-make exceptions for this.  Our decision will be guided by the two goals
++-of preserving the free status of all derivatives of our free software and
++-of promoting the sharing and reuse of software generally.
++-
++-			    NO WARRANTY
++-
++-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
++-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
++-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
++-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
++-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
++-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
++-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
++-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
++-REPAIR OR CORRECTION.
++-
++-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
++-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
++-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
++-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
++-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
++-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
++-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
++-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
++-POSSIBILITY OF SUCH DAMAGES.
++-
++-		     END OF TERMS AND CONDITIONS
++-
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
++deleted file mode 100644
++index 367657e64..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
+++++ /dev/null
++@@ -1,39 +0,0 @@
++-Errorpages
++-===========
++-
++-Error pages displays custom error pages in your forum. As an option all errors are logged in your errorlog.
++-
++-[![Build Status](https://travis-ci.org/ForumHulp/errorpages.svg?branch=master)](https://travis-ci.org/ForumHulp/errorpages)
++-
++-## Requirements
++-* phpBB 3.1.0-dev or higher
++-* PHP 5.3.3 or higher
++-
++-## Installation
++-You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:
++-
++-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/errorpages/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
++-3. Click Error pages => `Enable`.
++-
++-Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.
++-
++-## Update
++-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/errorpages/archive/master.zip).
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
++-3. Copy the contents of `errorpages-master` folder to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
++-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Enable`.
++-5. Click `Details` or `Re-Check all versions` link to follow updates.
++-6. Or use our Upload Extensions extension
++-
++-## Uninstallation
++-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
++-
++-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/errorpages/` folder or use our Upload Extensions extension to delet all files and folders.
++-
++-We feel sorry as our answers on phpbb sites are removed, so use gi
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/event/listener.php"
+index 57481f7bb..c7d1cc926 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/event/listener.php"
+@@ -36,86 +36,14 @@ class listener implements EventSubscriberInterface
+ 		$exception = $event->getException();
+ 		$request = $event->getRequest();
+ 
+-		switch ($exception->getStatusCode())
+-		{
+-			case '400':
+-				$msg = 'ERROR_BAD_REQUEST';
+-			break;
+-			case '401':
+-				$msg = 'ERROR_AUTH_REQUIRED';
+-			break;
+-			case '403':
+-				$msg = 'ERROR_FORBIDDEN';
+-			break;
+-			case '404':
+-				$msg = 'ERROR_NOT_FOUND';
+-			break;
+-			case '405':
+-				$msg = 'METHOD_NOT_ALLOWED';
+-			break;
+-			case '406':
+-				$msg = 'NOT_ACCEPTABLE';
+-			break;
+-			case '407':
+-				$msg = 'PROXY_AUTHENTICATION_REQUIRED';
+-			break;
+-			case '408':
+-				$msg = 'REQUEST_TIMED_OUT';
+-			break;
+-			case '409':
+-				$msg = 'CONFLICTING_REQUEST';
+-			break;
+-			case '410':
+-				$msg = 'GONE';
+-			break;
+-			case '411':
+-				$msg = 'CONTENT_LENGTH_REQUIRED';
+-			break;
+-			case '412':
+-				$msg = 'PRECONDITION_FAILED';
+-			break;
+-			case '413':
+-				$msg = 'REQUEST_ENTITY_TOO_LONG';
+-			break;
+-			case '414':
+-				$msg = 'REQUEST_URI_TOO_LONG';
+-			break;
+-			case '415':
+-				$msg = 'UNSUPPORTED_MEDIA_TYPE';
+-			break;
+-			case '418':
+-				$msg = 'TEAPOT';
+-			break;
++		
+ 
+-			case '500':
+-				$msg = 'INTERNAL_SERVER_ERROR';
+-			break;
+-			case '501':
+-				$msg = 'NOT_IMPLEMENTED';
+-			break;
+-			case '502':
+-				$msg = 'BAD_GATEWAY';
+-			break;
+-			case '503':
+-				$msg = 'SERVICE_UNAVAILABLE';
+-			break;
+-			case '504':
+-				$msg = 'GATEWAY_TIMOUT';
+-			break;
+-			case '505':
+-				$msg = 'HTTP_VERSION_NOT_SUPPORTED';
+-			break;
+-			default:
+-				$msg = 'ERROR_UNKNOWN';
+-			break;
+-		}
+-
+-		($this->config['error_pages_log']) ? $this->log->add('critical', $this->user->data['user_id'], $this->user->data['session_ip'], 'LOG_GENERAL_ERROR', false, array($exception->getStatusCode() . ': ' . $this->user->lang[$msg], $request->getPathInfo())) : null;
++		
+ 
+ 		page_header($this->user->lang('INFORMATION'));
+ 		$this->template->assign_vars(array(
+ 			'MESSAGE_TITLE'		=> $this->user->lang('INFORMATION'),
+-			'MESSAGE_TEXT'		=> $this->user->lang[$msg] . '<br />' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br />' . sprintf($this->user->lang['RETURN_INDEX'], '<a href="' . generate_board_url() .'">', '</a>'),
++			'MESSAGE_TEXT'		=> '</p><div class="text-center"><h1 class="text-uppercase">' . $this->user->lang[$msg] . '</h1>' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br /><a href="' . generate_board_url() .'" class="btn btn-default">' . sprintf($this->user->lang['RETURN_INDEX'], '', '') . '</a></div><p>',
+ 		));
+ 
+ 		$this->template->set_filenames(array(
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php"
+index a7be7e8ee..925ee85de 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php"
+@@ -39,15 +39,15 @@ $lang = array_merge($lang, array(
+ 	'ERRORPAGES_LOG_EXPLAIN'			=> 'Log all Error Pages in Error Log in Maintenance Tab',
+ 	'ERRORPAGES_EXPLAIN'				=> 'Explain Error Pages',
+ 	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Explain error in message display',
+-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Config settings are in %1$s » %2$s » %3$s.</p></div>',
++	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p>Config settings are in <strong>%1$s » %2$s » %3$s.</strong></p></div>',
+ 	'ERROR_BAD_REQUEST' 				=> 'Bad Request',
+ 	'ERROR_BAD_REQUESTEXPA' 			=> 'The request had bad syntax or was inherently impossible to be completed.',
+ 	'ERROR_AUTH_REQUIRED' 				=> 'Authorization Required',
+ 	'ERROR_AUTH_REQUIREDEXPA' 			=> 'This means that the page requires that the visitors authenticate with their username and password. If they fail to do that, the server returns this error message.',
+ 	'ERROR_FORBIDDEN' 					=> 'Forbidden',
+ 	'ERROR_FORBIDDENEXPA' 				=> 'This means that access to the page the visitor is requesting is not allowed. This can be due to a special rule in the configuration of the web server, or to the specific file system permissions of the file.',
+-	'ERROR_NOT_FOUND' 					=> 'Not Found',
+-	'ERROR_NOT_FOUNDEXPA'		 		=> 'This simply means that the requested file is not there.',
++	'ERROR_NOT_FOUND' 					=> '<span class="error"><i></i></span>OOPS! Page Not Found',
++	'ERROR_NOT_FOUNDEXPA'		 		=> 'Unfortunately the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exist.<br /><br />Check the URL you entered for any mistakes and try again.',
+ 	'PRECONDITION_FAILED'				=> 'Precondition Failed',
+ 	'PRECONDITION_FAILEDEXPA'			=> 'The error means that the request triggered a mod_security protection on our end.',
+ 	'METHOD_NOT_ALLOWED'				=> 'Method Not Allowed',
+@@ -86,5 +86,5 @@ $lang = array_merge($lang, array(
+ 	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'The server does not support the HTTP protocol version used in the request.',
+ 	'ERROR_UNKNOWN'     	  		 	=> 'Unknown Server Error',
+ 	'ERROR_UNKNOWNEXPA'      		 	=> '',
+-	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
++	'FH_HELPER_NOTICE'					=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/es/info_acp_errorpages.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/es/info_acp_errorpages.php"
+deleted file mode 100644
+index ca26f79f8..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/es/info_acp_errorpages.php"
++++ /dev/null
+@@ -1,90 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Errorpages
+-* @copyright (c) 2014 ForumHulp.com
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE!
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-
+-// Custom error pages
+-$lang = array_merge($lang, array(
+-	'ERRORPAGESERROR'			=> 'Páginas de Error',
+-	'ERRORPAGES_LOG'			=> 'Registro de Páginas de Error',
+-	'ERRORPAGES_LOG_EXPLAIN'		=> 'Registrar todos los errores de páginas en el registro de Error en la pestaña Mantenimiento',
+-	'ERRORPAGES_EXPLAIN'			=> 'Describir errores de páginas',
+-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Describir error en un mensaje en pantalla',
+-	'ERRORPAGE_NOTICE'			=> '<div class="phpinfo"><p class="entry">Los ajustes de configuración están en %1$s » %2$s » %3$s.</p></div>',
+-	'ERROR_BAD_REQUEST' 			=> 'Solicitud Incorrecta',
+-	'ERROR_BAD_REQUESTEXPA' 		=> 'La solicitud tiene mala sintaxis o era intrínsecamente imposible que esté terminado.',
+-	'ERROR_AUTH_REQUIRED' 			=> 'Autorización Requerida',
+-	'ERROR_AUTH_REQUIREDEXPA' 		=> 'Esto significa que la página requiere que los visitantes se identifiquen con su nombre de usuario y contraseña. Si no pueden hacerlo, el servidor devuelve este mensaje de error.',
+-	'ERROR_FORBIDDEN' 			=> 'Prohibido',
+-	'ERROR_FORBIDDENEXPA' 			=> 'Esto significa que el acceso a la página solicitada por el visitante no está permitido. Esto puede ser debido a una regla especial en la configuración del servidor web, o de los permisos específicos del sistema de archivos, sobre dicho archivo.',
+-	'ERROR_NOT_FOUND' 			=> 'No Encontrada',
+-	'ERROR_NOT_FOUNDEXPA'		 	=> 'Esto simplemente significa que el archivo solicitado no está allí.',
+-	'PRECONDITION_FAILED'			=> 'Condición previa Fracasado',
+-	'PRECONDITION_FAILEDEXPA'		=> 'El error significa que la solicitud desencadenó una protección mod_security por nuestra parte.',
+-	'METHOD_NOT_ALLOWED'			=> 'Método no Permitido',
+-	'METHOD_NOT_ALLOWEDEXPA'		=> 'Se realizó una solicitud de un recurso mediante un método de solicitud no soportado por ese recurso; por ejemplo, el uso de GET en un formulario que requiere datos que se presentará a través de POST, o el uso de poner en un recurso de sólo lectura.',
+-	'NOT_ACCEPTABLE'			=> 'No Aceptable (codificación)',
+-	'NOT_ACCEPTABLEEXPA'			=> 'El recurso solicitado sólo es capaz de generar contenido no aceptable de acuerdo con las cabeceras de aceptación enviadas en la petición.',
+-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Proxy requiere Autenticación',
+-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'El cliente primero debe autenticarse con el proxy.',
+-	'REQUEST_TIMED_OUT'			=> 'Tiempo de espera agotado',
+-	'REQUEST_TIMED_OUTEXPA'			=> 'El servidor ha agotado el tiempo de espera para la solicitud. De acuerdo con las especificaciones de HTTP: "El cliente no produjo una solicitud dentro del plazo que el servidor estaba dispuesto a esperar el cliente puede repetir la solicitud sin modificaciones en cualquier momento posterior."',
+-	'CONFLICTING_REQUEST'			=> 'Solicitud en conflicto',
+-	'CONFLICTING_REQUESTEXPA'		=> 'Indica que la solicitud no pudo ser procesada debido a los conflictos en la solicitud, tal como un conflicto de edición en el caso de varias actualizaciones',
+-	'GONE'					=> 'Pasado',
+-	'GONEEXPA'				=> 'Indica que el recurso solicitado ya no está disponible y no volverá a estar disponible. Esto se debe utilizar cuando un recurso se ha eliminado intencionalmente y el recurso debe ser purgado. Al recibir un código de estado 410, el cliente no debe solicitar el recurso de nuevo en el futuro. Clientes tales como motores de búsqueda deben eliminar el recurso de sus índices. [cita requerida] La mayoría de los casos de uso no requieren los clientes y los motores de búsqueda para purgar el recurso, y un "404 No Encontrado" se puede utilizar en su lugar.',
+-	'CONTENT_LENGTH_REQUIRED'		=> 'Longitud de Contenido Requerida',
+-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'La solicitud no especificó la duración de su contenido, que es requerido por el recurso solicitado',
+-	'REQUEST_ENTITY_TOO_LONG'		=> 'Solicitud de Entidad Demasiado Largo',
+-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'La solicitud es mayor que lo del servidor está dispuesto o es capaz de procesar.',
+-	'REQUEST_URI_TOO_LONG'			=> 'Solicitud de URI demasiado larga',
+-	'REQUEST_URI_TOO_LONGEXPA'		=> 'La URI proporcionada era demasiado larga para procesarlo el servidor. A menudo el resultado de demasiados datos se codifica como una cadena de consulta de una solicitud GET, en cuyo caso debe ser convertido a una solicitud POST.',
+-	'UNSUPPORTED_MEDIA_TYPE'		=> 'Tipo de Media no soportado',
+-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'La petición de entidad tiene un tipo de medio que el servidor o el recurso no es compatible. el cliente carga una imagen como imagen/svg+xml, pero el servidor requiere que las imágenes utilicen un formato diferente.',
+-	'TEAPOT'				=> 'Soy una tetera (RFC 2324)',
+-	'TEAPOTEXPA'				=> 'Se definió este código en 1998 como uno de los chistes tradicionales de Día de los Inocentes (IETF April Fools’ Jokes), en el RFC 2324, y no se espera que el Protocolo de Hyper Texto Cafetera de control para ser implementados por los servidores HTTP reales.',
+-	'INTERNAL_SERVER_ERROR'			=> 'Error interno del servidor',
+-	'INTERNAL_SERVER_ERROREXPA' 		=> 'El servidor encontró una condición inesperada que le impidió cumplir con la solicitud.',
+-	'NOT_IMPLEMENTED' 			=> 'No implementado',
+-	'NOT_IMPLEMENTEDEXPA' 			=> 'El servidor no admite la instalación requerida.',
+-	'BAD_GATEWAY' 				=> 'Puerta de enlace mala',
+-	'BAD_GATEWAYEXPA' 			=> 'El servidor encontró un error temporal y no pudo completar su solicitud.',
+-	'SERVICE_UNAVAILABLE' 			=> 'Servicio no disponible',
+-	'SERVICE_UNAVAILABLEEXPA' 		=> 'El servidor en este momento es incapaz de atender su solicitud debido a tiempo de inactividad, mantenimiento o problemas de capacidad. Por favor, inténtelo de nuevo más tarde.',
+-	'GATEWAY_TIMOUT' 			=> 'Tiempo de espera de puerta de enlace',
+-	'GATEWAY_TIMOUTEXPA' 			=> 'El servidor estaba actuando como una puerta de enlace o proxy y no recibió una respuesta a tiempo del servidor en sentido ascendente.',
+-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'Versión HTTP no soportado',
+-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'El servidor no soporta la versión del protocolo HTTP utilizada en la solicitud.',
+-	'ERROR_UNKNOWN'     	  		=> 'Error del servidor desconocido',
+-	'ERROR_UNKNOWNEXPA'      		=> '',
+-	'FH_HELPER_NOTICE'			=> '¡La aplicación Forumhulp helper no existe!<br />Descargar <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> y copie la carpeta helper dentro de la carpeta de extensión forumhulp.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/fr/info_acp_errorpages.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/fr/info_acp_errorpages.php"
+deleted file mode 100644
+index 20b059bc3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/fr/info_acp_errorpages.php"
++++ /dev/null
+@@ -1,95 +0,0 @@
+-<?php
+-/**
+-*
+-* Error pages extension for the phpBB Forum Software package.
+-* French translation by Galixte (http://www.galixte.com)
+-*
+-* @copyright (c) 2015 phpBB ForumHulp <http://www.forumhulp.com>
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ « » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ERRORPAGESERROR'					=> 'Pages d’erreurs',
+-	'ERRORPAGES_LOG'					=> 'Journal des pages d’erreurs',
+-	'ERRORPAGES_LOG_EXPLAIN'			=> 'Archive toutes les pages d’erreurs rencontrées par les utilisateurs dans le journal des pages d’erreurs accessible depuis l’onglet « MAINTENANCE ».',
+-	'ERRORPAGES_EXPLAIN'				=> 'Explications des pages d’erreurs',
+-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Permet de fournir une explication dans le message affiché sur la page d’erreur.',
+-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Les paramètres de cette extension se trouvent dans : %1$s » %2$s » %3$s.</p></div>',
+-	'ERROR_BAD_REQUEST' 				=> 'Erreur 400 - Mauvaise requête',
+-	'ERROR_BAD_REQUESTEXPA' 			=> 'La requête HTTP n’a pas pu être comprise par le serveur en raison d’une syntaxe erronée. Le problème peut provenir d’un navigateur web trop récent ou d’un serveur HTTP trop ancien.',
+-	'ERROR_AUTH_REQUIRED' 				=> 'Erreur 401 - Non autorisé',
+-	'ERROR_AUTH_REQUIREDEXPA' 			=> 'La requête nécessite une identification de l’utilisateur. Concrètement, cela signifie que tout ou partie du serveur contacté est protégé par des identifiants, qu’il faut indiquer au serveur pour pouvoir accéder à son contenu.',
+-	'ERROR_FORBIDDEN' 					=> 'Erreur 403 - Interdit',
+-	'ERROR_FORBIDDENEXPA' 				=> 'La ressource demandée vous est interdite d’accès. Soit parce que le serveur a été configuré de cette manière, soit parce que dans une phase d’authentification vous n’avez pas fourni d’identifiants valides. La raison peut être aussi plus large : votre adresse IP a été bannie, vous utilisez un client HTTP (navigateur) interdit (repéré par les en-têtes accompagnant la requête et l’identifiant), etc..',
+-	'ERROR_NOT_FOUND' 					=> 'Erreur 404 - Non trouvé',
+-	'ERROR_NOT_FOUNDEXPA'		 		=> 'Le serveur n’a rien trouvé qui corresponde à l’adresse (URI) demandée. Cela signifie que l’adresse URL que vous avez tapée ou cliquée est mauvaise ou obsolète et ne correspond à aucun document existant sur le serveur (vous pouvez essayez de supprimer progressivement les composants de l’adresse URL en partant de la fin pour éventuellement retrouver un chemin d’accès existant).',
+-	'PRECONDITION_FAILED'				=> 'Erreur 412 - Précondition échouée',
+-	'PRECONDITION_FAILEDEXPA'			=> 'Les conditions spécifiées dans la requête ne sont pas remplies.',
+-	'METHOD_NOT_ALLOWED'				=> 'Erreur 405 - Méthode non admise',
+-	'METHOD_NOT_ALLOWEDEXPA'			=> 'Ce code indique que la méthode utilisée par le client n’est pas supportée pour cet URI. Un client qui utilise une méthode non supportée sur un serveur ou pour une ressource précise verra une réponse 405. Celle-ci devra être accompagnée d’une liste de méthodes acceptées, spécifiées grâce à l’en-tête Allow.',
+-	'NOT_ACCEPTABLE'					=> 'Erreur 406 - Encodage pas acceptable',
+-	'NOT_ACCEPTABLEEXPA'				=> 'L’adresse (URI) spécifiée existe, mais pas dans le format préféré du client. Si le client demande une ressource dans un format que le serveur n’est pas en mesure de fournir, un code 406 sera retourné. Le serveur indique en retour le langage et les types d’encodages disponibles pour cette adresse.',
+-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Erreur 407 - Authentification proxy exigée',
+-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'Le serveur proxy exige une authentification du client avant de transmettre la requête. Le client contacte un proxy et lui envoie une requête, mais sans informations d’authentification alors que celui-ci en a besoin (absence de l’en-tête Proxy-Authorization).',
+-	'REQUEST_TIMED_OUT'					=> 'Erreur 408 - Délai écoulé pour la requête',
+-	'REQUEST_TIMED_OUTEXPA'				=> 'Le serveur met trop de temps à attendre la requête du client et finit par clore la conversation en répondant 408 (la connexion sera ensuite fermée). Le client n’a pas produit assez vite la requête attendue par le serveur, mais peut la produire plus tard.',
+-	'CONFLICTING_REQUEST'				=> 'Erreur 409 - Conflit',
+-	'CONFLICTING_REQUESTEXPA'			=> 'La requête entre en conflit avec une autre requête ou avec la configuration du serveur. Des informations sur les raisons de ce conflit doivent être indiquée en retour.',
+-	'GONE'								=> 'Erreur 410 - Page indisponible définitivement',
+-	'GONEEXPA'							=> 'L’adresse (URI) demandée n’existe plus et a été définitivement supprimée du serveur. La ressource est indisponible et aucune adresse de redirection n’est connue',
+-	'CONTENT_LENGTH_REQUIRED'			=> 'Erreur 411 - Longueur exigée',
+-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'Le serveur a besoin de connaitre la taille de cette requête pour pouvoir y répondre. La longueur de la requête n’a pas été précisée.',
+-	'REQUEST_ENTITY_TOO_LONG'			=> 'Erreur 413 - Corps de la requête trop grand',
+-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'Le serveur ne peut traiter la requête car la taille de son contenu est trop importante. Le traitement est abandonné dû à une requête trop importante.',
+-	'REQUEST_URI_TOO_LONG'				=> 'Erreur 414 - URI trop long',
+-	'REQUEST_URI_TOO_LONGEXPA'			=> 'Le serveur ne peut traiter la requête car la taille de l’objet (URI) a retourner est trop importante. L’adresse (URI) demandée par le client dépasse le nombre de caractères autorisés.',
+-	'UNSUPPORTED_MEDIA_TYPE'			=> 'Erreur 415 - Format non supporté',
+-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'Le serveur ne peut traiter la requête car son contenu est écrit dans un format non supporté. Le client envoie un contenu dont le type n’est pas reconnu par le serveur.',
+-	'TEAPOT'							=> '« Je suis une cafetière » (RFC 2324)',
+-	'TEAPOTEXPA'						=> 'L’Hyper Text Coffee Pot Control Protocol ou HTCPCP — de l’anglais signifiant littéralement « protocole hypertexte de gestion de cafetière » — est décrit dans la RFC 2324 publié le 1er avril 1998 et bien que cette RFC soit un poisson d’avril. C’est une proposition humoristique de protocole de communication client-serveur permettant le contrôle, la surveillance et le diagnostic de cafetière.',
+-	'INTERNAL_SERVER_ERROR'				=> 'Erreur 500 - Erreur interne du serveur',
+-	'INTERNAL_SERVER_ERROREXPA' 		=> 'Le serveur a rencontré un problème inattendu qui l’a empêché de traiter la requête avec succès. Cette erreur peut par exemple être le résultat d’une mauvaise configuration du serveur, ou d’une ressource épuisée ou refusée au serveur sur la machine hôte.',
+-	'NOT_IMPLEMENTED' 					=> 'Erreur 501 - Non mis en oeuvre',
+-	'NOT_IMPLEMENTEDEXPA' 				=> 'Le serveur ne supporte pas la fonctionnalité requise pour traiter avec succès la requête (ou ne reconnait pas la requête). C’est la réponse émise lorsque le serveur ne reconnait pas la méthode indiquée dans la requête et n’est capable de la mettre en oeuvre pour aucune ressource (soit le navigateur web est trop récent, soit le serveur HTTP est trop ancien).',
+-	'BAD_GATEWAY' 						=> 'Erreur 502 - Mauvaise passerelle',
+-	'BAD_GATEWAYEXPA' 					=> 'Le serveur agissait comme un intermédiaire (passerelle ou proxy) et une mauvaise réponse lui a été envoyée par un autre serveur.',
+-	'SERVICE_UNAVAILABLE' 				=> 'Erreur 503 - Service indisponible',
+-	'SERVICE_UNAVAILABLEEXPA' 			=> 'Le serveur est en ligne, mais il ne peut répondre pour le moment, repassez plus tard. Cela peut aussi indiquer que le serveur subit une maintenance ou est surchargé de requêtes et n’arrive pas à traiter correctement la votre.',
+-	'GATEWAY_TIMOUT' 					=> 'Erreur 504 - Expiration de la passerelle',
+-	'GATEWAY_TIMOUTEXPA' 				=> 'Le serveur agissait comme un intermédiaire (passerelle ou proxy) et il n’a pas eu de réponse d’un autre serveur dans les temps. Similaire à 408, cette fois-ci le serveur coupera alors la communication et répondra à son client par un 504.',
+-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'Erreur 505 - Version HTTP non supportée',
+-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'La version du protocole HTTP utilisée dans cette requête n’est pas (ou plus) supportée par le serveur.',
+-	'ERROR_UNKNOWN'     	  		 	=> 'Erreur 520 - Erreur inconnue du serveur',
+-	'ERROR_UNKNOWNEXPA'      		 	=> 'Le serveur renvoie une erreur inconnue.',
+-	'FH_HELPER_NOTICE'      		 	=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/nl/info_acp_errorpages.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/nl/info_acp_errorpages.php"
+deleted file mode 100644
+index d10348a09..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/nl/info_acp_errorpages.php"
++++ /dev/null
+@@ -1,90 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Errorpages
+-* @copyright (c) 2014 ForumHulp.com
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE!
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-
+-// Custom error pages
+-$lang = array_merge($lang, array(
+-	'ERRORPAGESERROR'					=> 'Error Pages',
+-	'ERRORPAGES_LOG'					=> 'Log Error Pages',
+-	'ERRORPAGES_LOG_EXPLAIN'			=> 'Sla alle Error Pages op in Error Log onder Maintenance Tab',
+-	'ERRORPAGES_EXPLAIN'				=> 'Uitleg Error Pages',
+-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Leg de foutmelding uit in het berichtenvenster',
+-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Config settings are in %1$s » %2$s » %3$s.</p></div>',
+-	'ERROR_BAD_REQUEST' 				=> 'Foute aanvraag',
+-	'ERROR_BAD_REQUESTEXPA' 			=> 'De aanvraag had een slechte syntax of kon onmogelijk worden uitgevoerd.',
+-	'ERROR_AUTH_REQUIRED' 				=> 'Niet geautoriseerd',
+-	'ERROR_AUTH_REQUIREDEXPA' 			=> 'Dit betekent dat de pagina vereist dat de bezoekers zich authenticeren met hun gebruikersnaam en wachtwoord. Als zij dit niet doen, retourneert de server deze foutmelding.',
+-	'ERROR_FORBIDDEN' 					=> 'Verboden toegang',
+-	'ERROR_FORBIDDENEXPA' 				=> 'Dit betekent dat de toegang tot de pagina die de bezoeker vraagt ​​niet is toegestaan. Dit kan door een bijzondere regel in de configuratie van de webserver of de specifieke bestandssysteem permissies van het bestand.',
+-	'ERROR_NOT_FOUND' 					=> 'Niet gevonden',
+-	'ERROR_NOT_FOUNDEXPA'		 		=> 'Het gevraagde bestand bestaat niet op de server.',
+-	'PRECONDITION_FAILED'				=> 'Niet voldaan aan vooraf gestelde voorwaarde',
+-	'PRECONDITION_FAILEDEXPA'			=> 'De fout betekent dat het verzoek leidde tot een mod_security bescherming aan de serverkant.',
+-	'METHOD_NOT_ALLOWED'				=> 'Methode niet toegestaan',
+-	'METHOD_NOT_ALLOWEDEXPA'			=> 'Een verzoek werd gemaakt van een bron met behulp van een verzoek methode die niet wordt ondersteund door die bron. Bijvoorbeeld met behulp van GET op een formulier dat de gegevens nodig heeft om via POST worden voorgelegd',
+-	'NOT_ACCEPTABLE'					=> 'Niet aanvaardbaar',
+-	'NOT_ACCEPTABLEEXPA'				=> 'De opgevraagde bron is alleen geschikt voor het genereren van content niet aanvaardbaar volgens de Accept headers verzonden in het verzoek.',
+-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Authenticatie op de proxyserver verplicht',
+-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'De gebruiker moet zich eerst verifiëren bij de proxyserver.',
+-	'REQUEST_TIMED_OUT'					=> 'Aanvraagtijd verstreken',
+-	'REQUEST_TIMED_OUTEXPA'				=> 'De server is gestopt met de aanvraag. Volgens HTTP specificaties: "De gebruiker deed geen aanvraag binnen de gestelde tijd van de server."',
+-	'CONFLICTING_REQUEST'				=> 'Conflict',
+-	'CONFLICTING_REQUESTEXPA'			=> 'Geeft aan dat het verzoek niet kon worden verwerkt, vanwege het conflict in het verzoek, zoals een bewerkingsconflict in het geval van meerdere updates',
+-	'GONE'								=> 'Verdwenen',
+-	'GONEEXPA'							=> 'Geeft aan dat de aangevraagde bron niet meer beschikbaar is. Na ontvangst van een 410 -status code , de klant moet niet de bron opnieuw op te vragen in de toekomst. Klanten zoals zoekmachines moet de bron te verwijderen uit hun indices. [ nodig citaat ] De meeste use cases hebben geen klanten en zoekmachines nodig om de bron te zuiveren , en een " 404 Not Found " kunnen in plaats daarvan worden gebruikt .',
+-	'CONTENT_LENGTH_REQUIRED'			=> 'Lengte benodigd',
+-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'The request did not specify the length of its content, which is required by the requested resource',
+-	'REQUEST_ENTITY_TOO_LONG'			=> 'Aanvraag te groot',
+-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'The request is larger than the server is willing or able to process.',
+-	'REQUEST_URI_TOO_LONG'				=> 'Aanvraag-URL te lang',
+-	'REQUEST_URI_TOO_LONGEXPA'			=> 'The URI provided was too long for the server to process. Often the result of too much data being encoded as a query-string of a GET request, in which case it should be converted to a POST request.',
+-	'UNSUPPORTED_MEDIA_TYPE'			=> 'Media-type niet ondersteund',
+-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'The request entity has a media type which the server or resource does not support. For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format.',
+-	'TEAPOT'							=> 'I’m a teapot (RFC 2324)',
+-	'TEAPOTEXPA'						=> 'This code was defined in 1998 as one of the traditional IETF April Fools’ jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.',
+-	'INTERNAL_SERVER_ERROR'				=> 'Interne serverfout',
+-	'INTERNAL_SERVER_ERROREXPA' 		=> 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
+-	'NOT_IMPLEMENTED' 					=> 'Niet geïmplementeerd',
+-	'NOT_IMPLEMENTEDEXPA' 				=> 'The server doesn’t support the facility required.',
+-	'BAD_GATEWAY' 						=> 'Bad Gateway',
+-	'BAD_GATEWAYEXPA' 					=> 'The server was acting as a gateway or proxy and received an invalid response from the upstream server.',
+-	'SERVICE_UNAVAILABLE' 				=> 'Dienst niet beschikbaar',
+-	'SERVICE_UNAVAILABLEEXPA' 			=> 'The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.',
+-	'GATEWAY_TIMOUT' 					=> 'Gateway Timeout',
+-	'GATEWAY_TIMOUTEXPA' 				=> 'The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.',
+-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'HTTP-versie wordt niet ondersteund',
+-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'The server does not support the HTTP protocol version used in the request.',
+-	'ERROR_UNKNOWN'     	  		 	=> 'Unbekende Server Fout',
+-	'ERROR_UNKNOWNEXPA'      		 	=> '',
+-	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
+-));
diff --git "[FORUM_EXT]/forumhulp\\errorpages/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\errorpages/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\errorpages/diff_nospace.tmp"
@@ -0,0 +1,1672 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
+deleted file mode 100644
+index c1dfdae77..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
++++ /dev/null
+@@ -1,60 +0,0 @@
+-language: php
+-
+-matrix:
+-  include:
+-    - php: 5.4
+-      env: DB=mysqli
+-    - php: 5.4
+-      env: DB=mysql
+-    - php: 5.4
+-      env: DB=mariadb
+-    - php: 5.4
+-      env: DB=postgres
+-    - php: 5.4
+-      env: DB=sqlite3
+-    - php: 5.5
+-      env: DB=mysqli
+-    - php: 5.6
+-      env: DB=mysqli
+-    - php: hhvm
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: hhvm
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="ForumHulp/errorpages"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="0"        # Should we run icc profile sniffer on your images?
+-    - EPV="0"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.1.x"
+-
+-branches:
+-  only:
+-    - master
+-    - develop
+-    - /^develop-.*$/
+-
+-before_install:
+-  - sudo mkdir travis
+-  - git clone "https://github.com/nickvergessen/phpbb-ext-acme-demo.git"
+-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
+-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
+-  - sudo rm -rf phpbb-ext-acme-demo
+-
+-install:
+-  - composer install --dev --no-interaction --prefer-source
+-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+-  - sh -c "if [ '$EPV' != '0' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
+deleted file mode 100644
+index ce992b2ce..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
++++ /dev/null
+@@ -1,281 +0,0 @@
+-		    GNU GENERAL PUBLIC LICENSE
+-		       Version 2, June 1991
+-
+- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
+-                          675 Mass Ave, Cambridge, MA 02139, USA
+- Everyone is permitted to copy and distribute verbatim copies
+- of this license document, but changing it is not allowed.
+-
+-			    Preamble
+-
+-  The licenses for most software are designed to take away your
+-freedom to share and change it.  By contrast, the GNU General Public
+-License is intended to guarantee your freedom to share and change free
+-software--to make sure the software is free for all its users.  This
+-General Public License applies to most of the Free Software
+-Foundation's software and to any other program whose authors commit to
+-using it.  (Some other Free Software Foundation software is covered by
+-the GNU Library General Public License instead.)  You can apply it to
+-your programs, too.
+-
+-  When we speak of free software, we are referring to freedom, not
+-price.  Our General Public Licenses are designed to make sure that you
+-have the freedom to distribute copies of free software (and charge for
+-this service if you wish), that you receive source code or can get it
+-if you want it, that you can change the software or use pieces of it
+-in new free programs; and that you know you can do these things.
+-
+-  To protect your rights, we need to make restrictions that forbid
+-anyone to deny you these rights or to ask you to surrender the rights.
+-These restrictions translate to certain responsibilities for you if you
+-distribute copies of the software, or if you modify it.
+-
+-  For example, if you distribute copies of such a program, whether
+-gratis or for a fee, you must give the recipients all the rights that
+-you have.  You must make sure that they, too, receive or can get the
+-source code.  And you must show them these terms so they know their
+-rights.
+-
+-  We protect your rights with two steps: (1) copyright the software, and
+-(2) offer you this license which gives you legal permission to copy,
+-distribute and/or modify the software.
+-
+-  Also, for each author's protection and ours, we want to make certain
+-that everyone understands that there is no warranty for this free
+-software.  If the software is modified by someone else and passed on, we
+-want its recipients to know that what they have is not the original, so
+-that any problems introduced by others will not reflect on the original
+-authors' reputations.
+-
+-  Finally, any free program is threatened constantly by software
+-patents.  We wish to avoid the danger that redistributors of a free
+-program will individually obtain patent licenses, in effect making the
+-program proprietary.  To prevent this, we have made it clear that any
+-patent must be licensed for everyone's free use or not licensed at all.
+-
+-  The precise terms and conditions for copying, distribution and
+-modification follow.
+-
+-		    GNU GENERAL PUBLIC LICENSE
+-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
+-
+-  0. This License applies to any program or other work which contains
+-a notice placed by the copyright holder saying it may be distributed
+-under the terms of this General Public License.  The "Program", below,
+-refers to any such program or work, and a "work based on the Program"
+-means either the Program or any derivative work under copyright law:
+-that is to say, a work containing the Program or a portion of it,
+-either verbatim or with modifications and/or translated into another
+-language.  (Hereinafter, translation is included without limitation in
+-the term "modification".)  Each licensee is addressed as "you".
+-
+-Activities other than copying, distribution and modification are not
+-covered by this License; they are outside its scope.  The act of
+-running the Program is not restricted, and the output from the Program
+-is covered only if its contents constitute a work based on the
+-Program (independent of having been made by running the Program).
+-Whether that is true depends on what the Program does.
+-
+-  1. You may copy and distribute verbatim copies of the Program's
+-source code as you receive it, in any medium, provided that you
+-conspicuously and appropriately publish on each copy an appropriate
+-copyright notice and disclaimer of warranty; keep intact all the
+-notices that refer to this License and to the absence of any warranty;
+-and give any other recipients of the Program a copy of this License
+-along with the Program.
+-
+-You may charge a fee for the physical act of transferring a copy, and
+-you may at your option offer warranty protection in exchange for a fee.
+-
+-  2. You may modify your copy or copies of the Program or any portion
+-of it, thus forming a work based on the Program, and copy and
+-distribute such modifications or work under the terms of Section 1
+-above, provided that you also meet all of these conditions:
+-
+-    a) You must cause the modified files to carry prominent notices
+-    stating that you changed the files and the date of any change.
+-
+-    b) You must cause any work that you distribute or publish, that in
+-    whole or in part contains or is derived from the Program or any
+-    part thereof, to be licensed as a whole at no charge to all third
+-    parties under the terms of this License.
+-
+-    c) If the modified program normally reads commands interactively
+-    when run, you must cause it, when started running for such
+-    interactive use in the most ordinary way, to print or display an
+-    announcement including an appropriate copyright notice and a
+-    notice that there is no warranty (or else, saying that you provide
+-    a warranty) and that users may redistribute the program under
+-    these conditions, and telling the user how to view a copy of this
+-    License.  (Exception: if the Program itself is interactive but
+-    does not normally print such an announcement, your work based on
+-    the Program is not required to print an announcement.)
+-
+-These requirements apply to the modified work as a whole.  If
+-identifiable sections of that work are not derived from the Program,
+-and can be reasonably considered independent and separate works in
+-themselves, then this License, and its terms, do not apply to those
+-sections when you distribute them as separate works.  But when you
+-distribute the same sections as part of a whole which is a work based
+-on the Program, the distribution of the whole must be on the terms of
+-this License, whose permissions for other licensees extend to the
+-entire whole, and thus to each and every part regardless of who wrote it.
+-
+-Thus, it is not the intent of this section to claim rights or contest
+-your rights to work written entirely by you; rather, the intent is to
+-exercise the right to control the distribution of derivative or
+-collective works based on the Program.
+-
+-In addition, mere aggregation of another work not based on the Program
+-with the Program (or with a work based on the Program) on a volume of
+-a storage or distribution medium does not bring the other work under
+-the scope of this License.
+-
+-  3. You may copy and distribute the Program (or a work based on it,
+-under Section 2) in object code or executable form under the terms of
+-Sections 1 and 2 above provided that you also do one of the following:
+-
+-    a) Accompany it with the complete corresponding machine-readable
+-    source code, which must be distributed under the terms of Sections
+-    1 and 2 above on a medium customarily used for software interchange; or,
+-
+-    b) Accompany it with a written offer, valid for at least three
+-    years, to give any third party, for a charge no more than your
+-    cost of physically performing source distribution, a complete
+-    machine-readable copy of the corresponding source code, to be
+-    distributed under the terms of Sections 1 and 2 above on a medium
+-    customarily used for software interchange; or,
+-
+-    c) Accompany it with the information you received as to the offer
+-    to distribute corresponding source code.  (This alternative is
+-    allowed only for noncommercial distribution and only if you
+-    received the program in object code or executable form with such
+-    an offer, in accord with Subsection b above.)
+-
+-The source code for a work means the preferred form of the work for
+-making modifications to it.  For an executable work, complete source
+-code means all the source code for all modules it contains, plus any
+-associated interface definition files, plus the scripts used to
+-control compilation and installation of the executable.  However, as a
+-special exception, the source code distributed need not include
+-anything that is normally distributed (in either source or binary
+-form) with the major components (compiler, kernel, and so on) of the
+-operating system on which the executable runs, unless that component
+-itself accompanies the executable.
+-
+-If distribution of executable or object code is made by offering
+-access to copy from a designated place, then offering equivalent
+-access to copy the source code from the same place counts as
+-distribution of the source code, even though third parties are not
+-compelled to copy the source along with the object code.
+-
+-  4. You may not copy, modify, sublicense, or distribute the Program
+-except as expressly provided under this License.  Any attempt
+-otherwise to copy, modify, sublicense or distribute the Program is
+-void, and will automatically terminate your rights under this License.
+-However, parties who have received copies, or rights, from you under
+-this License will not have their licenses terminated so long as such
+-parties remain in full compliance.
+-
+-  5. You are not required to accept this License, since you have not
+-signed it.  However, nothing else grants you permission to modify or
+-distribute the Program or its derivative works.  These actions are
+-prohibited by law if you do not accept this License.  Therefore, by
+-modifying or distributing the Program (or any work based on the
+-Program), you indicate your acceptance of this License to do so, and
+-all its terms and conditions for copying, distributing or modifying
+-the Program or works based on it.
+-
+-  6. Each time you redistribute the Program (or any work based on the
+-Program), the recipient automatically receives a license from the
+-original licensor to copy, distribute or modify the Program subject to
+-these terms and conditions.  You may not impose any further
+-restrictions on the recipients' exercise of the rights granted herein.
+-You are not responsible for enforcing compliance by third parties to
+-this License.
+-
+-  7. If, as a consequence of a court judgment or allegation of patent
+-infringement or for any other reason (not limited to patent issues),
+-conditions are imposed on you (whether by court order, agreement or
+-otherwise) that contradict the conditions of this License, they do not
+-excuse you from the conditions of this License.  If you cannot
+-distribute so as to satisfy simultaneously your obligations under this
+-License and any other pertinent obligations, then as a consequence you
+-may not distribute the Program at all.  For example, if a patent
+-license would not permit royalty-free redistribution of the Program by
+-all those who receive copies directly or indirectly through you, then
+-the only way you could satisfy both it and this License would be to
+-refrain entirely from distribution of the Program.
+-
+-If any portion of this section is held invalid or unenforceable under
+-any particular circumstance, the balance of the section is intended to
+-apply and the section as a whole is intended to apply in other
+-circumstances.
+-
+-It is not the purpose of this section to induce you to infringe any
+-patents or other property right claims or to contest validity of any
+-such claims; this section has the sole purpose of protecting the
+-integrity of the free software distribution system, which is
+-implemented by public license practices.  Many people have made
+-generous contributions to the wide range of software distributed
+-through that system in reliance on consistent application of that
+-system; it is up to the author/donor to decide if he or she is willing
+-to distribute software through any other system and a licensee cannot
+-impose that choice.
+-
+-This section is intended to make thoroughly clear what is believed to
+-be a consequence of the rest of this License.
+-
+-  8. If the distribution and/or use of the Program is restricted in
+-certain countries either by patents or by copyrighted interfaces, the
+-original copyright holder who places the Program under this License
+-may add an explicit geographical distribution limitation excluding
+-those countries, so that distribution is permitted only in or among
+-countries not thus excluded.  In such case, this License incorporates
+-the limitation as if written in the body of this License.
+-
+-  9. The Free Software Foundation may publish revised and/or new versions
+-of the General Public License from time to time.  Such new versions will
+-be similar in spirit to the present version, but may differ in detail to
+-address new problems or concerns.
+-
+-Each version is given a distinguishing version number.  If the Program
+-specifies a version number of this License which applies to it and "any
+-later version", you have the option of following the terms and conditions
+-either of that version or of any later version published by the Free
+-Software Foundation.  If the Program does not specify a version number of
+-this License, you may choose any version ever published by the Free Software
+-Foundation.
+-
+-  10. If you wish to incorporate parts of the Program into other free
+-programs whose distribution conditions are different, write to the author
+-to ask for permission.  For software which is copyrighted by the Free
+-Software Foundation, write to the Free Software Foundation; we sometimes
+-make exceptions for this.  Our decision will be guided by the two goals
+-of preserving the free status of all derivatives of our free software and
+-of promoting the sharing and reuse of software generally.
+-
+-			    NO WARRANTY
+-
+-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
+-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
+-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
+-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
+-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
+-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
+-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
+-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
+-REPAIR OR CORRECTION.
+-
+-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
+-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
+-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
+-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
+-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
+-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
+-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
+-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
+-POSSIBILITY OF SUCH DAMAGES.
+-
+-		     END OF TERMS AND CONDITIONS
+-
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
+deleted file mode 100644
+index 367657e64..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
++++ /dev/null
+@@ -1,39 +0,0 @@
+-Errorpages
+-===========
+-
+-Error pages displays custom error pages in your forum. As an option all errors are logged in your errorlog.
+-
+-[![Build Status](https://travis-ci.org/ForumHulp/errorpages.svg?branch=master)](https://travis-ci.org/ForumHulp/errorpages)
+-
+-## Requirements
+-* phpBB 3.1.0-dev or higher
+-* PHP 5.3.3 or higher
+-
+-## Installation
+-You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:
+-
+-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/errorpages/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
+-3. Click Error pages => `Enable`.
+-
+-Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.
+-
+-## Update
+-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/errorpages/archive/master.zip).
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
+-3. Copy the contents of `errorpages-master` folder to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
+-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Enable`.
+-5. Click `Details` or `Re-Check all versions` link to follow updates.
+-6. Or use our Upload Extensions extension
+-
+-## Uninstallation
+-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
+-
+-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/errorpages/` folder or use our Upload Extensions extension to delet all files and folders.
+-
+-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
+-
+-## License
+-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
+-
+-© 2014 - John Peskens (ForumHulp.com)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/config/services.yml"
+index 33bd7f719..e2c5eac76 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/config/services.yml"
+@@ -2,15 +2,16 @@ services:
+     kernel.listener.forumhulp_errorpages:
+         class: forumhulp\errorpages\event\listener
+         arguments:
+-            - @config
+-            - @user
+-            - @template
+-            - @log
++            - '@config'
++            - '@user'
++            - '@template'
++            - '@log'
+         tags:
+             - { name: kernel.event_listener, event: kernel.exception, method: onKernelException }
++
+     forumhulp.errorpages.acp_listener:
+         class: forumhulp\errorpages\event\acp_listener
+         arguments:
+-            - @controller.helper
++            - '@controller.helper'
+         tags:
+             - { name: event.listener }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp"
+new file mode 100644
+index 000000000..8e1d4cbdf
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp"
+@@ -0,0 +1,1242 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
++deleted file mode 100644
++index c1dfdae77..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
+++++ /dev/null
++@@ -1,60 +0,0 @@
++-language: php
++-
++-matrix:
++-  include:
++-    - php: 5.4
++-      env: DB=mysqli
++-    - php: 5.4
++-      env: DB=mysql
++-    - php: 5.4
++-      env: DB=mariadb
++-    - php: 5.4
++-      env: DB=postgres
++-    - php: 5.4
++-      env: DB=sqlite3
++-    - php: 5.5
++-      env: DB=mysqli
++-    - php: 5.6
++-      env: DB=mysqli
++-    - php: hhvm
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: hhvm
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="ForumHulp/errorpages"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="0"        # Should we run icc profile sniffer on your images?
++-    - EPV="0"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.1.x"
++-
++-branches:
++-  only:
++-    - master
++-    - develop
++-    - /^develop-.*$/
++-
++-before_install:
++-  - sudo mkdir travis
++-  - git clone "https://github.com/nickvergessen/phpbb-ext-acme-demo.git"
++-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
++-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
++-  - sudo rm -rf phpbb-ext-acme-demo
++-
++-install:
++-  - composer install --dev --no-interaction --prefer-source
++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
++-  - sh -c "if [ '$EPV' != '0' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
++deleted file mode 100644
++index ce992b2ce..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
+++++ /dev/null
++@@ -1,281 +0,0 @@
++-		    GNU GENERAL PUBLIC LICENSE
++-		       Version 2, June 1991
++-
++- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
++-                          675 Mass Ave, Cambridge, MA 02139, USA
++- Everyone is permitted to copy and distribute verbatim copies
++- of this license document, but changing it is not allowed.
++-
++-			    Preamble
++-
++-  The licenses for most software are designed to take away your
++-freedom to share and change it.  By contrast, the GNU General Public
++-License is intended to guarantee your freedom to share and change free
++-software--to make sure the software is free for all its users.  This
++-General Public License applies to most of the Free Software
++-Foundation's software and to any other program whose authors commit to
++-using it.  (Some other Free Software Foundation software is covered by
++-the GNU Library General Public License instead.)  You can apply it to
++-your programs, too.
++-
++-  When we speak of free software, we are referring to freedom, not
++-price.  Our General Public Licenses are designed to make sure that you
++-have the freedom to distribute copies of free software (and charge for
++-this service if you wish), that you receive source code or can get it
++-if you want it, that you can change the software or use pieces of it
++-in new free programs; and that you know you can do these things.
++-
++-  To protect your rights, we need to make restrictions that forbid
++-anyone to deny you these rights or to ask you to surrender the rights.
++-These restrictions translate to certain responsibilities for you if you
++-distribute copies of the software, or if you modify it.
++-
++-  For example, if you distribute copies of such a program, whether
++-gratis or for a fee, you must give the recipients all the rights that
++-you have.  You must make sure that they, too, receive or can get the
++-source code.  And you must show them these terms so they know their
++-rights.
++-
++-  We protect your rights with two steps: (1) copyright the software, and
++-(2) offer you this license which gives you legal permission to copy,
++-distribute and/or modify the software.
++-
++-  Also, for each author's protection and ours, we want to make certain
++-that everyone understands that there is no warranty for this free
++-software.  If the software is modified by someone else and passed on, we
++-want its recipients to know that what they have is not the original, so
++-that any problems introduced by others will not reflect on the original
++-authors' reputations.
++-
++-  Finally, any free program is threatened constantly by software
++-patents.  We wish to avoid the danger that redistributors of a free
++-program will individually obtain patent licenses, in effect making the
++-program proprietary.  To prevent this, we have made it clear that any
++-patent must be licensed for everyone's free use or not licensed at all.
++-
++-  The precise terms and conditions for copying, distribution and
++-modification follow.
++-
++-		    GNU GENERAL PUBLIC LICENSE
++-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
++-
++-  0. This License applies to any program or other work which contains
++-a notice placed by the copyright holder saying it may be distributed
++-under the terms of this General Public License.  The "Program", below,
++-refers to any such program or work, and a "work based on the Program"
++-means either the Program or any derivative work under copyright law:
++-that is to say, a work containing the Program or a portion of it,
++-either verbatim or with modifications and/or translated into another
++-language.  (Hereinafter, translation is included without limitation in
++-the term "modification".)  Each licensee is addressed as "you".
++-
++-Activities other than copying, distribution and modification are not
++-covered by this License; they are outside its scope.  The act of
++-running the Program is not restricted, and the output from the Program
++-is covered only if its contents constitute a work based on the
++-Program (independent of having been made by running the Program).
++-Whether that is true depends on what the Program does.
++-
++-  1. You may copy and distribute verbatim copies of the Program's
++-source code as you receive it, in any medium, provided that you
++-conspicuously and appropriately publish on each copy an appropriate
++-copyright notice and disclaimer of warranty; keep intact all the
++-notices that refer to this License and to the absence of any warranty;
++-and give any other recipients of the Program a copy of this License
++-along with the Program.
++-
++-You may charge a fee for the physical act of transferring a copy, and
++-you may at your option offer warranty protection in exchange for a fee.
++-
++-  2. You may modify your copy or copies of the Program or any portion
++-of it, thus forming a work based on the Program, and copy and
++-distribute such modifications or work under the terms of Section 1
++-above, provided that you also meet all of these conditions:
++-
++-    a) You must cause the modified files to carry prominent notices
++-    stating that you changed the files and the date of any change.
++-
++-    b) You must cause any work that you distribute or publish, that in
++-    whole or in part contains or is derived from the Program or any
++-    part thereof, to be licensed as a whole at no charge to all third
++-    parties under the terms of this License.
++-
++-    c) If the modified program normally reads commands interactively
++-    when run, you must cause it, when started running for such
++-    interactive use in the most ordinary way, to print or display an
++-    announcement including an appropriate copyright notice and a
++-    notice that there is no warranty (or else, saying that you provide
++-    a warranty) and that users may redistribute the program under
++-    these conditions, and telling the user how to view a copy of this
++-    License.  (Exception: if the Program itself is interactive but
++-    does not normally print such an announcement, your work based on
++-    the Program is not required to print an announcement.)
++-
++-These requirements apply to the modified work as a whole.  If
++-identifiable sections of that work are not derived from the Program,
++-and can be reasonably considered independent and separate works in
++-themselves, then this License, and its terms, do not apply to those
++-sections when you distribute them as separate works.  But when you
++-distribute the same sections as part of a whole which is a work based
++-on the Program, the distribution of the whole must be on the terms of
++-this License, whose permissions for other licensees extend to the
++-entire whole, and thus to each and every part regardless of who wrote it.
++-
++-Thus, it is not the intent of this section to claim rights or contest
++-your rights to work written entirely by you; rather, the intent is to
++-exercise the right to control the distribution of derivative or
++-collective works based on the Program.
++-
++-In addition, mere aggregation of another work not based on the Program
++-with the Program (or with a work based on the Program) on a volume of
++-a storage or distribution medium does not bring the other work under
++-the scope of this License.
++-
++-  3. You may copy and distribute the Program (or a work based on it,
++-under Section 2) in object code or executable form under the terms of
++-Sections 1 and 2 above provided that you also do one of the following:
++-
++-    a) Accompany it with the complete corresponding machine-readable
++-    source code, which must be distributed under the terms of Sections
++-    1 and 2 above on a medium customarily used for software interchange; or,
++-
++-    b) Accompany it with a written offer, valid for at least three
++-    years, to give any third party, for a charge no more than your
++-    cost of physically performing source distribution, a complete
++-    machine-readable copy of the corresponding source code, to be
++-    distributed under the terms of Sections 1 and 2 above on a medium
++-    customarily used for software interchange; or,
++-
++-    c) Accompany it with the information you received as to the offer
++-    to distribute corresponding source code.  (This alternative is
++-    allowed only for noncommercial distribution and only if you
++-    received the program in object code or executable form with such
++-    an offer, in accord with Subsection b above.)
++-
++-The source code for a work means the preferred form of the work for
++-making modifications to it.  For an executable work, complete source
++-code means all the source code for all modules it contains, plus any
++-associated interface definition files, plus the scripts used to
++-control compilation and installation of the executable.  However, as a
++-special exception, the source code distributed need not include
++-anything that is normally distributed (in either source or binary
++-form) with the major components (compiler, kernel, and so on) of the
++-operating system on which the executable runs, unless that component
++-itself accompanies the executable.
++-
++-If distribution of executable or object code is made by offering
++-access to copy from a designated place, then offering equivalent
++-access to copy the source code from the same place counts as
++-distribution of the source code, even though third parties are not
++-compelled to copy the source along with the object code.
++-
++-  4. You may not copy, modify, sublicense, or distribute the Program
++-except as expressly provided under this License.  Any attempt
++-otherwise to copy, modify, sublicense or distribute the Program is
++-void, and will automatically terminate your rights under this License.
++-However, parties who have received copies, or rights, from you under
++-this License will not have their licenses terminated so long as such
++-parties remain in full compliance.
++-
++-  5. You are not required to accept this License, since you have not
++-signed it.  However, nothing else grants you permission to modify or
++-distribute the Program or its derivative works.  These actions are
++-prohibited by law if you do not accept this License.  Therefore, by
++-modifying or distributing the Program (or any work based on the
++-Program), you indicate your acceptance of this License to do so, and
++-all its terms and conditions for copying, distributing or modifying
++-the Program or works based on it.
++-
++-  6. Each time you redistribute the Program (or any work based on the
++-Program), the recipient automatically receives a license from the
++-original licensor to copy, distribute or modify the Program subject to
++-these terms and conditions.  You may not impose any further
++-restrictions on the recipients' exercise of the rights granted herein.
++-You are not responsible for enforcing compliance by third parties to
++-this License.
++-
++-  7. If, as a consequence of a court judgment or allegation of patent
++-infringement or for any other reason (not limited to patent issues),
++-conditions are imposed on you (whether by court order, agreement or
++-otherwise) that contradict the conditions of this License, they do not
++-excuse you from the conditions of this License.  If you cannot
++-distribute so as to satisfy simultaneously your obligations under this
++-License and any other pertinent obligations, then as a consequence you
++-may not distribute the Program at all.  For example, if a patent
++-license would not permit royalty-free redistribution of the Program by
++-all those who receive copies directly or indirectly through you, then
++-the only way you could satisfy both it and this License would be to
++-refrain entirely from distribution of the Program.
++-
++-If any portion of this section is held invalid or unenforceable under
++-any particular circumstance, the balance of the section is intended to
++-apply and the section as a whole is intended to apply in other
++-circumstances.
++-
++-It is not the purpose of this section to induce you to infringe any
++-patents or other property right claims or to contest validity of any
++-such claims; this section has the sole purpose of protecting the
++-integrity of the free software distribution system, which is
++-implemented by public license practices.  Many people have made
++-generous contributions to the wide range of software distributed
++-through that system in reliance on consistent application of that
++-system; it is up to the author/donor to decide if he or she is willing
++-to distribute software through any other system and a licensee cannot
++-impose that choice.
++-
++-This section is intended to make thoroughly clear what is believed to
++-be a consequence of the rest of this License.
++-
++-  8. If the distribution and/or use of the Program is restricted in
++-certain countries either by patents or by copyrighted interfaces, the
++-original copyright holder who places the Program under this License
++-may add an explicit geographical distribution limitation excluding
++-those countries, so that distribution is permitted only in or among
++-countries not thus excluded.  In such case, this License incorporates
++-the limitation as if written in the body of this License.
++-
++-  9. The Free Software Foundation may publish revised and/or new versions
++-of the General Public License from time to time.  Such new versions will
++-be similar in spirit to the present version, but may differ in detail to
++-address new problems or concerns.
++-
++-Each version is given a distinguishing version number.  If the Program
++-specifies a version number of this License which applies to it and "any
++-later version", you have the option of following the terms and conditions
++-either of that version or of any later version published by the Free
++-Software Foundation.  If the Program does not specify a version number of
++-this License, you may choose any version ever published by the Free Software
++-Foundation.
++-
++-  10. If you wish to incorporate parts of the Program into other free
++-programs whose distribution conditions are different, write to the author
++-to ask for permission.  For software which is copyrighted by the Free
++-Software Foundation, write to the Free Software Foundation; we sometimes
++-make exceptions for this.  Our decision will be guided by the two goals
++-of preserving the free status of all derivatives of our free software and
++-of promoting the sharing and reuse of software generally.
++-
++-			    NO WARRANTY
++-
++-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
++-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
++-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
++-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
++-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
++-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
++-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
++-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
++-REPAIR OR CORRECTION.
++-
++-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
++-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
++-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
++-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
++-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
++-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
++-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
++-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
++-POSSIBILITY OF SUCH DAMAGES.
++-
++-		     END OF TERMS AND CONDITIONS
++-
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
++deleted file mode 100644
++index 367657e64..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
+++++ /dev/null
++@@ -1,39 +0,0 @@
++-Errorpages
++-===========
++-
++-Error pages displays custom error pages in your forum. As an option all errors are logged in your errorlog.
++-
++-[![Build Status](https://travis-ci.org/ForumHulp/errorpages.svg?branch=master)](https://travis-ci.org/ForumHulp/errorpages)
++-
++-## Requirements
++-* phpBB 3.1.0-dev or higher
++-* PHP 5.3.3 or higher
++-
++-## Installation
++-You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:
++-
++-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/errorpages/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
++-3. Click Error pages => `Enable`.
++-
++-Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.
++-
++-## Update
++-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/errorpages/archive/master.zip).
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
++-3. Copy the contents of `errorpages-master` folder to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
++-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Enable`.
++-5. Click `Details` or `Re-Check all versions` link to follow updates.
++-6. Or use our Upload Extensions extension
++-
++-## Uninstallation
++-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
++-
++-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/errorpages/` folder or use our Upload Extensions extension to delet all files and folders.
++-
++-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
++-
++-## License
++-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
++-
++-© 2014 - John Peskens (ForumHulp.com)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/config/services.yml"
++index 33bd7f719..e2c5eac76 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/config/services.yml"
++@@ -2,15 +2,16 @@ services:
++     kernel.listener.forumhulp_errorpages:
++         class: forumhulp\errorpages\event\listener
++         arguments:
++-            - @config
++-            - @user
++-            - @template
++-            - @log
+++            - '@config'
+++            - '@user'
+++            - '@template'
+++            - '@log'
++         tags:
++             - { name: kernel.event_listener, event: kernel.exception, method: onKernelException }
+++
++     forumhulp.errorpages.acp_listener:
++         class: forumhulp\errorpages\event\acp_listener
++         arguments:
++-            - @controller.helper
+++            - '@controller.helper'
++         tags:
++             - { name: event.listener }
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp"
++new file mode 100644
++index 000000000..1179747a0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/diff_full.tmp"
++@@ -0,0 +1,393 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
+++deleted file mode 100644
+++index c1dfdae77..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/.travis.yml"
++++++ /dev/null
+++@@ -1,60 +0,0 @@
+++-language: php
+++-
+++-matrix:
+++-  include:
+++-    - php: 5.4
+++-      env: DB=mysqli
+++-    - php: 5.4
+++-      env: DB=mysql
+++-    - php: 5.4
+++-      env: DB=mariadb
+++-    - php: 5.4
+++-      env: DB=postgres
+++-    - php: 5.4
+++-      env: DB=sqlite3
+++-    - php: 5.5
+++-      env: DB=mysqli
+++-    - php: 5.6
+++-      env: DB=mysqli
+++-    - php: hhvm
+++-      env: DB=mysqli
+++-  allow_failures:
+++-    - php: hhvm
+++-  fast_finish: true
+++-
+++-env:
+++-  global:
+++-    - EXTNAME="ForumHulp/errorpages"  # CHANGE name of the extension HERE
+++-    - SNIFF="1"            # Should we run code sniffer on your code?
+++-    - IMAGE_ICC="0"        # Should we run icc profile sniffer on your images?
+++-    - EPV="0"              # Should we run EPV (Extension Pre Validator) on your code?
+++-    - PHPBB_BRANCH="3.1.x"
+++-
+++-branches:
+++-  only:
+++-    - master
+++-    - develop
+++-    - /^develop-.*$/
+++-
+++-before_install:
+++-  - sudo mkdir travis
+++-  - git clone "https://github.com/nickvergessen/phpbb-ext-acme-demo.git"
+++-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
+++-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
+++-  - sudo rm -rf phpbb-ext-acme-demo
+++-
+++-install:
+++-  - composer install --dev --no-interaction --prefer-source
+++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+++-  - cd ../../phpBB3
+++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+++-
+++-before_script:
+++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+++-
+++-script:
+++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+++-  - sh -c "if [ '$EPV' != '0' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
+++deleted file mode 100644
+++index ce992b2ce..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/LICENSE.txt"
++++++ /dev/null
+++@@ -1,281 +0,0 @@
+++-		    GNU GENERAL PUBLIC LICENSE
+++-		       Version 2, June 1991
+++-
+++- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
+++-                          675 Mass Ave, Cambridge, MA 02139, USA
+++- Everyone is permitted to copy and distribute verbatim copies
+++- of this license document, but changing it is not allowed.
+++-
+++-			    Preamble
+++-
+++-  The licenses for most software are designed to take away your
+++-freedom to share and change it.  By contrast, the GNU General Public
+++-License is intended to guarantee your freedom to share and change free
+++-software--to make sure the software is free for all its users.  This
+++-General Public License applies to most of the Free Software
+++-Foundation's software and to any other program whose authors commit to
+++-using it.  (Some other Free Software Foundation software is covered by
+++-the GNU Library General Public License instead.)  You can apply it to
+++-your programs, too.
+++-
+++-  When we speak of free software, we are referring to freedom, not
+++-price.  Our General Public Licenses are designed to make sure that you
+++-have the freedom to distribute copies of free software (and charge for
+++-this service if you wish), that you receive source code or can get it
+++-if you want it, that you can change the software or use pieces of it
+++-in new free programs; and that you know you can do these things.
+++-
+++-  To protect your rights, we need to make restrictions that forbid
+++-anyone to deny you these rights or to ask you to surrender the rights.
+++-These restrictions translate to certain responsibilities for you if you
+++-distribute copies of the software, or if you modify it.
+++-
+++-  For example, if you distribute copies of such a program, whether
+++-gratis or for a fee, you must give the recipients all the rights that
+++-you have.  You must make sure that they, too, receive or can get the
+++-source code.  And you must show them these terms so they know their
+++-rights.
+++-
+++-  We protect your rights with two steps: (1) copyright the software, and
+++-(2) offer you this license which gives you legal permission to copy,
+++-distribute and/or modify the software.
+++-
+++-  Also, for each author's protection and ours, we want to make certain
+++-that everyone understands that there is no warranty for this free
+++-software.  If the software is modified by someone else and passed on, we
+++-want its recipients to know that what they have is not the original, so
+++-that any problems introduced by others will not reflect on the original
+++-authors' reputations.
+++-
+++-  Finally, any free program is threatened constantly by software
+++-patents.  We wish to avoid the danger that redistributors of a free
+++-program will individually obtain patent licenses, in effect making the
+++-program proprietary.  To prevent this, we have made it clear that any
+++-patent must be licensed for everyone's free use or not licensed at all.
+++-
+++-  The precise terms and conditions for copying, distribution and
+++-modification follow.
+++-
+++-		    GNU GENERAL PUBLIC LICENSE
+++-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
+++-
+++-  0. This License applies to any program or other work which contains
+++-a notice placed by the copyright holder saying it may be distributed
+++-under the terms of this General Public License.  The "Program", below,
+++-refers to any such program or work, and a "work based on the Program"
+++-means either the Program or any derivative work under copyright law:
+++-that is to say, a work containing the Program or a portion of it,
+++-either verbatim or with modifications and/or translated into another
+++-language.  (Hereinafter, translation is included without limitation in
+++-the term "modification".)  Each licensee is addressed as "you".
+++-
+++-Activities other than copying, distribution and modification are not
+++-covered by this License; they are outside its scope.  The act of
+++-running the Program is not restricted, and the output from the Program
+++-is covered only if its contents constitute a work based on the
+++-Program (independent of having been made by running the Program).
+++-Whether that is true depends on what the Program does.
+++-
+++-  1. You may copy and distribute verbatim copies of the Program's
+++-source code as you receive it, in any medium, provided that you
+++-conspicuously and appropriately publish on each copy an appropriate
+++-copyright notice and disclaimer of warranty; keep intact all the
+++-notices that refer to this License and to the absence of any warranty;
+++-and give any other recipients of the Program a copy of this License
+++-along with the Program.
+++-
+++-You may charge a fee for the physical act of transferring a copy, and
+++-you may at your option offer warranty protection in exchange for a fee.
+++-
+++-  2. You may modify your copy or copies of the Program or any portion
+++-of it, thus forming a work based on the Program, and copy and
+++-distribute such modifications or work under the terms of Section 1
+++-above, provided that you also meet all of these conditions:
+++-
+++-    a) You must cause the modified files to carry prominent notices
+++-    stating that you changed the files and the date of any change.
+++-
+++-    b) You must cause any work that you distribute or publish, that in
+++-    whole or in part contains or is derived from the Program or any
+++-    part thereof, to be licensed as a whole at no charge to all third
+++-    parties under the terms of this License.
+++-
+++-    c) If the modified program normally reads commands interactively
+++-    when run, you must cause it, when started running for such
+++-    interactive use in the most ordinary way, to print or display an
+++-    announcement including an appropriate copyright notice and a
+++-    notice that there is no warranty (or else, saying that you provide
+++-    a warranty) and that users may redistribute the program under
+++-    these conditions, and telling the user how to view a copy of this
+++-    License.  (Exception: if the Program itself is interactive but
+++-    does not normally print such an announcement, your work based on
+++-    the Program is not required to print an announcement.)
+++-
+++-These requirements apply to the modified work as a whole.  If
+++-identifiable sections of that work are not derived from the Program,
+++-and can be reasonably considered independent and separate works in
+++-themselves, then this License, and its terms, do not apply to those
+++-sections when you distribute them as separate works.  But when you
+++-distribute the same sections as part of a whole which is a work based
+++-on the Program, the distribution of the whole must be on the terms of
+++-this License, whose permissions for other licensees extend to the
+++-entire whole, and thus to each and every part regardless of who wrote it.
+++-
+++-Thus, it is not the intent of this section to claim rights or contest
+++-your rights to work written entirely by you; rather, the intent is to
+++-exercise the right to control the distribution of derivative or
+++-collective works based on the Program.
+++-
+++-In addition, mere aggregation of another work not based on the Program
+++-with the Program (or with a work based on the Program) on a volume of
+++-a storage or distribution medium does not bring the other work under
+++-the scope of this License.
+++-
+++-  3. You may copy and distribute the Program (or a work based on it,
+++-under Section 2) in object code or executable form under the terms of
+++-Sections 1 and 2 above provided that you also do one of the following:
+++-
+++-    a) Accompany it with the complete corresponding machine-readable
+++-    source code, which must be distributed under the terms of Sections
+++-    1 and 2 above on a medium customarily used for software interchange; or,
+++-
+++-    b) Accompany it with a written offer, valid for at least three
+++-    years, to give any third party, for a charge no more than your
+++-    cost of physically performing source distribution, a complete
+++-    machine-readable copy of the corresponding source code, to be
+++-    distributed under the terms of Sections 1 and 2 above on a medium
+++-    customarily used for software interchange; or,
+++-
+++-    c) Accompany it with the information you received as to the offer
+++-    to distribute corresponding source code.  (This alternative is
+++-    allowed only for noncommercial distribution and only if you
+++-    received the program in object code or executable form with such
+++-    an offer, in accord with Subsection b above.)
+++-
+++-The source code for a work means the preferred form of the work for
+++-making modifications to it.  For an executable work, complete source
+++-code means all the source code for all modules it contains, plus any
+++-associated interface definition files, plus the scripts used to
+++-control compilation and installation of the executable.  However, as a
+++-special exception, the source code distributed need not include
+++-anything that is normally distributed (in either source or binary
+++-form) with the major components (compiler, kernel, and so on) of the
+++-operating system on which the executable runs, unless that component
+++-itself accompanies the executable.
+++-
+++-If distribution of executable or object code is made by offering
+++-access to copy from a designated place, then offering equivalent
+++-access to copy the source code from the same place counts as
+++-distribution of the source code, even though third parties are not
+++-compelled to copy the source along with the object code.
+++-
+++-  4. You may not copy, modify, sublicense, or distribute the Program
+++-except as expressly provided under this License.  Any attempt
+++-otherwise to copy, modify, sublicense or distribute the Program is
+++-void, and will automatically terminate your rights under this License.
+++-However, parties who have received copies, or rights, from you under
+++-this License will not have their licenses terminated so long as such
+++-parties remain in full compliance.
+++-
+++-  5. You are not required to accept this License, since you have not
+++-signed it.  However, nothing else grants you permission to modify or
+++-distribute the Program or its derivative works.  These actions are
+++-prohibited by law if you do not accept this License.  Therefore, by
+++-modifying or distributing the Program (or any work based on the
+++-Program), you indicate your acceptance of this License to do so, and
+++-all its terms and conditions for copying, distributing or modifying
+++-the Program or works based on it.
+++-
+++-  6. Each time you redistribute the Program (or any work based on the
+++-Program), the recipient automatically receives a license from the
+++-original licensor to copy, distribute or modify the Program subject to
+++-these terms and conditions.  You may not impose any further
+++-restrictions on the recipients' exercise of the rights granted herein.
+++-You are not responsible for enforcing compliance by third parties to
+++-this License.
+++-
+++-  7. If, as a consequence of a court judgment or allegation of patent
+++-infringement or for any other reason (not limited to patent issues),
+++-conditions are imposed on you (whether by court order, agreement or
+++-otherwise) that contradict the conditions of this License, they do not
+++-excuse you from the conditions of this License.  If you cannot
+++-distribute so as to satisfy simultaneously your obligations under this
+++-License and any other pertinent obligations, then as a consequence you
+++-may not distribute the Program at all.  For example, if a patent
+++-license would not permit royalty-free redistribution of the Program by
+++-all those who receive copies directly or indirectly through you, then
+++-the only way you could satisfy both it and this License would be to
+++-refrain entirely from distribution of the Program.
+++-
+++-If any portion of this section is held invalid or unenforceable under
+++-any particular circumstance, the balance of the section is intended to
+++-apply and the section as a whole is intended to apply in other
+++-circumstances.
+++-
+++-It is not the purpose of this section to induce you to infringe any
+++-patents or other property right claims or to contest validity of any
+++-such claims; this section has the sole purpose of protecting the
+++-integrity of the free software distribution system, which is
+++-implemented by public license practices.  Many people have made
+++-generous contributions to the wide range of software distributed
+++-through that system in reliance on consistent application of that
+++-system; it is up to the author/donor to decide if he or she is willing
+++-to distribute software through any other system and a licensee cannot
+++-impose that choice.
+++-
+++-This section is intended to make thoroughly clear what is believed to
+++-be a consequence of the rest of this License.
+++-
+++-  8. If the distribution and/or use of the Program is restricted in
+++-certain countries either by patents or by copyrighted interfaces, the
+++-original copyright holder who places the Program under this License
+++-may add an explicit geographical distribution limitation excluding
+++-those countries, so that distribution is permitted only in or among
+++-countries not thus excluded.  In such case, this License incorporates
+++-the limitation as if written in the body of this License.
+++-
+++-  9. The Free Software Foundation may publish revised and/or new versions
+++-of the General Public License from time to time.  Such new versions will
+++-be similar in spirit to the present version, but may differ in detail to
+++-address new problems or concerns.
+++-
+++-Each version is given a distinguishing version number.  If the Program
+++-specifies a version number of this License which applies to it and "any
+++-later version", you have the option of following the terms and conditions
+++-either of that version or of any later version published by the Free
+++-Software Foundation.  If the Program does not specify a version number of
+++-this License, you may choose any version ever published by the Free Software
+++-Foundation.
+++-
+++-  10. If you wish to incorporate parts of the Program into other free
+++-programs whose distribution conditions are different, write to the author
+++-to ask for permission.  For software which is copyrighted by the Free
+++-Software Foundation, write to the Free Software Foundation; we sometimes
+++-make exceptions for this.  Our decision will be guided by the two goals
+++-of preserving the free status of all derivatives of our free software and
+++-of promoting the sharing and reuse of software generally.
+++-
+++-			    NO WARRANTY
+++-
+++-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
+++-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
+++-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
+++-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
+++-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
+++-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
+++-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
+++-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
+++-REPAIR OR CORRECTION.
+++-
+++-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
+++-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
+++-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
+++-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
+++-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
+++-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
+++-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
+++-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
+++-POSSIBILITY OF SUCH DAMAGES.
+++-
+++-		     END OF TERMS AND CONDITIONS
+++-
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
+++deleted file mode 100644
+++index 367657e64..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/README.md"
++++++ /dev/null
+++@@ -1,39 +0,0 @@
+++-Errorpages
+++-===========
+++-
+++-Error pages displays custom error pages in your forum. As an option all errors are logged in your errorlog.
+++-
+++-[![Build Status](https://travis-ci.org/ForumHulp/errorpages.svg?branch=master)](https://travis-ci.org/ForumHulp/errorpages)
+++-
+++-## Requirements
+++-* phpBB 3.1.0-dev or higher
+++-* PHP 5.3.3 or higher
+++-
+++-## Installation
+++-You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:
+++-
+++-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/errorpages/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
+++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
+++-3. Click Error pages => `Enable`.
+++-
+++-Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.
+++-
+++-## Update
+++-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/errorpages/archive/master.zip).
+++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
+++-3. Copy the contents of `errorpages-master` folder to `FORUM_DIRECTORY/ext/forumhulp/errorpages/`.
+++-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Enable`.
+++-5. Click `Details` or `Re-Check all versions` link to follow updates.
+++-6. Or use our Upload Extensions extension
+++-
+++-## Uninstallation
+++-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click Error pages => `Disable`.
+++-
+++-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/errorpages/` folder or use our Upload Extensions extension to delet all files and folders.
+++-
+++-We feel sorry as our answers on phpbb sites are removed, so use gi
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/event/listener.php"
++index 57481f7bb..c7d1cc926 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/event/listener.php"
++@@ -36,86 +36,14 @@ class listener implements EventSubscriberInterface
++ 		$exception = $event->getException();
++ 		$request = $event->getRequest();
++ 
++-		switch ($exception->getStatusCode())
++-		{
++-			case '400':
++-				$msg = 'ERROR_BAD_REQUEST';
++-			break;
++-			case '401':
++-				$msg = 'ERROR_AUTH_REQUIRED';
++-			break;
++-			case '403':
++-				$msg = 'ERROR_FORBIDDEN';
++-			break;
++-			case '404':
++-				$msg = 'ERROR_NOT_FOUND';
++-			break;
++-			case '405':
++-				$msg = 'METHOD_NOT_ALLOWED';
++-			break;
++-			case '406':
++-				$msg = 'NOT_ACCEPTABLE';
++-			break;
++-			case '407':
++-				$msg = 'PROXY_AUTHENTICATION_REQUIRED';
++-			break;
++-			case '408':
++-				$msg = 'REQUEST_TIMED_OUT';
++-			break;
++-			case '409':
++-				$msg = 'CONFLICTING_REQUEST';
++-			break;
++-			case '410':
++-				$msg = 'GONE';
++-			break;
++-			case '411':
++-				$msg = 'CONTENT_LENGTH_REQUIRED';
++-			break;
++-			case '412':
++-				$msg = 'PRECONDITION_FAILED';
++-			break;
++-			case '413':
++-				$msg = 'REQUEST_ENTITY_TOO_LONG';
++-			break;
++-			case '414':
++-				$msg = 'REQUEST_URI_TOO_LONG';
++-			break;
++-			case '415':
++-				$msg = 'UNSUPPORTED_MEDIA_TYPE';
++-			break;
++-			case '418':
++-				$msg = 'TEAPOT';
++-			break;
+++		
++ 
++-			case '500':
++-				$msg = 'INTERNAL_SERVER_ERROR';
++-			break;
++-			case '501':
++-				$msg = 'NOT_IMPLEMENTED';
++-			break;
++-			case '502':
++-				$msg = 'BAD_GATEWAY';
++-			break;
++-			case '503':
++-				$msg = 'SERVICE_UNAVAILABLE';
++-			break;
++-			case '504':
++-				$msg = 'GATEWAY_TIMOUT';
++-			break;
++-			case '505':
++-				$msg = 'HTTP_VERSION_NOT_SUPPORTED';
++-			break;
++-			default:
++-				$msg = 'ERROR_UNKNOWN';
++-			break;
++-		}
++-
++-		($this->config['error_pages_log']) ? $this->log->add('critical', $this->user->data['user_id'], $this->user->data['session_ip'], 'LOG_GENERAL_ERROR', false, array($exception->getStatusCode() . ': ' . $this->user->lang[$msg], $request->getPathInfo())) : null;
+++		
++ 
++ 		page_header($this->user->lang('INFORMATION'));
++ 		$this->template->assign_vars(array(
++ 			'MESSAGE_TITLE'		=> $this->user->lang('INFORMATION'),
++-			'MESSAGE_TEXT'		=> $this->user->lang[$msg] . '<br />' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br />' . sprintf($this->user->lang['RETURN_INDEX'], '<a href="' . generate_board_url() .'">', '</a>'),
+++			'MESSAGE_TEXT'		=> '</p><div class="text-center"><h1 class="text-uppercase">' . $this->user->lang[$msg] . '</h1>' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br /><a href="' . generate_board_url() .'" class="btn btn-default">' . sprintf($this->user->lang['RETURN_INDEX'], '', '') . '</a></div><p>',
++ 		));
++ 
++ 		$this->template->set_filenames(array(
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php"
++index a7be7e8ee..925ee85de 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\errorpages/language/en/info_acp_errorpages.php"
++@@ -39,15 +39,15 @@ $lang = array_merge($lang, array(
++ 	'ERRORPAGES_LOG_EXPLAIN'			=> 'Log all Error Pages in Error Log in Maintenance Tab',
++ 	'ERRORPAGES_EXPLAIN'				=> 'Explain Error Pages',
++ 	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Explain error in message display',
++-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Config settings are in %1$s » %2$s » %3$s.</p></div>',
+++	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p>Config settings are in <strong>%1$s » %2$s » %3$s.</strong></p></div>',
++ 	'ERROR_BAD_REQUEST' 				=> 'Bad Request',
++ 	'ERROR_BAD_REQUESTEXPA' 			=> 'The request had bad syntax or was inherently impossible to be completed.',
++ 	'ERROR_AUTH_REQUIRED' 				=> 'Authorization Required',
++ 	'ERROR_AUTH_REQUIREDEXPA' 			=> 'This means that the page requires that the visitors authenticate with their username and password. If they fail to do that, the server returns this error message.',
++ 	'ERROR_FORBIDDEN' 					=> 'Forbidden',
++ 	'ERROR_FORBIDDENEXPA' 				=> 'This means that access to the page the visitor is requesting is not allowed. This can be due to a special rule in the configuration of the web server, or to the specific file system permissions of the file.',
++-	'ERROR_NOT_FOUND' 					=> 'Not Found',
++-	'ERROR_NOT_FOUNDEXPA'		 		=> 'This simply means that the requested file is not there.',
+++	'ERROR_NOT_FOUND' 					=> '<span class="error"><i></i></span>OOPS! Page Not Found',
+++	'ERROR_NOT_FOUNDEXPA'		 		=> 'Unfortunately the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exist.<br /><br />Check the URL you entered for any mistakes and try again.',
++ 	'PRECONDITION_FAILED'				=> 'Precondition Failed',
++ 	'PRECONDITION_FAILEDEXPA'			=> 'The error means that the request triggered a mod_security protection on our end.',
++ 	'METHOD_NOT_ALLOWED'				=> 'Method Not Allowed',
++@@ -86,5 +86,5 @@ $lang = array_merge($lang, array(
++ 	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'The server does not support the HTTP protocol version used in the request.',
++ 	'ERROR_UNKNOWN'     	  		 	=> 'Unknown Server Error',
++ 	'ERROR_UNKNOWNEXPA'      		 	=> '',
++-	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
+++	'FH_HELPER_NOTICE'					=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/es/info_acp_errorpages.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/es/info_acp_errorpages.php"
++deleted file mode 100644
++index ca26f79f8..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/es/info_acp_errorpages.php"
+++++ /dev/null
++@@ -1,90 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Errorpages
++-* @copyright (c) 2014 ForumHulp.com
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE!
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-
++-// Custom error pages
++-$lang = array_merge($lang, array(
++-	'ERRORPAGESERROR'			=> 'Páginas de Error',
++-	'ERRORPAGES_LOG'			=> 'Registro de Páginas de Error',
++-	'ERRORPAGES_LOG_EXPLAIN'		=> 'Registrar todos los errores de páginas en el registro de Error en la pestaña Mantenimiento',
++-	'ERRORPAGES_EXPLAIN'			=> 'Describir errores de páginas',
++-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Describir error en un mensaje en pantalla',
++-	'ERRORPAGE_NOTICE'			=> '<div class="phpinfo"><p class="entry">Los ajustes de configuración están en %1$s » %2$s » %3$s.</p></div>',
++-	'ERROR_BAD_REQUEST' 			=> 'Solicitud Incorrecta',
++-	'ERROR_BAD_REQUESTEXPA' 		=> 'La solicitud tiene mala sintaxis o era intrínsecamente imposible que esté terminado.',
++-	'ERROR_AUTH_REQUIRED' 			=> 'Autorización Requerida',
++-	'ERROR_AUTH_REQUIREDEXPA' 		=> 'Esto significa que la página requiere que los visitantes se identifiquen con su nombre de usuario y contraseña. Si no pueden hacerlo, el servidor devuelve este mensaje de error.',
++-	'ERROR_FORBIDDEN' 			=> 'Prohibido',
++-	'ERROR_FORBIDDENEXPA' 			=> 'Esto significa que el acceso a la página solicitada por el visitante no está permitido. Esto puede ser debido a una regla especial en la configuración del servidor web, o de los permisos específicos del sistema de archivos, sobre dicho archivo.',
++-	'ERROR_NOT_FOUND' 			=> 'No Encontrada',
++-	'ERROR_NOT_FOUNDEXPA'		 	=> 'Esto simplemente significa que el archivo solicitado no está allí.',
++-	'PRECONDITION_FAILED'			=> 'Condición previa Fracasado',
++-	'PRECONDITION_FAILEDEXPA'		=> 'El error significa que la solicitud desencadenó una protección mod_security por nuestra parte.',
++-	'METHOD_NOT_ALLOWED'			=> 'Método no Permitido',
++-	'METHOD_NOT_ALLOWEDEXPA'		=> 'Se realizó una solicitud de un recurso mediante un método de solicitud no soportado por ese recurso; por ejemplo, el uso de GET en un formulario que requiere datos que se presentará a través de POST, o el uso de poner en un recurso de sólo lectura.',
++-	'NOT_ACCEPTABLE'			=> 'No Aceptable (codificación)',
++-	'NOT_ACCEPTABLEEXPA'			=> 'El recurso solicitado sólo es capaz de generar contenido no aceptable de acuerdo con las cabeceras de aceptación enviadas en la petición.',
++-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Proxy requiere Autenticación',
++-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'El cliente primero debe autenticarse con el proxy.',
++-	'REQUEST_TIMED_OUT'			=> 'Tiempo de espera agotado',
++-	'REQUEST_TIMED_OUTEXPA'			=> 'El servidor ha agotado el tiempo de espera para la solicitud. De acuerdo con las especificaciones de HTTP: "El cliente no produjo una solicitud dentro del plazo que el servidor estaba dispuesto a esperar el cliente puede repetir la solicitud sin modificaciones en cualquier momento posterior."',
++-	'CONFLICTING_REQUEST'			=> 'Solicitud en conflicto',
++-	'CONFLICTING_REQUESTEXPA'		=> 'Indica que la solicitud no pudo ser procesada debido a los conflictos en la solicitud, tal como un conflicto de edición en el caso de varias actualizaciones',
++-	'GONE'					=> 'Pasado',
++-	'GONEEXPA'				=> 'Indica que el recurso solicitado ya no está disponible y no volverá a estar disponible. Esto se debe utilizar cuando un recurso se ha eliminado intencionalmente y el recurso debe ser purgado. Al recibir un código de estado 410, el cliente no debe solicitar el recurso de nuevo en el futuro. Clientes tales como motores de búsqueda deben eliminar el recurso de sus índices. [cita requerida] La mayoría de los casos de uso no requieren los clientes y los motores de búsqueda para purgar el recurso, y un "404 No Encontrado" se puede utilizar en su lugar.',
++-	'CONTENT_LENGTH_REQUIRED'		=> 'Longitud de Contenido Requerida',
++-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'La solicitud no especificó la duración de su contenido, que es requerido por el recurso solicitado',
++-	'REQUEST_ENTITY_TOO_LONG'		=> 'Solicitud de Entidad Demasiado Largo',
++-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'La solicitud es mayor que lo del servidor está dispuesto o es capaz de procesar.',
++-	'REQUEST_URI_TOO_LONG'			=> 'Solicitud de URI demasiado larga',
++-	'REQUEST_URI_TOO_LONGEXPA'		=> 'La URI proporcionada era demasiado larga para procesarlo el servidor. A menudo el resultado de demasiados datos se codifica como una cadena de consulta de una solicitud GET, en cuyo caso debe ser convertido a una solicitud POST.',
++-	'UNSUPPORTED_MEDIA_TYPE'		=> 'Tipo de Media no soportado',
++-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'La petición de entidad tiene un tipo de medio que el servidor o el recurso no es compatible. el cliente carga una imagen como imagen/svg+xml, pero el servidor requiere que las imágenes utilicen un formato diferente.',
++-	'TEAPOT'				=> 'Soy una tetera (RFC 2324)',
++-	'TEAPOTEXPA'				=> 'Se definió este código en 1998 como uno de los chistes tradicionales de Día de los Inocentes (IETF April Fools’ Jokes), en el RFC 2324, y no se espera que el Protocolo de Hyper Texto Cafetera de control para ser implementados por los servidores HTTP reales.',
++-	'INTERNAL_SERVER_ERROR'			=> 'Error interno del servidor',
++-	'INTERNAL_SERVER_ERROREXPA' 		=> 'El servidor encontró una condición inesperada que le impidió cumplir con la solicitud.',
++-	'NOT_IMPLEMENTED' 			=> 'No implementado',
++-	'NOT_IMPLEMENTEDEXPA' 			=> 'El servidor no admite la instalación requerida.',
++-	'BAD_GATEWAY' 				=> 'Puerta de enlace mala',
++-	'BAD_GATEWAYEXPA' 			=> 'El servidor encontró un error temporal y no pudo completar su solicitud.',
++-	'SERVICE_UNAVAILABLE' 			=> 'Servicio no disponible',
++-	'SERVICE_UNAVAILABLEEXPA' 		=> 'El servidor en este momento es incapaz de atender su solicitud debido a tiempo de inactividad, mantenimiento o problemas de capacidad. Por favor, inténtelo de nuevo más tarde.',
++-	'GATEWAY_TIMOUT' 			=> 'Tiempo de espera de puerta de enlace',
++-	'GATEWAY_TIMOUTEXPA' 			=> 'El servidor estaba actuando como una puerta de enlace o proxy y no recibió una respuesta a tiempo del servidor en sentido ascendente.',
++-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'Versión HTTP no soportado',
++-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'El servidor no soporta la versión del protocolo HTTP utilizada en la solicitud.',
++-	'ERROR_UNKNOWN'     	  		=> 'Error del servidor desconocido',
++-	'ERROR_UNKNOWNEXPA'      		=> '',
++-	'FH_HELPER_NOTICE'			=> '¡La aplicación Forumhulp helper no existe!<br />Descargar <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> y copie la carpeta helper dentro de la carpeta de extensión forumhulp.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/fr/info_acp_errorpages.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/fr/info_acp_errorpages.php"
++deleted file mode 100644
++index 20b059bc3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/fr/info_acp_errorpages.php"
+++++ /dev/null
++@@ -1,95 +0,0 @@
++-<?php
++-/**
++-*
++-* Error pages extension for the phpBB Forum Software package.
++-* French translation by Galixte (http://www.galixte.com)
++-*
++-* @copyright (c) 2015 phpBB ForumHulp <http://www.forumhulp.com>
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ « » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ERRORPAGESERROR'					=> 'Pages d’erreurs',
++-	'ERRORPAGES_LOG'					=> 'Journal des pages d’erreurs',
++-	'ERRORPAGES_LOG_EXPLAIN'			=> 'Archive toutes les pages d’erreurs rencontrées par les utilisateurs dans le journal des pages d’erreurs accessible depuis l’onglet « MAINTENANCE ».',
++-	'ERRORPAGES_EXPLAIN'				=> 'Explications des pages d’erreurs',
++-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Permet de fournir une explication dans le message affiché sur la page d’erreur.',
++-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Les paramètres de cette extension se trouvent dans : %1$s » %2$s » %3$s.</p></div>',
++-	'ERROR_BAD_REQUEST' 				=> 'Erreur 400 - Mauvaise requête',
++-	'ERROR_BAD_REQUESTEXPA' 			=> 'La requête HTTP n’a pas pu être comprise par le serveur en raison d’une syntaxe erronée. Le problème peut provenir d’un navigateur web trop récent ou d’un serveur HTTP trop ancien.',
++-	'ERROR_AUTH_REQUIRED' 				=> 'Erreur 401 - Non autorisé',
++-	'ERROR_AUTH_REQUIREDEXPA' 			=> 'La requête nécessite une identification de l’utilisateur. Concrètement, cela signifie que tout ou partie du serveur contacté est protégé par des identifiants, qu’il faut indiquer au serveur pour pouvoir accéder à son contenu.',
++-	'ERROR_FORBIDDEN' 					=> 'Erreur 403 - Interdit',
++-	'ERROR_FORBIDDENEXPA' 				=> 'La ressource demandée vous est interdite d’accès. Soit parce que le serveur a été configuré de cette manière, soit parce que dans une phase d’authentification vous n’avez pas fourni d’identifiants valides. La raison peut être aussi plus large : votre adresse IP a été bannie, vous utilisez un client HTTP (navigateur) interdit (repéré par les en-têtes accompagnant la requête et l’identifiant), etc..',
++-	'ERROR_NOT_FOUND' 					=> 'Erreur 404 - Non trouvé',
++-	'ERROR_NOT_FOUNDEXPA'		 		=> 'Le serveur n’a rien trouvé qui corresponde à l’adresse (URI) demandée. Cela signifie que l’adresse URL que vous avez tapée ou cliquée est mauvaise ou obsolète et ne correspond à aucun document existant sur le serveur (vous pouvez essayez de supprimer progressivement les composants de l’adresse URL en partant de la fin pour éventuellement retrouver un chemin d’accès existant).',
++-	'PRECONDITION_FAILED'				=> 'Erreur 412 - Précondition échouée',
++-	'PRECONDITION_FAILEDEXPA'			=> 'Les conditions spécifiées dans la requête ne sont pas remplies.',
++-	'METHOD_NOT_ALLOWED'				=> 'Erreur 405 - Méthode non admise',
++-	'METHOD_NOT_ALLOWEDEXPA'			=> 'Ce code indique que la méthode utilisée par le client n’est pas supportée pour cet URI. Un client qui utilise une méthode non supportée sur un serveur ou pour une ressource précise verra une réponse 405. Celle-ci devra être accompagnée d’une liste de méthodes acceptées, spécifiées grâce à l’en-tête Allow.',
++-	'NOT_ACCEPTABLE'					=> 'Erreur 406 - Encodage pas acceptable',
++-	'NOT_ACCEPTABLEEXPA'				=> 'L’adresse (URI) spécifiée existe, mais pas dans le format préféré du client. Si le client demande une ressource dans un format que le serveur n’est pas en mesure de fournir, un code 406 sera retourné. Le serveur indique en retour le langage et les types d’encodages disponibles pour cette adresse.',
++-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Erreur 407 - Authentification proxy exigée',
++-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'Le serveur proxy exige une authentification du client avant de transmettre la requête. Le client contacte un proxy et lui envoie une requête, mais sans informations d’authentification alors que celui-ci en a besoin (absence de l’en-tête Proxy-Authorization).',
++-	'REQUEST_TIMED_OUT'					=> 'Erreur 408 - Délai écoulé pour la requête',
++-	'REQUEST_TIMED_OUTEXPA'				=> 'Le serveur met trop de temps à attendre la requête du client et finit par clore la conversation en répondant 408 (la connexion sera ensuite fermée). Le client n’a pas produit assez vite la requête attendue par le serveur, mais peut la produire plus tard.',
++-	'CONFLICTING_REQUEST'				=> 'Erreur 409 - Conflit',
++-	'CONFLICTING_REQUESTEXPA'			=> 'La requête entre en conflit avec une autre requête ou avec la configuration du serveur. Des informations sur les raisons de ce conflit doivent être indiquée en retour.',
++-	'GONE'								=> 'Erreur 410 - Page indisponible définitivement',
++-	'GONEEXPA'							=> 'L’adresse (URI) demandée n’existe plus et a été définitivement supprimée du serveur. La ressource est indisponible et aucune adresse de redirection n’est connue',
++-	'CONTENT_LENGTH_REQUIRED'			=> 'Erreur 411 - Longueur exigée',
++-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'Le serveur a besoin de connaitre la taille de cette requête pour pouvoir y répondre. La longueur de la requête n’a pas été précisée.',
++-	'REQUEST_ENTITY_TOO_LONG'			=> 'Erreur 413 - Corps de la requête trop grand',
++-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'Le serveur ne peut traiter la requête car la taille de son contenu est trop importante. Le traitement est abandonné dû à une requête trop importante.',
++-	'REQUEST_URI_TOO_LONG'				=> 'Erreur 414 - URI trop long',
++-	'REQUEST_URI_TOO_LONGEXPA'			=> 'Le serveur ne peut traiter la requête car la taille de l’objet (URI) a retourner est trop importante. L’adresse (URI) demandée par le client dépasse le nombre de caractères autorisés.',
++-	'UNSUPPORTED_MEDIA_TYPE'			=> 'Erreur 415 - Format non supporté',
++-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'Le serveur ne peut traiter la requête car son contenu est écrit dans un format non supporté. Le client envoie un contenu dont le type n’est pas reconnu par le serveur.',
++-	'TEAPOT'							=> '« Je suis une cafetière » (RFC 2324)',
++-	'TEAPOTEXPA'						=> 'L’Hyper Text Coffee Pot Control Protocol ou HTCPCP — de l’anglais signifiant littéralement « protocole hypertexte de gestion de cafetière » — est décrit dans la RFC 2324 publié le 1er avril 1998 et bien que cette RFC soit un poisson d’avril. C’est une proposition humoristique de protocole de communication client-serveur permettant le contrôle, la surveillance et le diagnostic de cafetière.',
++-	'INTERNAL_SERVER_ERROR'				=> 'Erreur 500 - Erreur interne du serveur',
++-	'INTERNAL_SERVER_ERROREXPA' 		=> 'Le serveur a rencontré un problème inattendu qui l’a empêché de traiter la requête avec succès. Cette erreur peut par exemple être le résultat d’une mauvaise configuration du serveur, ou d’une ressource épuisée ou refusée au serveur sur la machine hôte.',
++-	'NOT_IMPLEMENTED' 					=> 'Erreur 501 - Non mis en oeuvre',
++-	'NOT_IMPLEMENTEDEXPA' 				=> 'Le serveur ne supporte pas la fonctionnalité requise pour traiter avec succès la requête (ou ne reconnait pas la requête). C’est la réponse émise lorsque le serveur ne reconnait pas la méthode indiquée dans la requête et n’est capable de la mettre en oeuvre pour aucune ressource (soit le navigateur web est trop récent, soit le serveur HTTP est trop ancien).',
++-	'BAD_GATEWAY' 						=> 'Erreur 502 - Mauvaise passerelle',
++-	'BAD_GATEWAYEXPA' 					=> 'Le serveur agissait comme un intermédiaire (passerelle ou proxy) et une mauvaise réponse lui a été envoyée par un autre serveur.',
++-	'SERVICE_UNAVAILABLE' 				=> 'Erreur 503 - Service indisponible',
++-	'SERVICE_UNAVAILABLEEXPA' 			=> 'Le serveur est en ligne, mais il ne peut répondre pour le moment, repassez plus tard. Cela peut aussi indiquer que le serveur subit une maintenance ou est surchargé de requêtes et n’arrive pas à traiter correctement la votre.',
++-	'GATEWAY_TIMOUT' 					=> 'Erreur 504 - Expiration de la passerelle',
++-	'GATEWAY_TIMOUTEXPA' 				=> 'Le serveur agissait comme un intermédiaire (passerelle ou proxy) et il n’a pas eu de réponse d’un autre serveur dans les temps. Similaire à 408, cette fois-ci le serveur coupera alors la communication et répondra à son client par un 504.',
++-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'Erreur 505 - Version HTTP non supportée',
++-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'La version du protocole HTTP utilisée dans cette requête n’est pas (ou plus) supportée par le serveur.',
++-	'ERROR_UNKNOWN'     	  		 	=> 'Erreur 520 - Erreur inconnue du serveur',
++-	'ERROR_UNKNOWNEXPA'      		 	=> 'Le serveur renvoie une erreur inconnue.',
++-	'FH_HELPER_NOTICE'      		 	=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/nl/info_acp_errorpages.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/nl/info_acp_errorpages.php"
++deleted file mode 100644
++index d10348a09..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\errorpages/language/nl/info_acp_errorpages.php"
+++++ /dev/null
++@@ -1,90 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Errorpages
++-* @copyright (c) 2014 ForumHulp.com
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE!
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-
++-// Custom error pages
++-$lang = array_merge($lang, array(
++-	'ERRORPAGESERROR'					=> 'Error Pages',
++-	'ERRORPAGES_LOG'					=> 'Log Error Pages',
++-	'ERRORPAGES_LOG_EXPLAIN'			=> 'Sla alle Error Pages op in Error Log onder Maintenance Tab',
++-	'ERRORPAGES_EXPLAIN'				=> 'Uitleg Error Pages',
++-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Leg de foutmelding uit in het berichtenvenster',
++-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Config settings are in %1$s » %2$s » %3$s.</p></div>',
++-	'ERROR_BAD_REQUEST' 				=> 'Foute aanvraag',
++-	'ERROR_BAD_REQUESTEXPA' 			=> 'De aanvraag had een slechte syntax of kon onmogelijk worden uitgevoerd.',
++-	'ERROR_AUTH_REQUIRED' 				=> 'Niet geautoriseerd',
++-	'ERROR_AUTH_REQUIREDEXPA' 			=> 'Dit betekent dat de pagina vereist dat de bezoekers zich authenticeren met hun gebruikersnaam en wachtwoord. Als zij dit niet doen, retourneert de server deze foutmelding.',
++-	'ERROR_FORBIDDEN' 					=> 'Verboden toegang',
++-	'ERROR_FORBIDDENEXPA' 				=> 'Dit betekent dat de toegang tot de pagina die de bezoeker vraagt ​​niet is toegestaan. Dit kan door een bijzondere regel in de configuratie van de webserver of de specifieke bestandssysteem permissies van het bestand.',
++-	'ERROR_NOT_FOUND' 					=> 'Niet gevonden',
++-	'ERROR_NOT_FOUNDEXPA'		 		=> 'Het gevraagde bestand bestaat niet op de server.',
++-	'PRECONDITION_FAILED'				=> 'Niet voldaan aan vooraf gestelde voorwaarde',
++-	'PRECONDITION_FAILEDEXPA'			=> 'De fout betekent dat het verzoek leidde tot een mod_security bescherming aan de serverkant.',
++-	'METHOD_NOT_ALLOWED'				=> 'Methode niet toegestaan',
++-	'METHOD_NOT_ALLOWEDEXPA'			=> 'Een verzoek werd gemaakt van een bron met behulp van een verzoek methode die niet wordt ondersteund door die bron. Bijvoorbeeld met behulp van GET op een formulier dat de gegevens nodig heeft om via POST worden voorgelegd',
++-	'NOT_ACCEPTABLE'					=> 'Niet aanvaardbaar',
++-	'NOT_ACCEPTABLEEXPA'				=> 'De opgevraagde bron is alleen geschikt voor het genereren van content niet aanvaardbaar volgens de Accept headers verzonden in het verzoek.',
++-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Authenticatie op de proxyserver verplicht',
++-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'De gebruiker moet zich eerst verifiëren bij de proxyserver.',
++-	'REQUEST_TIMED_OUT'					=> 'Aanvraagtijd verstreken',
++-	'REQUEST_TIMED_OUTEXPA'				=> 'De server is gestopt met de aanvraag. Volgens HTTP specificaties: "De gebruiker deed geen aanvraag binnen de gestelde tijd van de server."',
++-	'CONFLICTING_REQUEST'				=> 'Conflict',
++-	'CONFLICTING_REQUESTEXPA'			=> 'Geeft aan dat het verzoek niet kon worden verwerkt, vanwege het conflict in het verzoek, zoals een bewerkingsconflict in het geval van meerdere updates',
++-	'GONE'								=> 'Verdwenen',
++-	'GONEEXPA'							=> 'Geeft aan dat de aangevraagde bron niet meer beschikbaar is. Na ontvangst van een 410 -status code , de klant moet niet de bron opnieuw op te vragen in de toekomst. Klanten zoals zoekmachines moet de bron te verwijderen uit hun indices. [ nodig citaat ] De meeste use cases hebben geen klanten en zoekmachines nodig om de bron te zuiveren , en een " 404 Not Found " kunnen in plaats daarvan worden gebruikt .',
++-	'CONTENT_LENGTH_REQUIRED'			=> 'Lengte benodigd',
++-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'The request did not specify the length of its content, which is required by the requested resource',
++-	'REQUEST_ENTITY_TOO_LONG'			=> 'Aanvraag te groot',
++-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'The request is larger than the server is willing or able to process.',
++-	'REQUEST_URI_TOO_LONG'				=> 'Aanvraag-URL te lang',
++-	'REQUEST_URI_TOO_LONGEXPA'			=> 'The URI provided was too long for the server to process. Often the result of too much data being encoded as a query-string of a GET request, in which case it should be converted to a POST request.',
++-	'UNSUPPORTED_MEDIA_TYPE'			=> 'Media-type niet ondersteund',
++-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'The request entity has a media type which the server or resource does not support. For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format.',
++-	'TEAPOT'							=> 'I’m a teapot (RFC 2324)',
++-	'TEAPOTEXPA'						=> 'This code was defined in 1998 as one of the traditional IETF April Fools’ jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.',
++-	'INTERNAL_SERVER_ERROR'				=> 'Interne serverfout',
++-	'INTERNAL_SERVER_ERROREXPA' 		=> 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
++-	'NOT_IMPLEMENTED' 					=> 'Niet geïmplementeerd',
++-	'NOT_IMPLEMENTEDEXPA' 				=> 'The server doesn’t support the facility required.',
++-	'BAD_GATEWAY' 						=> 'Bad Gateway',
++-	'BAD_GATEWAYEXPA' 					=> 'The server was acting as a gateway or proxy and received an invalid response from the upstream server.',
++-	'SERVICE_UNAVAILABLE' 				=> 'Dienst niet beschikbaar',
++-	'SERVICE_UNAVAILABLEEXPA' 			=> 'The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.',
++-	'GATEWAY_TIMOUT' 					=> 'Gateway Timeout',
++-	'GATEWAY_TIMOUTEXPA' 				=> 'The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.',
++-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'HTTP-versie wordt niet ondersteund',
++-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'The server does not support the HTTP protocol version used in the request.',
++-	'ERROR_UNKNOWN'     	  		 	=> 'Unbekende Server Fout',
++-	'ERROR_UNKNOWNEXPA'      		 	=> '',
++-	'FH_HELPER_NOTICE'		=> 'Forumhulp h
\ No newline at end of file
diff --git "[ORIGINAL]/forumhulp\\errorpages/event/listener.php" "[FORUM_EXT]/forumhulp\\errorpages/event/listener.php"
--- "[ORIGINAL]/forumhulp\\errorpages/event/listener.php"
+++ "[FORUM_EXT]/forumhulp\\errorpages/event/listener.php"
@@ -36,86 +36,14 @@ class listener implements EventSubscriberInterface
 		$exception = $event->getException();
 		$request = $event->getRequest();
 
-		switch ($exception->getStatusCode())
-		{
-			case '400':
-				$msg = 'ERROR_BAD_REQUEST';
-			break;
-			case '401':
-				$msg = 'ERROR_AUTH_REQUIRED';
-			break;
-			case '403':
-				$msg = 'ERROR_FORBIDDEN';
-			break;
-			case '404':
-				$msg = 'ERROR_NOT_FOUND';
-			break;
-			case '405':
-				$msg = 'METHOD_NOT_ALLOWED';
-			break;
-			case '406':
-				$msg = 'NOT_ACCEPTABLE';
-			break;
-			case '407':
-				$msg = 'PROXY_AUTHENTICATION_REQUIRED';
-			break;
-			case '408':
-				$msg = 'REQUEST_TIMED_OUT';
-			break;
-			case '409':
-				$msg = 'CONFLICTING_REQUEST';
-			break;
-			case '410':
-				$msg = 'GONE';
-			break;
-			case '411':
-				$msg = 'CONTENT_LENGTH_REQUIRED';
-			break;
-			case '412':
-				$msg = 'PRECONDITION_FAILED';
-			break;
-			case '413':
-				$msg = 'REQUEST_ENTITY_TOO_LONG';
-			break;
-			case '414':
-				$msg = 'REQUEST_URI_TOO_LONG';
-			break;
-			case '415':
-				$msg = 'UNSUPPORTED_MEDIA_TYPE';
-			break;
-			case '418':
-				$msg = 'TEAPOT';
-			break;
 		
-			case '500':
-				$msg = 'INTERNAL_SERVER_ERROR';
-			break;
-			case '501':
-				$msg = 'NOT_IMPLEMENTED';
-			break;
-			case '502':
-				$msg = 'BAD_GATEWAY';
-			break;
-			case '503':
-				$msg = 'SERVICE_UNAVAILABLE';
-			break;
-			case '504':
-				$msg = 'GATEWAY_TIMOUT';
-			break;
-			case '505':
-				$msg = 'HTTP_VERSION_NOT_SUPPORTED';
-			break;
-			default:
-				$msg = 'ERROR_UNKNOWN';
-			break;
-		}
 
-		($this->config['error_pages_log']) ? $this->log->add('critical', $this->user->data['user_id'], $this->user->data['session_ip'], 'LOG_GENERAL_ERROR', false, array($exception->getStatusCode() . ': ' . $this->user->lang[$msg], $request->getPathInfo())) : null;
+		
 
 		page_header($this->user->lang('INFORMATION'));
 		$this->template->assign_vars(array(
 			'MESSAGE_TITLE'		=> $this->user->lang('INFORMATION'),
-			'MESSAGE_TEXT'		=> $this->user->lang[$msg] . '<br />' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br />' . sprintf($this->user->lang['RETURN_INDEX'], '<a href="' . generate_board_url() .'">', '</a>'),
+			'MESSAGE_TEXT'		=> '</p><div class="text-center"><h1 class="text-uppercase">' . $this->user->lang[$msg] . '</h1>' . (($this->config['error_pages_explain']) ? $this->user->lang[$msg.'EXPA'] : '') . '<br /><br /><a href="' . generate_board_url() .'" class="btn btn-default">' . sprintf($this->user->lang['RETURN_INDEX'], '', '') . '</a></div><p>',
 		));
 
 		$this->template->set_filenames(array(
diff --git "[ORIGINAL]/forumhulp\\errorpages/language/en/info_acp_errorpages.php" "[FORUM_EXT]/forumhulp\\errorpages/language/en/info_acp_errorpages.php"
--- "[ORIGINAL]/forumhulp\\errorpages/language/en/info_acp_errorpages.php"
+++ "[FORUM_EXT]/forumhulp\\errorpages/language/en/info_acp_errorpages.php"
@@ -39,15 +39,15 @@ $lang = array_merge($lang, array(
 	'ERRORPAGES_LOG_EXPLAIN'			=> 'Log all Error Pages in Error Log in Maintenance Tab',
 	'ERRORPAGES_EXPLAIN'				=> 'Explain Error Pages',
 	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Explain error in message display',
-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Config settings are in %1$s » %2$s » %3$s.</p></div>',
+	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p>Config settings are in <strong>%1$s » %2$s » %3$s.</strong></p></div>',
 	'ERROR_BAD_REQUEST' 				=> 'Bad Request',
 	'ERROR_BAD_REQUESTEXPA' 			=> 'The request had bad syntax or was inherently impossible to be completed.',
 	'ERROR_AUTH_REQUIRED' 				=> 'Authorization Required',
 	'ERROR_AUTH_REQUIREDEXPA' 			=> 'This means that the page requires that the visitors authenticate with their username and password. If they fail to do that, the server returns this error message.',
 	'ERROR_FORBIDDEN' 					=> 'Forbidden',
 	'ERROR_FORBIDDENEXPA' 				=> 'This means that access to the page the visitor is requesting is not allowed. This can be due to a special rule in the configuration of the web server, or to the specific file system permissions of the file.',
-	'ERROR_NOT_FOUND' 					=> 'Not Found',
-	'ERROR_NOT_FOUNDEXPA'		 		=> 'This simply means that the requested file is not there.',
+	'ERROR_NOT_FOUND' 					=> '<span class="error"><i></i></span>OOPS! Page Not Found',
+	'ERROR_NOT_FOUNDEXPA'		 		=> 'Unfortunately the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exist.<br /><br />Check the URL you entered for any mistakes and try again.',
 	'PRECONDITION_FAILED'				=> 'Precondition Failed',
 	'PRECONDITION_FAILEDEXPA'			=> 'The error means that the request triggered a mod_security protection on our end.',
 	'METHOD_NOT_ALLOWED'				=> 'Method Not Allowed',
diff --git "[ORIGINAL]/forumhulp\\errorpages/language/es/info_acp_errorpages.php" "[ORIGINAL]/forumhulp\\errorpages/language/es/info_acp_errorpages.php"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\errorpages/language/es/info_acp_errorpages.php"
+++ /dev/null
@@ -1,90 +0,0 @@
-<?php
-/**
-*
-* @package Errorpages
-* @copyright (c) 2014 ForumHulp.com
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE!
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-
-// Custom error pages
-$lang = array_merge($lang, array(
-	'ERRORPAGESERROR'			=> 'Páginas de Error',
-	'ERRORPAGES_LOG'			=> 'Registro de Páginas de Error',
-	'ERRORPAGES_LOG_EXPLAIN'		=> 'Registrar todos los errores de páginas en el registro de Error en la pestaña Mantenimiento',
-	'ERRORPAGES_EXPLAIN'			=> 'Describir errores de páginas',
-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Describir error en un mensaje en pantalla',
-	'ERRORPAGE_NOTICE'			=> '<div class="phpinfo"><p class="entry">Los ajustes de configuración están en %1$s » %2$s » %3$s.</p></div>',
-	'ERROR_BAD_REQUEST' 			=> 'Solicitud Incorrecta',
-	'ERROR_BAD_REQUESTEXPA' 		=> 'La solicitud tiene mala sintaxis o era intrínsecamente imposible que esté terminado.',
-	'ERROR_AUTH_REQUIRED' 			=> 'Autorización Requerida',
-	'ERROR_AUTH_REQUIREDEXPA' 		=> 'Esto significa que la página requiere que los visitantes se identifiquen con su nombre de usuario y contraseña. Si no pueden hacerlo, el servidor devuelve este mensaje de error.',
-	'ERROR_FORBIDDEN' 			=> 'Prohibido',
-	'ERROR_FORBIDDENEXPA' 			=> 'Esto significa que el acceso a la página solicitada por el visitante no está permitido. Esto puede ser debido a una regla especial en la configuración del servidor web, o de los permisos específicos del sistema de archivos, sobre dicho archivo.',
-	'ERROR_NOT_FOUND' 			=> 'No Encontrada',
-	'ERROR_NOT_FOUNDEXPA'		 	=> 'Esto simplemente significa que el archivo solicitado no está allí.',
-	'PRECONDITION_FAILED'			=> 'Condición previa Fracasado',
-	'PRECONDITION_FAILEDEXPA'		=> 'El error significa que la solicitud desencadenó una protección mod_security por nuestra parte.',
-	'METHOD_NOT_ALLOWED'			=> 'Método no Permitido',
-	'METHOD_NOT_ALLOWEDEXPA'		=> 'Se realizó una solicitud de un recurso mediante un método de solicitud no soportado por ese recurso; por ejemplo, el uso de GET en un formulario que requiere datos que se presentará a través de POST, o el uso de poner en un recurso de sólo lectura.',
-	'NOT_ACCEPTABLE'			=> 'No Aceptable (codificación)',
-	'NOT_ACCEPTABLEEXPA'			=> 'El recurso solicitado sólo es capaz de generar contenido no aceptable de acuerdo con las cabeceras de aceptación enviadas en la petición.',
-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Proxy requiere Autenticación',
-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'El cliente primero debe autenticarse con el proxy.',
-	'REQUEST_TIMED_OUT'			=> 'Tiempo de espera agotado',
-	'REQUEST_TIMED_OUTEXPA'			=> 'El servidor ha agotado el tiempo de espera para la solicitud. De acuerdo con las especificaciones de HTTP: "El cliente no produjo una solicitud dentro del plazo que el servidor estaba dispuesto a esperar el cliente puede repetir la solicitud sin modificaciones en cualquier momento posterior."',
-	'CONFLICTING_REQUEST'			=> 'Solicitud en conflicto',
-	'CONFLICTING_REQUESTEXPA'		=> 'Indica que la solicitud no pudo ser procesada debido a los conflictos en la solicitud, tal como un conflicto de edición en el caso de varias actualizaciones',
-	'GONE'					=> 'Pasado',
-	'GONEEXPA'				=> 'Indica que el recurso solicitado ya no está disponible y no volverá a estar disponible. Esto se debe utilizar cuando un recurso se ha eliminado intencionalmente y el recurso debe ser purgado. Al recibir un código de estado 410, el cliente no debe solicitar el recurso de nuevo en el futuro. Clientes tales como motores de búsqueda deben eliminar el recurso de sus índices. [cita requerida] La mayoría de los casos de uso no requieren los clientes y los motores de búsqueda para purgar el recurso, y un "404 No Encontrado" se puede utilizar en su lugar.',
-	'CONTENT_LENGTH_REQUIRED'		=> 'Longitud de Contenido Requerida',
-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'La solicitud no especificó la duración de su contenido, que es requerido por el recurso solicitado',
-	'REQUEST_ENTITY_TOO_LONG'		=> 'Solicitud de Entidad Demasiado Largo',
-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'La solicitud es mayor que lo del servidor está dispuesto o es capaz de procesar.',
-	'REQUEST_URI_TOO_LONG'			=> 'Solicitud de URI demasiado larga',
-	'REQUEST_URI_TOO_LONGEXPA'		=> 'La URI proporcionada era demasiado larga para procesarlo el servidor. A menudo el resultado de demasiados datos se codifica como una cadena de consulta de una solicitud GET, en cuyo caso debe ser convertido a una solicitud POST.',
-	'UNSUPPORTED_MEDIA_TYPE'		=> 'Tipo de Media no soportado',
-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'La petición de entidad tiene un tipo de medio que el servidor o el recurso no es compatible. el cliente carga una imagen como imagen/svg+xml, pero el servidor requiere que las imágenes utilicen un formato diferente.',
-	'TEAPOT'				=> 'Soy una tetera (RFC 2324)',
-	'TEAPOTEXPA'				=> 'Se definió este código en 1998 como uno de los chistes tradicionales de Día de los Inocentes (IETF April Fools’ Jokes), en el RFC 2324, y no se espera que el Protocolo de Hyper Texto Cafetera de control para ser implementados por los servidores HTTP reales.',
-	'INTERNAL_SERVER_ERROR'			=> 'Error interno del servidor',
-	'INTERNAL_SERVER_ERROREXPA' 		=> 'El servidor encontró una condición inesperada que le impidió cumplir con la solicitud.',
-	'NOT_IMPLEMENTED' 			=> 'No implementado',
-	'NOT_IMPLEMENTEDEXPA' 			=> 'El servidor no admite la instalación requerida.',
-	'BAD_GATEWAY' 				=> 'Puerta de enlace mala',
-	'BAD_GATEWAYEXPA' 			=> 'El servidor encontró un error temporal y no pudo completar su solicitud.',
-	'SERVICE_UNAVAILABLE' 			=> 'Servicio no disponible',
-	'SERVICE_UNAVAILABLEEXPA' 		=> 'El servidor en este momento es incapaz de atender su solicitud debido a tiempo de inactividad, mantenimiento o problemas de capacidad. Por favor, inténtelo de nuevo más tarde.',
-	'GATEWAY_TIMOUT' 			=> 'Tiempo de espera de puerta de enlace',
-	'GATEWAY_TIMOUTEXPA' 			=> 'El servidor estaba actuando como una puerta de enlace o proxy y no recibió una respuesta a tiempo del servidor en sentido ascendente.',
-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'Versión HTTP no soportado',
-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'El servidor no soporta la versión del protocolo HTTP utilizada en la solicitud.',
-	'ERROR_UNKNOWN'     	  		=> 'Error del servidor desconocido',
-	'ERROR_UNKNOWNEXPA'      		=> '',
-	'FH_HELPER_NOTICE'			=> '¡La aplicación Forumhulp helper no existe!<br />Descargar <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> y copie la carpeta helper dentro de la carpeta de extensión forumhulp.',
-));
diff --git "[ORIGINAL]/forumhulp\\errorpages/language/fr/info_acp_errorpages.php" "[ORIGINAL]/forumhulp\\errorpages/language/fr/info_acp_errorpages.php"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\errorpages/language/fr/info_acp_errorpages.php"
+++ /dev/null
@@ -1,95 +0,0 @@
-<?php
-/**
-*
-* Error pages extension for the phpBB Forum Software package.
-* French translation by Galixte (http://www.galixte.com)
-*
-* @copyright (c) 2015 phpBB ForumHulp <http://www.forumhulp.com>
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ « » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'ERRORPAGESERROR'					=> 'Pages d’erreurs',
-	'ERRORPAGES_LOG'					=> 'Journal des pages d’erreurs',
-	'ERRORPAGES_LOG_EXPLAIN'			=> 'Archive toutes les pages d’erreurs rencontrées par les utilisateurs dans le journal des pages d’erreurs accessible depuis l’onglet « MAINTENANCE ».',
-	'ERRORPAGES_EXPLAIN'				=> 'Explications des pages d’erreurs',
-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Permet de fournir une explication dans le message affiché sur la page d’erreur.',
-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Les paramètres de cette extension se trouvent dans : %1$s » %2$s » %3$s.</p></div>',
-	'ERROR_BAD_REQUEST' 				=> 'Erreur 400 - Mauvaise requête',
-	'ERROR_BAD_REQUESTEXPA' 			=> 'La requête HTTP n’a pas pu être comprise par le serveur en raison d’une syntaxe erronée. Le problème peut provenir d’un navigateur web trop récent ou d’un serveur HTTP trop ancien.',
-	'ERROR_AUTH_REQUIRED' 				=> 'Erreur 401 - Non autorisé',
-	'ERROR_AUTH_REQUIREDEXPA' 			=> 'La requête nécessite une identification de l’utilisateur. Concrètement, cela signifie que tout ou partie du serveur contacté est protégé par des identifiants, qu’il faut indiquer au serveur pour pouvoir accéder à son contenu.',
-	'ERROR_FORBIDDEN' 					=> 'Erreur 403 - Interdit',
-	'ERROR_FORBIDDENEXPA' 				=> 'La ressource demandée vous est interdite d’accès. Soit parce que le serveur a été configuré de cette manière, soit parce que dans une phase d’authentification vous n’avez pas fourni d’identifiants valides. La raison peut être aussi plus large : votre adresse IP a été bannie, vous utilisez un client HTTP (navigateur) interdit (repéré par les en-têtes accompagnant la requête et l’identifiant), etc..',
-	'ERROR_NOT_FOUND' 					=> 'Erreur 404 - Non trouvé',
-	'ERROR_NOT_FOUNDEXPA'		 		=> 'Le serveur n’a rien trouvé qui corresponde à l’adresse (URI) demandée. Cela signifie que l’adresse URL que vous avez tapée ou cliquée est mauvaise ou obsolète et ne correspond à aucun document existant sur le serveur (vous pouvez essayez de supprimer progressivement les composants de l’adresse URL en partant de la fin pour éventuellement retrouver un chemin d’accès existant).',
-	'PRECONDITION_FAILED'				=> 'Erreur 412 - Précondition échouée',
-	'PRECONDITION_FAILEDEXPA'			=> 'Les conditions spécifiées dans la requête ne sont pas remplies.',
-	'METHOD_NOT_ALLOWED'				=> 'Erreur 405 - Méthode non admise',
-	'METHOD_NOT_ALLOWEDEXPA'			=> 'Ce code indique que la méthode utilisée par le client n’est pas supportée pour cet URI. Un client qui utilise une méthode non supportée sur un serveur ou pour une ressource précise verra une réponse 405. Celle-ci devra être accompagnée d’une liste de méthodes acceptées, spécifiées grâce à l’en-tête Allow.',
-	'NOT_ACCEPTABLE'					=> 'Erreur 406 - Encodage pas acceptable',
-	'NOT_ACCEPTABLEEXPA'				=> 'L’adresse (URI) spécifiée existe, mais pas dans le format préféré du client. Si le client demande une ressource dans un format que le serveur n’est pas en mesure de fournir, un code 406 sera retourné. Le serveur indique en retour le langage et les types d’encodages disponibles pour cette adresse.',
-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Erreur 407 - Authentification proxy exigée',
-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'Le serveur proxy exige une authentification du client avant de transmettre la requête. Le client contacte un proxy et lui envoie une requête, mais sans informations d’authentification alors que celui-ci en a besoin (absence de l’en-tête Proxy-Authorization).',
-	'REQUEST_TIMED_OUT'					=> 'Erreur 408 - Délai écoulé pour la requête',
-	'REQUEST_TIMED_OUTEXPA'				=> 'Le serveur met trop de temps à attendre la requête du client et finit par clore la conversation en répondant 408 (la connexion sera ensuite fermée). Le client n’a pas produit assez vite la requête attendue par le serveur, mais peut la produire plus tard.',
-	'CONFLICTING_REQUEST'				=> 'Erreur 409 - Conflit',
-	'CONFLICTING_REQUESTEXPA'			=> 'La requête entre en conflit avec une autre requête ou avec la configuration du serveur. Des informations sur les raisons de ce conflit doivent être indiquée en retour.',
-	'GONE'								=> 'Erreur 410 - Page indisponible définitivement',
-	'GONEEXPA'							=> 'L’adresse (URI) demandée n’existe plus et a été définitivement supprimée du serveur. La ressource est indisponible et aucune adresse de redirection n’est connue',
-	'CONTENT_LENGTH_REQUIRED'			=> 'Erreur 411 - Longueur exigée',
-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'Le serveur a besoin de connaitre la taille de cette requête pour pouvoir y répondre. La longueur de la requête n’a pas été précisée.',
-	'REQUEST_ENTITY_TOO_LONG'			=> 'Erreur 413 - Corps de la requête trop grand',
-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'Le serveur ne peut traiter la requête car la taille de son contenu est trop importante. Le traitement est abandonné dû à une requête trop importante.',
-	'REQUEST_URI_TOO_LONG'				=> 'Erreur 414 - URI trop long',
-	'REQUEST_URI_TOO_LONGEXPA'			=> 'Le serveur ne peut traiter la requête car la taille de l’objet (URI) a retourner est trop importante. L’adresse (URI) demandée par le client dépasse le nombre de caractères autorisés.',
-	'UNSUPPORTED_MEDIA_TYPE'			=> 'Erreur 415 - Format non supporté',
-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'Le serveur ne peut traiter la requête car son contenu est écrit dans un format non supporté. Le client envoie un contenu dont le type n’est pas reconnu par le serveur.',
-	'TEAPOT'							=> '« Je suis une cafetière » (RFC 2324)',
-	'TEAPOTEXPA'						=> 'L’Hyper Text Coffee Pot Control Protocol ou HTCPCP — de l’anglais signifiant littéralement « protocole hypertexte de gestion de cafetière » — est décrit dans la RFC 2324 publié le 1er avril 1998 et bien que cette RFC soit un poisson d’avril. C’est une proposition humoristique de protocole de communication client-serveur permettant le contrôle, la surveillance et le diagnostic de cafetière.',
-	'INTERNAL_SERVER_ERROR'				=> 'Erreur 500 - Erreur interne du serveur',
-	'INTERNAL_SERVER_ERROREXPA' 		=> 'Le serveur a rencontré un problème inattendu qui l’a empêché de traiter la requête avec succès. Cette erreur peut par exemple être le résultat d’une mauvaise configuration du serveur, ou d’une ressource épuisée ou refusée au serveur sur la machine hôte.',
-	'NOT_IMPLEMENTED' 					=> 'Erreur 501 - Non mis en oeuvre',
-	'NOT_IMPLEMENTEDEXPA' 				=> 'Le serveur ne supporte pas la fonctionnalité requise pour traiter avec succès la requête (ou ne reconnait pas la requête). C’est la réponse émise lorsque le serveur ne reconnait pas la méthode indiquée dans la requête et n’est capable de la mettre en oeuvre pour aucune ressource (soit le navigateur web est trop récent, soit le serveur HTTP est trop ancien).',
-	'BAD_GATEWAY' 						=> 'Erreur 502 - Mauvaise passerelle',
-	'BAD_GATEWAYEXPA' 					=> 'Le serveur agissait comme un intermédiaire (passerelle ou proxy) et une mauvaise réponse lui a été envoyée par un autre serveur.',
-	'SERVICE_UNAVAILABLE' 				=> 'Erreur 503 - Service indisponible',
-	'SERVICE_UNAVAILABLEEXPA' 			=> 'Le serveur est en ligne, mais il ne peut répondre pour le moment, repassez plus tard. Cela peut aussi indiquer que le serveur subit une maintenance ou est surchargé de requêtes et n’arrive pas à traiter correctement la votre.',
-	'GATEWAY_TIMOUT' 					=> 'Erreur 504 - Expiration de la passerelle',
-	'GATEWAY_TIMOUTEXPA' 				=> 'Le serveur agissait comme un intermédiaire (passerelle ou proxy) et il n’a pas eu de réponse d’un autre serveur dans les temps. Similaire à 408, cette fois-ci le serveur coupera alors la communication et répondra à son client par un 504.',
-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'Erreur 505 - Version HTTP non supportée',
-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'La version du protocole HTTP utilisée dans cette requête n’est pas (ou plus) supportée par le serveur.',
-	'ERROR_UNKNOWN'     	  		 	=> 'Erreur 520 - Erreur inconnue du serveur',
-	'ERROR_UNKNOWNEXPA'      		 	=> 'Le serveur renvoie une erreur inconnue.',
-	'FH_HELPER_NOTICE'      		 	=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
-));
diff --git "[ORIGINAL]/forumhulp\\errorpages/language/nl/info_acp_errorpages.php" "[ORIGINAL]/forumhulp\\errorpages/language/nl/info_acp_errorpages.php"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\errorpages/language/nl/info_acp_errorpages.php"
+++ /dev/null
@@ -1,90 +0,0 @@
-<?php
-/**
-*
-* @package Errorpages
-* @copyright (c) 2014 ForumHulp.com
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE!
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-
-// Custom error pages
-$lang = array_merge($lang, array(
-	'ERRORPAGESERROR'					=> 'Error Pages',
-	'ERRORPAGES_LOG'					=> 'Log Error Pages',
-	'ERRORPAGES_LOG_EXPLAIN'			=> 'Sla alle Error Pages op in Error Log onder Maintenance Tab',
-	'ERRORPAGES_EXPLAIN'				=> 'Uitleg Error Pages',
-	'ERRORPAGES_EXPLAIN_EXPLAIN'		=> 'Leg de foutmelding uit in het berichtenvenster',
-	'ERRORPAGE_NOTICE'					=> '<div class="phpinfo"><p class="entry">Config settings are in %1$s » %2$s » %3$s.</p></div>',
-	'ERROR_BAD_REQUEST' 				=> 'Foute aanvraag',
-	'ERROR_BAD_REQUESTEXPA' 			=> 'De aanvraag had een slechte syntax of kon onmogelijk worden uitgevoerd.',
-	'ERROR_AUTH_REQUIRED' 				=> 'Niet geautoriseerd',
-	'ERROR_AUTH_REQUIREDEXPA' 			=> 'Dit betekent dat de pagina vereist dat de bezoekers zich authenticeren met hun gebruikersnaam en wachtwoord. Als zij dit niet doen, retourneert de server deze foutmelding.',
-	'ERROR_FORBIDDEN' 					=> 'Verboden toegang',
-	'ERROR_FORBIDDENEXPA' 				=> 'Dit betekent dat de toegang tot de pagina die de bezoeker vraagt ​​niet is toegestaan. Dit kan door een bijzondere regel in de configuratie van de webserver of de specifieke bestandssysteem permissies van het bestand.',
-	'ERROR_NOT_FOUND' 					=> 'Niet gevonden',
-	'ERROR_NOT_FOUNDEXPA'		 		=> 'Het gevraagde bestand bestaat niet op de server.',
-	'PRECONDITION_FAILED'				=> 'Niet voldaan aan vooraf gestelde voorwaarde',
-	'PRECONDITION_FAILEDEXPA'			=> 'De fout betekent dat het verzoek leidde tot een mod_security bescherming aan de serverkant.',
-	'METHOD_NOT_ALLOWED'				=> 'Methode niet toegestaan',
-	'METHOD_NOT_ALLOWEDEXPA'			=> 'Een verzoek werd gemaakt van een bron met behulp van een verzoek methode die niet wordt ondersteund door die bron. Bijvoorbeeld met behulp van GET op een formulier dat de gegevens nodig heeft om via POST worden voorgelegd',
-	'NOT_ACCEPTABLE'					=> 'Niet aanvaardbaar',
-	'NOT_ACCEPTABLEEXPA'				=> 'De opgevraagde bron is alleen geschikt voor het genereren van content niet aanvaardbaar volgens de Accept headers verzonden in het verzoek.',
-	'PROXY_AUTHENTICATION_REQUIRED'		=> 'Authenticatie op de proxyserver verplicht',
-	'PROXY_AUTHENTICATION_REQUIREDexpa'	=> 'De gebruiker moet zich eerst verifiëren bij de proxyserver.',
-	'REQUEST_TIMED_OUT'					=> 'Aanvraagtijd verstreken',
-	'REQUEST_TIMED_OUTEXPA'				=> 'De server is gestopt met de aanvraag. Volgens HTTP specificaties: "De gebruiker deed geen aanvraag binnen de gestelde tijd van de server."',
-	'CONFLICTING_REQUEST'				=> 'Conflict',
-	'CONFLICTING_REQUESTEXPA'			=> 'Geeft aan dat het verzoek niet kon worden verwerkt, vanwege het conflict in het verzoek, zoals een bewerkingsconflict in het geval van meerdere updates',
-	'GONE'								=> 'Verdwenen',
-	'GONEEXPA'							=> 'Geeft aan dat de aangevraagde bron niet meer beschikbaar is. Na ontvangst van een 410 -status code , de klant moet niet de bron opnieuw op te vragen in de toekomst. Klanten zoals zoekmachines moet de bron te verwijderen uit hun indices. [ nodig citaat ] De meeste use cases hebben geen klanten en zoekmachines nodig om de bron te zuiveren , en een " 404 Not Found " kunnen in plaats daarvan worden gebruikt .',
-	'CONTENT_LENGTH_REQUIRED'			=> 'Lengte benodigd',
-	'CONTENT_LENGTH_REQUIREDexpa'		=> 'The request did not specify the length of its content, which is required by the requested resource',
-	'REQUEST_ENTITY_TOO_LONG'			=> 'Aanvraag te groot',
-	'REQUEST_ENTITY_TOO_LONGEXPA'		=> 'The request is larger than the server is willing or able to process.',
-	'REQUEST_URI_TOO_LONG'				=> 'Aanvraag-URL te lang',
-	'REQUEST_URI_TOO_LONGEXPA'			=> 'The URI provided was too long for the server to process. Often the result of too much data being encoded as a query-string of a GET request, in which case it should be converted to a POST request.',
-	'UNSUPPORTED_MEDIA_TYPE'			=> 'Media-type niet ondersteund',
-	'UNSUPPORTED_MEDIA_TYPEEXPA'		=> 'The request entity has a media type which the server or resource does not support. For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format.',
-	'TEAPOT'							=> 'I’m a teapot (RFC 2324)',
-	'TEAPOTEXPA'						=> 'This code was defined in 1998 as one of the traditional IETF April Fools’ jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.',
-	'INTERNAL_SERVER_ERROR'				=> 'Interne serverfout',
-	'INTERNAL_SERVER_ERROREXPA' 		=> 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
-	'NOT_IMPLEMENTED' 					=> 'Niet geïmplementeerd',
-	'NOT_IMPLEMENTEDEXPA' 				=> 'The server doesn’t support the facility required.',
-	'BAD_GATEWAY' 						=> 'Bad Gateway',
-	'BAD_GATEWAYEXPA' 					=> 'The server was acting as a gateway or proxy and received an invalid response from the upstream server.',
-	'SERVICE_UNAVAILABLE' 				=> 'Dienst niet beschikbaar',
-	'SERVICE_UNAVAILABLEEXPA' 			=> 'The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.',
-	'GATEWAY_TIMOUT' 					=> 'Gateway Timeout',
-	'GATEWAY_TIMOUTEXPA' 				=> 'The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.',
-	'HTTP_VERSION_NOT_SUPPORTED' 		=> 'HTTP-versie wordt niet ondersteund',
-	'HTTP_VERSION_NOT_SUPPORTEDEXPA' 	=> 'The server does not support the HTTP protocol version used in the request.',
-	'ERROR_UNKNOWN'     	  		 	=> 'Unbekende Server Fout',
-	'ERROR_UNKNOWNEXPA'      		 	=> '',
-	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
-));
```

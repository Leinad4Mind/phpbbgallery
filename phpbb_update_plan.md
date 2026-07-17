# phpBB Update Plan (Modified Core)

Since the `_forum` directory contains a phpBB 3.3.12 installation with **custom core modifications**, and everything is properly tracked via Git, the standard "Full Package Update" would overwrite your modifications. 

The easiest, most bulletproof, and professional way to update to the latest version (e.g., 3.3.17) without losing your custom edits is to use **Git's 3-way merge**. This method uses Git to automatically calculate the differences between vanilla 3.3.12 and vanilla 3.3.17, and applies those updates directly to your custom code.

## Step-by-Step Update Plan

### Step 1: Preparation & Backups
1. **Backup your Database**: Always take a full SQL dump of your production database before updating.
2. **Download Packages**: 
   - Download the **Full Package** of your current version (phpBB 3.3.12).
   - Download the **Full Package** of the latest version you want to update to (e.g., phpBB 3.3.17).

### Step 2: Create a Vanilla Tracking Branch
To let Git understand what changed in phpBB, we need a branch that tracks the official clean versions.

1. Create and checkout a new branch with no history:
   ```bash
   git checkout --orphan phpbb-vanilla
   git rm -rf .
   ```
2. Extract the **vanilla 3.3.12** files into the `_forum/` directory.
3. Commit this as the base official version:
   ```bash
   git add _forum/
   git commit -m "Add vanilla phpBB 3.3.12 base"
   ```

### Step 3: Update the Vanilla Branch to the Latest Version
1. Delete all phpBB files inside `_forum/` on this branch (except `config.php`, `images/`, `store/`, `files/`, `ext/`).
2. Extract the **vanilla latest version (e.g., 3.3.17)** files into the `_forum/` directory.
3. Commit the official update:
   ```bash
   git add -A _forum/
   git commit -m "Update vanilla phpBB to 3.3.17"
   ```
*(Git now knows exactly what lines of code changed between 3.3.12 and 3.3.17).*

### Step 4: Merge the Update into Your Custom Code
1. Checkout your main working branch (where your custom modifications live):
   ```bash
   git checkout main
   ```
2. Merge the vanilla updates into your custom branch:
   ```bash
   git merge phpbb-vanilla
   ```
3. **Resolve Conflicts**: Git will automatically apply the phpBB updates to your modified files! If a specific line of code you modified was also modified by the phpBB update, Git will pause and ask you to manually resolve the conflict. Fix any conflicts and commit the merge.

### Step 5: Run the Database Update
1. Upload/deploy the merged code to your server (or run locally).
2. The `install/` directory should be present from the update merge.
3. Update the database by running the CLI command (recommended):
   ```bash
   cd _forum
   php bin/phpbbcli.php db:migrate --safe-mode
   ```
   *Alternatively, you can visit `yoursite.com/_forum/install/app.php update` in your browser.*

### Step 6: Cleanup
1. Once the database update completes successfully, delete the `install/` directory:
   ```bash
   rm -rf _forum/install/
   ```
2. Purge the phpBB cache:
   ```bash
   rm -rf _forum/cache/production/
   ```
3. Commit the final state to your repository.

---

### Alternative Method: Official Patch File
If you don't want to use the Git branch method, the official phpBB fallback for modified boards is the **Patch File** method:
1. Download the "Patch File" update from phpbb.com (e.g., `phpBB 3.3.12 to 3.3.17 Patch`).
2. Apply the patch locally using a terminal: `patch -p1 < phpBB-3.3.12_to_3.3.17.patch` inside `_forum`.
3. Manually fix any `.rej` (rejected) files where the patch failed to apply due to your modifications.
4. Upload the `install/` folder, run the database update, and delete the `install/` folder.

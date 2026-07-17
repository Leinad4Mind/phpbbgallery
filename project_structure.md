# Project Structure: GoldTugAnime phpBB Extensions

This document provides an overview of the directory structure for the `gold-phpbb-ext` project.

## Root Directories Overview

- **`_forum/`**: 
  Contains the core phpBB 3.3.12 installation. This directory holds all the core board files, configuration, and any custom modifications (core edits) that have been made to the phpBB system.

- **`_index/`**: 
  Contains the main landing page of the website (the HTML `index.html` file, CSS, images, and background videos).

## phpBB Extension Vendors

The remaining directories at the root level are **phpBB Extension Vendor folders**. In a standard phpBB installation, these folders are placed inside the `ext/` directory. Here, they are kept at the root of the repository to maintain a clean and separate commit history for each vendor's extensions.

When deploying or building the forum, these vendor directories should be mapped or copied to `_forum/ext/<vendor_name>/`.

### List of Included Vendors

- `alfredoramos`
- `anavaro`
- `boardtools`
- `brunoais`
- `canidev`
- `chris1278`
- `david63`
- `devspace`
- `dmzx`
- `feneck91`
- `forumflair`
- `forumhulp`
- `goldtuganime` (Custom extensions specific to the community)
- `javiexin`
- `kasimi`
- `kinerity`
- `kirk`
- `lavigor`
- `leinad4mind` (Custom extensions developed by the author)
- `lmdi`
- `lukewcs`
- `marttiphpbb`
- `mober`
- `mod`
- `oxpus`
- `phpbb` (Official phpBB extensions)
- `phpbbgallery`
- `phpbbmodders`
- `phpbbstudio`
- `pikaron`
- `rmcgirr83`
- `senky`
- `shredder`
- `sitesplat`
- `splicker`
- `stk` (Support Toolkit)
- `tatiana5`
- `vse`
- `welshpaul`
- `wolfsblvt`

## Version Control

All folders, including the core `_forum` and individual vendor extensions, have their history committed and are kept clean in this repository. This modular structure allows for easier tracking of updates for specific extensions without cluttering the main phpBB core history.

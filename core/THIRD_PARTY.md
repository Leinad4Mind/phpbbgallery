# Third-party JavaScript

The Gallery keeps only the browser assets required by its upload interface. Runtime files live in styles/all/template/js so every phpBB style resolves the same copy.

## jQuery UI Widget

- Component: jQuery UI Widget Factory 1.14.2
- Upstream: https://github.com/jquery/jquery-ui/tree/1.14.2
- License: MIT
- Source file: https://raw.githubusercontent.com/jquery/jquery-ui/1.14.2/ui/widget.js

## Blueimp upload components

- Component: Blueimp jQuery File Upload
- Upstream: https://github.com/blueimp/jQuery-File-Upload
- License: MIT
- Status: the upstream repository is archived and read-only.

The original Gallery package did not record an upstream release for this legacy snapshot. The exact retained source is therefore pinned by SHA-256 below. Only the modules used by the image upload flow remain. The UI module has a local packaging patch that removes unused AMD dependencies for audio and video previews.

## Blueimp image loader

- Component: Blueimp JavaScript Load Image
- Upstream: https://github.com/blueimp/JavaScript-Load-Image
- License: MIT

The original package did not record an upstream release. Its retained bundled source is pinned by SHA-256.

## Asset checksums

File | SHA-256
--- | ---
jquery.ui.widget.js | d50b39d3a03aed723335188a428bca4a783b211368e8b13ae024fea22cad34f3
load-image.all.min.js | 1f9a171543305bc03d542822165a94ffad55580cc137634da12877736b04bbe9
jquery.iframe-transport.js | be43036704c70db0148f4970326f6dd36bad7b34eed8e5f76719269ef70cb8cd
jquery.fileupload.js | 071e66375d2207b30024197a4b566c5fd70c6f72ab394f1375f2521d36cc3dac
jquery.fileupload-process.js | a7f04469af255c4c547e8961ead78e4894718337f7a79df44df892d0067cf2b8
jquery.fileupload-image.js | bed7dd16807fe0e8d477a396d1103d0d609c4e4c9933fa2cc0f459d53a4b30a1
jquery.fileupload-validate.js | 8e899b2766035a6d318c7c50cbd258b78eb29c8108a171afeef6bbee2ffe2446
jquery.fileupload-ui.js | 3c3b4e896fe9763c331a2ce9dfa40779c0bf11a8d839a6e5ddca917ce6ff743c

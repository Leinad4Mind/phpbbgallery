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
jquery.iframe-transport.js | 5de5c447928d2b0ef87ba9f51a6e238cf841d12c90f2ca0e2fa5e2c835dec54f
jquery.fileupload.js | d81a55f26e15da852b28364fe8446fe4d6caea7aa1d68fa9ee25171407749f1f
jquery.fileupload-process.js | 9bc8036cf1e2028623f3ccf5e4b265b7a52a925428f00184e351ff9e1f6404e3
jquery.fileupload-image.js | 361eaa379b6e61f8ff280c5f203b3a3a62340d96595ab34691e47e7ef09291e8
jquery.fileupload-validate.js | da84967f1eecd4cc3474fc2027ad3a9cfe94a1c26fdc6ad1c49075888119a1e6
jquery.fileupload-ui.js | 3c3b4e896fe9763c331a2ce9dfa40779c0bf11a8d839a6e5ddca917ce6ff743c

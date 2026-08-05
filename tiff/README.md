# phpBB Gallery TIFF

This optional Gallery add-on accepts `.tif` and `.tiff` originals through the
normal permission-checked upload flows. Imagick must support both TIFF input
and WebP output.

The original TIFF is kept unchanged unless the upload must be rotated or
resized to satisfy Gallery limits. Medium images and thumbnails use only the
first TIFF frame and are stored as private WebP derivatives. Every source and
derived request continues to pass through Gallery authorization.

TIFF uploads are disabled by default. Enable the format and select the WebP
quality in ACP > phpBB Gallery > TIFF.

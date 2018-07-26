@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../overtrue/phplint/bin/phplint
php "%BIN_TARGET%" %*

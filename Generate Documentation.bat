@ECHO OFF

SET CFG_CLIENT=jsdoc.json
SET CFG_SERVER=Doxyfile
SET OUT_CLIENT=doc\client
SET OUT_SERVER=doc\server
SET GEN_CLIENT=1
SET GEN_SERVER=1

IF %GEN_CLIENT% EQU 1 (
    ECHO Generating client documentation...
    IF EXIST %OUT_CLIENT% (
        RMDIR %OUT_CLIENT% /s /q
    )
    jsdoc --configure %CFG_CLIENT%
)

IF %GEN_SERVER% EQU 1 (
    ECHO Generating server documentation...
    IF EXIST %OUT_SERVER% (
        RMDIR %OUT_SERVER% /s /q
    )
    doxygen %CFG_SERVER%
    (ECHO ^<script^>window.location.replace^('html/index.html'^)^;^</script^>) > %OUT_SERVER%\index.html
)

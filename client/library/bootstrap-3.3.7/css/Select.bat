@ECHO OFF
CLS
:Menu
ECHO.
ECHO ( 0) original
ECHO ( 1) Cerulean
ECHO ( 2) Cosmo
ECHO ( 3) Cyborg
ECHO ( 4) Darkly
ECHO ( 5) Flatly
ECHO ( 6) Journal
ECHO ( 7) Lumen
ECHO ( 8) Paper
ECHO ( 9) Readable
ECHO (10) Sandstone
ECHO (11) Simplex
ECHO (12) Slate
ECHO (13) Solar
ECHO (14) Spacelab
ECHO (15) Superhero
ECHO (16) United
ECHO (17) Yeti
ECHO.

SET /P c=Enter your choice, or 'x' to exit: 

       IF "%c%"== "x" (GOTO Exit
) ELSE IF "%c%"== "0" (SET d=_original
) ELSE IF "%c%"== "1" (SET d=Cerulean
) ELSE IF "%c%"== "2" (SET d=Cosmo
) ELSE IF "%c%"== "3" (SET d=Cyborg
) ELSE IF "%c%"== "4" (SET d=Darkly
) ELSE IF "%c%"== "5" (SET d=Flatly
) ELSE IF "%c%"== "6" (SET d=Journal
) ELSE IF "%c%"== "7" (SET d=Lumen
) ELSE IF "%c%"== "8" (SET d=Paper
) ELSE IF "%c%"== "9" (SET d=Readable
) ELSE IF "%c%"=="10" (SET d=Sandstone
) ELSE IF "%c%"=="11" (SET d=Simplex
) ELSE IF "%c%"=="12" (SET d=Slate
) ELSE IF "%c%"=="13" (SET d=Solar
) ELSE IF "%c%"=="14" (SET d=Spacelab
) ELSE IF "%c%"=="15" (SET d=Superhero
) ELSE IF "%c%"=="16" (SET d=United
) ELSE IF "%c%"=="17" (SET d=Yeti
) ELSE GOTO Menu

COPY /Y "%d%\*.*" .\
GOTO Menu

:Exit
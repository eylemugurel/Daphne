@ECHO OFF
SET JAVA="java.exe"
SET MINIFIER="yuicompressor-2.4.8.jar"

CALL CleanMinified.bat

FOR %%f IN (*.css) DO (
	ECHO %%f
	%JAVA% -jar %MINIFIER% "%%~nf.css" -o "%%~nf.min.css"
)
FOR %%f IN (*.js) DO (
	ECHO %%f
	%JAVA% -jar %MINIFIER% "%%~nf.js" -o "%%~nf.min.js" --preserve-semi --disable-optimizations
)

ECHO.
PAUSE

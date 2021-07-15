Set WinScriptHost = CreateObject("WScrip.Shell")
WinScriptHost.Run Chr & "D:\XAMPP\htdocs\UDPT-Project\app\cronjob\script.bat" & Chr(34) , 0
Set WinScriptHost = Nothing
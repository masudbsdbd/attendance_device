@echo off
cd /d "C:\Users\user\Herd\new-attendance"

echo [%date% %time%] Attendance Sync Started >> storage\logs\attendance-sync.log

"C:\Users\user\.config\herd\bin\php.bat" artisan attendance:sync >> storage\logs\attendance-sync.log 2>&1

echo [%date% %time%] Completed >> storage\logs\attendance-sync.log
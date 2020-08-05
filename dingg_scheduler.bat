@echo off

:loop

echo "Running scheduled tasks"
php artisan schedule:run

FOR /L %%A IN (1,1,200) DO (
  sleep 1s
)

goto loop

@echo off
chcp 65001 > nul
echo Остановка контейнеров...
docker compose down

echo.
echo Все контейнеры остановлены и удалены.
pause
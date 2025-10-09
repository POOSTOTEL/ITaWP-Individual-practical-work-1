@echo off
chcp 65001 > nul
echo ============================================
echo   Запуск веб-сервиса для подачи объявлений
echo ============================================
echo.

docker --version >nul 2>&1
if errorlevel 1 (
    echo ОШИБКА: Docker не установлен или не запущен!
    echo Пожалуйста, установите Docker Desktop и запустите его.
    echo Скачать можно с: https://www.docker.com/products/docker-desktop
    pause
    exit /b 1
)

docker compose version >nul 2>&1
if errorlevel 1 (
    echo ОШИБКА: Docker Compose не доступен!
    echo Убедитесь, что Docker Desktop запущен.
    pause
    exit /b 1
)

echo Проверка зависимостей... OK
echo.

echo Запуск контейнеров (это может занять несколько минут при первом запуске)...
docker compose up -d

if errorlevel 1 (
    echo ОШИБКА: Не удалось запустить контейнеры!
    echo Проверьте, что порты 8080, 8081 и 3308 свободны.
    pause
    exit /b 1
)

echo.
echo ============================================
echo          Приложение успешно запущено!
echo ============================================
echo.
echo Доступные сервисы:
echo - Веб-приложение: http://localhost:8080/form.html
echo - PhpMyAdmin:     http://localhost:8081
echo - База данных:    localhost:3308
echo.
echo Данные для входа в PhpMyAdmin:
echo - Сервер: db
echo - Пользователь: root
echo - Пароль: rootpassword
echo.
echo Для остановки приложения запустите stop.bat
echo.
pause
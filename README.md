# Моя библиотека (Laravel + Docker)

Веб-приложение для управления личной библиотекой книг. Позволяет вести учет прочитанного, ставить оценки, писать заметки и загружать обложки.
Реализовано с использованием классической MVC архитектуры и контейнеризации.

## Технологический стек

- **Backend:** PHP 8.2, Laravel 10
- **Database:** MySQL 8.0
- **Frontend:** Blade Templates, Tailwind CSS
- **Environment:** Docker & Docker Compose
- **Features:** Authentication, CRUD, File Storage, Access Control

## Функционал

- **Авторизация:** Регистрация и вход (Session based auth).
- **Книги:**
  - Добавление книг с загрузкой обложек (Image Upload).
  - Статусы: "В планах", "Читаю", "Прочитано".
  - Рейтинг (1-5 звезд) и личные заметки.
  - Удаление и редактирование (защищено проверкой владельца).
- **Интерфейс:**
  - Адаптивная верстка.
  - Красивые уведомления (SweetAlert2).
  - Детальный просмотр книги.

## Установка и запуск

Проект полностью контейнеризирован. Для запуска нужен только Docker.

1. **Клонирование репозитория:**
   ```bash
   git clone [https://github.com/your-username/my-library-laravel.git](https://github.com/your-username/my-library-laravel.git)
   cd my-library-laravel
   ```
2. **Настройка окружения:** Скопируйте пример файла конфигурации:
```bash
cp .env.example .env
```
3. **Запуск контейнеров:**
```bash
docker-compose up -d --build
```
4. **Установка зависимостей и миграции:**
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan storage:link
docker-compose exec app php artisan migrate
```
5. **Готово!** Сайт доступен по адресу: http://localhost:8000

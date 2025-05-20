# 🔧 Bladex

Простой PHP MVC-фреймворк-песочница, вдохновлённый Laravel и Symfony.  
Поддерживает маршруты, контроллеры, шаблоны на Twig, автозагрузку через Composer.

---

## 🚀 Возможности

- 🛣️ Простая система маршрутов (`GET`, `POST`)
- 🧭 Контроллеры с автозагрузкой
- 🖼 Поддержка шаблонов через [Twig](https://twig.symfony.com/)
- ⚙️ Автозагрузка через PSR-4
- 🛢 Работа с базой данных через [RedBeanPHP](https://redbeanphp.com/)
- 🔐 Простая система middleware с проверкой авторизации
- 🎯 Подходит для pet-проектов и обучения архитектуре фреймворков

---

## 📦 Установка

```bash
git clone https://github.com/nievon/bladex.git
cd Bladex
composer install
```

## 🧰 Структура проекта

```bash
bladex/
├── app/
│   ├── Controllers/         # Контроллеры
│   ├── Middleware/          # Промежуточное ПО
│   ├── Models/              # Модели RedBeanPHP
│   └── Views/               # Шаблоны Twig
├── config/
│   └── database.php         # Настройки подключения к БД
├── core/
│   ├── Router.php           # Обработчик маршрутов
│   ├── Middleware.php       # Обработка middleware
│   ├── Controller.php       # Базовый класс контроллера
│   └── View.php             # Обёртка Twig
├── public/
│   └── index.php            # Точка входа
└── composer.json
```
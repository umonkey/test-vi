# Тестовый обработчик заказов

Запуск локального приложения:

    $ make serve

Запуск тестов:

    $ make test

## Выполнение запросов

Заполнение таблицы товаров:

    $ curl -X POST 'http://127.0.0.1:8080/api/v1/seed'
    {"result":{"success":true}}

Создание заказа:

    $ curl -X POST -d 'product[]=1' -d 'product[]=2' 'http://127.0.0.1:8080/api/v1/orders/create'
    {"result":{"order_id":25,"total":1200}}

Оплата:

    $ curl -X POST -d 'amount=1200' 'http://127.0.0.1:8080/api/v1/orders/25/pay'
    {"result":{"success":true}}

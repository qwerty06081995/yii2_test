Для запуска проекта выполните команду
```
 php yii serve
```
Не забудьте выполнить команду минраций
```
 php yii migrate
```
В корне папке есть файл
```
test.http
```
После того как запустите проект, выполните их по очереди. 
Там пример для регистрация пользователя, получение токена, добавление книги в базу и список книг  

============================================== </br>
<b>Здесь все curl запросы. Если вы на Windows используйте Git Bash()</b>

1) Регистрация пользователя
```
curl -X POST http://localhost:8080/users \
    -H "Content-Type: application/json" \
    -d "{\"username\": \"test2\", \"email\": \"test2@email.com\", \"password\":\"123456\"}"
```

2) Авторизация (получение токена) 
```
curl -X POST http://localhost:8080/auth/login \
    -H "Content-Type: application/json" \
    -d "{\"username\": \"test2\", \"password\":\"123456\"}"
```
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlhdCI6MTc2MzQzNTg3NSwiZXhwIjoxNzYzNTIyMjc1fQ.uv9floZehguBuXZKgq0ZLtV3b-xYzWK9zgEqlzRJye8

3) Просмотр профиля (только для авторизованных)
```
curl -X GET http://localhost:8080/users/2 \
    -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlhdCI6MTc2MzQzNTg3NSwiZXhwIjoxNzYzNTIyMjc1fQ.uv9floZehguBuXZKgq0ZLtV3b-xYzWK9zgEqlzRJye8" \
    -H "Content-Type: application/json"
```

4) Получение список книг с пагинацией(per-page)
```
curl -X GET http://localhost:8080/books?per-page=3 \
    -H "Content-Type: application/json"
```

5) добавить книгу (только авторизованный пользователь).
```
curl -X POST http://localhost:8080/books \
    -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlhdCI6MTc2MzQzNTg3NSwiZXhwIjoxNzYzNTIyMjc1fQ.uv9floZehguBuXZKgq0ZLtV3b-xYzWK9zgEqlzRJye8" \
    -H "Content-Type: application/json" \
    -d '{"title": "New book curl", "author": "CURL Curlov"}'
```

6) Получить информацию о книге
```
curl -X GET http://localhost:8080/books/3 \
    -H "Content-Type: application/json"
```

7) Обновить данные книги (только авторизованный).
```
curl -X PUT http://localhost:8080/books/3 \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlhdCI6MTc2MzQzNjk5OSwiZXhwIjoxNzYzNTIzMzk5fQ.GKvn0-sDGITm0q3-pVirKng88Aw1_xmgjvZFl16fs8E" \
  -H "Content-Type: application/json" \
  -d "{ \"title\": \"Updated 1\", \"author\": \"Other 1\" }"
```

8) удалить книгу (только авторизованный).
```
curl -X DELETE http://localhost:8080/books/3 \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlhdCI6MTc2MzQzNjk5OSwiZXhwIjoxNzYzNTIzMzk5fQ.GKvn0-sDGITm0q3-pVirKng88Aw1_xmgjvZFl16fs8E"
```


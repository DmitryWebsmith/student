## Описание сервиса тестирования.

### Стек сайта
Laravel 11, Vue3, Inertiajs, компоненты Quasar.

### Описание
Сайт реализует сервис проверки знаний путем тестирования. Разработан для любимой супруги Елены, работающей учителем английского языка.

Сервис реализует две роли: учитель и ученик. У каждой роли свой кабинет, представляющий необходимый для роли функционал.

### Возможности учителя:
1. Создание/удаление/редактирование класса.
2. Создание/удаление/редактирование ученика.
3. Создание/удаление/редактирование категорий тестов.
4. Создание/удаление/редактировние тестов. Тесты могут включать произвольное количество вопросов и ответов. Ответы
   могут быть текстовыми, ответы с одиночным и множественным выбором правильного ответа.
5. Создание/удаление задач. Задача, определяет какой класс будет проходить выбранный текст, с какого по какое время,
   длительность прохождения теста.
6. Просмотр полученных результатов. Учитель в этом разделе видит результаты каждого ученика.
   Организовано сопоставление ответов ученика с тестом. Учитель видит правильный ответ теста и ответ ученика.
   Неправильные ответы помечены красным цветом, правильные зеленым. Сервис выставляет оценки по полученным результатам
   в автоматическом режиме по заданному алгоритму.

### Возможности ученика:

1. Прохождение теста. Сайт реализует SPA, что позволяет интерактивно взаимодействовать с учеником во время сдачи теста.
   Аналогичный режим используется в кабинете учителя. Каждый ответ ученика сохраняется в базу данных сервера. В случае утери
   связи, иных проблем на стороне ученика, после восстановления подключения, ученик может продолжить прохождение тестирования
   с момента последнего ответа.
2. Просмотр результатов тестирования доступен ученику после истечения времени прохождения теста.

### Сайт
- Адрес сайта https://excellent-student.ru/

Тестовый доступ в кабинет учителя:
- Логин: test@excellent-student.ru
- Пароль: 12345678

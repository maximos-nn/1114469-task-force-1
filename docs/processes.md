# Описание процессов проекта

## Классы

### Классы данных
* Category
* Location
* User
* Profile
* ProfileSetting
* ProfileStat
* ProfileCategory
* ProfilePortfolio
* Task
* TaskFile
* TaskFeedback
* TaskResponse
* TaskMessage

### Классы для работы с логикой
* AuthService
* RegisterService
* ProfileService
* TaskBrowserService
* TaskManagerService
* NotifyService
* LocationService

## Процессы

### Просмотр новых заданий на странице лендинга
    TaskBrowserService, Category, Task

### Регистрация аккаунта
    RegisterService, User, Profile

### Вход на сайт
    AuthService, User, Profile

### Просмотр новых заданий
    TaskBrowserService, LocationService, Category, Task

### Добавление задания
    TaskManagerService, LocationService, Category, Location, Task, TaskFile

### Просмотр списка исполнителей
    ProfileService, TaskBrowserService, Profile, ProfileSetting, ProfileStat, ProfileCategory, Category, Task, TaskFeedback

### Просмотр задания
    TaskBrowserService, LocationService, ProfileService, NotifyService, Category, Location, Task, TaskFile, TaskResponse, TaskMessage, Profile, ProfileCategory, ProfileStat, ProfileSetting

### Отклик на задание
    TaskManagerService, Task, TaskResponse

### Отклонение отклика
    TaskManagerService, Task, TaskResponse

### Старт задания
    TaskManagerService, ProfileService, Task, Profile

### Завершение задания
    TaskManagerService, ProfileService, Task, TaskFeedback, ProfileStat

### Отказ от задания
    TaskManagerService, ProfileService, Task, ProfileStat

### Просмотр профиля исполнителя
    ProfileService, TaskBrowserService, Profile, ProfileSetting, ProfileStat, ProfileCategory, ProfilePortfolio, Category, Location, Task, TaskFeedback

### Просмотр и настройка профиля
    ProfileService, Profile, ProfileSetting, ProfileCategory, ProfilePortfolio, Category, Location, User

### Просмотр собственных заданий
    TaskBrowserService, ProfileService, Task, TaskFeedback, Category, Profile

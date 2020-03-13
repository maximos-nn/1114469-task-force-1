# Описание процессов проекта

## Классы

### Классы данных
* Category
* Location
* User
* File
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
    TaskManagerService, LocationService, Category, Location, Task, TaskFile, File

### Просмотр списка исполнителей
    ProfileService, TaskBrowserService, Profile, ProfileSetting, ProfileStat, ProfileCategory, Category, Task, TaskFeedback, File

### Просмотр задания
    TaskBrowserService, LocationService, ProfileService, NotifyService, Category, Location, Task, TaskFile, TaskResponse, TaskMessage, Profile, ProfileCategory, ProfileStat, ProfileSetting, File

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
    ProfileService, TaskBrowserService, Profile, ProfileSetting, ProfileStat, ProfileCategory, ProfilePortfolio, Category, Location, Task, TaskFeedback, File

### Просмотр и настройка профиля
    ProfileService, Profile, ProfileSetting, ProfileCategory, ProfilePortfolio, Category, Location, User, File

### Просмотр собственных заданий
    TaskBrowserService, ProfileService, Task, TaskFeedback, Category, Profile, File

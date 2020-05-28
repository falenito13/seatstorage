# Tazo Base project

### ინსტალაციის ინსტრუქცია

###### პროექტის clone-ის შემდეგ გასაშვები ბრძანებების მიმდევრობა:

```
1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. შექმენით ლოკალურად ბაზა და შეავსეთ ბაზის კონფიგები env-ში.
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
5. Administrator-ის user-ის შესაქმნელად .env-ში გაუწერეთ შესაბამისი მნიშვნელობები
    ADMIN_USER_EMAIL=
    ADMIN_USER_PASSWORD=
6. php artisan module:optimize
7. php artisan migrate
8. php artisan db:seed
9. php artisan storage:link
```

## პროექტის პირველად დაყენებისას გასაშვების დამხამრე ბრძანებები

### 1. პროექტის სახელი
```
.env-ში გაუწერეთ მნიშვნელობა:
    PROJECT_NAME=
```

### 2. სათარგმნი ტექსტების import

`* "config/language_manager" exclude_groups-ში გაწერეთ იმ სათარგმნი ფაილების სია, რომლებიც გინდათ, რომ პანელში ტექსტების შეყვანისას არ გამოჩნდეს`

`* "config/language_manager" locales-ში გაწერეთ ენების ჩამონათვალი`

###### დაიმპორტდება ყველა არსებული ტექსტები ბაზაში.
```
php artisan import:text 
```

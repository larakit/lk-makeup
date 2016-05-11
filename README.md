# [Larakit] рабочий стол верстальщика 

###Для начала обозначу проблемы, которые решает данный инструмент:
* соблюдение корректности отображения верстки для разных разрешений (путем установки необходимого количества брейкпоинтов)
* возможность добавления тем оформления
* возможность просмотреть отдельный блок (это очень важно в момент натягивания верстки)
* возможность легкой кастомизации (темы оформления), вы, например, можете запросто сделать темы оформления для Android, iOS, Windows
* отсутствие необходимости сжимать и разжимать браузер, чтобы быстро продемонстрировать адаптивность страницы
* рабочий интерфейс понятный и верстальщику, и принимающей стороне
* возможность скачать готовую верстку одним архивом (HTML включая JS/CSS/images/fonts)
* возможность изменить сверстанный блок, без необходимости внесения правок во всех страницах (например, при 30 макетах изменение копирайта в footer - это убийство времени, обычно забивают на это).
* ну, и самое главное лично для нас - возможность работать над одним проектом сразу нескольким верстальщикам, причем разной квалификации (начинающим дать простые блоки в работу, опытным - доверить сборку страниц и сложные адаптации)
 
###Теперь о том, чем придется пожертвовать:
* придется верстальщику настроить рабочее место (поставить LAMP или OpenServer для Windows, а также установить Laravel)
* придется изучить некоторые базовые функции шаблонизатора Twig (в дальнейшем это СИЛЬНО облегчит жизнь)
* придется соблюдать некоторые соглашения (естественно, в обмен на упрощение работы)

###Оговорка:
Чтобы не отвлекаться на верстку, в качестве примера возьмем <a href="http://startbootstrap.com/template-overviews/freelancer/">готовый шаблон START BOOTSTRAP</a>, разобьем на блоки и покажем как правильно организовывать код и статику.
Для того, чтобы было проще работать и иметь возможность сборки страницы из кусочков воспользуемся шаблонизатором Twig.
Сразу обращу внимание на то, что на выходе мы получим примерно такую страницу со ссылками на сгенерированные страницы и блоки, причем для каждой темы оформления, т.е. можно будет таким образом верстать для проектов хоть с использованием Laravel, хоть Joomla.

Итак, начнем!

###1. Установка
Считаем, что с установкой окружения (веб-сервер, PHP>=5.4, composer) вы справились на отличненько, поэтому сразу перейдем к установке самого инструмента.

В директории, где лежат ваши домены, произведем установку последней версии laravel (на момент написания статьи это v5.2.31)
~~~bash
$composer create-project --prefer-dist --stability=dev larakit/larakit startbootstrap
$cd startbootstrap
$composer require larakit/lk-makeup
~~~
где startbootstrap - это название проекта.

Проверяем работоспособность страницы инструмента, для этого перейдем на страницу http://startbootstrap/makeup/, там мы должны увидеть следующую картинку:
<img src="https://habrastorage.org/files/7fb/947/00d/7fb94700d837440aa4c9ac82ef8e0793.png" />
Если до этого момента у вас все получилось, установка считается законченной. Поздравляем!

###2. Зададим основные стили проекта
Для этого мы всю common-статику проекта (типографика, картинки), другими словами то, что будет использоваться сразу в нескольких блоках одновременно, распределим следующим образом:
* в директорию ./public/!/static/css - стили
* в директорию ./public/!/static/js - скрипты
* в директорию ./public/!/static/img - картинки 
* в директорию ./public/!/static/fonts - шрифты

Подключим их, для этого в файле 

~~~
./app/Http/page.php
~~~

~~~php
<?php

\Larakit\StaticFiles\Manager::package('app')
    ->css('//fonts.googleapis.com/css?family=Montserrat:400,700')
    ->css('//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic')
    ->usePackage('larakit/sf-bootstrap')
    ->css('/!/static/css/common.css')
    ->js('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    ->js('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    ->js('//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js')
    ->js('/!/static/js/classie.js')
    ->js('/!/static/js/cbpAnimatedHeader.js')
    ->js('/!/static/js/jqBootstrapValidation.js');

~~~


###3. Формируем блок
<img src="https://habrastorage.org/files/7ba/6b3/016/7ba6b301668046f3a70fe3151dea448f.png" />

шаблоны блоков у нас хранятся в директории  ./resources/views/!/makeup/blocks/

<img src="https://habrastorage.org/files/7b4/9f1/114/7b49f111418c4df5aad68cc799534cba.png" />

обновляем страницу и видим, что в разделе блоки автоматически появился наш блок. Выбираем его.

<img src="https://habrastorage.org/files/356/7d1/744/3567d1744b464586b7cf540385b3d871.png" />

Блок голый, без оформления. Прямо "CSS naked day" какой то!

Добавим ему стилей.

<img src="https://habrastorage.org/files/218/74c/bb5/21874cbb5cf044118001fedaca11c9d4.png" />

Согласитесь, совсем другое дело!

Но в макете для этого блока дизайнер нарисовал адаптивность на 768 пикселях. Это очень просто: добавляем новый файл стилей в папке статики блока с названием брейкпоинта:
./public/!/static/css/locks/navbar/768.css

<img src="https://habrastorage.org/files/ff9/c8c/e19/ff9c8ce1953d48c08df5c24a33c5e941.png" />

и обновляем страницу

<img src="https://habrastorage.org/files/949/437/7a3/9494377a389246b99953b9b00405957a.png" />

Заметили разницу? Верно: вверху инструмента появилась кнопка с брейкпоинтом 768px. Кликнем на нее.

<img src="https://habrastorage.org/files/e7f/4a4/a93/e7f4a4a9365f4949a16b13ee9027bd10.gif" />

Т.е. не дергая браузер, мы одним нажатием кнопки с брейкпоинтом можем смотреть как наш шаблон будет адаптироваться под различные разрешения.

Главный разработчик сайта Kremlin.ru Артём Геллер давал интервью сайту https://vc.ru/p/kremlin-ru :
~~~
В итоге для того, чтобы идеально отобразить сайт на всех типах устройств с промежуточными значениями, 
нам понадобилось 9 брейкпоинтов. 
~~~
Действительно, нам тоже надо больше брейкпоинтов, даже если под них специально не рисовался макет, просто чтобы не упустить где может расползтись верстка.

<img src="https://habrastorage.org/files/e7f/867/ea7/e7f867ea7f404b118b68d5ea8aefada2.png" />

смотрим результат

<img src="https://habrastorage.org/files/0db/ccf/dd4/0dbccfdd417644fe84062a758abfd5b5.gif" />

заметьте - не важно в каком порядке регистрировались брейкпоинты, они все равно были отсортированы в порядке убывания.

На этом с блоками закончено. Переходим к сборке страниц из блоков.


###4. Собираем страницу из блоков
Считаем, что все блоки уже сверстаны к этому моменту. 

Шаблоны страниц у нас хранятся в директории  ./resources/views/!/makeup/pages/

Код страницы добавляем в файл index.twig

<img src="https://habrastorage.org/files/ca7/3cf/ccf/ca73cfccf67b446bb4475621c16d4230.png" />

Смотрим:

<img src="https://habrastorage.org/files/5a9/d5c/7d1/5a9d5c7d1eed423380fc31238221db56.gif" />


#5. Работа с темами оформления
Остался неохваченным еще один момент - темы оформления. Это тоже делается достаточно просто:

зарегистрируем темы оформления в page.php

<img src="https://habrastorage.org/files/138/2f7/611/1382f761139a46f58344a038375eefaf.png" />

Чтобы код оставался понятным другим - рекомендуется темы оформления разнести по разным файлам 
~~~
./public/!/static/css/themes/theme-name.css
~~~
и подключить в 
~~~
./app/Http/page.php
~~~

~~~php
<?php

\Larakit\StaticFiles\Manager::package('app')
    ->css('//fonts.googleapis.com/css?family=Montserrat:400,700')
    ->css('//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic')
    ->usePackage('larakit/sf-bootstrap')
    ->css('/!/static/css/common.css')
    //темы оформления
    ->css('/!/static/css/themes/windows.css')
    ->css('/!/static/css/themes/android.css')
    ->css('/!/static/css/themes/ios.css')
    
    ->js('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    ->js('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    ->js('//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js')
    ->js('/!/static/js/classie.js')
    ->js('/!/static/js/cbpAnimatedHeader.js')
    ->js('/!/static/js/jqBootstrapValidation.js');

~~~

Внутри каждой темы сделано небольшое изменение, чтобы показать принцип работы - раскрашен navbar & header.

<img src="https://habrastorage.org/files/e41/976/49b/e4197649bf1347a9b9a79309350e491b.gif" />

А принцип заключается в том, что элементу BODY добавляется класс "theme-*", где вместо звездочки пишется название темы, а затем кастомизируются элементы лежащие внутри

<img src="https://habrastorage.org/files/5e4/6e8/24c/5e46e824ca0c42dfbafc965b83bab000.png" />



###Полученный результат:
<img src="https://habrastorage.org/files/431/06e/28c/43106e28c8b54678b575720b21371a39.png" />

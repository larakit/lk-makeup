# [Larakit HtmlMakeup] инструмент верстальщика

###Для начала обозначу проблемы, которые решает данный инструмент:
* соблюдение корректности отображения верстки для разных разрешений (путем установки необходимого количества брейкпоинтов)
* возможность добавления тем оформления
* возможность просмотреть отдельный блок (это очень важно и для самого верстальщика, и для программиста)
* возможность легкой кастомизации (темы оформления), вы, например, можете запросто сделать темы оформления для Android, iOS, Windows
* отсутствие необходимости сжимать и разжимать браузер, чтобы быстро продемонстрировать адаптивность страницы
* упрощение процесса "натягивания верстки", так как все логически разделено на маленькие блоки, которыми удобно оперировать
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

###2. Определимся со структурой и зададим основные стили проекта
Вам придется работать со следующей файловой структурой:

Путь | Описание
------------ | -------------
./app/Http/page.php | тут все настройки страницы
./app/Http/page.php |  тут все настройки страницы
./public/!/static/blocks/ |  блоки 
./public/!/static/blocks/BLOCK_NAME/ | один блок
./public/!/static/blocks/BLOCK_NAME/block.twig | шаблон блока
./public/!/static/blocks/BLOCK_NAME/block.css | стили блока
./public/!/static/blocks/BLOCK_NAME/<N1>.css |  брейкпоинт на <N1> пикселей
./public/!/static/blocks/BLOCK_NAME/<N2>.css |  брейкпоинт на <N2> пикселей
./public/!/static/common/ |  общесайтовая статика
./public/!/static/common/css/ |  стили (любое содержимое внутри, подключается вручную)
./public/!/static/common/js/ |  скрипты (любое содержимое внутри, подключается вручную)
./public/!/static/common/img/ |  картинки 
./public/!/static/common/fonts/ |  шрифты
./public/!/static/pages/ |  страницы
./public/!/static/pages/PAGE_NAME.twig |  шаблон страницы
./public/!/static/themes/ |  темы оформления
./public/!/static/themes/<theme>.css |  темы оформления

Подключим их, для этого в файле 

~~~
./app/Http/page.php
~~~

пропишем

~~~php
<?php
\Larakit\StaticFiles\Manager::package('common')
    //подключим шрифты
    ->css('//fonts.googleapis.com/css?family=Montserrat:400,700')
    ->css('//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic')
    //укажем зависимость от twitter bootstrap
    //это будет означать то, что он будет подключаться до этого пакета
    ->usePackage('larakit/sf-bootstrap')
    //подключим локальные common-стили
    ->css('/!/static/common/css/common.css')

    //подключим скрипты библиотек из CDN
    ->js('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    ->js('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    ->js('//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js')
    //подключим локальные common-скрипты
    ->js('/!/static/common/js/classie.js')
    ->js('/!/static/common/js/cbpAnimatedHeader.js')
    ->js('/!/static/common/js/jqBootstrapValidation.js');
~~~


###3. Формируем первый блок "navbar"

HTML-код шаблона сохраняем в файле
~~~
./public/!/static/blocks/navbar/block.twig
~~~

<img src="https://habrastorage.org/files/be5/312/e21/be5312e215b3439b893251fad736830a.png" />

обновляем страницу и видим, что в разделе блоки автоматически появился наш блок. Выбираем его.

<img src="https://habrastorage.org/files/fc5/a69/bb0/fc5a69bb026d4f4ca8da9d51c65d1e53.png" />

Уже симпатично, но как то дефолтно, добавим ему стилей.

Для этого в файл
~~~
./public/!/static/blocks/navbar/block.css
~~~
запишем CSS данного блока

<img src="https://habrastorage.org/files/009/6f9/b1e/0096f9b1e2f04f9dbfdda5d5df6b3b60.png" />

Снова обновляем страницу

<img src="https://habrastorage.org/files/b2b/61d/b74/b2b61db74bc1402e8d9c737d6c4f1a93.png" />

Уже лучше!

Но в макете для этого блока дизайнер нарисовал адаптивность на 768 пикселях. 

С "Larakit HtmlMakeup" это очень просто: добавляем новый файл стилей в папке статики блока с названием брейкпоинта:
~~~
./public/!/static/blocks/navbar/768.css
~~~

<img src="https://habrastorage.org/files/3b6/f7a/26d/3b6f7a26d5784755acdf772ae42e3ec9.png" />

и обновляем страницу

<img src="https://habrastorage.org/files/949/437/7a3/9494377a389246b99953b9b00405957a.png" />

Заметили разницу? Верно: вверху инструмента появилась кнопка с брейкпоинтом 768px. Кликнем на нее.

<img src="https://habrastorage.org/files/e7f/4a4/a93/e7f4a4a9365f4949a16b13ee9027bd10.gif" />

Т.е. не дергая браузер, мы одним нажатием кнопки с брейкпоинтом можем смотреть как наш шаблон будет адаптироваться под различные разрешения.

Главный разработчик сайта Kremlin.ru Артём Геллер давая интервью сайту https://vc.ru/p/kremlin-ru, сказал:
~~~
В итоге для того, чтобы идеально отобразить сайт на всех типах устройств 
с промежуточными значениями, нам понадобилось 9 брейкпоинтов. 
~~~
Действительно, нам тоже надо больше брейкпоинтов, даже если под них специально не рисовался макет, просто чтобы не упустить где может расползтись верстка.

<img src="https://habrastorage.org/files/d0d/720/ff2/d0d720ff20a24eaab46a50dccbdf6f52.png" />

смотрим результат

<img src="https://habrastorage.org/files/0db/ccf/dd4/0dbccfdd417644fe84062a758abfd5b5.gif" />

заметьте - не важно в каком порядке регистрировались брейкпоинты, они все равно были отсортированы в порядке убывания.

На этом с блоками закончено. Переходим к сборке страниц из блоков.


###4. Собираем страницу "index"

Считаем, что все блоки уже сверстаны к этому моменту. 

Шаблоны страниц у нас хранятся в директорию
~~~
./resources/views/!/static/pages/
~~~

Код страницы добавляем в файл 

<img src="https://habrastorage.org/files/f16/216/be7/f16216be7baf4d6280ab2acaed541f01.png" />

Смотрим:

<img src="https://habrastorage.org/files/5a9/d5c/7d1/5a9d5c7d1eed423380fc31238221db56.gif" />


#5. Работа с темами оформления
Остался неохваченным еще один момент - темы оформления. Это тоже делается достаточно просто:

в директорию
~~~
./public/!/static/css/themes/
~~~

положить файлы с именем тем оформления, например, 
~~~
./public/!/static/css/themes/android.css
./public/!/static/css/themes/windows.css
./public/!/static/css/themes/ios.css
~~~
Темы автоматически зарегистрируются. 

Все, вы ожидали сложностей?

Для демонстрации механизма "темизации" внутри каждой темы сделано небольшое изменение, чтобы показать принцип работы - раскрашен navbar & header.

<img src="https://habrastorage.org/files/e41/976/49b/e4197649bf1347a9b9a79309350e491b.gif" />

А принцип заключается в том, что элементу BODY добавляется класс "theme-*", где вместо звездочки пишется название темы, а затем кастомизируются элементы лежащие внутри

<img src="https://habrastorage.org/files/e7f/2de/2cb/e7f2de2cb633450fb74ecae560cc1d49.png" />

###6. Результат верстки в одном архиве
После того, как вы убедились, что все сделано корректно, показываете дизайнеру, чтобы он убедился, что именно так он и видел свой макет - готовую работу надо отдать заказчику, чтобы тот отдал ее серверным программистам для "натягивания верстки".

Естественно, они будут не в восторге, если для того, чтобы посмотреть работу им придется также поставить LAMP, Laravel, Twig, etc...  - поэтому в инструменте есть кнопка "скачать", при нажатии на которую вы получите готовый архив со всеми вариантами использования блоков и страниц, всеми стилями и скриптами, а также темами оформления.

<img src="https://habrastorage.org/files/93d/e6c/0db/93de6c0db6cd46689f41ead27163b071.png" />
Отдельное спасибо, я надеюсь, вы услышите от серверных программистов, которым придется интегрировать вашу верстку.

Ну и бонусом к этому архиву - вы получите рубрикатор всех сверстанных страниц:

<img src="https://habrastorage.org/files/431/06e/28c/43106e28c8b54678b575720b21371a39.png" />

Результаты проименованые по следующему принципу:
* блоки: block_{name}--{theme}.html
* страницы: page_{name}--{theme}.html

~~~
Позабыты хлопоты, остановлен бег,
Вкалывают роботы, а не человек.
~~~

Ну и бонусом:
Согласитесь выглядит скучно
<img src="https://habrastorage.org/files/c75/832/12c/c7583212cfef471fa0b50bc6bf3cab8c.png" />
но верстальщики же парни с юмором и немного с ленцой, им лень искать фоточки для временного наполнения и хочется пива и сисек, поэтому они захотели плейсхолдеры картинок - не вопрос.

У нас уже подключен пакет-хелпер <a href="https://github.com/larakit/hlp-beerhold">larakit/hlp-beerhold</a>

Заменяем ссылки на картинки
~~~html
<img src="{{ beerhold(900, 650) }}" class="img-responsive" alt="">
~~~
где 900 - ширина, а 650 - высота 

<img src="https://habrastorage.org/files/829/10b/3c5/82910b3c5f2448479590fa9d849dc1da.png" />

и получаем:

<img src="https://habrastorage.org/files/684/296/a6f/684296a6f27a48a9b834966b3d788b3e.png" />

Смотрим исходные задачи, со всеми справились - плюс удовольствие от проделанной работу получили.

Кстати, текущий результат можно выкладывать на свой сервер и показывать заказчику по мере работы - это сильно мотивирует.

А также просить дизайнера доработать не совсем понятные моменты не запариваясь с объяснениями - просто дав ему ссылку на страницу или блок в нужном брейкпоинте и нужной теме оформления - это сильно экономит время.

###P.S.: 
уже дописав статью и сделав  все скриншоты и анимашки увидел, что не подключились иконки из font-awesome, потому, что забыл их подключить.

Это не сложно, выолним установку пакета со статикой, после которой он сам подключится где надо:
~~~
$composer require larakit/sf-font-awesome
~~~

сделаем еще раз скриншот последней страницы

<img src="https://habrastorage.org/files/559/272/ab2/559272ab25e9411a91905aba1dcd5d97.png" />

все иконки на месте.

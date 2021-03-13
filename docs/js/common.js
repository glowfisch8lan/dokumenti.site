$(function(){
/*
    $('#phone').mask("+7(999) 999-99-99");

    $('.articles-tab').click(function(){
        var art = $(this).attr('data-art');

        var desc1, title, desc2, fine;
        
        switch (art) {
            case 'art1311p1':
                desc1 = 'Получение данных пользователя, запись в (на первый взгляд безобидный) список клиентов, отправка рекламы или информирование об услуге - является обработкой персональных данных. Не правильная обработка данных влечет за собой (без отягчающих) штраф от 30.000 до 50.000 рублей';
                desc2 = 'Обработка персональных данных в случаях, не предусмотренных законодательством Российской Федерации в области персональных данных, либо обработка персональных данных, несовместимая с целями сбора персональных данных, за исключением случаев, предусмотренных частью 2 настоящей статьи, если эти действия не содержат уголовно наказуемого деяния';
                title = 'Статья 13.11 ч.1 КоАП РФ';
                fine = 'ШТРАФ: ОТ 30 ТЫС. ДО 50 ТЫС. РУБЛЕЙ';
                break;
            case 'art1311p2':
                desc1 = 'Сбор данных пользователя ведется не только через формы обратной связи. Сам сайт и программное обеспечение также производит сбор данных без ведома владельца сайта. Отсутствие согласия пользователя на сбор данных, влечет за собой штраф от 15.000 до 70.000 рублей, в случае если нарушение не влечет за собой уголовной ответственности';
                desc2 = 'Обработка персональных данных без согласия в письменной форме субъекта персональных данных на обработку его персональных данных, если эти действия не содержат уголовно наказуемого деяния, либо обработка персональных данных с нарушением установленных законодательством Российской Федерации в области персональных данных требований к составу сведений, включаемых в согласие в письменной форме субъекта персональных данных на обработку его персональных данных';
                title = 'Статья 13.11 ч.2 КоАП РФ';
                fine = 'ШТРАФ: ОТ 15 ТЫС. ДО 70 ТЫС. РУБЛЕЙ';
                break;
            case 'art1311p3':
                desc1 = 'Владелец сайта обязан не только иметь, но и корректно, в соответствии с требованиями Законодательства РФ предоставить пользователю политику оператора в отношении обработки персональных данных и прочее. нарушение данных требований влечет за собой штраф в размере от 15.000 до 30.000 рублей';
                desc2 = 'Невыполнение оператором предусмотренной законодательством Российской Федерации в области персональных данных обязанности по опубликованию или обеспечению иным образом неограниченного доступа к документу, определяющему политику оператора в отношении обработки персональных данных, или сведениям о реализуемых требованиях к защите персональных данных';
                title = 'Статья 13.11 ч.3 КоАП РФ';
                fine = 'ШТРАФ: ОТ 15 ТЫС. ДО 30 ТЫС. РУБЛЕЙ';
                break;
            case 'art1311p4':
                desc1 = 'Отсутствие необходимых документов на сайте, объясняющих пользователю схему обработки его персональных данных, хранение, накопление и прочее, влечет за собой штраф в размере от 20.000 до 40.000 рублей';
                desc2 = 'Невыполнение оператором предусмотренной законодательством Российской Федерации в области персональных данных обязанности по предоставлению субъекту персональных данных информации, касающейся обработки его персональных данных';
                title = 'Статья 13.11 ч.4 КоАП РФ';
                fine = 'ШТРАФ: ОТ 20 ТЫС. ДО 40 ТЫС. РУБЛЕЙ';
                break;
            case 'art1311p5':
                desc1 = 'Ошибка оператора (сотрудника, менеджера или иного лица имеющего доступ к пользовательским данным), по части не выполнения требований об уточнении, блокировке или уничтожении данных, даже если требования не доведены до Вас в виду технических ошибок или не достоверно указанных данных, влечет за собой штраф от 25.000 до 45.000 рублей';
                desc2 = 'Невыполнение оператором в сроки, установленные законодательством Российской Федерации в области персональных данных, требования субъекта персональных данных или его представителя либо уполномоченного органа по защите прав субъектов персональных данных об уточнении персональных данных, их блокировании или уничтожении в случае, если персональные данные являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки';
                title = 'Статья 13.11 ч.5 КоАП РФ';
                fine = 'ШТРАФ: ОТ 25 ТЫС. ДО 45 ТЫС. РУБЛЕЙ';
                break;
            case 'art1311p6':
                desc1 = 'Любые данные в итоговом виде находятся на физическом носителе, будь то жесткий диск компьютера, флэшка или распечатанные на бумаге. Нарушение требований Законодательства РФ в области хранения, случайная утечка данных в том числе по вине сотрудника грозит владельцу сайта штрафом от 25.000 до 50.000 рублей';
                desc2 = 'Невыполнение оператором при обработке персональных данных без использования средств автоматизации обязанности по соблюдению условий, обеспечивающих в соответствии с законодательством Российской Федерации в области персональных данных сохранность персональных данных при хранении материальных носителей персональных данных и исключающих несанкционированный к ним доступ, если это повлекло неправомерный или случайный доступ к персональным данным, их уничтожение, изменение, блокирование, копирование, предоставление, распространение либо иные неправомерные действия в отношении персональных данных, при отсутствии признаков уголовно наказуемого деяния';
                title = 'Статья 13.11 ч.6 КоАП РФ';
                fine = 'ШТРАФ: ОТ 25 ТЫС. ДО 50 ТЫС. РУБЛЕЙ';
                break;
            case 'art1311p7':
                desc1 = 'Работа сперсональными данными пользователя или клиента должна быть строго и пошагово задокументирована, должны соблюдаться необходимые требования при систематизации и накоплении данных. Нарушение требований к работе с данными влечет за собой штраф от 1 млн. до 6.000.000 млн. рублей.';
                desc2 = 'Невыполнение оператором при сборе персональных данных, в том числе посредством информационно-телекоммуникационной сети "Интернет", предусмотренной законодательством Российской Федерации в области персональных данных обязанности по обеспечению записи, систематизации, накопления, хранения, уточнения (обновления, изменения) или извлечения персональных данных граждан Российской Федерации с использованием баз данных, находящихся на территории Российской Федерации';
                title = 'Статья 13.11 ч.7 КоАП РФ';
                fine = 'ШТРАФ: ОТ 1 МЛН. ДО 6 МЛН. РУБЛЕЙ';
                break;
            case 'art137':
                desc1 = 'Сбор или распространение данных частной жизни посетителя сайта без его согласия является серьезным нарушением Законодательства РФ. Часто владельцы сайта не подразумевают, что сайт ведет сбор данных о пользователе без его ведома. Однако ответственность возлагается непосредственно на владельца, штрафом до 200.000 рублей или лишением свободы на срок до 2 лет';
                desc2 = 'Незаконное собирание или распространение сведений о частной жизни лица, составляющих его личную или семейную тайну, без его согласия либо распространение этих сведений в публичном выступлении, публично демонстрирующемся произведении или средствах массовой информации';
                title = 'Статья 137 УК РФ';
                fine = 'ШТРАФ: ДО 200 ТЫС. ИЛИ СРОК: ДО 2 ЛЕТ ЛИШЕНИЯ СВОБОДЫ';
                break;
        }

        $('.articles-desc-left p').text(desc1);
        $('.articles-desc-right h3').text(title);
        $('.articles-desc-right p').text(desc2);
        $('.articles-desc-right b').text(fine);
    });*/

    // Открытие и закрытие мобильного меню

    $('.header-nav a.hamb').click(function(e){
        e.preventDefault();

        $('.mobile-menu').slideDown();
    });

    $('.mobile-menu a.close').click(function(e){
        e.preventDefault();

        $('.mobile-menu').slideUp();
    });

    $('.mobile-menu-links a').click(function(){
        $('.mobile-menu').slideUp();
    });

    // Открытие и закрытие колбэк окна

    $('.header-callback a, .cta a, .footer-callback a, .mobile-menu-callback a').click(function(e){
        e.preventDefault();

        $('.mobile-menu').slideUp();

        $('.callback').fadeIn(0);
    });

    $('.callback a.close').click(function(e){
        e.preventDefault();

        $('.callback').fadeOut(0);
    });

    $('.main-cabinet-order__info__right a').click(function(e){
        e.preventDefault();

        $('.choice-replenishment').fadeIn(0);
    });

    $('.choice-replenishment a.close').click(function(e){
        e.preventDefault();

        $('.choice-replenishment').fadeOut(0);
    });

    $('.cabinet-top-menu-right a').click(function(e){
        e.preventDefault();

        $('.default-replenishment').fadeIn(0);
    });

    $('.default-replenishment a.close').click(function(e){
        e.preventDefault();

        $('.default-replenishment').fadeOut(0);
    });
});
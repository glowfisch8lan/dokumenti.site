/*
    jQuery Masked Input Plugin
    Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
    Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
    Version: 1.4.1
*/
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});

$(function(){

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
    });

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
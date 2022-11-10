//кнопка добавить в корзину
$('button.card__cart').on('click', function (e) {
    if($(this).is('.btn--added')) return;
    const id = $(this).data('product-id');
    Cart.add(id, 1, function (res) {
        $('.header__cart').replaceWith(res.header_cart);
        $('#cart-dialog').html(res.popup);
        $(this).addClass('btn--added');
        // $(this).text('Добавлено');
    }.bind(this));
});
//кнопка добавить в корзину в продукте
$('.product-data__add button').on('click', function (e) {
    // if($(this).is('.btn--added')) return;
    const id = $(this).data('product-id');
    Cart.add(id, 1, function (res) {
        $('.header__cart').replaceWith(res.header_cart);
        $('#cart-dialog').html(res.popup);
        $(this).addClass('btn--added');
        // $(this).text('Добавлено');
    }.bind(this));
});
//кнопка Купить
$('.card__actions button.btn').on('click', function (e) {
    const id = $(this).data('product-id');
    Cart.add(id, 1, function (res) {
        $('.header__cart').replaceWith(res.header_cart);
        $('#cart-dialog').html(res.popup);
        $(this).addClass('btn--added');
        // $(this).text('Добавлено');
    }.bind(this));
    document.location.href = '/cart';
});

$('button.catalog-list__add').on('click', function (e) {
    if($(this).is('.btn--added')) return;
    const id = $(this).data('product-id');
    Cart.add(id, 1, function (res) {
        $('.header__cart').replaceWith(res.header_cart);
        $('#cart-dialog').html(res.popup);
        $(this).addClass('btn--added');
        // $(this).text('Добавлено');
    }.bind(this));
});

$('button.cart-control--remove').on('click', function (e) {
    const id = $(this).data('remove-order');
    const count = $('.section__title.section__title--cart').data('count');
    Cart.remove(id,  function (res) {
        $('#product-' + id).remove();
        $('.header__cart').replaceWith(res.header_cart);
        $('.cart__values').replaceWith(res.cart_values);
        $('.section__title.section__title--cart').attr('data-count', count - 1);
        // $('#cart-dialog').html(res.popup);
        // $(this).text('Добавлено');
    }.bind(this));
});

$('button.clear-btn').on('click', function (e) {
    Cart.purge(function (res) {
        // location.href = res.cart;
        // let items = Array.from($('.cart-table__row'));
        // if(items.length > 0) {
        //     items.forEach(elem => elem.remove());
        // }
        // $('.section__title--cart').data('count', 0);
        location.reload();
        // $(html).html(res.render);

    }.bind(this));
});

let Cart = {
    add: function (id, count, callback) {
        sendAjax('/ajax/add-to-cart',
            {id: id, count: count}, (result) => {
            if (typeof callback == 'function') {
                callback(result);
            }
        });
    },

    update: function (id, count, callback) {
        sendAjax('/ajax/update-to-cart',
            {id: id, count: count}, (result) => {
            if (typeof callback == 'function') {
                callback(result);
            }
        });
    },

    edit:  function (id, count, callback) {
        sendAjax('/ajax/edit-cart-product',
            {id: id, count: count}, (result) => {
                if (typeof callback == 'function') {
                    callback(result);
                }
            });
    },

    remove: function (id, callback) {
        sendAjax('/ajax/remove-from-cart',
            {id: id}, (result) => {
            if (typeof callback == 'function') {
                callback(result);
            }
        });
    },

    purge: function (callback) {
        sendAjax('/ajax/purge-cart',
            {}, (result) => {
            if (typeof callback == 'function') {
                callback(result);
            }
        });
    },

}

function debounce(func, wait, immediate) {
    let timeout;

    return function executedFunction() {
        const context = this;
        const args = arguments;

        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };

        const callNow = immediate && !timeout;

        clearTimeout(timeout);

        timeout = setTimeout(later, wait);

        if (callNow) func.apply(context, args);
    };
}


function moreNews(el) {
    var url = $(el).data('url');
    var $more_lnk = $('.section__loader button');
    sendAjax(url, {}, function (json) {
        if (typeof json.paginate !== 'undefined') {
            //передаем обновленное значение "Загрузить еще"
            $('.section__loader').html(json.paginate);
        }
        if (typeof json.items !== 'undefined') {
            $('.newses__list').append(json.items);
        }
        if (typeof json.next_news_count !== 'undefined' && json.next_count > 0) {
            $more_lnk.data('url', json.next_page);
        }
    });
}

function moreSearchItems(el) {
    var url = $(el).data('url');
    var $more_lnk = $('.section__loader button');
    sendAjax(url, {}, function (json) {
        if (typeof json.paginate !== 'undefined') {
            //передаем обновленное значение "Загрузить еще"
            $('.section__loader').html(json.paginate);
        }
        if (typeof json.items !== 'undefined') {
            $('.search-page__list').append(json.items);
        }
    });
}

function moreOffers(el) {
    var url = $(el).data('url');
    var $more_lnk = $('.section__loader button');
    sendAjax(url, {}, function (json) {
        if (typeof json.paginate !== 'undefined') {
            //передаем обновленное значение "Загрузить еще"
            $('.section__loader').html(json.paginate);
        }
        if (typeof json.items !== 'undefined') {
            $('.offer__list').append(json.items);
        }
        if (typeof json.next_news_count !== 'undefined' && json.next_count > 0) {
            $more_lnk.data('url', json.next_page);
        }
    });
}

function resetForm(form) {
    $(form).trigger('reset');
    $(form).find('.err-msg-block').remove();
    $(form).find('.has-error').remove();
    $(form).find('.invalid').attr('title', '').removeClass('invalid');
}

function sendRequest(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            resetForm(form);
            alert('Форма отправлена!');
            // form.parent().find('.is-close').click();
            // popup('Спасибо, ваш вопрос отправлен. Сообщение об ответе придет на эл. почту.');
            // Fancybox.show([{ src: '#confirm', type: 'inline' }], {
            //     mainClass: 'popup--main popup--thanks'
            // });
        }
    });
}

function sendQuestion(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            resetForm(form);
            alert('Спасибо, ваш вопрос отправлен. Мы вам перезвоним!');
            // form.parent().find('.is-close').click();
            // popup('Спасибо, ваш вопрос отправлен. Сообщение об ответе придет на эл. почту.');
            // Fancybox.show([{ src: '#confirm', type: 'inline' }], {
            //     mainClass: 'popup--main popup--thanks'
            // });
        }
    });
}

function sendFastRequest(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            resetForm(form);
            alert('Быстрый заказ отправлен!');
            // form.parent().find('.is-close').click();
            // popup('Спасибо, ваш вопрос отправлен. Сообщение об ответе придет на эл. почту.');
            // Fancybox.show([{ src: '#confirm', type: 'inline' }], {
            //     mainClass: 'popup--main popup--thanks'
            // });
        }
    });
}

function sendCallback(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            resetForm(form);
            alert('Заявка на обратный звонок получена! Мы вам перезвоним!');
            form.find('.is-close').click();
            // popup('Спасибо, ваш вопрос отправлен. Сообщение об ответе придет на эл. почту.');
            // Fancybox.show([{ src: '#confirm', type: 'inline' }], {
            //     mainClass: 'popup--main popup--thanks'
            // });
        }
    });
}

function sendWriteback(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            resetForm(form);
            alert('Ваша заявка получена! Мы вам перезвоним!');
            form.find('.is-close').click();
            // popup('Спасибо, ваш вопрос отправлен. Сообщение об ответе придет на эл. почту.');
            // Fancybox.show([{ src: '#confirm', type: 'inline' }], {
            //     mainClass: 'popup--main popup--thanks'
            // });
        }
    });
}

function sendContactUs(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            resetForm(form);
            alert('Ваша заявка получена! Мы с вами свяжемся!');
            // form.find('.is-close').click();
            // popup('Спасибо, ваш вопрос отправлен. Сообщение об ответе придет на эл. почту.');
            // Fancybox.show([{ src: '#confirm', type: 'inline' }], {
            //     mainClass: 'popup--main popup--thanks'
            // });
        }
    });
}

function sendOrder(form, e) {
    e.preventDefault();
    var data = $(form).serialize();
    var url = $(form).attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors != 'undefined') {
            // validForm($(form), json.errors);
            var errMsg = [];
            for (var key in json.errors) {
                errMsg.push(json.errors[key]);
            }
            var strError = errMsg.join('<br />');
            $(form).find('[type="submit"]').after('<div class="err-msg-block">' + strError + '</div>');
        } else if(typeof json.redirect !== 'undefined') {
            location.href = json.redirect;
        } else {
            console.log('Успешно создан заказ');
            resetForm(form);
            popup('Спасибо за заявку, в ближайшее время мы вам ответим!');
        }
    })
}

function search(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                // form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            // form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            // resetForm(form);
            location.href = res.redirect;
        }
    });
}

$('.catalog-list__pages').on('change', function (e) {
    this.form.submit();
});

function setView(el, view) {
    let url = '/ajax/set-view/' + view;
    sendAjax(url, {view: view}, function (json) {
        if (json.success == true) {
            $('#setView').submit();
        }
    })
}

function updateFilter() {
    // $('#filter_form').submit();
}

$('button.cart-control--edit').on('click', function (e) {
    const id = $(this).data('edit-order');
    console.log(id);
})

function submitFilter() {
    $('#filter_form').submit();
}

function filterApply(elem, e) {
    e.preventDefault();
    let url = $(elem).attr('action');
    var data = $(elem).serialize();

    sendAjax(url, data, function (json) {
        if (typeof json.items !== 'undefined') {
            $('.catalog-list__products').html(json.items);
        }
        if (typeof json.paginate !== 'undefined') {
            $('.pagination').html(json.paginate);
        }
        // if (typeof json.perpage !== 'undefined') {
        //     $('.catalog-list__footer form').html(json.perpage);
        // }
    })
}


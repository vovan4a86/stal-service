var newsImage = null;
function newsImageAttache(elem, e){
    $.each(e.target.files, function(key, file)
    {
        if(file['size'] > max_file_size){
            alert('Слишком большой размер файла. Максимальный размер 2Мб');
        } else {
            newsImage = file;
            renderImage(file, function (imgSrc) {
                var item = '<img class="img-polaroid" src="' + imgSrc + '" height="100" data-image="' + imgSrc + '" onclick="return popupImage($(this).data(\'image\'))">';
                $('#article-image-block').html(item);
            });
        }
    });
    $(elem).val('');
}

function update_order(form, e) {
    e.preventDefault();
    var button = $(form).find('[type="submit"]');
    button.attr('disabled', 'disabled');
    var url = $(form).attr('action');
    var data = $(form).serialize();
    sendAjax(url, data, function(json){
        button.removeAttr('disabled');
    });
}

function catalogContent(elem){
    //var url = $(elem).attr('href');
    //sendAjax(url, {}, function(html){
    //	$('#catalog-content').html(html);
    //}, 'html');
    //return false;
}

function catalogSave(form, e){
    var url = $(form).attr('action');
    var data = new FormData();
    $.each($(form).serializeArray(), function(key, value){
        data.append(value.name, value.value);
    });
    if (newsImage) {
        data.append('image', newsImage);
    };
    sendFiles(url, data, function(json){
        if (typeof json.row != 'undefined') {
            if ($('#users-list tr[data-id='+json.id+']').length) {
                $('#users-list tr[data-id='+json.id+']').replaceWith(urldecode(json.row));
            } else {
                $('#users-list').append(urldecode(json.row));
            }
        }
        if (typeof json.errors != 'undefined') {
            applyFormValidate(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) { errMsg.push(json.errors[key]);  }
            $(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
        }
        if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
        if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
        if (typeof json.success != 'undefined' && json.success == true) {
            newsImage = null;
        }
    });
    return false;
}

function catalogDel(elem){
    if (!confirm('Удалить раздел?')) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest('li').fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

function productSave(form, e){
    var url = $(form).attr('action');
    var data = $(form).serialize();
    sendAjax(url, data, function(json){
        if (typeof json.errors != 'undefined') {
            applyFormValidate(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) { errMsg.push(json.errors[key]);  }
            $(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
        }
        if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
        if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
    });
    return false;
}

function productDel(elem){
    if (!confirm('Удалить товар?')) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest('tr').fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

function productImageUpload(elem, e){
    var url = $(elem).data('url');
    files = e.target.files;
    var data = new FormData();
    $.each(files, function(key, value)
    {
        if(value['size'] > max_file_size){
            alert('Слишком большой размер файла. Максимальный размер 2Мб');
        } else {
            data.append('images[]', value);
        }
    });
    $(elem).val('');

    sendFiles(url, data, function(json){
        if (typeof json.html != 'undefined') {
            $('.images_list').append(urldecode(json.html));
            if (!$('.images_list img.active').length) {
                $('.images_list .img_check').eq(0).trigger('click');
            }
        }
    });
}

function productCheckImage(elem){
    $('.images_list img').removeClass('active');
    $('.images_list .img_check .glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');

    $(elem).find('.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
    $(elem).siblings('img').addClass('active');

    $('#product-image').val($(elem).siblings('img').data('image'));
    return false;
}

function productImageDel(elem){
    if (!confirm('Удалить изображение?')) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest('.images_item').fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

function addActionProduct(elem, e) {
    e.preventDefault();
    var name = $('select[name=action-product-name] option:selected');
    var data = {
        product_id: name.val(),
        product_name: name.text(),
    }
    var url = $(elem).attr('href');

    sendAjax(url, data, function(json){
        if(typeof json.row != 'undefined'){
            $('#action_products_list tbody').append(json.row);
        }
    });
}

function delActionProduct(elem, e) {
    e.preventDefault();
    if(!confirm('Удалить этот товар из акции?')) return;
    var url = $(elem).attr('href');
    var row = $(elem).closest('tr');

    sendAjax(url, {}, function(json){
        if(typeof json.success != 'undefined'){
            $(row).fadeOut(300, function(){ $(this).remove(); });
        }
    });
}

function saveActionProduct(form, e) {
    e.preventDefault();
    var url = $(form).attr('action');
    var data = $(form).serialize();
    var id = $(form).data('id');
    sendAjax(url, data, function (html) {
        popupClose();
        $('tr#prod'+id).replaceWith(html);
    }, 'html');
}

$(document).ready(function () {
    $('#pages-tree').jstree({
        "core": {
            "animation": 0,
            "check_callback": true,
            'force_text': false,
            "themes": {"stripes": true},
            'data': {
                'url': function (node) {
                    return node.id === '#' ? '/admin/actions/get-actions' : '/admin/actions/get-actions/' + node.id;
                }
            },
        },
        "plugins": ["contextmenu", "dnd", "state", "types"],
        "contextmenu": {
            "items": function ($node) {
                var tree = $("#tree").jstree(true);
                return {
                    "Create": {
                        "icon": "fa fa-plus text-blue",
                        "label": "Создать страницу",
                        "action": function (obj) {
                            // $node = tree.create_node($node);
                            document.location.href = '/admin/actions/action-edit?parent=' + $node.id
                        }
                    },
                    "Edit": {
                        "icon": "fa fa-pencil text-yellow",
                        "label": "Редактировать страницу",
                        "action": function (obj) {
                            // tree.delete_node($node);
                            document.location.href = '/admin/actions/action-edit/' + $node.id
                        }
                    },
                    "Remove": {
                        "icon": "fa fa-trash text-red",
                        "label": "Удалить страницу",
                        "action": function (obj) {
                            if (confirm("Действительно удалить страницу?")) {
                                var url = '/admin/actions/action-delete/' + $node.id;
                                sendAjax(url, {}, function () {
                                    document.location.href = '/admin/actions';
                                })
                            }
                            // tree.delete_node($node);
                        }
                    }
                };
            }
        }
    }).bind("move_node.jstree", function (e, data) {
        treeInst = $(this).jstree(true);
        parent =  treeInst.get_node( data.parent );
        var d = {
            'id':   data.node.id,
            'parent': (data.parent == '#')? 0: data.parent,
            'sorted': parent.children
        };
        sendAjax('/admin/actions/action-reorder', d);
    }).on("activate_node.jstree", function(e,data){
        if(data.event.button == 0){
            window.location.href = '/admin/actions/products/' + data.node.id;
        }
    });
});
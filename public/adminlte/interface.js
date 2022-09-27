var max_file_size = 2097152;
$(function(){
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });

    $(document).on('click', '.popup-ajax', function(e){
    	e.preventDefault();
    	popupAjax($(this).attr('href'));
    });
});

function sendAjax(url, data, callback, type){
	data = data || {};
	if (typeof type == 'undefined') type = 'json';
	$.ajax({
		type: 'post',
		url: url,
		data: data,
		dataType: type,
		beforeSend: function(request) {
	        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
	    },
		success: function(json){
			if (typeof callback == 'function') {
				callback(json);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert('Не удалось выполнить запрос! Ошибка на сервере.');
		},
	});
}

function sendFiles(url, data, callback, type){
	if (typeof type == 'undefined') type = 'json';
	$.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        dataType: type,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        beforeSend: function(request) {
	        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
	    },
        success: function(json, textStatus, jqXHR)
        {
            if (typeof callback == 'function') {
				callback(json);
			}
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert('Не удалось выполнить запрос! Ошибка на сервере.');
        }
    });
}

function renderImage(file, callback){
	var reader = new FileReader();
	reader.onload = function(event){
		if (typeof callback == 'function') {
			callback(event.target.result);
		}
	};
	reader.readAsDataURL(file);
}

function applyFormValidate(form, ErrMsg){
	$(form).find('.invalid').attr('title', '').removeClass('invalid');
	for (var key in ErrMsg) {
		$(form).find('[name="'+urldecode(key)+'"]').addClass('invalid').attr('title', urldecode(ErrMsg[key].join(' ')));
	}
	$(form).find('.invalid').eq(0).trigger('focus');
}

var autoHideMsgNextId = 0;
function autoHideMsg(color, text, time){
	if (typeof time == 'undefined') time = 5000;
	var id = 'auto-hide-msg-'+(autoHideMsgNextId++);
	var msg = '<span id="'+id+'" class="auto-hide-msg text-'+color+'">'+text+'</span>';
	setTimeout(function(){ $('#'+id).fadeOut(500, function(){ $(this).remove(); }); }, time);
	return msg;
}

function startCkeditor(id){
	if (typeof CKEDITOR == 'undefined') {
		$('head').append('<script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>');
	}
	
	var editor = CKEDITOR.replace(
		id,
		{
            filebrowserBrowseUrl : '/admin/laravel-filemanager?type=Files',
            filebrowserImageBrowseUrl : '/admin/laravel-filemanager?type=Images',
            filebrowserFlashBrowseUrl : '/admin/laravel-filemanager?type=Flash',
            filebrowserUploadUrl : '/admin/laravel-filemanager/upload?type=Files',
            filebrowserImageUploadUrl : '/admin/laravel-filemanager/upload?type=Images',
            filebrowserFlashUploadUrl : '/admin/laravel-filemanager/upload?type=Flash',
			contentsCss : '/static/css/all.css',
			toolbar : [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', /*'Save', 'NewPage',*/ 'Preview', 'Print', /*'-', 'Templates'*/ ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
				//{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
				{ name: 'others', items: [ '-' ] },
				{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
				//{ name: 'about', items: [ 'About' ] },
				'/',
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', /*'CreateDiv',*/ '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', /* 'BidiLtr', 'BidiRtl', 'Language' */] },
				{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
				{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
				'/',
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
			],
            removePlugins: 'magicline',
            allowedContent: true
		}
	);

	editor.on( 'change', function( evt ) {
	    editor.updateElement();
	});
}

function popup(content){
	$('body').append('<div class="modal"><div class="modal-dialog"><div class="modal-content">' +
		'<div class="modal-header"><a href="#" class="popup-close close" onclick="return popupClose(this)"><span class="glyphicon glyphicon-remove"></span></a></div>'+
		'<div class="modal-body">' +
		content+'</div></div></div></div>')
	$('.modal').fadeIn(300);
}

function popupClose(el){
	if(typeof(el) !== 'undefined'){
        $(el).closest('.modal').fadeOut(300, function(){ $(this).remove(); });
	} else {
        $('.modal').fadeOut(300, function(){ $(this).remove(); });
	}


	return false;
}

function popupImage(src){
	popup('<img class="img-polaroid popup-image" src="'+src+'"/>');
}

function popupVideo(src){
	popup('<iframe class="mfp-iframe" src="'+src+'?rel=0&amp;autoplay=1" frameborder="0" allowfullscreen="" width="560" height="315"></iframe>');
}

function popupAjax(url){
	sendAjax(url, {}, function(html){
		popup(html);
	}, 'html');
}

function urldecode(str) {
   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}


function initTree(container) {

}

function postDelete(elem, confirm_msg, parent, e){
    e.preventDefault();
    if (!confirm(confirm_msg)) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest(parent).fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

function init_autocomplete(el){
    $(el).autocomplete({
        serviceUrl: $(el).data('url'),
        ajaxSettings: {
            dataType: 'json',
        },
        paramName: 'tag_name',
        minLength: 3,
        transformResult: function (response) {
            return {
                suggestions: $.map(response.data, function (dataItem) {
                    return {
                        value: dataItem.name, data: {
                            id: dataItem.id,
                        }
                    };
                })
            };
        }
    });

    $(el).on('keypress', function(e){
        if(e.keyCode == 13)
        {
            $(el).closest('.input-group').find('button').trigger('click');
            return false;
        }
    });
}
$(function () {
    if($('.locales').length) {
        $('.locales').find('li:first').addClass('active');
        var default_language = $('.locales').find('a:first').attr('href').replace('#', '');
        $('.form-group-translation').addClass('hidden');
        $('[data-language=' + default_language + ']').parent('div').removeClass('hidden');

        $('.toggle_locale').click(function(e){
            e.preventDefault();

            $('.toggle_locale').parent('li').removeClass('active');
            $(this).parent('li').toggleClass('active');

            $('.form-group-translation').addClass('hidden');

            var language = $(this).attr('href').replace('#', '');
            $('[data-language=' + language + ']').closest('div.form-group').removeClass('hidden');
        });
    }

    if($('.wysiwyg').length) {
        $('.wysiwyg').redactor({
            minHeight: 200,
            replaceDivs: false,
            buttonSource: true,
            plugins: ['table', 'video', 'imagemanager', 'properties'],
            clipboardUploadUrl: '/admin/ajax/upload',
            imageUpload: '/admin/ajax/upload',
            uploadImageFields: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'folder': $('#uploadFolder').val()
            }
            // TODO: image uploading on redactor!
        });
    }

    if($('.select2').length) {
        $('.select2').select2();
    }

    if($('.slugit').length) {
        //var field = ($('#title').length) ? '#title' : '#name';
        $('.slugit').focus(function(){
            $(this).val('');
        });

        $('body').on('blur', '.sluggable', function (e) {
            var title = $(this);
            var slug = $('#' + title.data('language') + '\\[slug\\]');

            $.ajax({
                url: '/admin/ajax/slug-it',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    title: title.val()
                }
            }).done(function (response) {
                if(slug.val() == '') {
                    slug.val(response);
                }
            })
        })
    }

    $('.date').datetimepicker({
        locale: 'en',
        format: 'YYYY-MM-DD'
    });

    $('.datetime').datetimepicker({
        locale: 'en',
        sideBySide: true,
        format: 'YYYY-MM-DD HH:mm'
    });

    $('body').on('click', '.delete', function(e) {
        e.preventDefault();
        var self = $(this);

        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                self.parent('form').submit();
            }
        })
    });

    if($('.codemirror').length) {
        var myTextarea = document.getElementsByClassName('codemirror');
        var editor = CodeMirror.fromTextArea(myTextarea[0], {
            lineNumbers: true
        });
    }
});
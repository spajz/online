$(document).ready(function () {

    // Display info box
    function infoBox() {
        if ($('#info-box').length) {
            $('#info-box').slideDown('fast')
        }
    }

    infoBox();

    // Change status button
    $('body').on('click', '.change-status', function (e) {
        e.preventDefault;
        var $thisObj = $(this);
        $.ajax({
            url: baseUrlAdmin + '/change-status',
            type: 'get',
            data: {
                "model": $thisObj.data('model'),
                "id": $thisObj.data('id')
            },
            success: function (data, status) {
                $thisObj.replaceWith(data);
            },
            error: function (xhr, desc, err) {
                alert('Server error.');
            }
        });
    })

    // Boot box confirm
    var bbFunction = {};

    $('body').on('click', 'a[data-bb], input[data-bb]', function (e) {
        e.preventDefault();
        var type = $(this).data('bb');
        var thisObj = $(this);

        if (typeof bbFunction[type] === 'function') {
            bbFunction[type](thisObj);
        }
    });

    bbFunction.confirm = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                location.href = thisObj.attr('href');
            }
        });
    };

    bbFunction.submit = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $('<input>').attr({
                    type: 'hidden',
                    name: thisObj.attr('name'),
                    value: thisObj.attr('value')
                }).appendTo(thisObj.closest('form'));
                thisObj.closest('form').submit();
            }
        });
    };

    bbFunction.confirmPjax = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $.pjax({url: thisObj.attr('href'), container: '#pjax-container', timeout: 5000})
            }
        });
    };

    // Fancybox
    function initFancyBox() {
        if ($('.fancybox').length) {
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        }
    }

    initFancyBox();

    // Color picker
    function initColorPicker() {
        if ($('.color-picker').length) {
            $('.color-picker').colpick({
                layout: 'hex',
                submit: 0,
                colorScheme: 'dark',
                onChange: function (hsb, hex, rgb, el, bySetColor) {
                    // $(el).css('border-color', '#' + hex);
                    // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                    if (!bySetColor) {
                        $(el).prev().css('background-color', '#' + hex);
                        $(el).val('#' + hex);
                    }
                }
            }).keyup(function () {
                $(this).colpickSetColor(this.value);
            });

            $('.color-picker').each(function (index) {
                $(this).prev().css('background-color', $(this).val());
            })
        }
    }

    initColorPicker();

    // Image preview
    $(document).on('click', '.image-preview', function (e) {
        e.preventDefault();
        var url = $(this).data('href');
        var form = $(this).closest('form');
        $.ajax({
            type: 'put',
            url: url,
            data: form.serialize(),
            success: function (data) {
                var url = baseUrlAdmin + '/api/admin/get-image/' + data;
                $.fancybox({
                    openEffect: 'none',
                    closeEffect: 'none',
                    href: url
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Add atttribute
    $(document).on('click', '.add-attribute', function (e) {
        e.preventDefault();
        var el = $('#templates #tpl-attribute').children().clone();
        $(this).closest('.form-group').before(el);
        el.show('fast')

        initColorPicker();
    })

    // Pjax
    $.pjax.defaults.scrollTo = false;

    $(document).on('pjax:send', function () {
        $('#loader-box').show();
    })
    $(document).on('pjax:complete', function () {
        $('#loader-box').hide();
        initSelect2();
        initiCheck();
        initCKEditor();
        initFancyBox();
        initColorPicker();

        if ($('#info-box-pjax').length) {
            $('#info-box').html('');
            $('#info-box-pjax').children().detach().appendTo('#info-box');
            infoBox();
            $('#info-box-pjax').remove();
        }
    })

    $(document).on('submit', 'form[data-pjax]', function (event) {
        var btn = $(":input[type=submit]:focus");
        if (btn.data('pjax')) {
            $.pjax.submit(event, {container: '#pjax-container', timeout: 5000});
        }
    })

    $(document).on('click', 'a[data-pjax]', function (e) {
        $.pjax.click(e, {container: '#pjax-container', timeout: 5000})
    })

    // Remove button
    $('body').on('click', '.btn-remove', function (e) {
        e.preventDefault();
        $(this).closest($(this).data('remove')).hide('fast', function () {
            this.remove();
        });
    })

    // Select2
    function initSelect2() {
        $('select.select2').select2();
    }

    initSelect2();

    // iCheck
    function initiCheck() {

        var checkboxClass = 'icheckbox_flat-blue';
        var radioClass = 'iradio_flat-blue';
        $('input[class=icheck],input[type=radio]').iCheck({
            checkboxClass: checkboxClass,
            radioClass: radioClass
        });

        $("span.icon input:checkbox, th input:checkbox").on('ifChecked || ifUnchecked', function () {
            var checkedStatus = this.checked;
            var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');
            checkbox.each(function () {
                this.checked = checkedStatus;
                if (checkedStatus == this.checked) {
                    $(this).closest('.' + checkboxClass).removeClass('checked');
                }
                if (this.checked) {
                    $(this).closest('.' + checkboxClass).addClass('checked');
                }
            });
        });
    }

    initiCheck();

    // CKeditor
    function initCKEditor() {
        if ($('#editor1').length) {
            CKEDITOR.replace('editor1');
        }
    }

    initCKEditor();

    // Menu
    $('#sidebar li.submenu').each(function (index) {
        var menuItem = $(this);
        var mainUrl = $(this).children('a').attr('href');
        $('li', this).each(function (index2) {
            var href = $(this).find('a').first().attr('href');
            if ((strpos(document.URL, mainUrl + '/') !== false) || (document.URL == mainUrl)) {
                menuItem.addClass('open');
                return false;
            }
        })
    })

    function strpos(haystack, needle, offset) {
        var i = (haystack + '').indexOf(needle, (offset || 0));
        return i === -1 ? false : i;
    }

    // Tags
    $('.bootstrap-tagsinput input').focus(function () {
        $(this).attr('style', 'background-color: #f3f3f3;');
    });

})

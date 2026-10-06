/**
 * Wires the theme's "Selecionar imagem / arquivo" buttons to the WordPress
 * Media Library (wp.media). No dependencies beyond jQuery + jquery-ui-sortable.
 */
(function ($) {
    'use strict';

    function openFrame(opts) {
        return wp.media({
            title: opts.title,
            library: opts.mime ? { type: opts.mime } : {},
            button: { text: opts.button || 'Usar' },
            multiple: !!opts.multiple
        });
    }

    /* ---- single picker: select ---- */
    $(document).on('click', '.dec-media-select', function (e) {
        e.preventDefault();
        var $wrap = $(this).closest('.dec-media-picker');
        var isFile = $wrap.data('type') === 'file';
        var frame = openFrame({
            title: isFile ? 'Selecionar arquivo' : 'Selecionar imagem',
            mime: isFile ? 'application/pdf' : 'image',
            button: 'Usar este'
        });

        frame.on('select', function () {
            var att = frame.state().get('selection').first().toJSON();
            $wrap.find('.dec-media-value').val(att.id).trigger('change');

            var $preview = $wrap.find('.dec-media-preview').empty();
            if (isFile) {
                $preview.append(
                    $('<a>', { href: att.url, target: '_blank', rel: 'noopener' })
                        .text('📄 ' + (att.filename || att.url))
                );
            } else {
                var src = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
                $preview.append($('<img>', { src: src, alt: '' }));
            }
            $wrap.find('.dec-media-remove').show();
        });

        frame.open();
    });

    /* ---- single picker: remove ---- */
    $(document).on('click', '.dec-media-remove', function (e) {
        e.preventDefault();
        var $wrap = $(this).closest('.dec-media-picker');
        $wrap.find('.dec-media-value').val('').trigger('change');
        $wrap.find('.dec-media-preview').empty();
        $(this).hide();
    });

    /* ---- repeater: add (multi-select) ---- */
    $(document).on('click', '.dec-repeater-add', function (e) {
        e.preventDefault();
        var $rep = $(this).closest('.dec-repeater');
        var name = $rep.data('name');
        var frame = openFrame({
            title: 'Adicionar fotos',
            mime: 'image',
            button: 'Adicionar',
            multiple: true
        });

        frame.on('select', function () {
            var $list = $rep.find('.dec-repeater-list');
            frame.state().get('selection').toJSON().forEach(function (att) {
                var src = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
                var $li = $('<li>', { 'class': 'dec-repeater-item' });
                $li.append($('<img>', { src: src, alt: '' }));
                $li.append($('<input>', { type: 'hidden', name: name + '[]', value: att.id }));
                $li.append($('<button>', { type: 'button', 'class': 'button-link dec-repeater-remove', text: 'Remover' }));
                $list.append($li);
            });
        });

        frame.open();
    });

    /* ---- repeater: remove ---- */
    $(document).on('click', '.dec-repeater-remove', function (e) {
        e.preventDefault();
        $(this).closest('.dec-repeater-item').remove();
    });

    /* ---- repeater: drag to reorder ---- */
    $(function () {
        if ($.fn.sortable) {
            $('.dec-repeater-list').sortable({ items: '> li', cursor: 'move', tolerance: 'pointer' });
        }
    });
})(jQuery);


$(document).ajaxStart(function()
{
});
$(document).ajaxComplete(function()
{
    materialize();
});

$(window).resize(function()
{
});

$(function()
{
    /* MATERIALIZECSS */
    materialize();

    /* AJAX EN FORMULARIOS */
    $('body').on('click', 'form[data-ajax] button', function(e)
    {
        e.preventDefault();
        var form = $(this).parents('form');
        var url = form.attr('action');
        console.log(url);
        $('.url a').attr('href', url).text(url);
        var to = form.attr('data-ajax');
        var btn_name = $(this).attr('name');
        var btn_val = $(this).val();
        var post = btn_name+'='+btn_val+'&'+form.serialize();
        $.post(url, post, function(data)
        {
            $(to).html(data);
        });
    });

    /* AJAX EN ENLACES */
    $('body').on('click', 'a[data-ajax]', function(e)
    {
        e.preventDefault();
		var url = $(this).attr('href');
        console.log(url);
        $('.url a').attr('href', url).text(url);
		var to = $(this).attr('data-ajax');
        console.log([to, url]);
		$(to).text('Loading...').load(url, {'to':to, 'url':url});

        /* GO TO TAB !! */
        var tab = url.split('#')[1];
        if (tab != 'undefined')
        {
            $('ul.tabs').tabs('select_tab', tab);
        }
    });

    /* MUESTRA Y OCULTA ALGO */
    $('body').on('click', '[data-toogle]', function()
    {
        var to = $(this).data('toogle-to');
        $(to).toggle();
    });

    /* MUESTRA Y OCULTA EL ASIDE */
    $('body').on('click', '.toggle-aside', function(e)
    {
        e.preventDefault();
        var to = 'aside.'+$(this).data('aside');

        $('aside').not(to).addClass('s0').css('position', 'relative');
        $('#sidenav-overlay').hide();

        if ( $(to).hasClass('s0') )
        {
            $(to).removeClass('s0').css('position', 'absolute');
            $('#sidenav-overlay').css('z-index', 1010).show();
        }
        else
        {
            $(to).addClass('s0').css('position', 'relative');
            $('#sidenav-overlay').hide();
        }
    });
    /* OCULTA EL ASIDE PINCHANDO EN EL OVERLAY O EN UN ENLACE DEL ASIDE */
    $('body').on('click', '#sidenav-overlay, aside a', function()
    {
        $('aside').addClass('s0').css('position', 'relative');
        $('#sidenav-overlay').hide();
    });

    /* CARGA CONTENIDO EN UN MODAL Y LO ABRE */
    $('body').on('click', '.load-modal', function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        $('.modal').load(url).modal('open');
    });
});

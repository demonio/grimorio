
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

    /* MUESTRA Y OCULTA ALGO */
    $('body').on('click', '[data-toogle]', function()
    {
        var to = $(this).data('toogle');
        $(to).toggle();
    });

    /* CARGA CONTENIDO EN UN MODAL Y LO ABRE */
    $('body').on('click', '.load-modal', function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        $('.modal').load(url).modal('open');
    });

    /* BOTON PARA IR ARRIBA DEL TODO */
    $('body').on('click', '.scroll-top', function(e)
    {
        e.preventDefault();
        window.scrollTo(0, 0);
    });

    /* BOTON PARA IR A ABAJO DEL TODO */
    $('body').on('click', '.scroll-bottom', function(e)
    {
        e.preventDefault();
        window.scrollTo(0, 10000);
    });
});

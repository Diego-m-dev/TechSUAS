$(document).ready( function () {
    $('#simples').hide()
    $('#beneficio').hide()
    $('#btn_familia').click(function () {
        $('#simples').show()
        $('#beneficio').hide()
    })
    $('#btn_benef').click(function () {
        $('#beneficio').show()
        $('#simples').hide()
    })

})

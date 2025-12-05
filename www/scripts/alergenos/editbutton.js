$(document).ready(function() {
    // Ativar modo de edição
    $('.btn-edit-alergeno').click(function() {
        let id = $(this).data('id');
        $('#text-alergeno-' + id).hide();
        $('#input-alergeno-' + id).show().focus();
        $('#task-buttons-alergeno-' + id).hide();
        $('#edit-buttons-alergeno-' + id).show();
        $('#edit-alergeno-' + id).val($('#input-alergeno-' + id).val());
    });

    // Atualizar valor do input escondido ao digitar
    $('input[id^="input-alergeno-"]').on('input', function() {
        let id = $(this).attr('id').split('-')[2];
        $('#edit-alergeno-' + id).val($(this).val());
    });

    // Cancelar edição
    $('.btn-cancel-edit-alergeno').click(function() {
        let id = $(this).data('id');
        $('#input-alergeno-' + id).hide();
        $('#text-alergeno-' + id).show();
        $('#edit-buttons-alergeno-' + id).hide();
        $('#task-buttons-alergeno-' + id).show();
        $('#input-alergeno-' + id).val($('#text-alergeno-' + id).text()); // Restaura o valor original
    });
});
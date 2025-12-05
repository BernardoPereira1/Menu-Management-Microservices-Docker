$(document).ready(function() {
    // Ativar modo de edição
    $('.btn-edit-ementa').click(function() {
        let id = $(this).data('id');
        $('#text-data-' + id).hide();
        $('#input-data-' + id).show();
        $('#text-prato-' + id).hide();
        $('#input-prato-' + id).show();
        $('#task-buttons-ementa-' + id).hide();
        $('#edit-buttons-ementa-' + id).show();
        $('#edit-data-' + id).val($('#input-data-' + id).val());
        $('#edit-id-prato-' + id).val($('#input-prato-' + id).val());
    });

    // Atualizar valores dos inputs escondidos ao alterar
    $('input[id^="input-data-"]').on('input', function() {
        let id = $(this).attr('id').split('-')[2];
        $('#edit-data-' + id).val($(this).val());
    });

    $('select[id^="input-prato-"]').on('change', function() {
        let id = $(this).attr('id').split('-')[2];
        $('#edit-id-prato-' + id).val($(this).val());
    });

    // Cancelar edição
    $('.btn-cancel-edit-ementa').click(function() {
        let id = $(this).data('id');
        $('#input-data-' + id).hide();
        $('#text-data-' + id).show();
        $('#input-prato-' + id).hide();
        $('#text-prato-' + id).show();
        $('#edit-buttons-ementa-' + id).hide();
        $('#task-buttons-ementa-' + id).show();
        // Restaurar valores originais
        $('#input-data-' + id).val($('#text-data-' + id).text());
        let originalPratoId = $('#input-prato-' + id).find('option[selected]').val();
        $('#input-prato-' + id).val(originalPratoId);
    });
});
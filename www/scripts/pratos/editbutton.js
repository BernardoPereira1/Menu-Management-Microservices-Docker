$(document).ready(function() {
    $('.btn-edit-prato').click(function() {
        let id = $(this).data('id');
        $('#task-buttons-' + id).hide();
        $('#edit-buttons-' + id).show();
        $('#text-' + id).hide();
        $('#input-' + id).show();
        $('#alergenos-text-' + id).hide();
        $('#alergenos-edit-' + id).show();
    });

    $('.btn-cancel-edit').click(function() {
        let id = $(this).data('id');
        $('#task-buttons-' + id).show();
        $('#edit-buttons-' + id).hide();
        $('#text-' + id).show();
        $('#input-' + id).hide();
        $('#alergenos-text-' + id).show();
        $('#alergenos-edit-' + id).hide();
    });

    $('.btn-success').click(function(e) {
        let form = $(this).closest('form');
        let id = form.find('input[name="edit_prato_id"]').val();
        form.find('#edit-designacao-' + id).val($('#input-' + id).val());
        // Collect selected allergens
        let alergenos = [];
        $('#alergenos-edit-' + id + ' input[name="alergenos-' + id + '[]"]:checked').each(function() {
            alergenos.push($(this).val());
        });
        form.find('#edit-alergenos-' + id).val(JSON.stringify(alergenos));
    });
});
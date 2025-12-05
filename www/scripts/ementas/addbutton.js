document.addEventListener('DOMContentLoaded', function () {
    const btnShow = document.getElementById('btn-show-add-ementa-form');
    const form = document.getElementById('add-ementa-form');
    const btnCancel = document.getElementById('btn-cancel-add-ementa-form');

    if (btnShow && form && btnCancel) {
        btnShow.addEventListener('click', () => {
            form.style.display = 'block';
            btnShow.style.display = 'none';
        });

        btnCancel.addEventListener('click', () => {
            form.style.display = 'none';
            btnShow.style.display = 'inline-block';
        });
    }
});

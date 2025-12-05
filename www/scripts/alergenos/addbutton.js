// Alterando os IDs para os específicos de Alergenos
const showFormBtnAlergeno = document.getElementById("btn-show-add-alergeno-form");
const cancelBtnAlergeno = document.getElementById("btn-cancel-add-alergeno-form");
const formContainerAlergeno = document.getElementById("add-alergeno-form");

showFormBtnAlergeno.addEventListener("click", () => {
    formContainerAlergeno.style.display = "block";
    showFormBtnAlergeno.style.display = "none";  // Esconde o botão "Adicionar Alergeno"
});

cancelBtnAlergeno.addEventListener("click", () => {
    formContainerAlergeno.style.display = "none";
    showFormBtnAlergeno.style.display = "inline-block";  // Mostra o botão novamente
});
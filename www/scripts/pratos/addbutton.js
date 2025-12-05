// Alterando os IDs para os específicos de Pratos
const showFormBtnPrato = document.getElementById("btn-show-add-prato-form");
const cancelBtnPrato = document.getElementById("btn-cancel-add-prato-form");
const formContainerPrato = document.getElementById("add-prato-form");

showFormBtnPrato.addEventListener("click", () => {
    formContainerPrato.style.display = "block";
    showFormBtnPrato.style.display = "none";  // Esconde o botão "Adicionar Prato"
});

cancelBtnPrato.addEventListener("click", () => {
    formContainerPrato.style.display = "none";
    showFormBtnPrato.style.display = "inline-block";  // Mostra o botão novamente
});

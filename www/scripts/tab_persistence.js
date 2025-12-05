// Script para persistência da aba ativa
document.addEventListener('DOMContentLoaded', function() {
    // Recupera a última aba ativa do localStorage
    const lastActiveTab = localStorage.getItem('activeTab');
    if (lastActiveTab) {
        // Remove a classe active de todas as abas
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.classList.remove('active');
            tab.setAttribute('aria-selected', 'false');
        });
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });

        // Ativa a última aba selecionada
        const activeTab = document.querySelector(lastActiveTab);
        const activePane = document.querySelector(lastActiveTab.replace('tab-', ''));
        if (activeTab && activePane) {
            activeTab.classList.add('active');
            activeTab.setAttribute('aria-selected', 'true');
            activePane.classList.add('show', 'active');
        }
    }

    // Adiciona listener para salvar a aba ativa quando mudar
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
            localStorage.setItem('activeTab', '#' + this.id);
        });
    });

    // Adiciona listener para todos os formulários
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            // Salva a aba atual antes do envio do formulário
            const activeTab = document.querySelector('.nav-link.active');
            if (activeTab) {
                localStorage.setItem('activeTab', '#' + activeTab.id);
            }
        });
    });
});
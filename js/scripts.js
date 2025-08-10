document.addEventListener('DOMContentLoaded', function() {
    // Validação de formulários
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], select[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.value) {
                    valid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show mt-3';
                alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Por favor, preencha todos os campos obrigatórios.<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                form.prepend(alert);
            }
        });
    });

    // Validação de quantidade em saídas
    const saidasForm = document.querySelector('form[action="saidas.php"]');
    if (saidasForm) {
        const select = saidasForm.querySelector('select[name="item_id"]');
        const quantidadeInput = saidasForm.querySelector('input[name="quantidade"]');
        
        select.addEventListener('change', function() {
            const option = select.options[select.selectedIndex];
            const estoque = parseInt(option.text.match(/\(Estoque: (\d+)\)/)?.[1] || 0);
            quantidadeInput.max = estoque;
        });

        quantidadeInput.addEventListener('input', function() {
            const option = select.options[select.selectedIndex];
            const estoque = parseInt(option.text.match(/\(Estoque: (\d+)\)/)?.[1] || 0);
            if (quantidadeInput.value > estoque) {
                quantidadeInput.classList.add('is-invalid');
                quantidadeInput.nextElementSibling?.remove();
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = `Quantidade máxima: ${estoque}`;
                quantidadeInput.parentNode.appendChild(feedback);
            } else {
                quantidadeInput.classList.remove('is-invalid');
                quantidadeInput.nextElementSibling?.remove();
            }
        });
    }
});
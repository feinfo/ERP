document.addEventListener('DOMContentLoaded', () => {
    const cepInput = document.getElementById('cep');
  
    cepInput.addEventListener('input', () => {
      let cep = cepInput.value.replace(/\D/g, '');
      if (cep.length > 5) {
        cep = cep.slice(0, 5) + '-' + cep.slice(5, 8);
      }
      cepInput.value = cep;
    });
  
    cepInput.addEventListener('keyup', function () {
      const cep = this.value.replace(/\D/g, '');
      if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(res => res.json())
          .then(data => {
            if (data.erro) {
              document.getElementById('mensagem-erro').classList.remove('d-none');
              document.getElementById('endereco-manual').classList.remove('d-none');
              document.getElementById('endereco-info').classList.add('d-none');
            } else {
              document.getElementById('mensagem-erro').classList.add('d-none');
              document.getElementById('endereco-manual').classList.add('d-none');
              document.getElementById('endereco-info').classList.remove('d-none');
  
              document.getElementById('logradouro').textContent = data.logradouro;
              document.getElementById('bairro').textContent = data.bairro;
              document.getElementById('localidade').textContent = data.localidade;
              document.getElementById('uf').textContent = data.uf;
  
              document.getElementById('inputLogradouro').value = data.logradouro;
              document.getElementById('inputBairro').value = data.bairro;
              document.getElementById('inputLocalidade').value = data.localidade;
              document.getElementById('inputUf').value = data.uf;
            }
          });
      }
    });
  });
  
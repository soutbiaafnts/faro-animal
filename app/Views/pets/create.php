<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main_auth'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <form action="<?= url_to('pets.store') ?>" method="post" class="row mx-auto gap-2 justify-content-center">
                <div class="col-md-4">
                    <label for="specie_id" class="form-label">Espécie</label>
                    <select name="species_id" id="specie_id"  class="form-select <?= isset($invalidArgs['species_id']) ? 'is-invalid' : '' ?>">
                       <option selected value="">Selecione uma espécie</option>
   
                       <?php foreach ($species as $specie): ?>
                           <option value="<?= $specie['id'] ?>">
                               <?= $specie['name'] ?>
                           </option>
                       <?php endforeach; ?>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['species_id'] ?? '' ?>
                    </span>
                </div>
                
                <div class="col-md-4">
                    <label for="breed_id" class="form-label">Raça</label>
                    <select name="breed_id" id="breed_id"  class="form-select <?= isset($invalidArgs['breed_id']) ? 'is-invalid' : '' ?>" disabled>
                        <!-- Populado pela requisição AJAX -->
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['breed_id'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="name" class="form-label">Nome</label>
                    <input name="name" type="text" id="name" placeholder="Digite o nome do pet"
                        value="<?= old('name') ?>"
                        class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['name'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="birth_date" class="form-label">Data de nascimento</label>
                    <input name="birth_date" type="date" id="birth_date" value="<?= old('birth_date') ?>"
                        class="form-control <?= isset($invalidArgs['birth_date']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['birth_date'] ?? '' ?>
                    </span>
                </div>
                
                <div class="col-md-4">
                    <label for="weight" class="form-label">Peso</label>
                    <input name="weight" type="number" step="0.01" min="0.00" placeholder="0.01 kg" id="weight" value="<?= old('weight') ?>"
                        class="form-control <?= isset($invalidArgs['weight']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['weight'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="sex" class="form-label">Sexo</label>
                    <select name="sex" id="sex"  class="form-select <?= isset($invalidArgs['sex']) ? 'is-invalid' : '' ?>">
                        <option selected value="">Selecione o sexo</option>
                        <option value="F">Fêmea</option>
                        <option value="M">Macho</option>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['sex'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="owner_name" class="form-label">Nome do tutor</label>
                    <input name="owner_name" type="text" id="owner_name" placeholder="Digite o nome do tutor"
                        value="<?= old('name') ?>"
                        class="form-control <?= isset($invalidArgs['owner_name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['owner_name'] ?? '' ?>
                    </span>
                </div>
                
                <div class="col-md-4">
                    <label for="owner_phone" class="form-label">Contato do tutor</label>
                    <input name="owner_phone" type="text" id="owner_phone" placeholder="(00) 00000-0000"
                        value="<?= old('name') ?>"
                        class="form-control <?= isset($invalidArgs['owner_phone']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['owner_phone'] ?? '' ?>
                    </span>
                </div>
                
                <div class="w-50">
                    <label for="notes" class="form-label">Anotações</label>
                    <textarea name="notes" type="number" maxlength="1000" placeholder="Faça as anotações..." id="notes" style="height: 200px" value="<?= old('name') ?>"
                        class="form-control <?= isset($invalidArgs['notes']) ? 'is-invalid' : '' ?>"/></textarea>
                    <div class="form-text"><span id="count">0</span> / 1000 caracteres</div>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['notes'] ?? '' ?>
                    </span>
                </div>

                <div class="d-flew flex-col gap-2 mt-3 text-center">
                    <a href="<?= url_to('pets') ?>" class="btn btn-sm btn-secondary px-4">Voltar</a>
                    <button class="btn btn-sm btn-primary px-4" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // - máscara para número de telefone
    document.getElementById('owner_phone').addEventListener('input', function (event) {
      let inputValue = event.target.value.replace(/\D/g, '');
      inputValue = inputValue.substring(0, 11);

      if (inputValue.length > 10) {
        inputValue = inputValue.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
      } else if (inputValue.length > 6) {
        inputValue = inputValue.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
      } else if (inputValue.length > 2) {
        inputValue = inputValue.replace(/(\d{2})(\d{0,5})/, '($1) $2');
      }

      event.target.value = inputValue;
    });

    // - AJAX para raças da espécie selecionada
    const BASE_URL = '<?= base_url() ?>';

    document.addEventListener('DOMContentLoaded', function () {
        const specieSelect = document.getElementById('specie_id');
        const breedSelect = document.getElementById('breed_id');

        breedSelect.innerHTML = '<option>Selecione uma espécie primeiro</option>';
        
        specieSelect.addEventListener('change', function() {
            if (breedSelect.disabled == false) {
                breedSelect.disabled = true;
                breedSelect.innerHTML = '<option>Selecione uma espécie primeiro</option>';
            }

            const specieId = this.value;
            
            if (specieId != "") {
                breedSelect.innerHTML = '<option>Selecione uma raça</option>';
                
                breedSelect.disabled = false;
                
                fetch(`${BASE_URL}/breeds/specie/${specieId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const success = data.success;
                    const message = data.message;
                    const breeds = data.breeds;
                    
                    for (const breed of breeds) {
                        const option = document.createElement('option');
                        option.value = breed.id;
                        option.textContent = breed.name;
                        breedSelect.appendChild(option);
                    }
                })
                .catch (error => console.error('Erro ao carregar raças:', error));
            }
        });
    });

    // - contador de caracteres da anotação
    const textarea = document.getElementById('notes');
    const count = document.getElementById('count');
    const maxLength = textarea.getAttribute('maxLength');

    textarea.addEventListener('input', () => {
        const currentLength = textarea.value.length;

        count.textContent = currentLength;
    });
</script>

<?= $this->endSection('content'); ?>
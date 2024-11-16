// Sélectionner tous les éléments avec la classe "select-input"
const selectInputs = document.querySelectorAll('.select-input');

// Sélectionner tous les éléments avec la classe "select-options"
const selectOptionsWrappers = document.querySelectorAll('.select-options');

// Parcourir chaque élément "select-input"
selectInputs.forEach((selectInput, index) => {

  // Sélectionner toutes les options de l'élément "select-options" correspondant
  const selectOptions = Array.from(selectOptionsWrappers[index].querySelectorAll('li'));

  //pour indiquer si les options sont affichées ou non
  let isOptionsDisplayed = false;

  //pour le clic sur l'input
  selectInput.addEventListener('click', () => {
    if (!isOptionsDisplayed) {
      // Afficher les options lorsque l'input est cliqué
      selectOptions.forEach(option => {
        option.style.display = 'block';
      });
      selectOptionsWrappers[index].style.display = 'block';
      isOptionsDisplayed = true;
    } else {
      // Masquer les options lorsque l'input est cliqué à nouveau
      selectOptionsWrappers[index].style.display = 'none';
      isOptionsDisplayed = false;
    }
  });

  //filtrer les options en fonction de la valeur saisie
  selectInput.addEventListener('input', () => {
    const inputText = selectInput.value.toLowerCase();

    selectOptions.forEach(option => {
      const optionText = option.textContent.toLowerCase();

      if (optionText.includes(inputText)) {
        option.style.display = 'block';
      } else {
        option.style.display = 'none';
      }
    });

    selectOptionsWrappers[index].style.display = 'block';
  });

  //pour les options
  selectOptions.forEach(option => {
    option.addEventListener('click', (event) => {
      const selectedOption = event.target;
      const optionValue = selectedOption.dataset.value;

      // Définir la valeur de l'option sélectionnée dans l'input
      selectInput.value = optionValue;//assigne la valeur de l'attribut optionValue de l'option sélectionnée à la propriété value de l'élément selectInput. 
      selectOptionsWrappers[index].style.display = 'none';
      isOptionsDisplayed = false;

      console.log('Option sélectionnée :', optionValue);
    });
  });
});

// masquer les options lors d'un clic en dehors
document.addEventListener('click', (event) => {
  const target = event.target;//récupérer l'élément sur lequel l'événement a été déclenché
  if (!target.closest('.custom-select')) {
    selectOptionsWrappers.forEach(wrapper => {
      wrapper.style.display = 'none';
    });
  }
});

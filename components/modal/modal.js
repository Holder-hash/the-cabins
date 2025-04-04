const modalOverlay = document.getElementById('modalOverlay');
const openModalBtn = document.getElementById('openModalBtn');
const closeModalBtn = document.getElementById('closeModal');
const submitBtn = document.getElementById('submitBtn');
const phoneInput = document.getElementById('phoneInput');

function openModal() {
  modalOverlay.classList.add('active');
}

function closeModal() {
  modalOverlay.classList.remove('active');
}

closeModalBtn.addEventListener('click', closeModal);

modalOverlay.addEventListener('click', (event) => {
  if (event.target === modalOverlay) {
    closeModal();
  }
});

openModalBtn.addEventListener('click', () => {
  openModal();
});

function validatePhoneInput() {
  const digits = phoneInput.value.replace(/[^\d]/g, '');

  return /^7\d{10}$/.test(digits);
}

phoneInput.addEventListener('input', function() {

  if (!this.value.startsWith('+7')) {
    if (this.value.length > 0 && /^[0-9]$/.test(this.value[0])) {
      this.value = '+7' + this.value;
    }
  }

  if (validatePhoneInput()) {
    phoneInput.classList.remove('invalid');
  } else {
    phoneInput.classList.add('invalid');
  }
});

submitBtn.addEventListener('click', () => {

  const digits = phoneInput.value.replace(/[^\d]/g, '');
  if (!/^7\d{10}$/.test(digits)) {
    phoneInput.classList.add('invalid');
    alert('Пожалуйста, введите корректный номер телефона.');
    return;
  }

  console.log('Отправка запроса на сервер с номером: ' + digits);
  closeModal();
});
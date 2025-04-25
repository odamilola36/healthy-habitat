function roleSelectAction() {
    const roleSelectValue = document.getElementById("role").value;
    const sections = ['resident', 'business', 'council'];

    sections.forEach(section => {
        const show = roleSelectValue === section;

        document.querySelectorAll(`.${section}`).forEach(el => {
            el.classList.toggle('hidden', !show);

            el.querySelectorAll('input, select').forEach(field => {
                if (show) {
                    field.setAttribute('required', true);
                } else {
                    field.removeAttribute('required');
                }
            });
        });
    });
}

function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    const toggleButton = document.getElementById("togglePassword");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    } else {
        passwordField.type = "password";
        toggleButton.innerHTML = '<i class="fa-solid fa-eye"></i>';
    }
}

function validatePassword() {
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("re-password").value.trim();
    const message = document.getElementById("password-error");

    const strong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (password !== confirmPassword) {
        message.textContent = "Passwords do not match";
        message.style.color = "red";
    } else if (!strong.test(password)) {
        message.textContent = "Password must be at least 8 characters and include uppercase, lowercase, number, and symbol.";
        message.style.color = "red";
    } else {
        message.textContent = "Password is valid";
        message.style.color = "green";
    }
}

function isValidUKPhoneNumber(event) {
    const phone = event.target.value.trim();
    const message = document.getElementById("telephone-error");
    const ukPhoneRegex = /^(?:\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/;

    if (!ukPhoneRegex.test(phone)) {
        message.textContent = "Invalid UK phone number";
        message.style.color = "red";
    } else {
        message.textContent = "";
    }
}

function multiSelect(optionsArray) {
    return {
        open: false,
        selected: [],
        options: optionsArray,

        toggleDropdown() {
            console.log(this.selected);
            this.open = !this.open;
        },

        toggleOption(option) {
            const exists = this.selected.find(o => o.id === option.id);
            if (exists) {
                this.selected = this.selected.filter(o => o.id !== option.id);
            } else {
                this.selected.push(option);
            }
        },

        removeOption(index) {
            this.selected.splice(index, 1);
        }
    }
}


function submitForm(event) {
    event.preventDefault();
    const form = document.querySelector("#registration-form");

    const formData = new FormData(form);

    fetch('/register.php',{
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(errors => {
        ['bname', 'regnum', 'email', 'cname', 'telephone'].forEach(field => {
            const errorEl = document.getElementById(`${field}-error`);
            if (errorEl) errorEl.textContent = '';
        });
        if (errors.success) {
            window.location.href = "/login.php";
        }
        for (const key in errors.errors) {
            const errorEl = document.getElementById(`${key}-error`);
            if (errorEl) errorEl.textContent = errors.errors[key];
        }
        
    }).catch(err => {
        console.error('An error occurred:', err);
    });
}

function validateEmail(event) {
    const email = event.target.value;
    const errorEl = document.getElementById("email-error");
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        errorEl.textContent = "Invalid email address";
    } else {
        errorEl.textContent = "";
    }
}

function removeError(event) {
    const errorEl = document.getElementById(`${event.target.name}-error`);
    if (errorEl && event.target.value === '') errorEl.textContent = '';
}

function searchFilters() {
    return {
      newFilter: { key: '', value: '' },
      filters: [],
      filterOptions: {
        name: 'Name',
        benefit: 'Benefit',
        price: 'Price',
        category: 'Category',
        type: 'Type',
        quantity: 'Quantity'
      },
      addFilter() {
        if (this.newFilter.key && this.newFilter.value) {
            this.filters.push({ ...this.newFilter });
            this.newFilter = { key: '', operator: '=', value: '' };
          }
      },
      removeFilter(index) {
        this.filters.splice(index, 1);
      },
      vlaidateSearch() {
        const key = document.querySelector('[name="key1"]').value.trim();
        const value = document.querySelector('[name="value1"]').value.trim();

        if (key && value) {
            $el.submit(); // manually submit the form if valid
        }
      }
    }
  }

  function filterSearch() {
    return {
        newFilter: { key: '', value: '' },
        filters: [],
        inputType: 'text',
        allOptions: ['name', 'price'],

        get availableOptions() {
            return this.allOptions.filter(opt => !this.filters.some(f => f.key === opt));
        },

        updateInputType() {
            this.inputType = this.newFilter.key === 'price' ? 'number' : 'text';
            this.newFilter.value = '';
        },

        addFilter() {
            if (this.newFilter.key && this.newFilter.value) {
                this.filters.push({ ...this.newFilter });
                document.getElementById('search-error').innerText = '';
                this.newFilter = { key: '', value: '' };
                this.inputType = 'text';
            }
        },

        removeFilter(index) {
            this.filters.splice(index, 1);
        },

        clearFilters() {
            this.filters = [];
            document.getElementById('search-error').innerText = '';
        },

        submitForm() {
            if (this.filters.length === 0) {
                document.getElementById('search-error').innerText = 'Please add at least one filter.';
                return;
            }

            const form = document.getElementById('searchForm');
            form.querySelectorAll('.dynamic-filter').forEach(e => e.remove());

            this.filters.forEach(filter => {
                const keyInput = document.createElement('input');
                keyInput.type = 'hidden';
                keyInput.name = 'key[]';
                keyInput.value = filter.key;
                keyInput.classList.add('dynamic-filter');

                const valueInput = document.createElement('input');
                valueInput.type = 'hidden';
                valueInput.name = 'value[]';
                valueInput.value = filter.value;
                valueInput.classList.add('dynamic-filter');

                form.appendChild(keyInput);
                form.appendChild(valueInput);
            });

            form.submit();
        }
    };
}


  function validateUpload(event) {
    console.log(event);
    const fileInput = event.target;
    const filePath = fileInput.value;
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const errorEl = document.getElementById("upload-error");
    
    if (!allowedExtensions.exec(filePath)) {
        errorEl.textContent = "Invalid file type. Please upload an image.";
        fileInput.value = '';
        return false;
    } else {
        errorEl.textContent = "";
    }
    const file = fileInput.files[0];
    if (file.size > 2 * 1024 * 1024) {
        errorEl.textContent = "File size exceeds 2MB.";
        fileInput.value = '';
        return false;
    } else {
        errorEl.textContent = "";
    }
}
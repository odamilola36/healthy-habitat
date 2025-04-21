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

function checkPassword() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("re-password").value;
    const message = document.getElementById("passwordMessage");

    if (password !== confirmPassword) {
        message.textContent = "Passwords do not match";
        message.style.color = "red";
    } else {
        message.textContent = "Passwords match";
        message.style.color = "green";
    }
}

function isValidUKPhoneNumber(phone) {
    const cleaned = phone.replace(/[\s\-().]/g, '');

    const pattern = /^(?:\+44|0)7\d{9}$|^(?:\+44|0)2\d{9}$|^(?:\+44|0)1\d{9}$/;

    return pattern.test(cleaned);
}
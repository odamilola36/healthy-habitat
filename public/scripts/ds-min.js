function roleSelectAction() {
    let roleSelect = document.getElementById("role");
    let roleSelectValue = roleSelect.options[roleSelect.selectedIndex].value;
    
    if(roleSelectValue === 'resident'){
        document.querySelectorAll('.resident').forEach(input => {
            input.classList.remove('d-none');
        })
        document.querySelectorAll('.business').forEach(input => {
            input.classList.add('d-none');
        })
        document.querySelectorAll('.council').forEach(input => {
            input.classList.add('d-none');
        })
    }
    if(roleSelectValue === 'business'){
        document.querySelectorAll('.resident').forEach(input => {
            input.classList.add('d-none');
        })
        document.querySelectorAll('.business').forEach(input => {
            input.classList.remove('d-none');
        })
        document.querySelectorAll('.council').forEach(input => {
            input.classList.add('d-none');
        })
    }
    if(roleSelectValue === 'council'){
        document.querySelectorAll('.resident').forEach(input => {
            input.classList.add('d-none');
        })
        document.querySelectorAll('.business').forEach(input => {
            input.classList.add('d-none');
        })
        document.querySelectorAll('.council').forEach(input => {
            input.classList.remove('d-none');
        })
    }
}
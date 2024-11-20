
document.addEventListener('DOMContentLoaded', function () {

    const openLoginButton = document.getElementById('open-login');
    const openRegisterButton = document.getElementById('open-register');
    const deleteUserButton = document.getElementById('open-delete-profile');
    const openCreateTopicButton = document.getElementById('open-create-topic');

    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const deleteUserForm = document.getElementById('delete-profile-form');
    const createTopicForm = document.getElementById('create-topic-form');

    const closeLoginForm = document.querySelector('.close-login-form');
    const closeRegisterForm = document.querySelector('.close-register-form');
    const closeDeleteUserForm = document.querySelector('.close-delete-profile-form');
    const closeCreateTopicForm = document.querySelector('.close-create-topic-form');

    function openForm(form) {
        form.style.display = 'block';
    }

    function closeForm(form) {
        form.style.display = 'none';
    }

    openLoginButton.addEventListener('click', () => openForm(loginForm));
    closeLoginForm.addEventListener('click', () => closeForm(loginForm));

    openRegisterButton.addEventListener('click', () => openForm(registerForm));
    closeRegisterForm.addEventListener('click', () => closeForm(registerForm));

    deleteUserButton.addEventListener('click', () => openForm(deleteUserForm));
    closeDeleteUserForm.addEventListener('click', () => closeForm(deleteUserForm));

    openCreateTopicButton.addEventListener('click', () => openForm(createTopicForm));
    closeCreateTopicForm.addEventListener('click', () => closeForm(createTopicForm));

    // Валидация форм
    const form1 = document.getElementById('myForm1');
    const form2 = document.getElementById('myForm2');
    const form3 = document.getElementById('myForm3');
    const inputs1 = form1.querySelectorAll('input');
    const inputs2 = form2.querySelectorAll('input');
    const inputs3 = form3.querySelectorAll('input');

    function checkInput(input) {
        if (input.value.trim() === '') {
            input.classList.add('invalid');
        } else {
            input.classList.remove('invalid');
        }
    }

    inputs1.forEach(input => {
        input.addEventListener('input', () => checkInput(input));
    });

    inputs2.forEach(input => {
        input.addEventListener('input', () => checkInput(input));
    });

    inputs3.forEach(input => {
        input.addEventListener('input', () => checkInput(input));
    });

    form1.addEventListener('submit', (event) => {
        const isValid = [...inputs1].every(input => input.value.trim() !== '');

        if (!isValid) {
            event.preventDefault();
            alert('Пожалуйста, заполните все обязательные поля.');
        }
    });

    form2.addEventListener('submit', (event) => {
        const isValid = [...inputs2].every(input => input.value.trim() !== '');

        if (!isValid) {
            event.preventDefault();
            alert('Пожалуйста, заполните все обязательные поля.');
        }
    });

    form3.addEventListener('submit', (event) => {
        const isValid = [...inputs3].every(input => input.value.trim() !== '');
        if (!isValid) {
            event.preventDefault();
            alert('Пожалуйста, заполните все обязательные поля.');
        }
    });

    // Отправка формы для создания темы
    const createTopicFormData = document.getElementById('create-topic-form-data');

    createTopicFormData.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('create_topic.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeForm(createTopicForm);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка при отправке формы:', error);
                alert('Произошла ошибка. Попробуйте снова.');
            });
    });
});



// ......
window.addEventListener('logout', function () {
            fetch('check_auth.php') 
                .then(response => response.json())
                .then(data => {
                    if (data.auth) {
                 
                        document.getElementById('open-login').classList.add('hidden');
                        document.getElementById('open-register').classList.add('hidden');
                        document.getElementById('open-create-topic').classList.remove('hidden');
                        document.getElementById('logout').classList.remove('hidden');

                    } else {
                 
                        document.getElementById('open-login').classList.remove('hidden');
                        document.getElementById('open-register').classList.remove('hidden');
                        document.getElementById('open-create-topic').classList.add('hidden');
                        document.getElementById('logout').classList.add('hidden');
                    }
                });
});
        

// Удаление

deleteUserForm.addEventListener('submit', function (event) {
    event.preventDefault(); 


    const formData = new FormData(this);

    fetch('delete_profile.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
         
            if (response.ok) {
     
                window.location.href = '/index.php'; 
            } else {
          
                response.text().then(errorMessage => {
                    alert('Ошибка: ' + errorMessage);
                });
            }
        })
        .catch(error => {
       
            console.error('Ошибка сети:', error);
            alert('Ошибка при удалении аккаунта. Попробуйте позже.');
        });
});



<!DOCTYPE html>
   <html>
   <head>
       <title>{{ title }}</title>
      
       <link rel="stylesheet" href="css/main.css">
       
   </head>
   <body>
       <header>
    
             <h1 class="logo">
    <span>В</span><span>С</span><span>Е</span> <span>О</span><span>Б</span><span>О</span> <span>В</span><span>С</span><span>Е</span><span>М</span>
  </h1>
           <nav>
    <ul>
        <li><a href="/">Главная</a></li>
       
        <li id="open-create-topic"><a href="#">Создать тему</a></li>
      
        <li class="hidden"><a href="#" id="open-login">Вход</a></li>
        <li class="hidden"><a href="#" id="open-register">Регистрация</a></li>

        
    </ul>
 
</nav>
        <div id="profile-container">
           {{ profile }} 
       </div>  
       </header>

       <main>
           {{ content }}        
       </main>
       
<!-- для входа -->
       <div id="login-form" class="modal" style="display: none;"> 
           <form method="POST" action="login.php" id="myForm1">
               <input type="text" name="login" placeholder="Логин">
               <input type="password" name="password" placeholder="Пароль">
               <button type="submit">Войти</button>
           </form>
           <span class="close-login-form">&times;</span>
       </div>
<!-- для регистрации -->
       <div id="register-form" class="modal" style="display: none;"> 
           <form method="POST" action="reg.php" id="myForm2">
               <input type="text" name="login" placeholder="Логин">
               <input type="email" name="email" placeholder="e-mail">
               <input type="password" name="password" placeholder="Пароль">
               <button type="submit">Зарегистрироваться</button>
           </form>
           <span class="close-register-form">&times;</span> 
       </div>

       <!-- для удаления -->

       <div id="delete-profile-form" class="modal" style="display: none;">
               <h2>Вы действительно хотите удалить свой профиль?</h2>
           <form method="POST" action="delete_profile.php" id="myForm3">
               <input type="text" name="login" placeholder="Логин">
               <input type="password" name="password" placeholder="Пароль">
               <input type="hidden" name="confirm_delete" value="1"> 
               <button type="submit">Удалить</button>
            </form>
          
           <span class="close-delete-profile-form">&times;</span>
       </div>

<!-- для создания темы -->
 
  

      <div id="create-topic-form" class="modal" style="display: none;">
        <form method="POST" action="create_topic.php" id="create-topic-form-data" class="form-container">
            <h2>Создать тему</h2>
            <label for="title">Название:</label>
            <input type="text" name="title" id="title" required>

            <label for="content">Содержание:</label>
            <textarea type="text" name="content" id="content" rows="10" required></textarea>

            <button type="submit">Создать</button>
        </form>
        <span class="close-create-topic-form">&times;</span>
    </div>

    <!-- для комментариев -->

        <form id='reply-form' method='POST' action='reply.php' style="display: none;">
        <textarea name='content' placeholder='Напишите комментарий'></textarea>
        <input type='hidden' name='topic_id' value="1">
        <button type='submit'>Отправить</button>
    </form>

    <script>
        function showReplyForm(topicId) {
            document.getElementById('reply-form').style.display = 'block';
        }


        
    </script>
       <footer>
           <p>© 2024 Мой Форум</p>
       </footer>

       <script src="js/script.js"></script> 
   </body>
   </html>

   
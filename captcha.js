(function()
{
   
   grecaptcha.ready(function() {
    grecaptcha.execute('6LfyKL0UAAAAABuYBtOXDP-6X_wYDT6mbrXWTUuT'
     , {action: 'contact'}).then(function(token) {
       document.getElementById('recaptcha_token').value = token;
      
    });
});


})();
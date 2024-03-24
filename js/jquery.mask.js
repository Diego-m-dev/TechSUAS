document.addEventListener("DOMContentLoaded", function () {
     var cpfInput = document.getElementById("cpf");
     var telefoneInput = document.getElementById("telefone");
 
     // Aplicar máscara para CPF
     VMasker(cpfInput).maskPattern("999.999.999-99");
 
     // Aplicar máscara para telefone
     VMasker(telefoneInput).maskPattern("(99) 9 9999-9999");
 });
 
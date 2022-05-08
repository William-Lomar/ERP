$(function(){
  $('[formato=data]').mask('99/99/9999'); //plugin de formatos = só colocar na div 
  //exemplo <input type="text" name="user" formato = data>

  $('[botaoAcao=delete]').click(function(){
      var txt;
      var r = confirm("Deseja excluir o registro?");
      if (r == true) {
          return true;
      } else {
          return false;
      }
  })

  $('[botaoAcao=finalizar]').click(function(){
      var txt;
      var r = confirm("Deseja finalizar o registro?");
      if (r == true) {
          return true;
      } else {
          return false;
      }
  })

  $(document).ready(function() {
    $('.select2').select2();
  });

  $(".menuOpcoes").click(function(event) {
    /* Act on the event */
    $('.opcoes').fadeToggle(1000);
  });
})



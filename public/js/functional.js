
function unsavedChanges(selector) {
  var formObject = $(selector);
  formObject.data('original_serialized_form', formObject.serialize());
 
  $(':submit').click(function() {
    window.onbeforeunload = null;
  });
 
  window.onbeforeunload = function() {
    if (formObject.data('original_serialized_form') !== formObject.serialize()) {
      return "As mudanças deste formulário não foram salvas. Saindo desta página, todas as mudanças serão perdidas.";
    }
  };
}


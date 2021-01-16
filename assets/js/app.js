import '../css/global.scss';

const $ = require('jquery');

global.$ = global.jQuery = $;

require('bootstrap');
require('bootstrap-datepicker');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.es');

$(document).ready(function(){
  $('.js-datepicker').datepicker({
      format: 'dd-mm-yyyy',
      language: 'es'
  });

  $('form[name=appbundle_human]').submit(function(event){
      event.preventDefault();
      let form = $(this);
      let url = form.attr('action');
      let data = form.serialize();

      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response){
          let option = $('<option>');

          option.attr('value', response.id);
          option.attr('selected', true);
          option.text(response.rut);

          $('#appbundle_pet_human').find('option').attr('selected', false);
          $('#appbundle_pet_human').append(option);
          $('#newHumanModal').modal('hide');

          form.reset();
        },
        error: function(response){
          let errors = Object.entries(response.responseJSON);
          for (var i = 0; i < errors.length; i++) {
            let path = 'appbundle_human_' + errors[i][0];
            let message = errors[i][1];

            $('#'+path).parent()[0].append(message);
          }
        }
        // dataType: dataType
      });

  });
})

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
})

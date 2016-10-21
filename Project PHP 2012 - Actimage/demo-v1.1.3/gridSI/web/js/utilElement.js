
/**
 * Permet de cacher un element lorsqu'on clique
 * @param selector string de selector JQuery
 */
function hideOnClick(selector) {
  $(document).ready(function() {
    $(selector).mouseover(function () {
      $(this).css('cursor', 'pointer');
    });
    $(selector).click(function() {
      $(this).hide('slow');
    });
  });
}


var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;
var ddspanitem = 0;

function jsddm_open() {
  jsddm_canceltimer();
  jsddm_close();
  ddmenuitem = $(this).find('ul').show();
  ddspanitem = $(this).find('span').hide();
}

function jsddm_close() {
  if(ddmenuitem) {
    ddmenuitem.hide();
    ddspanitem.show();
  }

}

function jsddm_timer()
{closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer() {
  if(closetimer) {
    window.clearTimeout(closetimer);
    closetimer = null;
  }
}

$(document).ready(function() {
  $('.actions').each(function() {
    $(this).addClass("width_125");
    var toMove = $(this).children().children(':gt(2):not(:last)');
    var destination = $(this).children().children(':last');
    toMove.appendTo(destination.find('ul'));
    destination.find('span').show();

    destination.find('ul').hide();

  });

  $('.jsddm > li').bind('mouseover', jsddm_open);
  $('.jsddm > li').bind('mouseout',  jsddm_timer);
});

document.onclick = jsddm_close;

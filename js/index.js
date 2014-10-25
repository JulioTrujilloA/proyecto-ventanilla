//var ajax = new XMLHttpRequest();
$('a.admin').bind('click', function(e) {           
  var url = $(this).attr('href');
  $('#h2').remove();
  $('#bienvcuerpo').remove();  
  $('div#nuevo').load(url); // load the html response into a DOM element
  e.preventDefault(); // stop the browser from following the link
});

$('a.soli').bind('click', function(e) {           
  var url = $(this).attr('href');
  $('#h2').remove();
  $('#bienvcuerpo').remove();  
  $('div#nuevo').load(url); // load the html response into a DOM element
  e.preventDefault(); // stop the browser from following the link
});

$('a.alum').bind('click', function(e) {           
  var url = $(this).attr('href');
  $('#h2').remove();
  $('#bienvcuerpo').remove();
  $('div#nuevo').load(url); // load the html response into a DOM element
  e.preventDefault(); // stop the browser from following the link
});


$('a.tadmin').bind('click', function(e) {           
  var url = $(this).attr('href');
  $('#h2').remove();
  $('#bienvcuerpo').remove();
  $('div#bod').load(url); // load the html response into a DOM element
  e.preventDefault(); // stop the browser from following the link
});

$('#buscaAlum').bind('keypress', function(e) {           
  var url = $(this);
  $('div#bod').load(url, function(resp) {
	  tabla= $('#tabla_alumnos');
      tablaHTML = tabla.html();
      head = $('thead', tabla).clone();
  }); // load the html response into a DOM element
  e.preventDefault(); // stop the browser from following the link
});
//*/

$(function() {
tabla = false;
tablaHTML = false;
head = false;
    $('#bod').on('keyup', '#buscaAlum', function(e) {
        var txt   = $(this).val();
        if (txt != '') {
            $('thead', tabla).remove();
            var filas = $('tr:contains('+txt+')', tabla);
            if (filas.size() == 0) {
                $('#tabla_alumnos').html('').html('<table><tr><th>Sin coincidencias</th></tr></table>');
            } else {
                $('#tabla_alumnos').html('').append( $('<table />').append(head, $('<tbody />').append(filas)));
            }
        } else {
            $('#tabla_alumnos').html(tablaHTML);
        }
    });
	
});

$('a.tsoli').bind('click', function(e) {           
  var url = $(this).attr('href');
  $('#bienvcuerpo').remove();
  $('#h2').remove();
  $('#bod').load(url, function(resp){
	  tablaS= $('#tabla_solicitudes');
      tablaHTMLS = tablaS.html();
      headS = $('thead', tablaS).clone();
  }); // load the html response into a DOM element
  e.preventDefault(); // stop the browser from following the link
});

$(function() {
tablaS = false;
tablaHTMLS = false;
headS = false;
    $('#bod').on('keyup', '#buscaSoli', function(e) {
        var txtS   = $(this).val();
        if (txtS != '') {
            $('thead', tablaS).remove();
            var filasS = $('tr:contains('+txtS+')', tablaS);
            if (filasS.size() == 0) {
                $('#tabla_solicitudes').html('').html('<table><tr><th>Sin coincidencias</th></tr></table>');
            } else {
                $('#tabla_solicitudes').html('').append( $('<table />').append(headS, $('<tbody />').append(filasS)));
            }
        } else {
            $('#tabla_solicitudes').html(tablaHTMLS);
        }
    });
	
});

$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});
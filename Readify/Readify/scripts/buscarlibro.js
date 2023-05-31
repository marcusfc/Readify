/**
 * @author abel i marc
 */
function buscarLibro() {
  var searchTerm = document.getElementById('search-input').value;
  
  $.ajax({
    url: '../model/buscarlibro.php',
    type: 'POST',
    dataType: 'json',
    data: { search: searchTerm },
    /**
     * 
     * @param {*} books per obtenir llibre
     */
    success: function(books) {
      if (books.length > 0) {
        var bookId = books[0].id; // Obtener el ID del primer libro encontrado
        cargarVentanaDetalle(bookId);
      } else {
        alert('No se encontraron resultados.');
      }
    },
    error: function() {
      alert('Error en la búsqueda del libro.');
    }
  });
}
/**
 * 
 * @param {*} id El ID que s'utilizarà en la URL de redirecció.
 */
function cargarVentanaDetalle(id) {
  window.location.href = '../view/ventanadetalle.php?id=' + id;
}

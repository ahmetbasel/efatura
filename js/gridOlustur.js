 function gridbas(tabloadi,sayfaadi,parameter){
	var table_companies = $('#'+tabloadi).dataTable({
    "ajax": sayfaadi+"?job=get_companies",
    "columns": parameter,
    "aoColumnDefs": [
      { "bSortable": true, "aTargets": [-1] }
    ],
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "oLanguage": {
      "oPaginate": {
        "sFirst":       " ",
        "sPrevious":    " ",
        "sNext":        " ",
        "sLast":        " ",
      },
      "sLengthMenu":    "Gösterilecek Kayıt Sayısı: _MENU_",
      "sInfo":          "Toplam Kayıt Sayısı _TOTAL_ ",
      "sInfoFiltered":  "(filtered from _MAX_ total records)"
    }
  });
}
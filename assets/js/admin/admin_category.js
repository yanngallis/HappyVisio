import '/assets/js/admin/custom/plugins/jquery.richtext.js'
import '/assets/js/admin/custom/plugins/wysiwyag.js'
import 'datatables.net';
import 'datatables.net-dt';

$(function () {
    $('#category_datatable').DataTable({
        responsive: true,
        language: {
            url: '/assets/i18n/datatables.fr_FR.json'
        }
    });
});
import 'datatables.net';
import 'datatables.net-dt';

$(function () {
    $('#coupon_datatable').DataTable({
        responsive: true,
        language: {
            url: '/assets/i18n/datatables.fr_FR.json'
        }
    });
});
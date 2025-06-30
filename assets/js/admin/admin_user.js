import '/assets/js/admin/custom/sparkline.js'
import '/assets/js/admin/custom/plugins/jquery.richtext.js'
import '/assets/js/admin/custom/plugins/wysiwyag.js'
import 'datatables.net';
import 'datatables.net-dt';
import swal from 'sweetalert';

$(function () {
    $('.user_datatable').DataTable({
        responsive: true,
        language: {
            url: '/assets/i18n/datatables.fr_FR.json'
        }
    });

    $('#usersExportAll').click(function () {
        $("#global-loader").fadeIn("slow");
        $.ajax({
            url: exportAllRoute,
            success: function(data) {
                $("#global-loader").fadeOut("slow");
                location.href = exportAllRoute;
                swal(exportOkTitle, exportOkText, "success", {
                    buttons: false,
                    timer: 3000,
                })
            },
            error: function() {
                $("#global-loader").fadeOut("slow");
                swal(exportKoTitle, exportKoText, "error", {})
            },
        });
    });
});
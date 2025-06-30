import '/assets/js/admin/custom/plugins/jquery.richtext.js'
import '/assets/js/admin/custom/plugins/wysiwyag.js'
import '/assets/js/admin/custom/cropper-image.js'
import { CustomCropperJs } from './custom/cropper-image'
import 'datatables.net';
import 'datatables.net-dt';

$(function () {
    let cropper = new CustomCropperJs(
        450,
        300,
        'partner',
        "#partnerImage"
    );

    cropper.init();

    $('#partner_datatable').DataTable({
        responsive: true,
        language: {
            url: '/assets/i18n/datatables.fr_FR.json'
        }
    });
});
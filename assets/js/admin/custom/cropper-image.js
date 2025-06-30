import Cropper from 'cropperjs';

export class CustomCropperJs {
    constructor(
        width,
        height,
        formToRender = '',
        imageToRender = '',
        dragMode = 'move',
        viewMode = 2,
        responsive = false,
        cropBoxMovable = true,
        cropBoxResizable = false
    ) {
        this.height = height;
        this.width = width;
        this.aspectRatio = width / height;
        this.formToRender = 'form[name="' + formToRender + '"]';
        this.imageToRender = imageToRender;
        this.dragMode = dragMode;
        this.viewMode = viewMode;
        this.responsive = responsive;
        this.cropBoxMovable = cropBoxMovable;
        this.cropBoxResizable = cropBoxResizable;
    }

    init() {
        let self = this;
        let imageCropperModal = $('#imageCropperModal');
        let cropperImage = $('#cropperImage');
        let cropper;

        $('.imageCropper').change(function() {
            if (this.files && this.files.length > 0) {
                if (this.files[0].type.match(/^image\//)) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        cropperImage.attr('src', reader.result);
                        imageCropperModal.modal('show');
                    };

                    reader.readAsDataURL(this.files[0]);
                } else {
                    // TODO: Afficher une erreur sur le type de fichier
                }
            } else {
                // TODO: Afficher une erreur sur l'absence de fichier
            }
        });

        imageCropperModal
            .on('shown.bs.modal', function() {
                cropper = new Cropper(cropperImage[0], {
                    aspectRatio: self.aspectRatio,
                    dragMode: self.dragMode,
                    viewMode: self.viewMode,
                    responsive: self.responsive,
                    cropBoxMovable: self.cropBoxMovable,
                    cropBoxResizable: self.cropBoxResizable,
                    minCropBoxWidth: self.width,
                    minCropBoxHeight: self.height
                })
            })
            .on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            })
        ;

        $('#imageCropperZoomPlus').click(function() {
            cropper.zoom(0.1);
        });

        $('#imageCropperZoomMinus').click(function() {
            cropper.zoom(-0.1);
        });

        $('#crop').click(function() {
            let canvas = cropper.getCroppedCanvas({
                width: self.width,
                height: self.height
            });

            canvas.toBlob(function(blob) {
                let reader = new FileReader();

                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    let base64data = reader.result;
                    let render = $(self.imageToRender);
                    let form = $(self.formToRender);

                    render.attr('src', base64data);
                    render.removeClass('d-none');
                    form.append('<input type="hidden" value="' + base64data + '" ' + 'name="base64image" />');

                    imageCropperModal.modal('hide');
                }
            });
        });
    }
}
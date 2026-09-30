function readURL(input,a,i) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#preview-${a}${i}`)
                .attr('src', e.target.result);
            $(`#multi-selected-image-${a}${i}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}
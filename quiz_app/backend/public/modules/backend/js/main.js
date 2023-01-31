$(document).ready(function () {
    function readURL(input, element) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                element.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            element.attr('src', '/images/not-available.jpg');
        }
    }


    $('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Ooops, something wrong appended.'
        },
        error: {
            'fileSize': 'The file size is too big (2M max).'
        }
    });


    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $('.go-back').on('click', function () {
        history.back();
    });

    $('.btn-remove-item').on('click', function () {
        return confirm('Bạn muốn xóa dữ liệu này?');
    });
});

function showLoading() {
    $('body').loadingModal({
        position: 'auto',
        text: '',
        color: '#fff',
        opacity: '0.7',
        backgroundColor: 'rgb(0,0,0)',
        // animation: 'fadingCircle'
        animation: 'wave'
    });
}

function hideLoading() {
    $('body').loadingModal('destroy');

}

$("form").on('submit', function () {
    showLoading();
    // $('.loading-modal-before-submit').removeClass('hide');
});

$('.datepicker').datepicker({
    todayHighlight: true,
    autoclose: true,
    format: "d/m/yyyy",
    language: "vi"
});

function formatPrice(num) {
    num = num.replace(/[^0-9]/g, '');
    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if (str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for (var j = 0, len = str.length; j < len; j++) {
        if (str[j] != ",") {
            output.push(str[j]);
            if (i % 3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return (formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};



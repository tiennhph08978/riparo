var expanded = false;

function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        $('.selectBoxCustom').addClass('form-active')
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        $('.selectBoxCustom').removeClass('form-active')
        expanded = false;
    }
}
function hideCheckboxes() {
    $('#checkboxes').hide();
    expanded = false;
}
$('.form-checkbox-custom').on('click', function () {
    $(this).children('input.first').trigger('click')
})

document.addEventListener('mouseup', function(e) {
    var checkboxIndustry = document.getElementById('checkbox-industry');
    var checkbox = document.getElementById('checkboxes');
    if (!checkboxIndustry.contains(e.target)) {
        checkbox.style.display = 'none';
        $('.selectBoxCustom').removeClass('form-active')
        expanded = false;
    }
});

$(document).ready(function() {
    let template = $('#defaultRow').html();
    $('#addRowDefault').click(function() {
        $('#targetTable').append(template);
        changeCount()
    });
    $('.submit-form-data').click(function(e) {
        e.preventDefault()
        $(this).prop('disabled', true)
        $('#form-project').submit()
    });
    $(document).on('click', '.input-date', function(){
        $(this).datepicker({
            dateFormat: "yy年mm月dd日"
        }).focus();
        $(this).removeClass('input-date');
    });
    $(document).on('focus', 'input', function(){
        $(this).siblings('span').css('display', 'none')
        $(this).removeClass('input-invalid')
    });
    $(document).on('focus', 'textarea', function(){
        $(this).siblings('span').css('display', 'none')
        $(this).removeClass('input-invalid')
    });
    $('.selectBoxCustom').click(function () {
        $(this).siblings('span').css('display', 'none')
        $(this).removeClass('input-invalid')
    })
    $('.input-checkbox-custom').on('change', function(e) {
        checkTextIndustries()
    });
    checkTextIndustries()
    function checkTextIndustries() {
        let checked = $('.input-checkbox-custom:checked')
        if (checked.length) {
            var titles = $('.input-checkbox-custom:checked').map(function(idx, elem) {
                return $(elem).data().label;
            }).get();
            $('#option-selected').html(titles.join('、'))
            $('#select-industry').val('select')
            $('#select-industry').addClass('selected')
            $('#select-industry').removeClass('non-select')
        } else {
            $('#select-industry').val('non-select')
            $('#select-industry').addClass('non-select')
            $('#select-industry').removeClass('selected')
        }
    }
    $('.input-checkbox-custom').change(function () {
        checkboxCustom()
    })
    checkboxCustom()
    function checkboxCustom() {
        if ($('.input-checkbox-custom:checked').length >= 3) {
            $('.input-checkbox-custom').attr('disabled', true)
            $('.input-checkbox-custom:checked').removeAttr('disabled')
        } else {
            $('.input-checkbox-custom').removeAttr('disabled')
        }
    }
});

function removeRow(e) {
    e.parentElement.parentElement.parentElement.parentElement.remove();
    changeCount()
}
changeCount()

function changeCount() {
    let count = 1
    $('.candidate-number').each(function(e) {
        $(this).html(count)
        count++
    })
    if (count === 2) {
        $('.img-date-work').hide()
    } else {
        $('.img-date-work').show()
    }
    if (count >= 4) {
        $('#addRowDefault').hide()
    } else {
        $('#addRowDefault').show()
    }
}

$(".number_share").keydown(function(event) {
    if (event.ctrlKey) {
        return;
    }
    if (!([46, 8, 37, 38, 39, 40].includes(event.keyCode))) {
        if (!((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode > 95 && event.keyCode < 106))) {
            event.preventDefault();
            return;
        }
        if ($(this).val().length >= 3) {
            event.preventDefault();
            return;
        }
        if ($(this).attr('name') === 'recruitment_number') {
            if (Number($(this).val() + '' + event.target.value) > 100) {
                event.preventDefault();
                $(this).val(100)
                $(this).change()
            }
        }
        if (['recruitment_quantity_min', 'recruitment_quantity_max'].includes($(this).attr('name'))) {
            if (Number($(this).val() + '' + event.target.value) > 50) {
                event.preventDefault();
                $(this).val(50)
                $(this).change()
            }
        }
    }
});

$('.format_number').mask('000,000,000,000', {
    reverse: true,
});

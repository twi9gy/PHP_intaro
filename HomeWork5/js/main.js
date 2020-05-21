/////////////////////////////
// Form_Send Handler

$(document).ready(function() {
    $('#form_send').submit(function(e) {
        e.preventDefault();
        // Если все поля валидны, то используем post запрос
        if (Validate()) {
            $.ajax({
                type: "POST",
                url: 'send_massege.php',
                data: $(this).serialize(),
                success: function(response)
                {
                    var jsonData = JSON.parse(response);
                    if(jsonData.success == "1"){
                        $('#content').html(jsonData.block);
                    }
                    else{
                        alert(jsonData.text);
                    }
                }
            });
        }
    });
});

/////////////////////////////
// Valid Handler

$(document).ready(function() {
    $('#form_send').find($('input')).each(function () {
        $(this).on('input',function(){
            if ($(this).val().length > 0) {
                var error = $(this).next();
                $(error).text("");
                $(error).removeClass("error_active");
            }
        });
    });

    $('#form_send').find($('textarea')).on('input', function () {
        if ($(this).text().length == 0) {
            var error = $(this).next();
            $(error).text("");
            $(error).removeClass("error_active");
        }
    });
});

function Validate() {
    // проверка на пустоту
    var count = 0; //если count == 0, то все поля заполнены
    $('#form_send').find($('input')).each(function () {
        if ($(this).val().length == 0) {
            var error = $(this).next();
            $(error).text("Заполните поле");
            $(error).addClass("error_active");
            count = count + 1;
        }
    });

    var text = $('#form_send').find($('textarea'));
    if ($(text).val().length == 0) {
        var error = $(text).next();
        $(error).text("Заполните область для комментария");
        $(error).addClass("error_active");
        count = count + 1;
    }
    // проверка ФИО
    if(count == 0) {
        var fullname = $('#form_send').find($('input[name=fullname]'));
        var pattern = new RegExp("[а-яА-Я]+ [а-яА-Я]+ [а-яА-Я]+");
        if (!pattern.test($(fullname).val())) {
            var error = $(fullname).next();
            $(error).text("Некорректное ФИО");
            $(error).addClass("error_active");
            count = count + 1;
        }
    }
    // проверка почты
    if(count == 0) {
        var email = $('#form_send').find($('input[name=email]'));
        var pattern = new RegExp( "\@[A-Za-z]+\.[A-Za-z]{2,4}");
        if (!pattern.test($(email).val())) {
            var error = $(email).next();
            $(error).text("Некорректный email");
            $(error).addClass("error_active");
            count = count + 1;
        }
    }
    // проверка телефона
    if(count == 0) {
        var phone = $('#form_send').find($('input[name=phone]'));
        var pattern = new RegExp("^((8|\\+7)[\\- ]?)?(\\(?\\d{3}\\)?[\\- ]?)?[\\d\\- ]{7,10}$");
        if (!pattern.test($(phone).val())) {
            var error = $(phone).next();
            $(error).text("Некорректный телефон");
            $(error).addClass("error_active");
            count = count + 1;
        }
    }

    if(count == 0)
        return true;
    else
        return false;
}

/////////////////////////////

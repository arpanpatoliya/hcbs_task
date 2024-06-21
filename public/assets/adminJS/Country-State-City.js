const base_url = $("#base_url").val();
$('#country_dropdown').select2({
    dropdownCssClass: 'custom-z-index'
}).on('change', function () {
    $('#state_dropdown').empty();
    $('#city_dropdown').empty();
    // console.log(stateByCountryRoute);
    var state_html = `<option value="">Select County</option>`;
    $('#state_dropdown').html(state_html);
    var city_html = `<option value="">Select City</option>`;
    $('#city_dropdown').html(city_html);
    var url = stateByCountryRoute + `/` + $(this).val()
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status) {
                var html = '<option>Select County</option>';
                var html2 = '<option>Select City</option>';
                for (let i = 0; i < response.data.length; i++) {
                    html += `<option value="` + response.data[i].id + `">` + response.data[i].name + `</option>`
                }
                $('#state_dropdown').html(html);
                $('#city_dropdown').html(html2);
            }
        }
    });
});
$('#state_dropdown').select2({
    dropdownCssClass: 'custom-z-index'
}).on('change', function () {
    $('#city_dropdown').empty();
    var city_html = `<option value="">Select City</option>`;
    $('#city_dropdown').html(city_html);
    var url = cityByState + `/` + $(this).val();
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            county_id: $('#country_dropdown').val()
        },
        success: function (response) {
            if (response.status) {
                var html = '<option>Select City</option>';
                for (let i = 0; i < response.data.length; i++) {
                    html += `<option value="` + response.data[i].id + `">` + response.data[i].name + `</option>`
                }
                $('#city_dropdown').html(html);
            }
        }
    });
});
$('#city_dropdown').select2({
    dropdownCssClass: 'custom-z-index'
});

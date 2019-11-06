// service buy
function activateServer(i, service) {
    if(document.getElementById(i).style.border == 'none') {

        // reset current info
        deleteActiveServerBorder();
        toggleValuSelection(false);

        // prepare new info
        changePaymentDetails(i);
        togglePaymentCollapse(true, service);
        document.getElementById(i).style.border='6px solid #1a75ff';

        // Go to the botom of page
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    }
    else {
        togglePaymentCollapse(false);
        toggleValuSelection(false);
        document.getElementById(i).style.border='none';
    }
}

function deleteActiveServerBorder() {
    $( "div[id^='server_']" ).css( "border", "none" );
}

function changePaymentDetails(i){
    document.getElementById("server_name").setAttribute('value', i.replace('server_', ''));
}

// show/hide payments options
function togglePaymentCollapse(on = false, service = null) {
    if(on)
        GetPaymentTypeAccesiblity(service);
    else
        $('#collapsePaymentMethod').removeClass('show');
}

// show/hide value selection
function toggleValuSelection(on = false) {
    if(on)
        $('#collapseValueSelection').addClass('show');
    else
        $('#collapseValueSelection').removeClass('show');
}

// show/hide payment info modal
function togglePaymentInfo(on = false) {
    if(on)
        $('#payment_info').modal('show');
    else
        $('#payment_info').modal('hide');
}

function addToSelect(id, value, display, selected = false, disabled = false) {
    let select = document.getElementById(id);
    let option = document.createElement( 'option' );

    option.value = value;
    option.text = display;
    option.disabled = disabled;
    option.selected = selected;
    select.add( option );
}

function clearSelect(id)
{
    var i;
    var selectbox = document.getElementById(id);
    for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
    {
        selectbox.remove(i);
    }
    addToSelect(id, 0, '-- Wybierz --', true, true);
}

// Load prices values for service
function GetPaymentTypeAccesiblity(service){
    // collapse current values
    $('#collapsePaymentMethod').removeClass('show');

    // show loader
    $("#ajax_loader").show();

    $.ajax({
        url:        '/api/get/payments/' + service + '/' + document.getElementById('server_name').getAttribute('value') + '/',
        type:       'POST',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();

            $('#sms_type').html('');
            $('#psc_type').html('');
            $('#transfer_type').html('');
            $('#wallet_type').html('');

            var sms = $('<div class="card d-flex flex-row mb-4">' +
                '       <a class="d-flex" href="#">' +
                '           <img alt="sms" src="/img/payment-icons/sms.png" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">' +
                '       </a>' +
                '       <div class=" d-flex flex-grow-1 min-width-zero">' +
                '           <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">' +
                '               <div class="min-width-zero">' +
                '                   <a href="#" onclick="LoadValuesForService(\'' + service + '\',\'sms\')">' +
                '                       <p class="list-item-heading mb-1 truncate">SMS</p>' +
                '                   </a>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>');
            var psc = $('<div class="card d-flex flex-row mb-4">' +
                '       <a class="d-flex" href="#">' +
                '           <img alt="paysafecard" src="/img/payment-icons/psc.png" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">' +
                '       </a>' +
                '       <div class=" d-flex flex-grow-1 min-width-zero">' +
                '           <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">' +
                '               <div class="min-width-zero">' +
                '                   <a href="#" onclick="LoadValuesForService(\'' + service + '\',\'paysafecard\')">' +
                '                       <p class="list-item-heading mb-1 truncate">PaySafeCard</p>' +
                '                   </a>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>');
            var transfer = $('<div class="card d-flex flex-row mb-4">' +
                '       <a class="d-flex" href="#">' +
                '           <img alt="transfer" src="/img/payment-icons/transfer.png" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">' +
                '       </a>' +
                '       <div class=" d-flex flex-grow-1 min-width-zero">' +
                '           <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">' +
                '               <div class="min-width-zero">' +
                '                   <a href="#" onclick="LoadValuesForService(\'' + service + '\',\'transfer\')">' +
                '                       <p class="list-item-heading mb-1 truncate">Przelew</p>' +
                '                   </a>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>');
            var wallet = $('<div class="card d-flex flex-row mb-4">' +
                '       <a class="d-flex" href="#">' +
                '           <img alt="wallet" src="/img/payment-icons/wallet.png" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">' +
                '       </a>' +
                '       <div class=" d-flex flex-grow-1 min-width-zero">' +
                '           <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">' +
                '               <div class="min-width-zero">' +
                '                   <a href="#" onclick="LoadValuesForService(\'' + service + '\',\'wallet\')">' +
                '                       <p class="list-item-heading mb-1 truncate">Portfel</p>' +
                '                   </a>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>');

            if(data['sms'])
                $('#sms_type').append(sms);

            if(data['psc'])
                $('#psc_type').append(psc);

            if(data['transfer'])
                $('#transfer_type').append(transfer);

            if(data['wallet'])
                $('#wallet_type').append(wallet);

            // show avaible metods
            $('#collapsePaymentMethod').addClass('show');

            // Go to the botom of page
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            alert('Ajax request failed: ' + errorThrown);
        }
    });
};

// Load prices values for service
function LoadValuesForService(service, payment){
    // collapse current values
    toggleValuSelection(false);

    // show loader
    $("#ajax_loader").show();

    $.ajax({
        url:        '/api/get/values/' + service + '/' + document.getElementById('server_name').getAttribute('value') + '/' + payment + '/',
        type:       'POST',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();

            var e = $('');
            $('#p_values').html('');

            for(i = 0; i < data.length; i++) {
                price = data[i];
                var e = $('<div class="col-lg-3">' +
                    '    <div class="card mb-4 progress-banner" style="border: none">' +
                    '        <div class="card-body justify-content-between align-items-center text-center">' +
                    '            <a onclick="LoadPaymentInfo(\'' + service + '\', \'' + document.getElementById('server_name').getAttribute('value') + '\', \'' + payment + '\', \'' + price['value'] + '\')">' +
                    '                <div>' +
                    '                    <i class="iconsmind-Diamond mr-2 text-white align-text-bottom d-inline-block"></i>' +
                    '                    <div>' +
                    '                        <p class="lead text-white" >' + price['value'] + ' ' + price['sufix'] + '</p>' +
                    '                    </div>' +
                    '                </div>' +
                    '            </a>' +
                    '        </div>' +
                    '    </div>' +
                    '</div>');

                $('#p_values').append(e);
            }

            // Go to the botom of page
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");

            toggleValuSelection(true);
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            alert('Ajax request failed: ' + errorThrown);
        }
    });
};


// Load prices values for service
function LoadPaymentInfo(service, server, payment, value){
    // collapse current modal
    togglePaymentInfo(false);

    // show loader
    $("#ajax_loader").show();

    $.ajax({
        url:        '/api/get/price-info/' + service + '/' + server + '/' + payment + '/' + value + '/',
        type:       'POST',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();

            for(i = 0; i < data.length; i++) {
                info = data[i];

                switch(info['type'])
                {
                    // sms
                    case 1: {
                        $('#payment_details').html('');
                        $('#payment_details').append('' +
                            '<p style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">' +
                            '    Sms o treści &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                            '   <span class="payment-smskey text-white">' +
                            '       ' + info['smskey'] +
                            '   </span>' +
                            '</p>' +
                            '<p style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">' +
                            '    Na numer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                            '   <span class="payment-smsnumber text-white">' +
                            '       ' + info['smsNumber'] +
                            '   </span>' +
                            '</p>' +
                            '<p style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">' +
                            '    Koszt SMS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                            '    <span class="payment-price text-white">' +
                            '       ' + info['brutto'] + ' zł' +
                            '   </span>' +
                            '</p>' +
                            '<br/>' +
                            '<div class="row top-buffer"></div>' +
                            '<br/>' +
                            '<br/>' +
                            '<br/>' +
                            '<form>' +
                            '   <div class="form-group">' +
                            '       <label>Kod zwrotny:</label>' +
                            '       <input type="text" id="smsCode" class="form-control radius-type" required>' +
                            '   </div>' +
                            '   <div class="form-group">' +
                            '       <label>SteamID:</label>' +
                            '       <input type="text" id="authData" class="form-control radius-type" placeholder="STEAM_0:0:12345" value="' + info['steamid'] + '" required>' +
                            '   </div>' +
                            '   <button type="button" onclick="PerformPayment(\'sms\', \'' + service + '\', \'' + server + '\', \'' + value + '\')" class="btn btn-primary btn-block mb-1">Zapłać</button>' +
                            '</form>');

                        // fill payment info
                        $('#payment_name').append(info['name']);
                        break;
                    }

                    // transfer
                    case 2: {
                        alert('transfer');
                        break;
                    }

                    // paysafecard
                    case 3: {
                        alert('paysafecard');
                        break;
                    }

                    // paypal
                    case 3: {
                        alert('paypal');
                        break;
                    }
                }

                // show modal
                togglePaymentInfo(true);
            }
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            swal("Błąd", "Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
        }
    });
};

// Call payment prepare
function PerformPayment(type, service, server, value){
    // show loader
    $("#ajax_loader").show();

    // prepare variables
    var authData = $('#authData').val();
    var smsCode = $('#smsCode').val();

    $.ajax({
        url:        '/api/payment/perform/' + type + '/' + service + '/' + server + '/' + value + '/' + authData + '/' + smsCode + '/',
        type:       'POST',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();

            if(data[0]['type'] == "error")
            {
                swal("Błąd", data[0]['response'], "error");
            }
            else
            {
                togglePaymentInfo(false);
                swal({
                    title: "Gratulacje!",
                    text: data[0]['response'],
                    type: "success",
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                },
                    function(isConfirmed) {
                        document.location.href=pathToUserServices;
                    });
            }
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            swal("Błąd", "Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
        }
    });
}

function loadWalletPayments() {
    // show loader
    $("#ajax_loader").show();


    $.ajax({
        url:        '/api/get/accessible-payment-types',
        type:       'POST',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();
            clearSelect('walletMethods');

            // give client data
            for(i = 0; i < data.length; i++) {
                info = data[i];

                switch(info['type'])
                {
                    // sms
                    case 1: {
                        addToSelect('walletMethods', 1, 'SMS');
                        break;
                    }

                    // transfer
                    case 2: {
                        addToSelect('walletMethods', 2, 'Przelew');
                        break;
                    }

                    // paysafecard
                    case 3: {
                        addToSelect('walletMethods', 3, 'PaySafeCard');
                        break;
                    }

                    // paypal
                    case 4: {
                        addToSelect('walletMethods', 4, 'PayPal');
                        break;
                    }
                }
            }

            // show modal
            $('#chargeWallet').modal('show');
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            swal("Błąd", "Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
        }
    });
}

function loadPaymentValues(type) {

    switch(parseInt(type))
    {
        // sms
        case 1: {
            // reset div
            $('#walletPaymentContent').html('<br/><label><h4>Wybierz wartość doładowania</h4></label>');
            $('#walletPaymentDetails').html('');

            $("#ajax_loader").show();

            $.ajax({
                url:        '/api/get/tariff-values/1',
                type:       'POST',
                dataType:   'json',
                async:      true,

                success: function(data, status) {
                    // create select
                    $('#walletPaymentContent').append('' +
                        '<select id="walletSMSValues" class="form-control radius-type" onchange="getSMSVisualisation(this.options[this.selectedIndex].value)"></select>');

                    $("#ajax_loader").hide();
                    clearSelect('walletSMSValues');

                    // give client data
                    for(i = 0; i < data.length; i++) {
                        info = data[i];
                        addToSelect('walletSMSValues', info['id'], 'Koszt: ' + info['brutto'] + ' zł ~ Do portfela: ' + info['netto'] + ' zł');
                    }
                },
                error : function(xhr, textStatus, errorThrown) {
                    $("#ajax_loader").hide();

                    // Alert (no prices for this payment method)
                    swal("Błąd", "Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
                }
            });
            break;
        }
        case 2: break;// transfer
        case 3: break;// psc
        case 4: break;// paypal
    }
}

// event listener for sms values selector
function getSMSVisualisation(id) {

    // show loader
    $("#ajax_loader").show();

    $.ajax({
        url:        '/api/get/tariff-info/' + id + '/',
        type:       'GET',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();
            info = data[0];


            $('#walletPaymentDetails').html('');
            $('#walletPaymentDetails').append('</br></br>' +
                '<p style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">' +
                '    Sms o treści &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                '   <span class="payment-smskey text-white">' +
                '       ' + info['smskey'] +
                '   </span>' +
                '</p>' +
                '<p style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">' +
                '    Na numer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                '   <span class="payment-smsnumber text-white">' +
                '       ' + info['smsNumber'] +
                '   </span>' +
                '</p>' +
                '<p style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">' +
                '    Koszt SMS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                '    <span class="payment-price text-white">' +
                '       ' + info['brutto'] + ' zł' +
                '   </span>' +
                '</p>' +
                '<br/>' +
                '<div class="row top-buffer"></div>' +
                '<br/>' +
                '<form>' +
                '   <div class="form-group">' +
                '       <label><h4>Kod zwrotny:</h4></label>' +
                '       <input type="text" id="smsCode_chargeWallet" class="form-control radius-type" required>' +
                '   </div>' +
                '   <br/>' +
                '   <button type="button" onclick="PerformSMSPayment('+ id + ')" class="btn btn-primary btn-block mb-1">Zapłać</button>' +
                '</form>');
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            swal("Błąd", "Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
        }
    });
}

// Call charge wallet payment prepare
function PerformSMSPayment(id){
    // show loader
    $("#ajax_loader").show();

    // prepare variables
    var smsCode = $('#smsCode_chargeWallet').val();

    $.ajax({
        url:        '/api/payment/sms/perform/' + id + '/' + smsCode + '/',
        type:       'GET',
        dataType:   'json',
        async:      true,

        success: function(data, status) {
            $("#ajax_loader").hide();

            if(data[0]['type'] == "error")
            {
                swal("Błąd", data[0]['response'], "error");
            }
            else
            {
                togglePaymentInfo(false);
                swal({
                        title: "Gratulacje!",
                        text: data[0]['response'],
                        type: "success",
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    },
                    function(isConfirmed) {
                        // change wallet value
                        var new_amount = parseFloat($("#wallet_funds").text()) + parseFloat(data[0]['amount']);
                        $("#wallet_funds").html('&nbsp;' + new_amount.toFixed(2) + ' zł | +&nbsp;');

                        // hide modal
                        $('#chargeWallet').modal('hide');
                    });
            }
        },
        error : function(xhr, textStatus, errorThrown) {
            $("#ajax_loader").hide();

            // Alert (no prices for this payment method)
            swal("Błąd", "Wystąpił niespodziewany błąd, skontaktuj się z administratorem.", "error");
        }
    });
}
"use strict";

$('.profile__refill-form').submit(function (event) {
  event.preventDefault();
});


$('.pay-refill').click(function (e) {

  e.preventDefault();

  const amount = $('#history-amount').val();
  const paymentType = $('#refill-modal .profile__order-select option:selected').val();
  const validate = $('.field-history-amount').hasClass('has-success');


  if (validate)
    $.post('/api/balance/increase',
      {amount: amount, payment_type: paymentType},
      function (tb_data) {
        if (tb_data.Success) {
          document.location.replace(tb_data.PaymentURL);
        } else {
          $('#refill-modal').modal('hide');
          $('#order-invoice-modal').modal('show');
        }
        ;
      }
    )
});
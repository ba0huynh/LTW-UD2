const CheckoutButton = document.querySelector('.thanhtoanbutton');


CheckoutButton.addEventListener('click', function(e) {
    const name = document.getElementById('name').value.trim();
  const address = document.getElementById('address').value.trim();
  const phone = document.getElementById('phone').value.trim();

  let hasError = false;

  // Clear previous error messages
  document.getElementById('name-error').innerHTML = '';
  document.getElementById('address-error').innerHTML = '';
  document.getElementById('phone-error').innerHTML = '';

  // Validate name
  if (!name) {
    document.getElementById('name-error').innerHTML = 'Họ và tên không được để trống.';
    hasError = true;
  }

  // Validate address
  if (!address) {
    document.getElementById('address-error').innerHTML = 'Địa chỉ không được để trống.';
    hasError = true;
  }

  // Validate phone
  if (!phone) {
    document.getElementById('phone-error').innerHTML = 'Số điện thoại không được để trống.';
    hasError = true;
  }

  // Prevent form submission if there are errors
  if (hasError) {
    e.preventDefault();
  }
  });
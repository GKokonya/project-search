<!--Start of footer-->
<footer class="bg-dark">
    <div class="container py-4 mt-5">
        <div class="row gy-4 gx-5">
            <div class="col-lg-4 col-md-4">
                <h3 class="h3 text-white">About <?php echo SITE_NAME; ?></h3>
                <p class="text-muted"><?php echo SITE_NAME; ?> allows one to identify if a device or gadget has been reported lost or stolen</p>
            </div>
            <div class="col-lg-4 col-md-4">
                <ul class="list-unstyled text-muted">
                    <li><a href="#"> <h3 class="mb-3">FAQ</h3></a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h3 class="mb-3 text-white">Contact Us</h3>

                <p class="text-muted"><?php echo SITE_NAME; ?>@gmail.com</p>
                <p class="text-muted">+254700000000</p>
                </ul>
            </div>
            <div class="roW">
                <div class="col">
                    <p class="text-white">© <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End of Footer-->    
<!--JS/JQUERY CDNS-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--Bootstrap 5 Jj-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<!--Popper JS-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<!--Slick JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js" integrity="sha512-WNZwVebQjhSxEzwbettGuQgWxbpYdoLf7mH+25A7sfQbbxKeS5SQ9QBf97zOY4nOlwtksgDA/czSTmfj4DUEiQ==" crossorigin="anonymous"></script>
<!--JS Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
<!-- Custom JS function-->
<script type="text/javascript" src="js/function.js"></script>
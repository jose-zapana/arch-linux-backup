<script>
  var listener = new window.keypress.Listener();
  listener.simple_combo("f4", function() {
      console.log('hola');
  });
  listener.simple_combo("f8", function() {
      document.getElementById('cash').value = ''
      document.getElementById('cash').focus()
  });
</script>
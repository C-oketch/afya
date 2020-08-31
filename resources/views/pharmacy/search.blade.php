<html>
<title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

</title>
<body>
<div class="container">

    <h1>Laravel 5 Autocomplete using Bootstrap Typeahead JS</h1>
    <input class="typeahead form-control" style="margin:0px auto;width:300px;" type="text" name="q">

</div>
</body>
</html>
<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
      $( "#q" ).autocomplete({
       source: "search/autocomplete",
       minLength: 3,
       select: function(event, ui) {
         $('#q').val(ui.item.value);
       }
     });
    $(function()
{

});
</script>

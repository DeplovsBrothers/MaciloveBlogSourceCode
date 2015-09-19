<html>
<head>
<script type="text/javascript">
$(document).ready(function () {
    $('.group').hide();
    $('#option1').show();
    $('#selectMe').change(function () {
        $('.group').hide();
        $('#'+$(this).val()).show();
    })
});
</script>
</head>
<body>
<div id="option1" class="group">asdf</div>
<div id="option2" class="group">kljh</div>
<div id="option3" class="group">zxcv</div>
<div id="option4" class="group">qwerty</div>
<select id="selectMe">
    <option value="option1">option1</option>
    <option value="option2">option2</option>
    <option value="option3">option3</option>
    <option value="option4">option4</option>
</select>
</body>
</html>



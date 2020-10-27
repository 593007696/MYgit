<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
  $('input[type=checkbox]').click(function() {
   $('input[type=checkbox]').attr('disabled', true);
   if ($("input[type=checkbox]:checked").length >= 3) {
    $("input[type=checkbox]:checked").attr('disabled', false);
   } else {
    $("input[type=checkbox]").attr('disabled', false);
   }
  });
 });
</script>
<ul>
 <li>
  <input type="checkbox" name="apk[]" value=1 />
  APK1
 </li>
 <li>
  <input type="checkbox" name="apk[]" value=2 />
  APK2
 </li>
 <li>
  <input type="checkbox" name="apk[]" value=1 />
  APK3
 </li>
 <li>
  <input type="checkbox" name="apk[]" value=4 />
  APK4
 </li>
 <li>
  <input type="checkbox" name="apk[]" value=6 />
  APK5
 </li>
 <li>
  <input type="checkbox" name="apk[]" value=7 />
  APK6
 </li>
 <li>
  <input type="checkbox" name="apk[]" value=8 />
  APK7
 </li>
</ul>

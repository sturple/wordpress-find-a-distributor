<form class="find-a-distributor">
	<input type="text" name="lat">
	<input type="text" name="lng">
	<input type="text" name="radius">
	<input type="submit">
</form>

<div class="found-distributors"></div>

<script type="text/javascript">
	(function () {
		var $=jQuery;
		var curr=$('script').last();
		var form=curr.prevAll('form').first();
		var found=curr.prevAll('div').first();
		form.submit(function (e) {
			e.preventDefault();
			found.empty();
			var lat=parseFloat(form.find('input[name="lat"]').val());
			var lng=parseFloat(form.find('input[name="lng"]').val());
			var radius=parseFloat(form.find('input[name="radius"]').val());
			if (isNaN(lat) || isNaN(lng) || isNaN(radius) || (radius<=0)) return;
			var query='?action=fgms_distributor_radius&lat=';
			query+=encodeURIComponent(lat);
			query+='&lng=';
			query+=encodeURIComponent(lng);
			query+='&radius=';
			query+=encodeURIComponent(radius);
			var url=<?php	echo(json_encode(admin_url('admin-ajax.php')));	?>+query;
			var xhr=$.ajax(url);
			xhr.fail(function (xhr, text, e) {	alert(text);	});
			xhr.done(function (data, text, xhr) {
				var arr=JSON.parse(xhr.responseText);
				arr.sort(function (a, b) {	return a.dist-b.dist;	});
				arr.forEach(function (dist) {
					var e=document.createElement('div');
					e.setAttribute('class','found-distributor');
					var h=document.createElement('h3');
					h.setAttribute('class','found-distributor-name');
					h.appendChild(document.createTextNode(dist.name));
					e.appendChild(h);
					found[0].appendChild(e);
				});
			});
		});
	})();
</script>
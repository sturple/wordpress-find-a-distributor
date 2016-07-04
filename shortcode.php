<form class="find-a-distributor">
	<label for="radius">Search Radius (km)</label>
	<input type="text" name="radius">
	<label for="address">Zip/Postal Code, Address, or City</label>
	<input type="text" name="address">
	<input type="submit">
</form>

<div class="found-distributors"></div>

<script type="text/javascript">
	(function () {
		var $=jQuery;
		var curr=$('script').last();
		var form=curr.prevAll('form').first();
		var found=curr.prevAll('div').first();
		var get=function (name) {
			var str=form.find('input[name="'+name+'"]').val().trim();
			if (str==='') return null;
			return str;
		};
		form.submit(function (e) {
			e.preventDefault();
			found.empty();
			var radius=parseFloat(form.find('input[name="radius"]').val());
			if (isNaN(radius)) return;
			var address=get('address');
			if (address===null) return;
			var query='?action=fgms_distributor_radius&address='+encodeURIComponent(address)+'&radius='+encodeURIComponent(radius);
			var url=<?php	echo(json_encode(admin_url('admin-ajax.php')));	?>+query;
			var xhr=$.ajax(url);
			xhr.fail(function (xhr, text, e) {	alert(xhr.statusText);	});
			xhr.done(function (data, text, xhr) {
				var obj=JSON.parse(xhr.responseText);
				var arr=obj.results;
				arr.sort(function (a, b) {	return a.distance-b.distance;	});
				arr.forEach(function (dist) {
					var e=document.createElement('div');
					e.setAttribute('class','found-distributor');
					e.innerHTML=dist.html;
					found[0].appendChild(e);
				});
			});
		});
	})();
</script>
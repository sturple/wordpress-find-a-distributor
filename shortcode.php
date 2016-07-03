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
				arr.sort(function (a, b) {	return a.dist-b.dist;	});
				arr.forEach(function (dist) {
					var e=document.createElement('div');
					e.setAttribute('class','found-distributor');
					var h=document.createElement('h3');
					h.setAttribute('class','found-distributor-name');
					h.appendChild(document.createTextNode(dist.name));
					e.appendChild(h);
					var addr=document.createElement('div');
					addr.setAttribute('class','found-distributor-address');
					addr.appendChild(document.createTextNode(dist.address));
					addr.appendChild(document.createElement('br'));
					addr.appendChild(document.createTextNode(dist.city+(dist.territorial_unit ? ', '+dist.territorial_unit : '')));
					addr.appendChild(document.createElement('br'));
					addr.appendChild(document.createTextNode(dist.country));
					e.appendChild(addr);
					dist.description=dist.description.trim();
					if (dist.description) {
						var desc=document.createElement('div');
						desc.setAttribute('class','found-distributor-description');
						desc.appendChild(document.createTextNode(dist.description));
						e.appendChild(desc);
					}
					found[0].appendChild(e);
				});
			});
		});
	})();
</script>
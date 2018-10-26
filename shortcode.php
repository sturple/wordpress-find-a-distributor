<div class="find-a-distributor">
	<div class="row">
		<div class="col-md-4">
			<h3>Filter</h3>
			<form class="find-a-distributor-form">
				<div class="error-message"></div>
				<h4 style="margin-bottom: 16px; padding-top:0">Select a Region</h4>
				<div class="form-group">
					<select name="region" class="form-control ">
						<option value="">Select ...</option>
						<option value="ca" >Canada</option>
						<option value="us" >US</option>
						<option value="nz" >New Zealand</option>
						<option value="au" >Australia</option>
						<option value="gb" >Europe</option>
					</select>
				</div>
				<div class="narrow-your-search" style="display:none;">
					<h4 style="margin-bottom: 8px;">Narrow your search</h4>
					<div class="form-group">
						<label for="address">Zip/Postal Code, Address, or City</label>
						<input type="text" id="gm-distributor-autocomplete" name="address" class="form-control" >
					</div>
					<div class="form-group">
						<label for="radius">Search Radius</label>
						<select name="radius" class="form-control ">
							<option value ="">Select ...</option>
							<option value="500">500mi (805km)</option>
							<option value="100">100mi (160km)</option>
							<option value="50">50mi (80km)</option>
							<option value="20">20mi (32km)</option>
							<option value="10">10mi (16km)</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tags">Air Compressors</label>
						<select name="tags" class="form-control ">
							<option value="all">All Types</option>
							<?php foreach ($allowed_tags as  $tag=>$label) : ?>
							<option value="<?= $tag;?>"><?= $label;?></option>
							<?php endforeach ?>
							<option value="" selected="selected" >No Filter</option>
						</select>
					</div>
					<div style="padding-top: 12px" class="form-group">
						<input type="submit" value="Find a Dealer">
					</div>
				</div>

			</form>
			<h3 class="find-a-distributor-title">Results <span style="font-size: 0.8em;margin-left: 12px;text-transform: none; color: #aaa;"></span></h3>
			<ul class="found-distributors-results"></ul>
		</div>
		<div class="col-md-8">
			<div class="found-distributors-map" style="height:800px;"></div>
		</div>
	</div>
</div>

<?php	if ($output_maps):$output_maps=false;	?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyATLdDoA36EXy-b6UO2rFqNMh9iEslZNNQ&v=3&libraries=places&sensor=false"></script>
<script type="text/javascript">
function MarkerLabel_(e,t,n){this.marker_=e;this.handCursorURL_=e.handCursorURL;this.labelDiv_=document.createElement("div");this.labelDiv_.style.cssText="position: absolute; overflow: hidden;";this.eventDiv_=document.createElement("div");this.eventDiv_.style.cssText=this.labelDiv_.style.cssText;this.eventDiv_.setAttribute("onselectstart","return false;");this.eventDiv_.setAttribute("ondragstart","return false;");this.crossDiv_=MarkerLabel_.getSharedCross(t)}function MarkerWithLabel(e){e=e||{};e.labelContent=e.labelContent||"";e.labelAnchor=e.labelAnchor||new google.maps.Point(0,0);e.labelClass=e.labelClass||"markerLabels";e.labelStyle=e.labelStyle||{};e.labelInBackground=e.labelInBackground||false;if(typeof e.labelVisible==="undefined"){e.labelVisible=true}if(typeof e.raiseOnDrag==="undefined"){e.raiseOnDrag=true}if(typeof e.clickable==="undefined"){e.clickable=true}if(typeof e.draggable==="undefined"){e.draggable=false}if(typeof e.optimized==="undefined"){e.optimized=false}e.crossImage=e.crossImage||"http"+(document.location.protocol==="https:"?"s":"")+"://maps.gstatic.com/intl/en_us/mapfiles/drag_cross_67_16.png";e.handCursor=e.handCursor||"http"+(document.location.protocol==="https:"?"s":"")+"://maps.gstatic.com/intl/en_us/mapfiles/closedhand_8_8.cur";e.optimized=false;this.label=new MarkerLabel_(this,e.crossImage,e.handCursor);google.maps.Marker.apply(this,arguments)}MarkerLabel_.prototype=new google.maps.OverlayView;MarkerLabel_.getSharedCross=function(e){var t;if(typeof MarkerLabel_.getSharedCross.crossDiv==="undefined"){t=document.createElement("img");t.style.cssText="position: absolute; z-index: 1000002; display: none;";t.style.marginLeft="-8px";t.style.marginTop="-9px";t.src=e;MarkerLabel_.getSharedCross.crossDiv=t}return MarkerLabel_.getSharedCross.crossDiv};MarkerLabel_.prototype.onAdd=function(){var e=this;var t=false;var n=false;var r;var i,s;var o;var u;var a;var f;var l=20;var c="url("+this.handCursorURL_+")";var h=function(e){if(e.preventDefault){e.preventDefault()}e.cancelBubble=true;if(e.stopPropagation){e.stopPropagation()}};var p=function(){e.marker_.setAnimation(null)};this.getPanes().overlayImage.appendChild(this.labelDiv_);this.getPanes().overlayMouseTarget.appendChild(this.eventDiv_);if(typeof MarkerLabel_.getSharedCross.processed==="undefined"){this.getPanes().overlayImage.appendChild(this.crossDiv_);MarkerLabel_.getSharedCross.processed=true}this.listeners_=[google.maps.event.addDomListener(this.eventDiv_,"mouseover",function(t){if(e.marker_.getDraggable()||e.marker_.getClickable()){this.style.cursor="pointer";google.maps.event.trigger(e.marker_,"mouseover",t)}}),google.maps.event.addDomListener(this.eventDiv_,"mouseout",function(t){if((e.marker_.getDraggable()||e.marker_.getClickable())&&!n){this.style.cursor=e.marker_.getCursor();google.maps.event.trigger(e.marker_,"mouseout",t)}}),google.maps.event.addDomListener(this.eventDiv_,"mousedown",function(r){n=false;if(e.marker_.getDraggable()){t=true;this.style.cursor=c}if(e.marker_.getDraggable()||e.marker_.getClickable()){google.maps.event.trigger(e.marker_,"mousedown",r);h(r)}}),google.maps.event.addDomListener(document,"mouseup",function(i){var s;if(t){t=false;e.eventDiv_.style.cursor="pointer";google.maps.event.trigger(e.marker_,"mouseup",i)}if(n){if(u){s=e.getProjection().fromLatLngToDivPixel(e.marker_.getPosition());s.y+=l;e.marker_.setPosition(e.getProjection().fromDivPixelToLatLng(s));try{e.marker_.setAnimation(google.maps.Animation.BOUNCE);setTimeout(p,1406)}catch(a){}}e.crossDiv_.style.display="none";e.marker_.setZIndex(r);o=true;n=false;i.latLng=e.marker_.getPosition();google.maps.event.trigger(e.marker_,"dragend",i)}}),google.maps.event.addListener(e.marker_.getMap(),"mousemove",function(o){var c;if(t){if(n){o.latLng=new google.maps.LatLng(o.latLng.lat()-i,o.latLng.lng()-s);c=e.getProjection().fromLatLngToDivPixel(o.latLng);if(u){e.crossDiv_.style.left=c.x+"px";e.crossDiv_.style.top=c.y+"px";e.crossDiv_.style.display="";c.y-=l}e.marker_.setPosition(e.getProjection().fromDivPixelToLatLng(c));if(u){e.eventDiv_.style.top=c.y+l+"px"}google.maps.event.trigger(e.marker_,"drag",o)}else{i=o.latLng.lat()-e.marker_.getPosition().lat();s=o.latLng.lng()-e.marker_.getPosition().lng();r=e.marker_.getZIndex();a=e.marker_.getPosition();f=e.marker_.getMap().getCenter();u=e.marker_.get("raiseOnDrag");n=true;e.marker_.setZIndex(1e6);o.latLng=e.marker_.getPosition();google.maps.event.trigger(e.marker_,"dragstart",o)}}}),google.maps.event.addDomListener(document,"keydown",function(t){if(n){if(t.keyCode===27){u=false;e.marker_.setPosition(a);e.marker_.getMap().setCenter(f);google.maps.event.trigger(document,"mouseup",t)}}}),google.maps.event.addDomListener(this.eventDiv_,"click",function(t){if(e.marker_.getDraggable()||e.marker_.getClickable()){if(o){o=false}else{google.maps.event.trigger(e.marker_,"click",t);h(t)}}}),google.maps.event.addDomListener(this.eventDiv_,"dblclick",function(t){if(e.marker_.getDraggable()||e.marker_.getClickable()){google.maps.event.trigger(e.marker_,"dblclick",t);h(t)}}),google.maps.event.addListener(this.marker_,"dragstart",function(e){if(!n){u=this.get("raiseOnDrag")}}),google.maps.event.addListener(this.marker_,"drag",function(t){if(!n){if(u){e.setPosition(l);e.labelDiv_.style.zIndex=1e6+(this.get("labelInBackground")?-1:+1)}}}),google.maps.event.addListener(this.marker_,"dragend",function(t){if(!n){if(u){e.setPosition(0)}}}),google.maps.event.addListener(this.marker_,"position_changed",function(){e.setPosition()}),google.maps.event.addListener(this.marker_,"zindex_changed",function(){e.setZIndex()}),google.maps.event.addListener(this.marker_,"visible_changed",function(){e.setVisible()}),google.maps.event.addListener(this.marker_,"labelvisible_changed",function(){e.setVisible()}),google.maps.event.addListener(this.marker_,"title_changed",function(){e.setTitle()}),google.maps.event.addListener(this.marker_,"labelcontent_changed",function(){e.setContent()}),google.maps.event.addListener(this.marker_,"labelanchor_changed",function(){e.setAnchor()}),google.maps.event.addListener(this.marker_,"labelclass_changed",function(){e.setStyles()}),google.maps.event.addListener(this.marker_,"labelstyle_changed",function(){e.setStyles()})]};MarkerLabel_.prototype.onRemove=function(){var e;this.labelDiv_.parentNode.removeChild(this.labelDiv_);this.eventDiv_.parentNode.removeChild(this.eventDiv_);for(e=0;e<this.listeners_.length;e++){google.maps.event.removeListener(this.listeners_[e])}};MarkerLabel_.prototype.draw=function(){this.setContent();this.setTitle();this.setStyles()};MarkerLabel_.prototype.setContent=function(){var e=this.marker_.get("labelContent");if(typeof e.nodeType==="undefined"){this.labelDiv_.innerHTML=e;this.eventDiv_.innerHTML=this.labelDiv_.innerHTML}else{this.labelDiv_.innerHTML="";this.labelDiv_.appendChild(e);e=e.cloneNode(true);this.eventDiv_.appendChild(e)}};MarkerLabel_.prototype.setTitle=function(){this.eventDiv_.title=this.marker_.getTitle()||""};MarkerLabel_.prototype.setStyles=function(){var e,t;this.labelDiv_.className=this.marker_.get("labelClass");this.eventDiv_.className=this.labelDiv_.className;this.labelDiv_.style.cssText="";this.eventDiv_.style.cssText="";t=this.marker_.get("labelStyle");for(e in t){if(t.hasOwnProperty(e)){this.labelDiv_.style[e]=t[e];this.eventDiv_.style[e]=t[e]}}this.setMandatoryStyles()};MarkerLabel_.prototype.setMandatoryStyles=function(){this.labelDiv_.style.position="absolute";this.labelDiv_.style.overflow="hidden";if(typeof this.labelDiv_.style.opacity!=="undefined"&&this.labelDiv_.style.opacity!==""){this.labelDiv_.style.MsFilter='"progid:DXImageTransform.Microsoft.Alpha(opacity='+this.labelDiv_.style.opacity*100+')"';this.labelDiv_.style.filter="alpha(opacity="+this.labelDiv_.style.opacity*100+")"}this.eventDiv_.style.position=this.labelDiv_.style.position;this.eventDiv_.style.overflow=this.labelDiv_.style.overflow;this.eventDiv_.style.opacity=.01;this.eventDiv_.style.MsFilter='"progid:DXImageTransform.Microsoft.Alpha(opacity=1)"';this.eventDiv_.style.filter="alpha(opacity=1)";this.setAnchor();this.setPosition();this.setVisible()};MarkerLabel_.prototype.setAnchor=function(){var e=this.marker_.get("labelAnchor");this.labelDiv_.style.marginLeft=-e.x+"px";this.labelDiv_.style.marginTop=-e.y+"px";this.eventDiv_.style.marginLeft=-e.x+"px";this.eventDiv_.style.marginTop=-e.y+"px"};MarkerLabel_.prototype.setPosition=function(e){var t=this.getProjection().fromLatLngToDivPixel(this.marker_.getPosition());if(typeof e==="undefined"){e=0}this.labelDiv_.style.left=Math.round(t.x)+"px";this.labelDiv_.style.top=Math.round(t.y-e)+"px";this.eventDiv_.style.left=this.labelDiv_.style.left;this.eventDiv_.style.top=this.labelDiv_.style.top;this.setZIndex()};MarkerLabel_.prototype.setZIndex=function(){var e=this.marker_.get("labelInBackground")?-1:+1;if(typeof this.marker_.getZIndex()==="undefined"){this.labelDiv_.style.zIndex=parseInt(this.labelDiv_.style.top,10)+e;this.eventDiv_.style.zIndex=this.labelDiv_.style.zIndex}else{this.labelDiv_.style.zIndex=this.marker_.getZIndex()+e;this.eventDiv_.style.zIndex=this.labelDiv_.style.zIndex}};MarkerLabel_.prototype.setVisible=function(){if(this.marker_.get("labelVisible")){this.labelDiv_.style.display=this.marker_.getVisible()?"block":"none"}else{this.labelDiv_.style.display="none"}this.eventDiv_.style.display=this.labelDiv_.style.display};MarkerWithLabel.prototype=new google.maps.Marker;MarkerWithLabel.prototype.setMap=function(e){google.maps.Marker.prototype.setMap.apply(this,arguments);this.label.setMap(e)}
</script>
<?php	endif;	?>
<script type="text/javascript">
	(function () {
		var $=jQuery;
		$('body').prepend('<div class="find-a-distributor-loading-overlay"><div><div style="font-weight: bold" ></div></div></div>');
		var curr=$('script').last();
		var container=$('.find-a-distributor');
		var form=container.find('form').first();
		var found=$('.found-distributors-results');
		var found_count = 0;
		var bounds_listner = null;
		var map_container=$('.found-distributors-map');
		var map=new google.maps.Map(map_container[0],{
			zoom: 3,
			center: new google.maps.LatLng(46.0730555556,-100.546666667),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			maxZoom: 18
		});
		var get=function (name,textflag) {
			textflag = textflag || false;
			var $field = form.find('*[name="'+name+'"]');
			var str='';
			if ($field.is('select')){
				$selected = $field.find(":selected");
				str= textflag ? $selected.text().trim() : $selected.val().trim();
			}
			if ($field.is('input')){
				str =$field.val().trim();
			}

			if (str==='') return null;
			return str;
		};
		var markers=[];
		var info_windows=[];
		var bounds=null;
		var auto_viewport={};

		var search_options = {types: [ '(cities)' ]};
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('gm-distributor-autocomplete'), search_options);


		var close_windows=function () {	info_windows.forEach(function (iw) {	iw.close();	});	};
		var add_distributor=function (dist, i) {
			var pos=new google.maps.LatLng(dist.lat,dist.lng);
			var mapbounds =map.getBounds();
			var search_within = auto_viewport.contains(pos);


			if ( ( (dist.inradius ) ||  (search_within) || (mapbounds.contains(pos) ) ) && ( dist.marker == false) ) {
				if ( (dist.inradius ) || (search_within) ){
					++found_count;
				}

				$('.find-a-distributor-loading-overlay > div > div').text('Found '+ found_count + ' results.')

				var marker=new MarkerWithLabel({
					position: pos,
					draggable: false,
					map: map,
					raiseOnDrag: false,
					labelContent: (( (dist.inradius ) || (search_within) ) ? ''+(i+1) : '<i class="fa fa-eye" aria-hidden="true"></i>'),
					labelAnchor: new google.maps.Point(15, 40),	//	No idea what these numbers mean
					labelClass: (dist.inradius ? 'find-a-distributor-label' : 'find-a-distributor-label-outside'),
					labelInBackground: false,
					icon: {
						path: google.maps.SymbolPath.CIRCLE,
						fillOpacity: 0.5,
						fillColor: '#D44300',
						strokeOpacity: 1,
						strokeColor: '#BA3C01',
						strokeWeight: 2,
						scale: 1
					}
				});
				dist.marker = true;
				markers.push(marker);
				var ie=document.createElement('div');
				ie.setAttribute('class','found-distributor');
				ie.innerHTML=dist.html;

				var info_window=new google.maps.InfoWindow({
					//	TODO: Change this?
					content: ie.outerHTML,
					disableAutoPan: true,
					position: pos
				});
				info_windows.push(info_window);
				var open=function () {
					close_windows();
					map.panTo(pos);
					info_window.open(map);
				};

				google.maps.event.addListener(marker,'click',open);
				if ( (dist.inradius ) || (search_within) ){
					var e=document.createElement('li');
					e.setAttribute('class','found-distributor');
					e.innerHTML=dist.html;
					found[0].appendChild(e);
					$(e).click(open);
				}
			}

		};
		var update=function (obj) {

			map=new google.maps.Map(map_container[0],{
				zoom: 3,
				center: new google.maps.LatLng(46.0730555556,-100.546666667),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: false,
				maxZoom: 18
			});

			map.setCenter(new google.maps.LatLng(obj.lat,obj.lng));
			var arr=obj.results;
			arr.sort(function (a, b) {	return a.distance-b.distance;	});
			bounds=null;
			var circ = new google.maps.Circle({
				strokeColor: '#000000',
				strokeOpacity: 0.8,
				strokeWeight: 1,
				fillColor: '#000000',
				fillOpacity: 0.1,
				map: map,
				center: new google.maps.LatLng(obj.lat,obj.lng),
				radius: obj.radius * 1609.34
			});
			var circle_bounds = circ.getBounds()
			var bne = circle_bounds.getNorthEast();
			var bsw = circle_bounds.getSouthWest();
			// if circle is in auto_viewport (bounds) then must be a region or bigger area.
			bounds = (auto_viewport.contains(bne) && auto_viewport.contains(bsw)) ? auto_viewport : circle_bounds;
			map.fitBounds(bounds);
			map.setZoom(map.getZoom() +1);

			// update autocomplete restrictions.
			if (get('region') !==null || get('region').length >0) {
				autocomplete.setComponentRestrictions({country : get('region')});
			}
			if (bounds_listner !== null) {
				bounds_listner.remove();
			}

			bounds_listner = map.addListener('bounds_changed', function(event) {

				found_count = 0;
				if (arr.length > 0 ){
					arr.forEach(add_distributor);
					arr = [];
					$('.find-a-distributor-loading-overlay').removeClass('active');
					$('.find-a-distributor-title span').text('Found: '+ found_count);
					if (found_count == 0 ){
						found.html('<div><strong>No Results Found</strong></div><div> Please broaden or modify your search parameters.</div>');
					}
				}

			//new MarkerClusterer(map, markers,  {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
		});

		};
		var getRequest = function(){
			found.empty();
			//markers.forEach(function (marker) {	marker.setMap(null);	});
			markers=[];
			close_windows();
			info_windows=[];
			var radius=parseFloat(form.find('*[name="radius"]').val());
			//if (isNaN(radius)) return;
			var address=get('address');
			var tags=form.find('*[name="tags"]').val();

			// uses region first otherwise see what is in the address field;
			address =  (address===null) ? get('region',true) : address;
			if (address===null) {
				// lets print out error
				var error = '<div style="font-size: 0.8em; text-align: center;" class="alert alert-danger"><strong>Please povide a valid region or address!</strong></div>';
				if (error !== null ) {
					form.find('.error-message').html(error);
				}
			}
			var query='?action=fgms_distributor_radius&address='+encodeURIComponent(address)+'&radius='+encodeURIComponent(radius)+'&tags='+encodeURIComponent(tags);

			var url=<?php	echo(json_encode(admin_url('admin-ajax.php')));	?>+query;

			var xhr=$.ajax(url);
			xhr.fail(function (xhr, text, e) {
				console.warn(xhr.statusText);
				$('.find-a-distributor-loading-overlay').removeClass('active');
				found.html('<span color="red">Error Fetching Data: ' + xhr.statusText+'</span>');
			});
			xhr.done(function (data, text, xhr) {
				var obj=JSON.parse(xhr.responseText);
				update(obj);
			});
		};

		var getGeocode = function() {

		}
		form.find('select[name="region"]').on('change',function(e){
			var region_val = $(this).find(":selected").val();
			if (region_val.length > 1){
				form.find('.narrow-your-search').slideDown();
				form.trigger('submit');
				// makes sense to clear all filters if they change reagion.
				form.find('*[name="address"]').val("");
				// setting radius to default 100km if not already set. this is the only one we could leave.
				var $radius = form.find('*[name="radius"]');
				if ( $radius.find(":selected").val() === '') {
					$radius.val("100");
				}
			}
			else {
				autocomplete.setComponentRestrictions({country : ['ca','us','nz','au','gb']});
				form.find('.narrow-your-search').slideUp();
				form.find('input[type="text"]').val('');
			}
			e.preventDefault();
			return false;

		});
		form.submit(function (e) {
			$('.find-a-distributor-loading-overlay > div > div').text('Finding Results...');
			$('.find-a-distributor-loading-overlay').addClass('active');
			$(this).find('.error-message').html('');
			e.preventDefault();
			var error=null;

			var address = get('address');
			address = (address===null) ? get('region',true) : address;

			if (address === '' || address ===null){
				error = '<div style="font-size: 0.8em; text-align: center;" class="alert alert-danger"><strong>Please Provide a valid address!</strong></div>';
			}
			var auto_place = autocomplete.getPlace();
			if (!auto_place || !auto_place.geometry){
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({address: address	},function(results){
					if (results.length > 0 ){
						results = results[0];
						auto_viewport = (results.geometry.viewport === undefined) ? { 'contains' : function(pos){return false;}} : results.geometry.viewport;
						getRequest();
					}
					else {
						error = '<div style="font-size: 0.8em; text-align: center;" class="alert alert-danger"><strong>Error with Geocoder please try again!</strong></div>'
					}
				});
			}
			else {
				auto_viewport = (auto_place.geometry.viewport === undefined) ? { 'contains' : function(pos){return false;}} : auto_place.geometry.viewport;
				getRequest();
			}

			if (error !== null ) {
				form.find('.error-message').html(error);
			}
			return false;
		});
	})();

</script>

<script type="text/javascript">
//function MarkerClusterer(a,b,c){this.extend(MarkerClusterer,google.maps.OverlayView),this.map_=a,this.markers_=[],this.clusters_=[],this.sizes=[53,56,66,78,90],this.styles_=[],this.ready_=!1;var d=c||{};this.gridSize_=d.gridSize||60,this.minClusterSize_=d.minimumClusterSize||2,this.maxZoom_=d.maxZoom||null,this.styles_=d.styles||[],this.imagePath_=d.imagePath||this.MARKER_CLUSTER_IMAGE_PATH_,this.imageExtension_=d.imageExtension||this.MARKER_CLUSTER_IMAGE_EXTENSION_,this.zoomOnClick_=!0,void 0!=d.zoomOnClick&&(this.zoomOnClick_=d.zoomOnClick),this.averageCenter_=!1,void 0!=d.averageCenter&&(this.averageCenter_=d.averageCenter),this.setupStyles_(),this.setMap(a),this.prevZoom_=this.map_.getZoom();var e=this;google.maps.event.addListener(this.map_,"zoom_changed",function(){var a=e.map_.getZoom();e.prevZoom_!=a&&(e.prevZoom_=a,e.resetViewport())}),google.maps.event.addListener(this.map_,"idle",function(){e.redraw()}),b&&b.length&&this.addMarkers(b,!1)}function Cluster(a){this.markerClusterer_=a,this.map_=a.getMap(),this.gridSize_=a.getGridSize(),this.minClusterSize_=a.getMinClusterSize(),this.averageCenter_=a.isAverageCenter(),this.center_=null,this.markers_=[],this.bounds_=null,this.clusterIcon_=new ClusterIcon(this,a.getStyles(),a.getGridSize())}function ClusterIcon(a,b,c){a.getMarkerClusterer().extend(ClusterIcon,google.maps.OverlayView),this.styles_=b,this.padding_=c||0,this.cluster_=a,this.center_=null,this.map_=a.getMap(),this.div_=null,this.sums_=null,this.visible_=!1,this.setMap(this.map_)}MarkerClusterer.prototype.MARKER_CLUSTER_IMAGE_PATH_="../images/m",MarkerClusterer.prototype.MARKER_CLUSTER_IMAGE_EXTENSION_="png",MarkerClusterer.prototype.extend=function(a,b){return function(a){for(var b in a.prototype)this.prototype[b]=a.prototype[b];return this}.apply(a,[b])},MarkerClusterer.prototype.onAdd=function(){this.setReady_(!0)},MarkerClusterer.prototype.draw=function(){},MarkerClusterer.prototype.setupStyles_=function(){if(!this.styles_.length)for(var b,a=0;b=this.sizes[a];a++)this.styles_.push({url:this.imagePath_+(a+1)+"."+this.imageExtension_,height:b,width:b})},MarkerClusterer.prototype.fitMapToMarkers=function(){for(var d,a=this.getMarkers(),b=new google.maps.LatLngBounds,c=0;d=a[c];c++)b.extend(d.getPosition());this.map_.fitBounds(b)},MarkerClusterer.prototype.setStyles=function(a){this.styles_=a},MarkerClusterer.prototype.getStyles=function(){return this.styles_},MarkerClusterer.prototype.isZoomOnClick=function(){return this.zoomOnClick_},MarkerClusterer.prototype.isAverageCenter=function(){return this.averageCenter_},MarkerClusterer.prototype.getMarkers=function(){return this.markers_},MarkerClusterer.prototype.getTotalMarkers=function(){return this.markers_.length},MarkerClusterer.prototype.setMaxZoom=function(a){this.maxZoom_=a},MarkerClusterer.prototype.getMaxZoom=function(){return this.maxZoom_},MarkerClusterer.prototype.calculator_=function(a,b){for(var c=0,d=a.length,e=d;0!==e;)e=parseInt(e/10,10),c++;return c=Math.min(c,b),{text:d,index:c}},MarkerClusterer.prototype.setCalculator=function(a){this.calculator_=a},MarkerClusterer.prototype.getCalculator=function(){return this.calculator_},MarkerClusterer.prototype.addMarkers=function(a,b){for(var d,c=0;d=a[c];c++)this.pushMarkerTo_(d);b||this.redraw()},MarkerClusterer.prototype.pushMarkerTo_=function(a){if(a.isAdded=!1,a.draggable){var b=this;google.maps.event.addListener(a,"dragend",function(){a.isAdded=!1,b.repaint()})}this.markers_.push(a)},MarkerClusterer.prototype.addMarker=function(a,b){this.pushMarkerTo_(a),b||this.redraw()},MarkerClusterer.prototype.removeMarker_=function(a){var b=-1;if(this.markers_.indexOf)b=this.markers_.indexOf(a);else for(var d,c=0;d=this.markers_[c];c++)if(d==a){b=c;break}return b!=-1&&(a.setMap(null),this.markers_.splice(b,1),!0)},MarkerClusterer.prototype.removeMarker=function(a,b){var c=this.removeMarker_(a);return!(b||!c)&&(this.resetViewport(),this.redraw(),!0)},MarkerClusterer.prototype.removeMarkers=function(a,b){for(var e,c=!1,d=0;e=a[d];d++){var f=this.removeMarker_(e);c=c||f}if(!b&&c)return this.resetViewport(),this.redraw(),!0},MarkerClusterer.prototype.setReady_=function(a){this.ready_||(this.ready_=a,this.createClusters_())},MarkerClusterer.prototype.getTotalClusters=function(){return this.clusters_.length},MarkerClusterer.prototype.getMap=function(){return this.map_},MarkerClusterer.prototype.setMap=function(a){this.map_=a},MarkerClusterer.prototype.getGridSize=function(){return this.gridSize_},MarkerClusterer.prototype.setGridSize=function(a){this.gridSize_=a},MarkerClusterer.prototype.getMinClusterSize=function(){return this.minClusterSize_},MarkerClusterer.prototype.setMinClusterSize=function(a){this.minClusterSize_=a},MarkerClusterer.prototype.getExtendedBounds=function(a){var b=this.getProjection(),c=new google.maps.LatLng(a.getNorthEast().lat(),a.getNorthEast().lng()),d=new google.maps.LatLng(a.getSouthWest().lat(),a.getSouthWest().lng()),e=b.fromLatLngToDivPixel(c);e.x+=this.gridSize_,e.y-=this.gridSize_;var f=b.fromLatLngToDivPixel(d);f.x-=this.gridSize_,f.y+=this.gridSize_;var g=b.fromDivPixelToLatLng(e),h=b.fromDivPixelToLatLng(f);return a.extend(g),a.extend(h),a},MarkerClusterer.prototype.isMarkerInBounds_=function(a,b){return b.contains(a.getPosition())},MarkerClusterer.prototype.clearMarkers=function(){this.resetViewport(!0),this.markers_=[]},MarkerClusterer.prototype.resetViewport=function(a){for(var c,b=0;c=this.clusters_[b];b++)c.remove();for(var d,b=0;d=this.markers_[b];b++)d.isAdded=!1,a&&d.setMap(null);this.clusters_=[]},MarkerClusterer.prototype.repaint=function(){var a=this.clusters_.slice();this.clusters_.length=0,this.resetViewport(),this.redraw(),window.setTimeout(function(){for(var c,b=0;c=a[b];b++)c.remove()},0)},MarkerClusterer.prototype.redraw=function(){this.createClusters_()},MarkerClusterer.prototype.distanceBetweenPoints_=function(a,b){if(!a||!b)return 0;var c=6371,d=(b.lat()-a.lat())*Math.PI/180,e=(b.lng()-a.lng())*Math.PI/180,f=Math.sin(d/2)*Math.sin(d/2)+Math.cos(a.lat()*Math.PI/180)*Math.cos(b.lat()*Math.PI/180)*Math.sin(e/2)*Math.sin(e/2),g=2*Math.atan2(Math.sqrt(f),Math.sqrt(1-f)),h=c*g;return h},MarkerClusterer.prototype.addToClosestCluster_=function(a){for(var f,b=4e4,c=null,e=(a.getPosition(),0);f=this.clusters_[e];e++){var g=f.getCenter();if(g){var h=this.distanceBetweenPoints_(g,a.getPosition());h<b&&(b=h,c=f)}}if(c&&c.isMarkerInClusterBounds(a))c.addMarker(a);else{var f=new Cluster(this);f.addMarker(a),this.clusters_.push(f)}},MarkerClusterer.prototype.createClusters_=function(){if(this.ready_)for(var d,a=new google.maps.LatLngBounds(this.map_.getBounds().getSouthWest(),this.map_.getBounds().getNorthEast()),b=this.getExtendedBounds(a),c=0;d=this.markers_[c];c++)!d.isAdded&&this.isMarkerInBounds_(d,b)&&this.addToClosestCluster_(d)},Cluster.prototype.isMarkerAlreadyAdded=function(a){if(this.markers_.indexOf)return this.markers_.indexOf(a)!=-1;for(var c,b=0;c=this.markers_[b];b++)if(c==a)return!0;return!1},Cluster.prototype.addMarker=function(a){if(this.isMarkerAlreadyAdded(a))return!1;if(this.center_){if(this.averageCenter_){var b=this.markers_.length+1,c=(this.center_.lat()*(b-1)+a.getPosition().lat())/b,d=(this.center_.lng()*(b-1)+a.getPosition().lng())/b;this.center_=new google.maps.LatLng(c,d),this.calculateBounds_()}}else this.center_=a.getPosition(),this.calculateBounds_();a.isAdded=!0,this.markers_.push(a);var e=this.markers_.length;if(e<this.minClusterSize_&&a.getMap()!=this.map_&&a.setMap(this.map_),e==this.minClusterSize_)for(var f=0;f<e;f++)this.markers_[f].setMap(null);return e>=this.minClusterSize_&&a.setMap(null),this.updateIcon(),!0},Cluster.prototype.getMarkerClusterer=function(){return this.markerClusterer_},Cluster.prototype.getBounds=function(){for(var d,a=new google.maps.LatLngBounds(this.center_,this.center_),b=this.getMarkers(),c=0;d=b[c];c++)a.extend(d.getPosition());return a},Cluster.prototype.remove=function(){this.clusterIcon_.remove(),this.markers_.length=0,delete this.markers_},Cluster.prototype.getSize=function(){return this.markers_.length},Cluster.prototype.getMarkers=function(){return this.markers_},Cluster.prototype.getCenter=function(){return this.center_},Cluster.prototype.calculateBounds_=function(){var a=new google.maps.LatLngBounds(this.center_,this.center_);this.bounds_=this.markerClusterer_.getExtendedBounds(a)},Cluster.prototype.isMarkerInClusterBounds=function(a){return this.bounds_.contains(a.getPosition())},Cluster.prototype.getMap=function(){return this.map_},Cluster.prototype.updateIcon=function(){var a=this.map_.getZoom(),b=this.markerClusterer_.getMaxZoom();if(b&&a>b)for(var d,c=0;d=this.markers_[c];c++)d.setMap(this.map_);else{if(this.markers_.length<this.minClusterSize_)return void this.clusterIcon_.hide();var e=this.markerClusterer_.getStyles().length,f=this.markerClusterer_.getCalculator()(this.markers_,e);this.clusterIcon_.setCenter(this.center_),this.clusterIcon_.setSums(f),this.clusterIcon_.show()}},ClusterIcon.prototype.triggerClusterClick=function(a){var b=this.cluster_.getMarkerClusterer();google.maps.event.trigger(b,"clusterclick",this.cluster_,a),b.isZoomOnClick()&&this.map_.fitBounds(this.cluster_.getBounds())},ClusterIcon.prototype.onAdd=function(){if(this.div_=document.createElement("DIV"),this.visible_){var a=this.getPosFromLatLng_(this.center_);this.div_.style.cssText=this.createCss(a),this.div_.innerHTML=this.sums_.text}var b=this.getPanes();b.overlayMouseTarget.appendChild(this.div_);var c=this,d=!1;google.maps.event.addDomListener(this.div_,"click",function(a){d||c.triggerClusterClick(a)}),google.maps.event.addDomListener(this.div_,"mousedown",function(){d=!1}),google.maps.event.addDomListener(this.div_,"mousemove",function(){d=!0})},ClusterIcon.prototype.getPosFromLatLng_=function(a){var b=this.getProjection().fromLatLngToDivPixel(a);return"object"==typeof this.iconAnchor_&&2===this.iconAnchor_.length?(b.x-=this.iconAnchor_[0],b.y-=this.iconAnchor_[1]):(b.x-=parseInt(this.width_/2,10),b.y-=parseInt(this.height_/2,10)),b},ClusterIcon.prototype.draw=function(){if(this.visible_){var a=this.getPosFromLatLng_(this.center_);this.div_.style.top=a.y+"px",this.div_.style.left=a.x+"px"}},ClusterIcon.prototype.hide=function(){this.div_&&(this.div_.style.display="none"),this.visible_=!1},ClusterIcon.prototype.show=function(){if(this.div_){var a=this.getPosFromLatLng_(this.center_);this.div_.style.cssText=this.createCss(a),this.div_.style.display=""}this.visible_=!0},ClusterIcon.prototype.remove=function(){this.setMap(null)},ClusterIcon.prototype.onRemove=function(){this.div_&&this.div_.parentNode&&(this.hide(),this.div_.parentNode.removeChild(this.div_),this.div_=null)},ClusterIcon.prototype.setSums=function(a){this.sums_=a,this.text_=a.text,this.index_=a.index,this.div_&&(this.div_.innerHTML=a.text),this.useStyle()},ClusterIcon.prototype.useStyle=function(){var a=Math.max(0,this.sums_.index-1);a=Math.min(this.styles_.length-1,a);var b=this.styles_[a];this.url_=b.url,this.height_=b.height,this.width_=b.width,this.textColor_=b.textColor,this.anchor_=b.anchor,this.textSize_=b.textSize,this.backgroundPosition_=b.backgroundPosition,this.iconAnchor_=b.iconAnchor},ClusterIcon.prototype.setCenter=function(a){this.center_=a},ClusterIcon.prototype.createCss=function(a){var b=[];b.push("background-image:url("+this.url_+");");var c=this.backgroundPosition_?this.backgroundPosition_:"0 0";b.push("background-position:"+c+";"),"object"==typeof this.anchor_?("number"==typeof this.anchor_[0]&&this.anchor_[0]>0&&this.anchor_[0]<this.height_?b.push("height:"+(this.height_-this.anchor_[0])+"px; padding-top:"+this.anchor_[0]+"px;"):"number"==typeof this.anchor_[0]&&this.anchor_[0]<0&&-this.anchor_[0]<this.height_?b.push("height:"+this.height_+"px; line-height:"+(this.height_+this.anchor_[0])+"px;"):b.push("height:"+this.height_+"px; line-height:"+this.height_+"px;"),"number"==typeof this.anchor_[1]&&this.anchor_[1]>0&&this.anchor_[1]<this.width_?b.push("width:"+(this.width_-this.anchor_[1])+"px; padding-left:"+this.anchor_[1]+"px;"):b.push("width:"+this.width_+"px; text-align:center;")):b.push("height:"+this.height_+"px; line-height:"+this.height_+"px; width:"+this.width_+"px; text-align:center;");var d=this.textColor_?this.textColor_:"black",e=this.textSize_?this.textSize_:11;return b.push("cursor:pointer; top:"+a.y+"px; left:"+a.x+"px; color:"+d+"; position:absolute; font-size:"+e+"px; font-family:Arial,sans-serif; font-weight:bold"),b.join("")},window.MarkerClusterer=MarkerClusterer,MarkerClusterer.prototype.addMarker=MarkerClusterer.prototype.addMarker,MarkerClusterer.prototype.addMarkers=MarkerClusterer.prototype.addMarkers,MarkerClusterer.prototype.clearMarkers=MarkerClusterer.prototype.clearMarkers,MarkerClusterer.prototype.fitMapToMarkers=MarkerClusterer.prototype.fitMapToMarkers,MarkerClusterer.prototype.getCalculator=MarkerClusterer.prototype.getCalculator,MarkerClusterer.prototype.getGridSize=MarkerClusterer.prototype.getGridSize,MarkerClusterer.prototype.getExtendedBounds=MarkerClusterer.prototype.getExtendedBounds,MarkerClusterer.prototype.getMap=MarkerClusterer.prototype.getMap,MarkerClusterer.prototype.getMarkers=MarkerClusterer.prototype.getMarkers,MarkerClusterer.prototype.getMaxZoom=MarkerClusterer.prototype.getMaxZoom,MarkerClusterer.prototype.getStyles=MarkerClusterer.prototype.getStyles,MarkerClusterer.prototype.getTotalClusters=MarkerClusterer.prototype.getTotalClusters,MarkerClusterer.prototype.getTotalMarkers=MarkerClusterer.prototype.getTotalMarkers,MarkerClusterer.prototype.redraw=MarkerClusterer.prototype.redraw,MarkerClusterer.prototype.removeMarker=MarkerClusterer.prototype.removeMarker,MarkerClusterer.prototype.removeMarkers=MarkerClusterer.prototype.removeMarkers,MarkerClusterer.prototype.resetViewport=MarkerClusterer.prototype.resetViewport,MarkerClusterer.prototype.repaint=MarkerClusterer.prototype.repaint,MarkerClusterer.prototype.setCalculator=MarkerClusterer.prototype.setCalculator,MarkerClusterer.prototype.setGridSize=MarkerClusterer.prototype.setGridSize,MarkerClusterer.prototype.setMaxZoom=MarkerClusterer.prototype.setMaxZoom,MarkerClusterer.prototype.onAdd=MarkerClusterer.prototype.onAdd,MarkerClusterer.prototype.draw=MarkerClusterer.prototype.draw,Cluster.prototype.getCenter=Cluster.prototype.getCenter,Cluster.prototype.getSize=Cluster.prototype.getSize,Cluster.prototype.getMarkers=Cluster.prototype.getMarkers,ClusterIcon.prototype.onAdd=ClusterIcon.prototype.onAdd,ClusterIcon.prototype.draw=ClusterIcon.prototype.draw,ClusterIcon.prototype.onRemove=ClusterIcon.prototype.onRemove;
</script>

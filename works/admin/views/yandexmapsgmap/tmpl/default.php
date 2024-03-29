<?php defined('_JEXEC') or die('Restricted access');

if ($this->apikey == '') {
echo '<p>' . JText::_('Google Maps API Key Error') . '</p>';
} else {

	$document	= & JFactory::getDocument();
	$scriptLink	= 'http://api-maps.yandex.ru/1.0/index.xml?key='. $this->apikey;
	$document->addScript($scriptLink);
	
?>
<script xmlns:str="http://exslt.org/strings" type="text/javascript"><!--
            var map, placemark;
            
            window.onload = function init () {
                var pointCenter = new YMaps.GeoPoint( <?php echo $this->longitude;?>, <?php echo $this->latitude;?>);
                map = new YMaps.Map(document.getElementById("YMapsID"));
                map.setCenter(pointCenter, <?php echo $this->zoom;?>);
                map.addControl(new YMaps.TypeControl());
                map.enableScrollZoom();
                
                placemark = new YMaps.Placemark(pointCenter, {draggable: true, hideIcon: false});
                setBalloonInfo(placemark, pointCenter);
                map.addOverlay(placemark);
                
                YMaps.Events.observe(placemark, placemark.Events.Drag, function (mEvent) {
                    setBalloonInfo(placemark, mEvent.getGeoPoint());
                })
                
                YMaps.Events.observe(map, map.Events.Click, function (mEvent) {
                    var newGeoPoint = mEvent.getGeoPoint();
                    placemark.setGeoPoint(newGeoPoint);
                    setBalloonInfo(placemark, newGeoPoint);
                })
            }
            
            function showAddress (value) {
                var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});
                
                YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
                    if (this.length()) {
                        var geoResult = this.get(0);
                        map.setBounds(geoResult.getBounds());
                        
                        placemark.setGeoPoint(geoResult.getGeoPoint());
                        setBalloonInfo(placemark, geoResult.getGeoPoint(), geoResult.text);
                        placemark.openBalloon();
						
                    }else {
                        alert("<?php echo JText::_('An unknown error occurred');?>")
                    }
                });
            }
            
            function setBalloonInfo (placemark, geoPoint, text) {
                var content = '';
                if (text) {
                content += '<div class="title">' + text + '</div>';
                }
                content += '<span class="coords-title"> <?php echo JText::_('Koordinate');?>: </span>' + geoPoint.toString();
                placemark.setBalloonContent(content);
                document.getElementById('coords').value = geoPoint.getLng();
				document.getElementById('coords2').value = geoPoint.getLat();	
				
				window.top.document.forms.adminForm.getElementById('longitude').value = geoPoint.getLng();
				window.top.document.forms.adminForm.getElementById('latitude').value = geoPoint.getLat();
				
				<?php if ($this->type == 'marker') { //автоматическая подстановка gps координат ?>
				setPMGPSLongitude(geoPoint.getLng());
				setPMGPSLatitude(geoPoint.getLat());
				<?php } ?>

            }
			
			
			
            --></script>

<div>
  <form action="#" onsubmit="showAddress(this.address.value);return false;">
    <table>
      <tr>
        <td><input name=""  type="text" id="address" value="" size="50" />
          </input></td>
        <td><input class="find-button" type="submit" value="<?php echo JText::_('Get route');?>">
          </input>
        </td>
      </tr>
      <tr>
        <td colspan="2"><p>
        	<?php echo JText::_('Latitude');?>:<input name="" type="text" id="coords2" size="30" /></input>&nbsp;
            <?php echo JText::_('Longitude');?>:<input name="" type="text" id="coords" size="30" />
            
            </input>
          </p></td>
      </tr>
    </table>

    <div style="margin:0;padding:0;text-align:center;">
      <div id="YMapsID" style="margin:0;padding:0;width:600px;height:520px;margin-bottom:5px;"></div>
    </div>
  </form>
  </td>
  <td><i></i></td>
  </tr>
  </table>
 </div>
<?php
}
?>

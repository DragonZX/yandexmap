<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); 

echo YandexMapsRender::renderSubmitButtonJs(array(
		0 => array('title', 'Marker must have a title', 'true', 1),
		1 =>array('catid', 'You must select a map', 'true', 0))
	);
echo YandexMapsRender::renderFormStyle();?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Basic Settings'); ?></legend>
	<table width="50%" class="admintable" style="float:left;">		
		<?php	
		echo YandexMapsRender::renderFormInput('title', 'Titlemarker', '', $this->item->title);	
		echo YandexMapsRender::renderFormInput('titlem', 'Titlemarker_2', '', $this->item->titlem);
		echo YandexMapsRender::renderFormItemSpecial('catid', 'Map', '', $this->lists['catid'] );
		echo YandexMapsRender::renderFormItemSpecial('published', 'Published', '', $this->lists['published'] );
		echo YandexMapsRender::renderFormItemSpecial('ordering', 'Ordering', '', $this->lists['ordering'] );
		echo YandexMapsRender::renderFormItemSpecial('description', 'Description', '', $this->editor->display( 'description',  $this->item->description, '550', '300', '60', '20', array('pagebreak', 'readmore') ) );

		?>
       
	</table>
    <div style="float:right; width:30%;">
 
<?php  
jimport('joomla.html.pane');
$pane =& JPane::getInstance('Sliders');
echo $pane->startPane('myPane');
{
echo $pane->startPanel(JText::_('Nastroykamarkera'), 'panel1');

		echo '<table class="paramlist admintable">';
		echo YandexMapsRender::renderFormItemImageButton('latitude', 'Latitude', $this->item->latitude, 50, 50, $this->buttonmap, 'onChange="setPMGPSLatitude(this.value);"');
		echo YandexMapsRender::renderFormInput('longitude', 'Longitude', '', $this->item->longitude, 50, 50, 'onChange="setPMGPSLongitude(this.value);"');
		echo YandexMapsRender::renderFormInput('gpslatitude', 'GPS Latitude', '', $this->item->gpslatitude, '', '', 'readonly', 'background:#f0f0f0');
		echo YandexMapsRender::renderFormInput('gpslongitude', 'GPS Longitude', '', $this->item->gpslongitude, '', '', 'readonly', 'background:#f0f0f0');
		$option = array(0 => 'No', 1 => 'Yes');
		echo YandexMapsRender::renderFormSelectBox('displaygps', 'Display GPS', '', $this->item->displaygps, $option);
		echo "</table>";

echo $pane->endPanel();
echo $pane->startPanel(JText::_('Design Settings'), 'panel2');

echo '<table>'.YandexMapsRender::renderFormItemSpecial('icon', 'Marker Icon', '', $this->iconcombo, '').'</table>';
echo $pane->endPanel();
}
echo $pane->endPane();?>

</div>
	
</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_yandexmaps" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="yandexmapsmarker" />
</form>
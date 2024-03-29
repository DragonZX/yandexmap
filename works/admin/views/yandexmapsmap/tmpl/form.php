<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); 

echo YandexMapsRender::renderSubmitButtonJs(array(
		0 => array('title', 'Map must have a title', 'true', 1))
	);
echo YandexMapsRender::renderFormStyle();?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<table width="100%">
    <tr>
      <td width="60%" valign="top">
<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Basic Settings'); ?></legend>
	<table class="admintable">		
		<?php		
		echo YandexMapsRender::renderFormInput('title', 'Title', '', $this->item->title);
		echo YandexMapsRender::renderFormInput('alias', 'Alias', '', $this->item->alias);
		echo YandexMapsRender::renderFormItemImageButton('latitude', 'Latitude', $this->item->latitude, 50, 50, $this->buttonmap);
		echo YandexMapsRender::renderFormInput('longitude', 'Longitude', '', $this->item->longitude, 50, 50);		
		echo YandexMapsRender::renderFormInput('zoom', 'Zoom', 'Zoom Disc', $this->item->zoom);
		echo YandexMapsRender::renderFormInput('width', 'Map Width', 'Map Width Disc', $this->item->width);
		echo YandexMapsRender::renderFormInput('height', 'Map Height', '', $this->item->height);
		echo YandexMapsRender::renderFormInput('lang', 'Versionmap', 'Versionmap Disc', $this->item->lang, 5, 5);
		echo YandexMapsRender::renderFormItemSpecial('published', 'Published', '', $this->lists['published'] );
		echo YandexMapsRender::renderFormItemSpecial('ordering', 'Ordering', '', $this->lists['ordering'] );
		echo YandexMapsRender::renderFormItemSpecial('description', 'Description', '', $this->editor->display( 'description',  $this->item->description, '550', '300', '60', '20', array('pagebreak', 'readmore') ) );
		
		
		?>
	</table>	
</fieldset>
</div>
</td>
      <td style="width:40%;" valign="top">
<div class="col50">
<fieldset class="adminform">
	<legend><?php echo JText::_('Advanced Settings'); ?></legend>
	<table class="admintable">		
		<?php
		$option = array(0 => 'No', 1 => 'Yes');
		echo YandexMapsRender::renderFormSelectBox('continuouszoom', 'Continuous Zoom', 'Continuous Zoom Disc', $this->item->continuouszoom, $option);
		echo YandexMapsRender::renderFormSelectBox('doubleclickzoom', 'Doubleclick Zoom', '', $this->item->doubleclickzoom, $option);
		echo YandexMapsRender::renderFormSelectBox('scrollwheelzoom', 'Scroll Wheel Zoom', '', $this->item->scrollwheelzoom, $option);
		$option = array(0 => 'None', 1 => 'LargeMap Control 3D', 2 => 'LargeMap Control');
		echo YandexMapsRender::renderFormSelectBox('zoomcontrol', 'Zoom Control', '', $this->item->zoomcontrol, $option);
		$option = array(0 => 'No', 1 => 'Yes');
		echo YandexMapsRender::renderFormSelectBox('scalecontrol', 'Scale Control', '', $this->item->scalecontrol, $option);
		$option = array(0 => 'None', 1 => 'Default Map Types', 2 => 'Normal Map', 3 => 'Satellite Map', 4 => 'Hybrid Map', 5 => 'Physical Map', 7 => 'Default Map Types (Satellite Map)', 8 => 'Default Map Types (Hybrid Map)', 9 => 'Default Map Types (Physical Map)');
		echo YandexMapsRender::renderFormSelectBox('typecontrol', 'Type Control', '', $this->item->typecontrol, $option);
		$option = array(0 => 'No', 1 => 'Yes');
		echo YandexMapsRender::renderFormSelectBox('collapsibleoverview', 'Collapsible Overview Control', '', $this->item->collapsibleoverview, $option);
		echo YandexMapsRender::renderFormSelectBox('dynamiclabel', 'Dynamic Label Control', '', $this->item->dynamiclabel, $option);
		echo YandexMapsRender::renderFormSelectBox('googlebar', 'GoogleBar', '', $this->item->googlebar, $option);
		//echo YandexMapsRender::renderFormSelectBox('displayroute', 'Display Get Route Form', '', $this->item->displayroute, $option);
			

		$option = array(0 => 'No', 1 => 'Yes');
		echo YandexMapsRender::renderFormSelectBox('border', 'Search Maps', '', $this->item->border, $option, 1);
		?>
	
	</table>	
</fieldset>
</div>
</td>
    </tr>
  </table>
<div class="clr"></div>

<input type="hidden" name="option" value="com_yandexmaps" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="yandexmapsmap" />
</form>

	

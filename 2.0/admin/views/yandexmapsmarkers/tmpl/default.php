<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
//Ordering allowed ?
$ordering = ($this->lists['order'] == 'a.ordering');
?>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">

<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>:
			<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		<td nowrap="nowrap">
			<?php
			echo $this->lists['catid'];
			echo $this->lists['state'];
			?>
		</td>
	</tr>
</table>

<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
			
			<th class="title" width="70%"><?php echo JHTML::_('grid.sort',  'Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
			<th class="title" width="10%"><?php echo JHTML::_('grid.sort',  'Marker Icon', 'a.icon', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th class="title" width="10%"><?php echo JHTML::_('grid.sort',  'Map', 'a.catid', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
			
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
			<th width="13%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'Order', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
			<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		
		$k = 0;
		$i = 0;
		$n = count( $this->items );
		$rows = &$this->items;

		if (is_array($rows)) {
			foreach ($rows as $row) {
				$checked 	= JHTML::_('grid.checkedout', $row, $i );
				$published 	= JHTML::_('grid.published', $row, $i );
				$link 		= JRoute::_( 'index.php?option=com_yandexmaps&controller=yandexmapsmarker&task=edit&cid[]='. $row->id );
				$linkCatid	= JRoute::_( 'index.php?option=com_yandexmaps&controller=yandexmapsmap&task=edit&cid[]='. $row->catid );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?php echo $this->pagination->getRowOffset( $i );?></td>
					<td><?php echo $checked; ?></td>
					
					<td>
						<?php
						if (  JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ) {
							echo $row->title;
						} else {
						?>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Marker' ); ?>">
								<?php echo $row->title; ?></a>
						<?php
						}
						?>					</td>
					
					<td align="center">
                    <?php 
							
							if ($row->icon != '')
							{
							$path = 'components/com_yandexmaps/assets/images/icon/';
							$fullpath = JURI::root() . $path;
							?>
                    <img src="<?php echo $fullpath.$row->icon; ?>" alt="" />
                    <?php }else{
					$path = 'administrator/components/com_yandexmaps/assets/images/deficon/';
							$fullpath = JURI::root() . $path;
					?>
                    <img src="<?php echo $fullpath.$row->deficon; ?>.png" alt="" />
                    <?php }?>
                    </td>
					<td align="center">
						<a href="<?php echo $linkCatid; ?>" title="<?php echo JText::_( 'Edit Map' ); ?>">
							<?php echo $row->catidname; ?></a></td>
					
					<td align="center"><?php echo $published;?></td>
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i, ($row->catid == @$this->items[$i-1]->catid),'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->catid == @$this->items[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />					</td>
					<td align="center"><?php echo $row->id; ?></td>
				</tr>
			<?php
			$k = 1 - $k;
			$i++;
			}
		}
	?>
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="12"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
</table>
	
</div>

<input type="hidden" name="controller" value="yandexmapsmarker" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="catid" value="<?php echo $this->tmpl['catid']; ?>" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>
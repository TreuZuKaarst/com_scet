<?php
// *********************************************************************//
// Project      : scet for Joomla                                       //
// @package     : com_scet                                              //
// @file        : admin/views/categories/tmpl/default.php               //
// @implements  :                                                       //
// @description : Template for the Categories-List-View                 //
// Version      : 2.5.24                                                //
// *********************************************************************//
// Check to ensure this file is included in Joomla!
defined('_JEXEC')or die('Restricted access');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$saveOrder	= $this->listOrder == 'ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_scet&task=categories.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_scet&view=categories'); ?>" method="post" name="adminForm" id="adminForm">
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_JTODO_ITEMS_SEARCH_FILTER_DESC');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('COM_SCET_ITEMS_SEARCH_FILTER'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
			</div>
    </div>
    <div class="clearfix"> </div>

		<table class="table table-striped" id="articleList">
        <thead>
            <tr>
				<th width="1%" class="nowrap center hidden-phone">
					<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->listDirn, $this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
				</th>
				<th width="1%" class="hidden-phone">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_SCET_CATEGORY', 'category', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5%" align="center">
                    <?php echo JHTML::_('grid.sort', 'COM_SCET_PUBLISHED', 'published', $this->listDirn, $this->listOrder); ?>
               </th>
                <th width="5%" align="center">
                    <?php echo JHTML::_('grid.sort', 'COM_SCET_PUBLIC', 'publiccategory', $this->listDirn, $this->listOrder); ?>
               </th>
                <th width="5">
                    <?php echo JHTML::_('grid.sort', 'COM_SCET_ID', 'id', $this->listDirn, $this->listOrder); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($this->items as $i => $item) :
                $link = JRoute::_( 'index.php?option=com_scet&task=event.edit&id='.(int)$item->id );
                $ordering	= ($this->listOrder == 'ordering');
                ?>
					<tr class="row<?php echo $i % 2; ?>" sortable-group-id="1">
						<td class="order nowrap center hidden-phone">
							<?php
							$iconClass = '';
							if (!$saveOrder)
							{
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass ?>">
								<i class="icon-menu"></i>
							</span>
							<?php if ($saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5"
									value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
                        <td><?php echo JHTML::_('grid.id', $i, $item->id); ?></td>
                        <td><a href="<?php echo $link; ?>"><?php echo $item->category; ?></a></td>
                        <td align="center"><?php echo JHTML::_('jgrid.published', $item->published, $i, 'categories.' ); ?></td>
                        <td align="center"><?php echo JHTML::_('jgrid.published', $item->publiccategory, $i, 'categories.publicity_' ); ?></td>
                        <td><?php echo $item->id; ?></td>
                    </tr>

                <?php
                endforeach;
            ?>
        <tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    <?php echo $this->pagination->getListFooter()
                               .'<br>'
                               . $this->pagination->getResultsCounter();
                    ?>
                    <p>
                    <center>SCET (Small Community Event Table) for Joomla  v<?php echo _SCET_VERSION; ?></center>
                    <center>Copyright &copy; 2011-<?php echo date('Y', time() )?> by Hanjo Hingsen, Webmaster of  <a href="http://www.treu-zu-kaarst.de">http://www.treu-zu-kaarst.de</a>, All Rights reserved</center>
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="task"             value = "" />
        <input type="hidden" name="boxchecked"       value = "0" />
        <input type="hidden" name="filter_order"     value = "<?php echo $this->listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value = "<?php echo $this->listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>

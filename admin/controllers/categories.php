<?php// *************************************************************************//// Project      : SCET for Joomla                                           //// @package     : com_scet                                                  //// @file        : /admin/controllers/categories.php                         //// @implements  : Class scetControllerCategories                            //// @description : Controller for editing the categories-List                //// Version      : 2.5.19                                                     //// *************************************************************************//// No direct access.defined('_JEXEC') or die;jimport('joomla.application.component.controlleradmin');class scetControllercategories extends JControllerAdmin{	// constructor (registers additional tasks to methods)	// @return void	function __construct()	{		parent::__construct();    }    	public function getModel($name = 'Category', $prefix = 'scetModel', 							 $config = array('ignore_request' => true))	{		$model = parent::getModel($name, $prefix, $config);		return $model;	}	      public function setDbField($fieldname, $state)    {		$this->setRedirect( 'index.php?option=com_scet&view=categories' );		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );		if (empty( $cid ))         {			return JError::raiseWarning( 500, JText::_( 'COM_SCET_MSG_NO_ITEMS_SELECTED' ) );		}        return $this->getModel()->setDBField($fieldname, $state, $cid);    }      public function publicity_publish()    {        $this->setDbField('publiccategory', '1');    }      public function publicity_unpublish()    {        $this->setDbField('publiccategory', '0');    }  }
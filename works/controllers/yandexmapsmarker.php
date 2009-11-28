<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Yandex Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

class YandexMapsCpControllerYandexMapsMarker extends YandexMapsCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply'  , 'save' );
	}
	
	function edit() {
		JRequest::setVar( 'view', 'yandexmapsmarker' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();

		// Checkin
		$model = $this->getModel( 'yandexmapsmarker' );
		$model->checkout();
	}

	function save() {
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['description']	= JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['id'] 			= (int) $cid[0];
		
		$model = $this->getModel( 'yandexmapsmarker' );
		
		switch ( JRequest::getCmd('task') ) {
			case 'apply':
				$id	= $model->store($post);//you get id and you store the table data
				if ($id && $id > 0) {
					$msg = JText::_( 'Changes to Yandex Maps Markers Saved' );
					//$id		= $model->store($post);
				} else {
					$msg = JText::_( 'Error Saving Yandex Maps Markers' );
					$id		= $post['id'];
				}
				$this->setRedirect( 'index.php?option=com_yandexmaps&controller=yandexmapsmarker&task=edit&cid[]='. $id, $msg );
				break;

			case 'save':
			default:
				if ($model->store($post)) {
					$msg = JText::_( 'Yandex Maps Markers Saved' );
				} else {
					$msg = JText::_( 'Error Saving Yandex Maps Markers' );
				}
				$this->setRedirect( 'index.php?option=com_yandexmaps&view=yandexmapsmarkers', $msg );
				break;
		}
		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
	}

	function remove() {
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		
		
		$model = $this->getModel( 'yandexmapsmarker' );
		
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Yandex Maps Markers' );
		} else {
			$msg = JText::_( 'Yandex Maps Markers Deleted' );
		}

		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect( $link, $msg );
	}

	function publish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('yandexmapsmarker');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect($link);
	}

	function unpublish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('yandexmapsmarker');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect($link);
	}

	function cancel() {
		$model = $this->getModel( 'yandexmapsmarker' );
		$model->checkin();

		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect( $link );
	}

	function orderup() {
		$model = $this->getModel( 'yandexmapsmarker' );
		$model->move(-1);

		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect( $link );
	}

	function orderdown() {
		$model = $this->getModel( 'yandexmapsmarker' );
		$model->move(1);

		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect( $link );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'yandexmapsmarker' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$link = 'index.php?option=com_yandexmaps&view=yandexmapsmarkers';
		$this->setRedirect( $link, $msg  );
	}
}
?>

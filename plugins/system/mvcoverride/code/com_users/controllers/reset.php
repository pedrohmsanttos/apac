<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersController', COM_USERS_JPATH_SOURCE_COMPONENT . '/controller.php');

/**
 * Reset controller class for Users.
 *
 * @since  1.6
 */
class UsersControllerReset extends UsersController
{
	/**
	 * Method to request a password reset.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function request()
	{
		// Check the request token.
		$this->checkToken('post');

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->post->get('jform', array(), 'array');

		// Submit the password reset request.
		$return	= $model->processResetRequest($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			if ($app->get('error_reporting'))
			{
				$message = $return->getMessage();
			}
			else
			{
				$message = JText::_('COM_USERS_RESET_REQUEST_ERROR');
			}

			// Go back to the request form.
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset', false), $message, 'error');

			return false;
		}
		elseif ($return === false)
		{
			// The request failed.
			// Go back to the request form.
			$message = JText::sprintf('COM_USERS_RESET_REQUEST_FAILED', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset', false), $message, 'notice');

			return false;
		}
		else
		{
			// The request succeeded.
			// Proceed to step two.
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset&layout=confirm', false));

			return true;
		}
	}

	/**
	 * Method to confirm the password request.
	 *
	 * @return  boolean
	 *
	 * @access	public
	 * @since   1.6
	 */
	public function confirm()
	{
		// Check the request token.
		$this->checkToken('request');

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->get('jform', array(), 'array');
		$data['username'] = $this->getUsernameByEmail($data['username']);

		// Confirm the password reset request.
		$return	= $model->processResetConfirm($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			if ($app->get('error_reporting'))
			{
				$message = $return->getMessage();
			}
			else
			{
				$message = JText::_('COM_USERS_RESET_CONFIRM_ERROR');
			}

			// Go back to the confirm form.
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset&layout=confirm', false), $message, 'error');

			return false;
		}
		elseif ($return === false)
		{
			// Confirm failed.
			// Go back to the confirm form.
			$message = JText::sprintf('COM_USERS_RESET_CONFIRM_FAILED', $model->getError());
			$message = str_replace('Nome de Usuário', 'E-mail', $message);
			$message = str_replace('nome de usuário', 'e-mail', $message);
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset&layout=confirm', false), $message, 'notice');

			return false;
		}
		else
		{
			// Confirm succeeded.
			// Proceed to step three.
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset&layout=complete', false));

			return true;
		}
	}

	public function getUsernameByEmail($email){
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select($db->quoteName(array('username')));
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('email') . ' = '. $db->quote($email.'.frontend'));

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		
		return $results[0];
	}
	
	/**
	 * Method to complete the password reset process.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function complete()
	{
		// Check for request forgeries
		$this->checkToken('post');

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->post->get('jform', array(), 'array');

		// Complete the password reset request.
		$return	= $model->processResetComplete($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			if ($app->get('error_reporting'))
			{
				$message = $return->getMessage();
			}
			else
			{
				$message = JText::_('COM_USERS_RESET_COMPLETE_ERROR');
			}

			// Go back to the complete form.
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset&layout=complete', false), $message, 'error');

			return false;
		}
		elseif ($return === false)
		{
			// Complete failed.
			// Go back to the complete form.
			$message = JText::sprintf('COM_USERS_RESET_COMPLETE_FAILED', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=reset&layout=complete', false), $message, 'notice');

			return false;
		}
		else
		{
			// Complete succeeded.
			// Proceed to the login form.
			$message = JText::_('COM_USERS_RESET_COMPLETE_SUCCESS');
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=login', false), $message);

			return true;
		}
	}
}
